<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class KasirController extends Controller
{
    /**
     * Display the POS/Kasir screen.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $selectedCategory = $request->input('category', 'all');

        // Retrieve active categories
        $categories = Category::where('is_active', true)->orderBy('name', 'asc')->get();

        // Retrieve all customers for debt/credit checkout selection
        $customers = Customer::orderBy('name', 'asc')->get()->map(function ($customer) {
            // Append dynamic attributes for Alpine.js visibility
            return [
                'id' => $customer->id,
                'name' => $customer->name,
                'phone' => $customer->phone ?: '-',
                'total_debt' => $customer->total_debt,
            ];
        });

        // Query active products
        $query = Product::where('is_active', true);

        if ($selectedCategory !== 'all') {
            $cat = Category::where('slug', $selectedCategory)->first();
            if ($cat) {
                $query->where('category_id', $cat->id);
            }
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('sku', 'like', '%' . $search . '%');
            });
        }

        $products = $query->orderBy('name', 'asc')->get();

        return view('kasir.index', compact('categories', 'products', 'customers', 'search', 'selectedCategory'));
    }

    /**
     * Handle POS transaction checkout with advanced payment flows.
     */
    public function checkout(Request $request)
    {
        $request->validate([
            'cart_data' => ['required', 'string'],
            'payment_method' => ['required', 'in:cash,qris,debt,cash_debt,qris_debt'],
            'customer_id' => ['nullable', 'exists:customers,id'],
            'amount_paid' => ['required', 'numeric', 'min:0'],
        ]);

        $cartItems = json_decode($request->input('cart_data'), true);

        if (empty($cartItems)) {
            return redirect()->back()->withErrors(['checkout' => 'Keranjang belanja kosong.']);
        }

        $paymentMethod = $request->input('payment_method');
        $customerId = $request->input('customer_id');
        $amountPaid = (float) $request->input('amount_paid');

        // Check customer requirements for debt-involved transactions
        if (in_array($paymentMethod, ['debt', 'cash_debt', 'qris_debt'])) {
            if (empty($customerId)) {
                return redirect()->back()->withErrors(['checkout' => 'Pelanggan harus dipilih untuk transaksi hutang/kredit.']);
            }
            if (!Customer::where('id', $customerId)->exists()) {
                return redirect()->back()->withErrors(['checkout' => 'Pelanggan tidak ditemukan.']);
            }
        }

        // Validate QRIS + Hutang values on the server side
        if ($paymentMethod === 'qris_debt') {
            $rawAmount = $request->input('amount_paid');
            if (!is_numeric($rawAmount) || (float) $rawAmount < 0) {
                return redirect()->back()->withErrors(['checkout' => 'Jumlah dibayar via QRIS tidak valid.']);
            }
        }

        try {
            $transactionId = DB::transaction(function () use ($cartItems, $paymentMethod, $customerId, $amountPaid) {
                $subtotal = 0;
                $validatedItems = [];

                // 1. Lock rows and validate stock levels first
                foreach ($cartItems as $item) {
                    $product = Product::where('id', $item['id'])
                        ->lockForUpdate()
                        ->first();

                    if (!$product) {
                        throw new \Exception("Produk tidak ditemukan.");
                    }

                    if (!$product->is_active) {
                        throw new \Exception("Produk '{$product->name}' sedang tidak aktif.");
                    }

                    if ($product->stock < $item['quantity']) {
                        throw new \Exception("Stok untuk '{$product->name}' tidak mencukupi. Stok saat ini: {$product->stock}.");
                    }

                    $itemSubtotal = $product->selling_price * $item['quantity'];
                    $subtotal += $itemSubtotal;

                    $validatedItems[] = [
                        'product' => $product,
                        'quantity' => $item['quantity'],
                        'price' => $product->selling_price,
                        'cost_price' => $product->cost_price,
                        'subtotal' => $itemSubtotal,
                    ];
                }

                // Calculate remaining amount based on customer debt logic
                $existingDebt = 0;
                if (!empty($customerId)) {
                    $customer = Customer::find($customerId);
                    if ($customer) {
                        $existingDebt = (float) $customer->total_debt;
                    }
                }

                $grossDebt = $existingDebt + $subtotal;

                // Validate QRIS + Hutang / Cash + Hutang boundaries inside transaction
                if (in_array($paymentMethod, ['cash_debt', 'qris_debt'])) {
                    if ($amountPaid > $grossDebt) {
                        throw new \Exception("Jumlah dibayar tidak boleh melebihi total kewajiban pelanggan (Rp " . number_format($grossDebt, 0, ',', '.') . ").");
                    }
                }

                if (in_array($paymentMethod, ['debt', 'cash_debt', 'qris_debt'])) {
                    // Capped payment amount cannot exceed gross debt (excess is change)
                    $appliedPayment = min($amountPaid, $grossDebt);
                    $remainingAmount = $subtotal - $appliedPayment;
                    
                    if ($remainingAmount <= 0) {
                        $status = 'paid';
                    } elseif ($amountPaid <= 0) {
                        $status = 'unpaid';
                    } else {
                        $status = 'partial';
                    }
                } else {
                    // normal cash or qris checkout (no previous debt payment applied)
                    $remainingAmount = 0;
                    $status = 'paid';
                }

                // No debt limit validation applies to checkouts as per business rules. Outstanding debt accumulates freely.

                // 2. Generate unique transaction number
                $date = now()->format('Ymd');
                do {
                    $number = 'TRX-' . $date . '-' . strtoupper(Str::random(6));
                } while (Transaction::where('transaction_number', $number)->exists());

                // 3. Create transaction record
                $transaction = Transaction::create([
                    'user_id' => Auth::id(),
                    'customer_id' => $customerId,
                    'transaction_number' => $number,
                    'subtotal' => $subtotal,
                    'discount' => 0,
                    'total' => $subtotal,
                    'amount_paid' => $amountPaid,
                    'remaining_amount' => $remainingAmount,
                    'status' => $status,
                    'payment_method' => $paymentMethod,
                ]);

                // 4. Create items and reduce stock
                foreach ($validatedItems as $itemData) {
                    $transaction->items()->create([
                        'product_id' => $itemData['product']->id,
                        'quantity' => $itemData['quantity'],
                        'price' => $itemData['price'],
                        'cost_price' => $itemData['cost_price'],
                        'subtotal' => $itemData['subtotal'],
                    ]);

                    // Decrement stock
                    $itemData['product']->decrement('stock', $itemData['quantity']);
                }

                return $transaction->id;
            });

            // Redirect to success page based on active role
            $routeName = Auth::user()->role === 'Owner' ? 'owner.kasir.success' : 'kasir.success';
            return redirect()->route($routeName, $transactionId);

        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['checkout' => $e->getMessage()]);
        }
    }

    /**
     * Display the payment success screen and receipt.
     */
    public function success(Transaction $transaction)
    {
        // Enforce user authentication ownership if needed, otherwise roles
        $transaction->load(['items.product', 'customer', 'user']);

        return view('kasir.success', compact('transaction'));
    }

    /**
     * Create a new customer inline via AJAX from POS.
     */
    public function createCustomer(Request $request)
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:100'],
                'phone' => ['required', 'string', 'max:20'],
            ]);

            $customer = Customer::create([
                'name' => trim($request->input('name')),
                'phone' => trim($request->input('phone')),
            ]);

            return response()->json([
                'success' => true,
                'customer' => [
                    'id' => $customer->id,
                    'name' => $customer->name,
                    'phone' => $customer->phone ?: '-',
                    'total_debt' => 0,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }
}
