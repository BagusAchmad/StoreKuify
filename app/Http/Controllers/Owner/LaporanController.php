<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\DebtPayment;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Http\Request;

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

        // Current period items & profit
        $items = TransactionItem::whereHas('transaction', function ($q) use ($startDate, $endDate) {
            $q->whereBetween('created_at', [$startDate, $endDate]);
        })->with(['transaction', 'product' => function ($q) {
            $q->withTrashed();
        }])->get();

        $totalProfit = (float) $items->sum(function ($item) {
            $cost = $item->cost_price ?? (optional($item->product)->cost_price ?? 0);
            return ((float) $item->price - (float) $cost) * (int) $item->quantity;
        });

        // Previous period items & profit
        $prevItems = TransactionItem::whereHas('transaction', function ($q) use ($prevStartDate, $prevEndDate) {
            $q->whereBetween('created_at', [$prevStartDate, $prevEndDate]);
        })->with(['product' => function ($q) {
            $q->withTrashed();
        }])->get();

        $prevTotalProfit = (float) $prevItems->sum(function ($item) {
            $cost = $item->cost_price ?? (optional($item->product)->cost_price ?? 0);
            return ((float) $item->price - (float) $cost) * (int) $item->quantity;
        });

        $profitChangePercent = $prevTotalProfit > 0 ? round((($totalProfit - $prevTotalProfit) / $prevTotalProfit) * 100, 1) : null;

        // Transaction count
        $transactionCount = Transaction::whereBetween('created_at', [$startDate, $endDate])->count();
        $prevTransactionCount = Transaction::whereBetween('created_at', [$prevStartDate, $prevEndDate])->count();
        $transactionCountChange = $transactionCount - $prevTransactionCount;

        // Total items sold
        $itemsSold = (int) $items->sum('quantity');
        $prevItemsSold = (int) $prevItems->sum('quantity');
        $itemsSoldChange = $itemsSold - $prevItemsSold;

        // 2. Payment Method Distribution
        $transactionsInPeriod = Transaction::whereBetween('created_at', [$startDate, $endDate])->get();
        $paymentMethodsData = [
            'cash' => ['count' => 0, 'total' => 0, 'paid' => 0, 'debt' => 0],
            'qris' => ['count' => 0, 'total' => 0, 'paid' => 0, 'debt' => 0],
            'debt' => ['count' => 0, 'total' => 0, 'paid' => 0, 'debt' => 0],
            'cash_debt' => ['count' => 0, 'total' => 0, 'paid' => 0, 'debt' => 0],
            'qris_debt' => ['count' => 0, 'total' => 0, 'paid' => 0, 'debt' => 0],
        ];

        foreach ($transactionsInPeriod as $trx) {
            $method = $trx->payment_method;
            if (isset($paymentMethodsData[$method])) {
                $paymentMethodsData[$method]['count']++;
                $paymentMethodsData[$method]['total'] += (float) $trx->total;
                $paymentMethodsData[$method]['paid'] += (float) $trx->amount_paid;
                $paymentMethodsData[$method]['debt'] += (float) $trx->remaining_amount;
            }
        }

        // 3. Debt Summary
        $creditSalesTotal = (float) $transactionsInPeriod->whereIn('payment_method', ['debt', 'cash_debt', 'qris_debt'])->sum('total');
        $newDebtGenerated = (float) $transactionsInPeriod->sum('remaining_amount');
        $debtPaymentsCollected = (float) DebtPayment::whereBetween('created_at', [$startDate, $endDate])->sum('amount');
        
        // Total customer outstanding debt currently
        $allCustomers = Customer::all();
        $totalCustomerDebt = (float) $allCustomers->sum('total_debt');

        // 4. Trend Charts Data Generation
        $trendData = $this->generateTrendData($period, $startDate, $endDate, $transactionsInPeriod, $items);

        // 5. Product Rankings
        $groupedByProduct = $items->groupBy('product_id');
        $productRankings = collect();

        foreach ($groupedByProduct as $productId => $prodItems) {
            $firstItem = $prodItems->first();
            $productName = optional($firstItem->product)->name ?? 'Produk tidak tersedia';
            $sku = optional($firstItem->product)->sku ?? '-';
            
            $qtySold = (int) $prodItems->sum('quantity');
            $salesAmount = (float) $prodItems->sum('subtotal');
            $profitAmount = (float) $prodItems->sum(function ($item) {
                $cost = $item->cost_price ?? (optional($item->product)->cost_price ?? 0);
                return ((float) $item->price - (float) $cost) * (int) $item->quantity;
            });

            $productRankings->push([
                'product_id' => $productId,
                'name' => $productName,
                'sku' => $sku,
                'qty_sold' => $qtySold,
                'sales' => $salesAmount,
                'profit' => $profitAmount,
            ]);
        }

        $topSellingProducts = $productRankings->sortByDesc('qty_sold')->take(5)->values();
        $topProfitProducts = $productRankings->sortByDesc('profit')->take(5)->values();

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
    private function generateTrendData(string $period, Carbon $startDate, Carbon $endDate, $transactions, $items): array
    {
        $labels = [];
        $salesData = [];
        $profitData = [];

        if ($period === 'harian') {
            // Group by hour 00:00 to 23:00
            for ($h = 0; $h < 24; $h++) {
                $labels[] = sprintf('%02d:00', $h);
                $salesData[] = 0;
                $profitData[] = 0;
            }

            foreach ($transactions as $trx) {
                $hour = (int) $trx->created_at->format('H');
                if (isset($salesData[$hour])) {
                    $salesData[$hour] += (float) $trx->total;
                }
            }

            foreach ($items as $item) {
                $hour = (int) $item->transaction->created_at->format('H');
                if (isset($profitData[$hour])) {
                    $cost = $item->cost_price ?? (optional($item->product)->cost_price ?? 0);
                    $profitData[$hour] += ((float) $item->price - (float) $cost) * (int) $item->quantity;
                }
            }
        } elseif ($period === 'tahunan') {
            // Group by month 1 to 12
            $monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
            for ($m = 1; $m <= 12; $m++) {
                $labels[] = $monthNames[$m - 1];
                $salesData[] = 0;
                $profitData[] = 0;
            }

            foreach ($transactions as $trx) {
                $m = (int) $trx->created_at->format('n') - 1;
                if (isset($salesData[$m])) {
                    $salesData[$m] += (float) $trx->total;
                }
            }

            foreach ($items as $item) {
                $m = (int) $item->transaction->created_at->format('n') - 1;
                if (isset($profitData[$m])) {
                    $cost = $item->cost_price ?? (optional($item->product)->cost_price ?? 0);
                    $profitData[$m] += ((float) $item->price - (float) $cost) * (int) $item->quantity;
                }
            }
        } else {
            // Daily grouping for mingguan, bulanan, or custom
            $current = $startDate->copy()->startOfDay();
            $dateMap = [];
            $index = 0;

            while ($current->lte($endDate)) {
                $dateKey = $current->format('Y-m-d');
                $labels[] = $current->format('d M');
                $salesData[] = 0;
                $profitData[] = 0;
                $dateMap[$dateKey] = $index;
                $index++;
                $current->addDay();
            }

            foreach ($transactions as $trx) {
                $dateKey = $trx->created_at->format('Y-m-d');
                if (isset($dateMap[$dateKey])) {
                    $idx = $dateMap[$dateKey];
                    $salesData[$idx] += (float) $trx->total;
                }
            }

            foreach ($items as $item) {
                $dateKey = $item->transaction->created_at->format('Y-m-d');
                if (isset($dateMap[$dateKey])) {
                    $idx = $dateMap[$dateKey];
                    $cost = $item->cost_price ?? (optional($item->product)->cost_price ?? 0);
                    $profitData[$idx] += ((float) $item->price - (float) $cost) * (int) $item->quantity;
                }
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
