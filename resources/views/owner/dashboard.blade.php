@extends('layouts.app')

@section('title', 'Dashboard Owner - StoreKuify')

@section('content')
<div x-data="{ sidebarOpen: false }" class="h-screen flex overflow-hidden bg-slate-50">
    
    @include('partials.sidebar_owner', ['active' => 'dashboard'])

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col overflow-hidden">
        
        <!-- Header -->
        @include('partials.header', ['breadcrumbs' => [['label' => 'Beranda', 'url' => route('owner.dashboard')], ['label' => 'Dashboard']]])

        <!-- Main Scrollable Dashboard Content -->
        <main class="flex-1 overflow-y-auto p-6 md:p-8 bg-slate-50 space-y-6">
            
            <!-- Dashboard Title Section -->
            <div>
                <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">Ringkasan Hari Ini</h2>
                <p class="text-slate-500 text-sm mt-0.5">Pantau performa warung Anda secara real-time.</p>
            </div>

            <!-- Summary Cards Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6">
                <!-- Card 1: Penjualan Hari Ini -->
                <div class="bg-white border border-slate-200/60 rounded-2xl p-6 flex flex-col justify-between shadow-sm relative overflow-hidden">
                    <div class="flex justify-between items-start">
                        <div>
                            <span class="text-xs font-bold text-slate-400 block tracking-wide uppercase">Penjualan Hari Ini</span>
                            <span class="text-2xl font-extrabold text-slate-800 block mt-2">
                                Rp {{ number_format($salesToday, 0, ',', '.') }}
                            </span>
                        </div>
                        <div class="h-10 w-10 bg-blue-50 text-[#1e5cfb] rounded-xl flex items-center justify-center">
                            <!-- Money / Sales Icon -->
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center gap-1 text-[11px] font-bold text-slate-400">
                        <svg class="h-3.5 w-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>0% dari kemarin</span>
                    </div>
                </div>

                <!-- Card 2: Keuntungan Hari Ini -->
                <div class="bg-white border border-slate-200/60 rounded-2xl p-6 flex flex-col justify-between shadow-sm">
                    <div class="flex justify-between items-start">
                        <div>
                            <span class="text-xs font-bold text-slate-400 block tracking-wide uppercase">Keuntungan Hari Ini</span>
                            <span class="text-2xl font-extrabold text-[#10b981] block mt-2">
                                Rp {{ number_format($profitToday, 0, ',', '.') }}
                            </span>
                        </div>
                        <div class="h-10 w-10 bg-emerald-50 text-[#10b981] rounded-xl flex items-center justify-center">
                            <!-- Profit Wallet Icon -->
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center gap-1 text-[11px] font-bold text-slate-400">
                        <svg class="h-3.5 w-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>0% dari kemarin</span>
                    </div>
                </div>

                <!-- Card 3: Jumlah Transaksi -->
                <div class="bg-white border border-slate-200/60 rounded-2xl p-6 flex flex-col justify-between shadow-sm">
                    <div class="flex justify-between items-start">
                        <div>
                            <span class="text-xs font-bold text-slate-400 block tracking-wide uppercase">Jumlah Transaksi</span>
                            <span class="text-2xl font-extrabold text-slate-800 block mt-2">
                                {{ $transactionCountToday }}
                            </span>
                        </div>
                        <div class="h-10 w-10 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center">
                            <!-- Receipt / Transaction Icon -->
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 text-[11px] font-bold text-slate-400">
                        <span>Transaksi hari ini</span>
                    </div>
                </div>

                <!-- Card 4: Barang Terjual -->
                <div class="bg-white border border-slate-200/60 rounded-2xl p-6 flex flex-col justify-between shadow-sm">
                    <div class="flex justify-between items-start">
                        <div>
                            <span class="text-xs font-bold text-slate-400 block tracking-wide uppercase">Barang Terjual</span>
                            <span class="text-2xl font-extrabold text-slate-800 block mt-2">
                                {{ $itemsSoldToday }} <span class="text-sm font-bold text-slate-400">unit</span>
                            </span>
                        </div>
                        <div class="h-10 w-10 bg-blue-50 text-blue-500 rounded-xl flex items-center justify-center">
                            <!-- Shopping Bag Icon -->
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 text-[11px] font-bold text-slate-400">
                        <span>Total item keluar</span>
                    </div>
                </div>
            </div>

            <!-- Lower Dashboard Grid (Charts and metrics list) -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Left/Center: Sales Trend Chart Container -->
                <div class="lg:col-span-2 bg-white border border-slate-200/60 rounded-2xl p-6 shadow-sm flex flex-col justify-between min-h-[360px]">
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <h3 class="text-base font-extrabold text-slate-800 tracking-tight">Tren Penjualan (7 Hari Terakhir)</h3>
                            <p class="text-slate-400 text-xs mt-0.5">Grafik perbandingan transaksi harian.</p>
                        </div>
                        <a href="{{ route('owner.laporan') }}" class="text-xs text-[#1e5cfb] hover:text-[#1a52db] font-bold transition duration-150">
                            Lihat Laporan Lengkap
                        </a>
                    </div>

                    <!-- SVG Vector Line Chart (Flat Zero Baseline) -->
                    <div class="flex-1 w-full relative flex items-center justify-center">
                        <svg class="w-full h-full min-h-[220px]" viewBox="0 0 600 240" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <!-- Grid Y-axis indicators -->
                            <text x="35" y="45" fill="#94a3b8" font-size="10" font-weight="bold">1.5M</text>
                            <line x1="50" y1="40" x2="560" y2="40" stroke="#f1f5f9" stroke-width="1.5" stroke-dasharray="4 4" />

                            <text x="35" y="105" fill="#94a3b8" font-size="10" font-weight="bold">1M</text>
                            <line x1="50" y1="100" x2="560" y2="100" stroke="#f1f5f9" stroke-width="1.5" stroke-dasharray="4 4" />

                            <text x="35" y="165" fill="#94a3b8" font-size="10" font-weight="bold">500k</text>
                            <line x1="50" y1="160" x2="560" y2="160" stroke="#f1f5f9" stroke-width="1.5" stroke-dasharray="4 4" />

                            <text x="35" y="215" fill="#94a3b8" font-size="10" font-weight="bold">0</text>
                            <line x1="50" y1="210" x2="560" y2="210" stroke="#e2e8f0" stroke-width="1.5" />

                            <!-- X-axis Labels (Days of Week) -->
                            @foreach($salesTrend['labels'] as $index => $label)
                                @php $x = 80 + ($index * 75); @endphp
                                <text x="{{ $x }}" y="232" fill="#64748b" font-size="11" font-weight="bold" text-anchor="middle">
                                    {{ $label }}
                                </text>
                            @endforeach

                            <!-- Baseline flat data path (representing zero sales) -->
                            <path d="M 80 210 L 155 210 L 230 210 L 305 210 L 380 210 L 455 210 L 530 210" stroke="#cbd5e1" stroke-width="3" stroke-linecap="round" fill="none" />
                            
                            <!-- Dots on the zero data line -->
                            @foreach($salesTrend['labels'] as $index => $label)
                                @php $x = 80 + ($index * 75); @endphp
                                <circle cx="{{ $x }}" cy="210" r="4.5" fill="#94a3b8" stroke="#ffffff" stroke-width="1.5" />
                            @endforeach

                            <!-- Overlay description for empty graph -->
                            <rect x="150" y="70" width="300" height="70" rx="16" fill="white" opacity="0.9" class="shadow-sm" />
                            <text x="300" y="102" text-anchor="middle" fill="#475569" font-size="13" font-weight="bold">Belum Ada Data Transaksi</text>
                            <text x="300" y="122" text-anchor="middle" fill="#94a3b8" font-size="10.5" font-weight="semibold">Grafik akan terisi saat modul Kasir mencatat penjualan.</text>
                        </svg>
                    </div>
                </div>

                <!-- Right Side Columns (Low stock & Debts list) -->
                <div class="space-y-6">
                    
                    <!-- Low Stock Widget Card -->
                    <div class="bg-white border border-slate-200/60 rounded-2xl p-6 shadow-sm flex flex-col justify-between">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="h-6 w-6 text-amber-500 bg-amber-50 rounded-lg flex items-center justify-center">
                                <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </span>
                            <h3 class="text-sm font-extrabold text-slate-800 tracking-tight">Barang Hampir Habis</h3>
                        </div>

                        <!-- Content Condition -->
                        <div class="flex-1 py-4 flex flex-col items-center justify-center text-center">
                            @if ($lowStockProducts->isEmpty())
                                <div class="h-12 w-12 bg-emerald-50 text-emerald-500 rounded-full flex items-center justify-center mb-3">
                                    <svg class="h-6.5 w-6.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </div>
                                <h4 class="text-xs font-bold text-slate-800">Stok Barang Aman</h4>
                                <p class="text-slate-400 text-[10.5px] mt-1">Semua barang memiliki jumlah persediaan yang memadai.</p>
                            @else
                                <!-- Future products listing loop will reside here -->
                            @endif
                        </div>

                        <!-- Footer Action Button -->
                        <div class="mt-4 pt-3 border-t border-slate-100">
                            <a href="{{ route('owner.barang') }}" class="w-full flex justify-center bg-slate-50 hover:bg-slate-100 text-slate-600 hover:text-slate-800 py-2 rounded-xl text-xs font-bold transition duration-150">
                                Cek Stok Lainnya
                            </a>
                        </div>
                    </div>

                    <!-- Unpaid Debt Widget Card -->
                    <div class="bg-white border border-slate-200/60 rounded-2xl p-6 shadow-sm flex flex-col justify-between">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="h-6 w-6 text-rose-500 bg-rose-50 rounded-lg flex items-center justify-center">
                                <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </span>
                            <h3 class="text-sm font-extrabold text-slate-800 tracking-tight">Hutang Belum Lunas</h3>
                        </div>

                        <!-- Content Condition -->
                        <div class="flex-1 py-4 flex flex-col items-center justify-center text-center">
                            @if ($unpaidDebts->isEmpty())
                                <div class="h-12 w-12 bg-emerald-50 text-emerald-500 rounded-full flex items-center justify-center mb-3">
                                    <svg class="h-6.5 w-6.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <h4 class="text-xs font-bold text-slate-800">Semua Tagihan Lunas</h4>
                                <p class="text-slate-400 text-[10.5px] mt-1">Tidak ada catatan hutang pelanggan yang belum lunas.</p>
                            @else
                                <!-- Future unpaid debts loop will reside here -->
                            @endif
                        </div>

                        <!-- Footer Action Link -->
                        <div class="mt-4 pt-3 border-t border-slate-100">
                            <a href="{{ route('owner.hutang') }}" class="w-full flex justify-center bg-slate-50 hover:bg-slate-100 text-slate-600 hover:text-slate-800 py-2 rounded-xl text-xs font-bold transition duration-150">
                                Lihat Catatan Hutang
                            </a>
                        </div>
                    </div>

                </div>

            </div>

        </main>
    </div>
</div>
@endsection
