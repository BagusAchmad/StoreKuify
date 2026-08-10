<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KasirDashboardController extends Controller
{
    /**
     * Display the operational dashboard for Cashier role.
     */
    public function index()
    {
        $today = Carbon::today();
        $user = Auth::user();

        // Count today's valid sales transactions processed by the current cashier
        $todayTransactionCount = Transaction::where('user_id', $user->id)
            ->whereDate('created_at', $today)
            ->count();

        // Recent 5 transactions processed by current cashier today
        $recentTransactions = Transaction::with('items.product')
            ->where('user_id', $user->id)
            ->whereDate('created_at', $today)
            ->latest()
            ->take(5)
            ->get();

        // Low stock products alert (stock <= 5), stock = 0 prioritized first
        $lowStockProducts = Product::with('category')
            ->where('is_active', true)
            ->where('stock', '<=', 5)
            ->orderByRaw('CASE WHEN stock = 0 THEN 0 ELSE 1 END, stock ASC')
            ->take(5)
            ->get();

        return view('kasir.dashboard', compact(
            'todayTransactionCount',
            'recentTransactions',
            'lowStockProducts'
        ));
    }
}
