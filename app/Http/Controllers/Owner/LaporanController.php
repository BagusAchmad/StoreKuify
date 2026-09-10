<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\DebtPayment;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    /**
     * Display the main Business Performance Report (Laporan Performa Bisnis).
     */
    public function index(Request $request)
    {
        $period = $request->input('period', 'bulanan');
        $customStartDate = $request->input('start_date');
        $customEndDate = $request->input('end_date');

        // Resolve date range based on selected period
        $dateRange = $this->resolveDateRange($period, $customStartDate, $customEndDate);
        
        $startDate = $dateRange['start'];
        $endDate = $dateRange['end'];
        $prevStartDate = $dateRange['prev_start'];
        $prevEndDate = $dateRange['prev_end'];
        $periodLabel = $dateRange['label'];
        $prevPeriodLabel = $dateRange['prev_label'];

        // 1. Calculate Summary Cards (Current vs Previous Period)
        $totalSales = (float) Transaction::whereBetween('created_at', [$startDate, $endDate])->sum('total');
        $prevTotalSales = (float) Transaction::whereBetween('created_at', [$prevStartDate, $prevEndDate])->sum('total');
        $salesChangePercent = $prevTotalSales > 0 ? round((($totalSales - $prevTotalSales) / $prevTotalSales) * 100, 1) : null;

        // Current period profit
        $totalProfit = (float) TransactionItem::join('transactions', 'transaction_items.transaction_id', '=', 'transactions.id')
            ->join('products', 'transaction_items.product_id', '=', 'products.id')
            ->whereBetween('transactions.created_at', [$startDate, $endDate])
            ->sum(DB::raw('(transaction_items.price - coalesce(transaction_items.cost_price, products.cost_price, 0)) * transaction_items.quantity'));

        // Previous period profit
        $prevTotalProfit = (float) TransactionItem::join('transactions', 'transaction_items.transaction_id', '=', 'transactions.id')
            ->join('products', 'transaction_items.product_id', '=', 'products.id')
            ->whereBetween('transactions.created_at', [$prevStartDate, $prevEndDate])
            ->sum(DB::raw('(transaction_items.price - coalesce(transaction_items.cost_price, products.cost_price, 0)) * transaction_items.quantity'));

        $profitChangePercent = $prevTotalProfit > 0 ? round((($totalProfit - $prevTotalProfit) / $prevTotalProfit) * 100, 1) : null;

        // Transaction count
        $transactionCount = Transaction::whereBetween('created_at', [$startDate, $endDate])->count();
        $prevTransactionCount = Transaction::whereBetween('created_at', [$prevStartDate, $prevEndDate])->count();
        $transactionCountChange = $transactionCount - $prevTransactionCount;

        // Total items sold
        $itemsSold = (int) TransactionItem::join('transactions', 'transaction_items.transaction_id', '=', 'transactions.id')
            ->whereBetween('transactions.created_at', [$startDate, $endDate])
            ->sum('transaction_items.quantity');

        $prevItemsSold = (int) TransactionItem::join('transactions', 'transaction_items.transaction_id', '=', 'transactions.id')
            ->whereBetween('transactions.created_at', [$prevStartDate, $prevEndDate])
            ->sum('transaction_items.quantity');
        $itemsSoldChange = $itemsSold - $prevItemsSold;

        // 2. Payment Method Distribution (Single GroupBy Query)
        $paymentMethodSummary = Transaction::whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('payment_method, count(*) as count, sum(total) as total, sum(amount_paid) as paid, sum(remaining_amount) as debt')
            ->groupBy('payment_method')
            ->get()
            ->keyBy('payment_method');

        $paymentMethodsData = [
            'cash' => ['count' => 0, 'total' => 0, 'paid' => 0, 'debt' => 0],
            'qris' => ['count' => 0, 'total' => 0, 'paid' => 0, 'debt' => 0],
            'debt' => ['count' => 0, 'total' => 0, 'paid' => 0, 'debt' => 0],
            'cash_debt' => ['count' => 0, 'total' => 0, 'paid' => 0, 'debt' => 0],
            'qris_debt' => ['count' => 0, 'total' => 0, 'paid' => 0, 'debt' => 0],
        ];

        $creditSalesTotal = 0;
        $newDebtGenerated = 0;

        foreach ($paymentMethodSummary as $method => $row) {
            if (isset($paymentMethodsData[$method])) {
                $paymentMethodsData[$method] = [
                    'count' => (int) $row->count,
                    'total' => (float) $row->total,
                    'paid' => (float) $row->paid,
                    'debt' => (float) $row->debt,
                ];
            }
            if (in_array($method, ['debt', 'cash_debt', 'qris_debt'])) {
                $creditSalesTotal += (float) $row->total;
            }
            $newDebtGenerated += (float) $row->debt;
        }

        // 3. Debt Summary
        $debtPaymentsCollected = (float) DebtPayment::whereBetween('created_at', [$startDate, $endDate])->sum('amount');
        
        // Total customer outstanding debt currently (Single aggregated query)
        $totalCustomerDebt = (float) Customer::withSum('transactions as total_tx_debt', 'remaining_amount')
            ->withSum('debtPayments as total_paid', 'amount')
            ->get()
            ->sum(function ($c) {
                return max(0, (float)($c->total_tx_debt ?? 0) - (float)($c->total_paid ?? 0));
            });

        // 4. Trend Charts Data Generation
        $trendData = $this->generateTrendData($period, $startDate, $endDate);

        // 5. Product Rankings (Direct SQL GroupBy)
        $productRankingsRaw = TransactionItem::join('transactions', 'transaction_items.transaction_id', '=', 'transactions.id')
            ->join('products', 'transaction_items.product_id', '=', 'products.id')
            ->whereBetween('transactions.created_at', [$startDate, $endDate])
            ->selectRaw('
                products.id as product_id,
                products.name as name,
                products.sku as sku,
                sum(transaction_items.quantity) as qty_sold,
                sum(transaction_items.subtotal) as sales,
                sum((transaction_items.price - coalesce(transaction_items.cost_price, products.cost_price, 0)) * transaction_items.quantity) as profit
            ')
            ->groupBy('products.id', 'products.name', 'products.sku')
            ->get();

        $topSellingProducts = $productRankingsRaw->sortByDesc(fn($p) => (int)$p->qty_sold)->take(5)->map(fn($p) => [
            'product_id' => $p->product_id,
            'name' => $p->name,
            'sku' => $p->sku,
            'qty_sold' => (int) $p->qty_sold,
            'sales' => (float) $p->sales,
            'profit' => (float) $p->profit,
        ])->values();

        $topProfitProducts = $productRankingsRaw->sortByDesc(fn($p) => (float)$p->profit)->take(5)->map(fn($p) => [
            'product_id' => $p->product_id,
            'name' => $p->name,
            'sku' => $p->sku,
            'qty_sold' => (int) $p->qty_sold,
            'sales' => (float) $p->sales,
            'profit' => (float) $p->profit,
        ])->values();

        // 6. Transaction Recap (Paginated)
        $recapTransactions = Transaction::whereBetween('created_at', [$startDate, $endDate])
            ->with(['user', 'customer', 'items.product'])
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view('owner.laporan.index', compact(
            'period',
            'customStartDate',
            'customEndDate',
            'startDate',
            'endDate',
            'periodLabel',
            'prevPeriodLabel',
            'totalSales',
            'salesChangePercent',
            'totalProfit',
            'profitChangePercent',
            'transactionCount',
            'transactionCountChange',
            'itemsSold',
            'itemsSoldChange',
            'paymentMethodsData',
            'creditSalesTotal',
            'newDebtGenerated',
            'debtPaymentsCollected',
            'totalCustomerDebt',
            'trendData',
            'topSellingProducts',
            'topProfitProducts',
            'recapTransactions'
        ));
    }

    /**
     * Export Transaction Recap for the selected period to CSV format.
     */
    public function export(Request $request)
    {
        $period = $request->input('period', 'bulanan');
        $customStartDate = $request->input('start_date');
        $customEndDate = $request->input('end_date');

        $dateRange = $this->resolveDateRange($period, $customStartDate, $customEndDate);
        $startDate = $dateRange['start'];
        $endDate = $dateRange['end'];

        $transactions = Transaction::whereBetween('created_at', [$startDate, $endDate])
            ->with(['user', 'customer'])
            ->orderBy('created_at', 'desc')
            ->get();

        $fileName = 'rekap_transaksi_' . $startDate->format('Ymd') . '_' . $endDate->format('Ymd') . '.csv';

        $headers = [
            "Content-type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $callback = function () use ($transactions) {
            $file = fopen('php://output', 'w');
            // Write UTF-8 BOM for Excel compatibility
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // CSV Header
            fputcsv($file, [
                'Tanggal',
                'No. Transaksi',
                'Kasir',
                'Pelanggan',
                'Total Belanja (Rp)',
                'Metode Pembayaran',
                'Jumlah Dibayar (Rp)',
                'Sisa Hutang (Rp)',
                'Status'
            ]);

            foreach ($transactions as $trx) {
                $statusLabel = $trx->status === 'paid' ? 'Lunas' : ($trx->status === 'partial' ? 'Sebagian' : 'Belum Lunas');
                $methodLabel = match ($trx->payment_method) {
                    'cash' => 'Tunai',
                    'qris' => 'QRIS',
                    'debt' => 'Hutang',
                    'cash_debt' => 'Tunai + Hutang',
                    'qris_debt' => 'QRIS + Hutang',
                    default => ucfirst($trx->payment_method),
                };

                fputcsv($file, [
                    $trx->created_at->format('d/m/Y H:i'),
                    $trx->transaction_number,
                    optional($trx->user)->name ?? 'System',
                    optional($trx->customer)->name ?? '-',
                    $trx->total,
                    $methodLabel,
                    $trx->amount_paid,
                    $trx->remaining_amount,
                    $statusLabel,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Resolve start date, end date, and previous period dates based on period filter.
     */
    private function resolveDateRange(string $period, ?string $customStart, ?string $customEnd): array
    {
        $anchor = !empty($customStart) ? Carbon::parse($customStart) : Carbon::now();

        switch ($period) {
            case 'harian':
                $start = $anchor->copy()->startOfDay();
                $end = $anchor->copy()->endOfDay();
                $prevStart = $anchor->copy()->subDay()->startOfDay();
                $prevEnd = $anchor->copy()->subDay()->endOfDay();
                $label = $start->translatedFormat('d F Y');
                $prevLabel = $prevStart->translatedFormat('d F Y');
                break;

            case 'mingguan':
                $start = $anchor->copy()->startOfWeek();
                $end = $anchor->copy()->endOfWeek();
                $prevStart = $anchor->copy()->subWeek()->startOfWeek();
                $prevEnd = $anchor->copy()->subWeek()->endOfWeek();
                $label = $start->translatedFormat('d M Y') . ' - ' . $end->translatedFormat('d M Y');
                $prevLabel = $prevStart->translatedFormat('d M Y') . ' - ' . $prevEnd->translatedFormat('d M Y');
                break;

            case 'tahunan':
                $start = $anchor->copy()->startOfYear();
                $end = $anchor->copy()->endOfYear();
                $prevStart = $anchor->copy()->subYear()->startOfYear();
                $prevEnd = $anchor->copy()->subYear()->endOfYear();
                $label = 'Tahun ' . $start->format('Y');
                $prevLabel = 'Tahun ' . $prevStart->format('Y');
                break;

            case 'custom':
                if (!empty($customStart) && !empty($customEnd)) {
                    $start = Carbon::parse($customStart)->startOfDay();
                    $end = Carbon::parse($customEnd)->endOfDay();
                    if ($start->gt($end)) {
                        $temp = $start;
                        $start = $end->copy()->startOfDay();
                        $end = $temp->copy()->endOfDay();
                    }
                } else {
                    $start = $anchor->copy()->startOfMonth();
                    $end = $anchor->copy()->endOfMonth();
                }

                $daysDiff = max(1, $start->diffInDays($end) + 1);
                $prevEnd = $start->copy()->subDay()->endOfDay();
                $prevStart = $prevEnd->copy()->subDays($daysDiff - 1)->startOfDay();
                $label = $start->translatedFormat('d M Y') . ' - ' . $end->translatedFormat('d M Y');
                $prevLabel = $prevStart->translatedFormat('d M Y') . ' - ' . $prevEnd->translatedFormat('d M Y');
                break;

            case 'bulanan':
            default:
                $period = 'bulanan';
                $start = $anchor->copy()->startOfMonth();
                $end = $anchor->copy()->endOfMonth();
                $prevStart = $anchor->copy()->subMonth()->startOfMonth();
                $prevEnd = $anchor->copy()->subMonth()->endOfMonth();
                $label = $start->translatedFormat('F Y');
                $prevLabel = $prevStart->translatedFormat('F Y');
                break;
        }

        return [
            'start' => $start,
            'end' => $end,
            'prev_start' => $prevStart,
            'prev_end' => $prevEnd,
            'label' => $label,
            'prev_label' => $prevLabel,
        ];
    }

    /**
     * Generate trend chart dataset (Sales & Profit over time).
     */
    private function generateTrendData(string $period, Carbon $startDate, Carbon $endDate): array
    {
        $labels = [];
        $salesData = [];
        $profitData = [];

        $driver = DB::connection()->getDriverName();
        $isSqlite = $driver === 'sqlite';

        if ($period === 'harian') {
            $hourExpr = $isSqlite ? "cast(strftime('%H', created_at) as integer)" : "HOUR(created_at)";
            $txHourExpr = $isSqlite ? "cast(strftime('%H', transactions.created_at) as integer)" : "HOUR(transactions.created_at)";

            $salesGroup = Transaction::whereBetween('created_at', [$startDate, $endDate])
                ->selectRaw("{$hourExpr} as hour_key, sum(total) as total_sales")
                ->groupBy('hour_key')
                ->pluck('total_sales', 'hour_key')
                ->mapWithKeys(fn($val, $key) => [(int)$key => (float)$val]);

            $profitGroup = TransactionItem::join('transactions', 'transaction_items.transaction_id', '=', 'transactions.id')
                ->join('products', 'transaction_items.product_id', '=', 'products.id')
                ->whereBetween('transactions.created_at', [$startDate, $endDate])
                ->selectRaw("{$txHourExpr} as hour_key, sum((transaction_items.price - coalesce(transaction_items.cost_price, products.cost_price, 0)) * transaction_items.quantity) as total_profit")
                ->groupBy('hour_key')
                ->pluck('total_profit', 'hour_key')
                ->mapWithKeys(fn($val, $key) => [(int)$key => (float)$val]);

            for ($h = 0; $h < 24; $h++) {
                $labels[] = sprintf('%02d:00', $h);
                $salesData[] = (float) ($salesGroup[$h] ?? 0);
                $profitData[] = (float) ($profitGroup[$h] ?? 0);
            }
        } elseif ($period === 'tahunan') {
            $monthExpr = $isSqlite ? "cast(strftime('%m', created_at) as integer)" : "MONTH(created_at)";
            $txMonthExpr = $isSqlite ? "cast(strftime('%m', transactions.created_at) as integer)" : "MONTH(transactions.created_at)";

            $salesGroup = Transaction::whereBetween('created_at', [$startDate, $endDate])
                ->selectRaw("{$monthExpr} as month_key, sum(total) as total_sales")
                ->groupBy('month_key')
                ->pluck('total_sales', 'month_key')
                ->mapWithKeys(fn($val, $key) => [(int)$key => (float)$val]);

            $profitGroup = TransactionItem::join('transactions', 'transaction_items.transaction_id', '=', 'transactions.id')
                ->join('products', 'transaction_items.product_id', '=', 'products.id')
                ->whereBetween('transactions.created_at', [$startDate, $endDate])
                ->selectRaw("{$txMonthExpr} as month_key, sum((transaction_items.price - coalesce(transaction_items.cost_price, products.cost_price, 0)) * transaction_items.quantity) as total_profit")
                ->groupBy('month_key')
                ->pluck('total_profit', 'month_key')
                ->mapWithKeys(fn($val, $key) => [(int)$key => (float)$val]);

            $monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
            for ($m = 1; $m <= 12; $m++) {
                $labels[] = $monthNames[$m - 1];
                $salesData[] = (float) ($salesGroup[$m] ?? 0);
                $profitData[] = (float) ($profitGroup[$m] ?? 0);
            }
        } else {
            $dateExpr = $isSqlite ? "date(created_at)" : "DATE(created_at)";
            $txDateExpr = $isSqlite ? "date(transactions.created_at)" : "DATE(transactions.created_at)";

            $salesGroup = Transaction::whereBetween('created_at', [$startDate, $endDate])
                ->selectRaw("{$dateExpr} as date_key, sum(total) as total_sales")
                ->groupBy('date_key')
                ->pluck('total_sales', 'date_key');

            $profitGroup = TransactionItem::join('transactions', 'transaction_items.transaction_id', '=', 'transactions.id')
                ->join('products', 'transaction_items.product_id', '=', 'products.id')
                ->whereBetween('transactions.created_at', [$startDate, $endDate])
                ->selectRaw("{$txDateExpr} as date_key, sum((transaction_items.price - coalesce(transaction_items.cost_price, products.cost_price, 0)) * transaction_items.quantity) as total_profit")
                ->groupBy('date_key')
                ->pluck('total_profit', 'date_key');

            $current = $startDate->copy()->startOfDay();
            while ($current->lte($endDate)) {
                $dateKey = $current->format('Y-m-d');
                $labels[] = $current->format('d M');
                $salesData[] = (float) ($salesGroup[$dateKey] ?? 0);
                $profitData[] = (float) ($profitGroup[$dateKey] ?? 0);
                $current->addDay();
            }
        }

        $hasData = array_sum($salesData) > 0 || array_sum($profitData) > 0;

        return [
            'labels' => $labels,
            'sales' => $salesData,
            'profit' => $profitData,
            'has_data' => $hasData,
        ];
    }
}
