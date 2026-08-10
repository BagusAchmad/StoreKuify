<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\DebtPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class KasirHutangController extends Controller
{
    /**
     * Display customer debt listing for Cashier.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $query = Customer::query();
        
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('phone', 'like', '%' . $search . '%');
            });
        }
        
        $customers = $query->orderBy('name', 'asc')->paginate(10)->withQueryString();
        
        return view('kasir.hutang.index', compact('customers', 'search'));
    }

    /**
     * Display customer debt detail for Cashier.
     */
    public function show(Customer $customer)
    {
        $transactions = $customer->transactions()
            ->with('items.product')
            ->orderBy('created_at', 'desc')
            ->get();

        $debtPayments = $customer->debtPayments()
            ->orderBy('created_at', 'desc')
            ->get();

        $history = collect();

        foreach ($transactions as $trx) {
            $history->push([
                'date' => $trx->created_at,
                'type' => 'purchase',
                'reference' => $trx->transaction_number,
                'total' => (float) $trx->total,
                'amount_paid' => (float) $trx->amount_paid,
                'remaining' => (float) $trx->remaining_amount,
                'payment_method' => $trx->payment_method,
                'status' => $trx->status,
                'items' => $trx->items,
                'model' => $trx,
            ]);
        }

        foreach ($debtPayments as $dp) {
            $history->push([
                'date' => $dp->created_at,
                'type' => 'payment',
                'reference' => $dp->reference,
                'amount' => (float) $dp->amount,
                'payment_method' => $dp->payment_method,
                'debt_before' => (float) $dp->debt_before,
                'debt_after' => (float) $dp->debt_after,
                'model' => $dp,
            ]);
        }

        $history = $history->sortByDesc('date')->values();

        $totalDebt = $customer->total_debt;
        $totalTransactions = $transactions->count();
        $totalPaid = $debtPayments->sum('amount');

        return view('kasir.hutang.show', compact(
            'customer',
            'history',
            'totalDebt',
            'totalTransactions',
            'totalPaid'
        ));
    }

    /**
     * Process a standalone debt payment for Cashier with concurrency safety.
     */
    public function payDebt(Request $request, Customer $customer)
    {
        // Normalize payment_method input to lowercase if passed in any casing
        if ($request->has('payment_method')) {
            $request->merge(['payment_method' => strtolower($request->input('payment_method'))]);
        }

        $request->validate([
            'amount' => ['required', 'numeric', 'min:1'],
            'payment_method' => ['required', 'in:cash,qris'],
        ]);

        $amount = (float) $request->input('amount');

        try {
            $debtPaymentId = DB::transaction(function () use ($customer, $amount, $request) {
                // Lock customer rows to prevent concurrent double-payment
                $lockedCustomer = Customer::lockForUpdate()->find($customer->id);

                // Recalculate current debt inside the transaction
                $transactionDebt = (float) $lockedCustomer->transactions()->sum('remaining_amount');
                $existingPayments = (float) $lockedCustomer->debtPayments()->sum('amount');
                $currentDebt = max(0, $transactionDebt - $existingPayments);

                if ($currentDebt <= 0) {
                    throw new \Exception('Pelanggan tidak memiliki hutang yang harus dibayar.');
                }

                if ($amount > $currentDebt) {
                    throw new \Exception("Jumlah pembayaran (Rp " . number_format($amount, 0, ',', '.') . ") melebihi hutang saat ini (Rp " . number_format($currentDebt, 0, ',', '.') . ").");
                }

                // Generate unique reference
                $date = now()->format('Ymd');
                do {
                    $reference = 'PAY-' . $date . '-' . strtoupper(Str::random(6));
                } while (DebtPayment::where('reference', $reference)->exists());

                $debtAfter = max(0, $currentDebt - $amount);

                $payment = DebtPayment::create([
                    'customer_id' => $lockedCustomer->id,
                    'amount' => $amount,
                    'payment_method' => $request->input('payment_method'),
                    'debt_before' => $currentDebt,
                    'debt_after' => $debtAfter,
                    'reference' => $reference,
                ]);

                return $payment->id;
            });

            return redirect()->route('kasir.hutang.payment.success', $debtPaymentId);

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['payment' => $e->getMessage()]);
        }
    }

    /**
     * Display the debt payment success receipt for Cashier.
     */
    public function paymentSuccess(DebtPayment $debtPayment)
    {
        $debtPayment->load('customer');

        return view('owner.hutang.payment-success', compact('debtPayment'));
    }
}
