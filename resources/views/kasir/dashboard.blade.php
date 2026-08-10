@extends('layouts.app')

@section('title', 'Dashboard Kasir - StoreKuify')

@section('content')
<div class="min-h-screen bg-slate-50 flex overflow-hidden" x-data="{ sidebarOpen: false }">
    
    <!-- Cashier Dedicated Sidebar -->
    @include('partials.sidebar_kasir', ['active' => 'dashboard'])

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col overflow-hidden">
        
        <!-- Header -->
        @include('partials.header', ['title' => 'Dashboard Kasir'])

        <!-- Main Scrollable Content -->
        <main class="flex-1 overflow-y-auto p-6 md:p-8 space-y-6">
            
            <!-- Page Title Header -->
            <div>
                <h2 class="text-2xl font-black text-slate-800 tracking-tight">Dashboard Kasir</h2>
                <p class="text-xs font-bold text-slate-400 mt-0.5">Ringkasan operasional Anda hari ini.</p>
            </div>

            <!-- Dashboard Main Layout Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                
                <!-- Left Main Section (8 cols) -->
                <div class="lg:col-span-8 space-y-6">
                    
                    <!-- Today's Transaction Summary Card -->
                    <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <div class="h-12 w-12 rounded-2xl bg-blue-50 border border-blue-100 text-[#1e5cfb] flex items-center justify-center shrink-0">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-base font-extrabold text-slate-800">Ringkasan Transaksi Anda Hari Ini</h3>
                                <p class="text-xs font-semibold text-slate-400 mt-0.5">Total transaksi yang berhasil diproses hari ini.</p>
                            </div>
                        </div>

                        <div class="text-left sm:text-right shrink-0">
                            <div class="flex items-baseline gap-1.5 justify-start sm:justify-end">
                                <span class="text-3xl font-black text-[#1e5cfb] tracking-tight">{{ $todayTransactionCount }}</span>
                                <span class="text-xs font-bold text-slate-500">Transaksi</span>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Action Cards Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Card 1: Mulai Transaksi -->
                        <a href="{{ route('kasir.pos') }}" class="group bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm hover:shadow-md hover:border-blue-300 transition duration-150 flex flex-col justify-between space-y-4">
                            <div class="flex items-center justify-between">
                                <div class="h-10 w-10 rounded-xl bg-blue-50 text-[#1e5cfb] flex items-center justify-center group-hover:scale-105 transition transform">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17" />
                                    </svg>
                                </div>
                                <svg class="h-5 w-5 text-slate-300 group-hover:text-[#1e5cfb] group-hover:translate-x-1 transition transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-sm font-extrabold text-slate-800 group-hover:text-[#1e5cfb] transition">Mulai Transaksi (Kasir)</h4>
                                <p class="text-xs text-slate-400 font-semibold mt-0.5">Buka modul kasir untuk melayani pelanggan.</p>
                            </div>
                        </a>

                        <!-- Card 2: Hutang Pelanggan -->
                        <a href="{{ route('kasir.hutang') }}" class="group bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm hover:shadow-md hover:border-blue-300 transition duration-150 flex flex-col justify-between space-y-4">
                            <div class="flex items-center justify-between">
                                <div class="h-10 w-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center group-hover:scale-105 transition transform">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                    </svg>
                                </div>
                                <svg class="h-5 w-5 text-slate-300 group-hover:text-indigo-600 group-hover:translate-x-1 transition transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-sm font-extrabold text-slate-800 group-hover:text-indigo-600 transition">Hutang Pelanggan</h4>
                                <p class="text-xs text-slate-400 font-semibold mt-0.5">Kelola catatan kasbon dan pembayaran.</p>
                            </div>
                        </a>
                    </div>

                    <!-- Recent Transactions Table Section -->
                    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                            <h3 class="text-sm font-extrabold text-slate-800">Riwayat Transaksi Terakhir Anda</h3>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-slate-50/80 text-[10px] font-black text-slate-400 uppercase tracking-wider border-b border-slate-100">
                                        <th class="px-6 py-3">Waktu</th>
                                        <th class="px-6 py-3">ID Transaksi</th>
                                        <th class="px-6 py-3">Item</th>
                                        <th class="px-6 py-3">Total</th>
                                        <th class="px-6 py-3 text-right">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 text-xs font-semibold text-slate-700">
                                    @forelse($recentTransactions as $tx)
                                        <tr class="hover:bg-slate-50/60 transition">
                                            <td class="px-6 py-3.5 text-slate-400 font-bold whitespace-nowrap">
                                                {{ $tx->created_at->format('h:i A') }}
                                            </td>
                                            <td class="px-6 py-3.5 font-bold text-slate-800 whitespace-nowrap">
                                                {{ $tx->transaction_number }}
                                            </td>
                                            <td class="px-6 py-3.5 text-slate-500 max-w-xs truncate">
                                                @php
                                                    $itemCount = $tx->items->count();
                                                    $sampleItems = $tx->items->take(3)->map(fn($i) => $i->product->name ?? 'Barang')->join(', ');
                                                @endphp
                                                {{ $itemCount }} Item ({{ $sampleItems }})
                                            </td>
                                            <td class="px-6 py-3.5 font-extrabold text-slate-800 whitespace-nowrap">
                                                Rp {{ number_format($tx->total, 0, ',', '.') }}
                                            </td>
                                            <td class="px-6 py-3.5 text-right whitespace-nowrap">
                                                <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold bg-blue-50 text-[#1e5cfb] border border-blue-200">
                                                    Selesai
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-8 text-center text-slate-400">
                                                <p class="text-xs font-bold text-slate-500">Belum ada transaksi hari ini.</p>
                                                <p class="text-[10px] text-slate-400 mt-0.5">Mulai melayani transaksi kasir pertama Anda!</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Right Side Low Stock Alert Section (4 cols) -->
                <div class="lg:col-span-4 space-y-6">
                    <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm space-y-4">
                        <!-- Panel Header -->
                        <div class="flex items-center gap-2 border-b border-slate-100 pb-3">
                            <svg class="h-5 w-5 text-amber-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <h3 class="text-sm font-extrabold text-slate-800">Barang Hampir Habis</h3>
                        </div>

                        <!-- Low Stock Items List -->
                        <div class="space-y-3">
                            @forelse($lowStockProducts as $prod)
                                <div class="flex items-center justify-between p-2.5 rounded-xl bg-slate-50/70 border border-slate-100">
                                    <div class="min-w-0 pr-2">
                                        <h4 class="text-xs font-bold text-slate-800 truncate">{{ $prod->name }}</h4>
                                        <p class="text-[10px] font-semibold text-slate-400 mt-0.5 truncate">
                                            Kategori: {{ $prod->category->name ?? 'Umum' }}
                                        </p>
                                    </div>
                                    @if($prod->stock == 0)
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-black bg-rose-100 text-rose-600 border border-rose-200 shrink-0">
                                            Sisa 0
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-black bg-amber-100 text-amber-600 border border-amber-200 shrink-0">
                                            Sisa {{ $prod->stock }}
                                        </span>
                                    @endif
                                </div>
                            @empty
                                <div class="py-6 text-center text-slate-400">
                                    <svg class="h-8 w-8 text-emerald-400 mx-auto mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p class="text-xs font-bold text-slate-600">Semua stok aman</p>
                                    <p class="text-[10px] text-slate-400">Tidak ada barang dengan stok &le; 5.</p>
                                </div>
                            @endforelse
                        </div>

                        <!-- View All Stock Button -->
                        <div class="pt-2">
                            <a href="{{ route('kasir.barang') }}" class="w-full py-2.5 px-4 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl text-center block transition duration-150">
                                Lihat Semua Stok
                            </a>
                        </div>
                    </div>
                </div>

            </div>

        </main>
    </div>
</div>
@endsection
