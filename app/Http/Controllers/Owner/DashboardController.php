<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the owner dashboard.
     */
    public function index()
    {
        // Card 1: Penjualan Hari Ini
        $salesToday = Transaction::whereDate('created_at', today())->sum('total');

        // Card 2: Keuntungan Hari Ini
        // Join with products table to calculate dynamically using selling price minus cost price
        $profitToday = TransactionItem::whereDate('transaction_items.created_at', today())
            ->join('products', 'transaction_items.product_id', '=', 'products.id')
            ->sum(DB::raw('(transaction_items.price - products.cost_price) * transaction_items.quantity'));

        // Card 3: Jumlah Transaksi
        $transactionCountToday = Transaction::whereDate('created_at', today())->count();

        // Card 4: Barang Terjual
        $itemsSoldToday = TransactionItem::whereDate('created_at', today())->sum('quantity');

        // Sales Trend chart data (Last 7 Days)
        $salesTrendData = Transaction::whereDate('created_at', '>=', now()->subDays(6))
            ->selectRaw('DATE(created_at) as date, SUM(total) as total')
            ->groupBy('date')
            ->pluck('total', 'date');

        $labels = [];
        $data = [];
        
        $dayNames = [
            'Monday' => 'Sen',
            'Tuesday' => 'Sel',
            'Wednesday' => 'Rab',
            'Thursday' => 'Kam',
            'Friday' => 'Jum',
            'Saturday' => 'Sab',
            'Sunday' => 'Min',
        ];

        for ($i = 6; $i >= 0; $i--) {
            $dateObj = now()->subDays($i);
            $dateStr = $dateObj->format('Y-m-d');
            $labels[] = $dayNames[$dateObj->format('l')] ?? substr($dateObj->format('l'), 0, 3);
            $data[] = (float) ($salesTrendData->get($dateStr) ?? 0);
        }

        $salesTrend = [
            'labels' => $labels,
            'data' => $data,
        ];

        // Low stock products collection using single config threshold
        $lowStockProducts = Product::where('is_active', true)
            ->where('stock', '<=', config('storekuify.low_stock_threshold', 5))
            ->orderBy('stock', 'asc')
            ->take(5)
            ->get();

        // Unpaid debts collection (unused placeholder for now)
        $unpaidDebts = collect();

        return view('owner.dashboard', compact(
            'salesToday',
            'profitToday',
            'transactionCountToday',
            'itemsSoldToday',
            'salesTrend',
            'lowStockProducts',
            'unpaidDebts'
        ));
    }
}
