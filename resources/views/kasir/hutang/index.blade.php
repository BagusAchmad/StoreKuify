@extends('layouts.app')

@section('title', 'Hutang Pelanggan - StoreKuify Kasir')

@section('content')
<div x-data="{ sidebarOpen: false }" class="h-screen flex overflow-hidden bg-slate-50">
    
    <!-- Kasir Sidebar -->
    @include('partials.sidebar_kasir', ['active' => 'hutang'])

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col overflow-hidden">
        
        <!-- Header -->
        @include('partials.header', ['breadcrumbs' => [['label' => 'Dashboard', 'url' => route('kasir.dashboard')], ['label' => 'Hutang Pelanggan']]])

        <!-- Main Scrollable Content -->
        <main class="flex-1 overflow-y-auto p-6 md:p-8 bg-slate-50 space-y-6">
            
            <!-- Breadcrumbs Header -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <div class="text-xs font-bold text-slate-400 flex items-center gap-1">
                        <span>Dashboard</span>
                        <span class="text-slate-300">/</span>
                        <span class="text-slate-600 font-extrabold">Hutang Pelanggan</span>
                    </div>
                    <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight mt-1.5">Daftar Hutang Pelanggan</h2>
                    <p class="text-xs text-slate-500 font-semibold mt-0.5">Kelola catatan kasbon dan pembayaran pelanggan.</p>
                </div>
            </div>

            <!-- Toast Success Alert -->
            @if(session('success'))
                <div class="p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-600 text-sm font-semibold flex items-center gap-3">
                    <svg class="h-5 w-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- Search and List Table -->
            <div class="bg-white border border-slate-200/60 rounded-2xl shadow-sm overflow-hidden flex flex-col justify-between">
                
                <!-- Search input -->
                <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-stretch sm:items-center gap-4">
                    <form action="{{ route('kasir.hutang') }}" method="GET" class="relative flex-1 max-w-md">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ $search }}"
                            class="block w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:bg-white focus:border-[#1e5cfb] focus:ring-1 focus:ring-[#1e5cfb] transition duration-150"
                            placeholder="Cari nama pelanggan atau nomor HP...">
                    </form>
                </div>

                <!-- Table Content -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100">
                        <thead class="bg-slate-50/75">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">
                                    Nama Pelanggan
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">
                                    No. Handphone
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">
                                    Total Hutang
                                </th>
                                <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-slate-400 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-slate-400 uppercase tracking-wider">
                                    Tgl. Transaksi Terakhir
                                </th>
                                <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-slate-400 uppercase tracking-wider pr-10">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-100">
                            @forelse($customers as $customer)
                                @php
                                    $totalDebt = $customer->total_debt;
                                    $hasDebt = $totalDebt > 0;
                                    $lastTrx = $customer->transactions()->latest()->first();
                                    $lastTrxDate = $lastTrx ? $lastTrx->created_at->format('d M Y, H:i') : '-';
                                @endphp
                                <tr class="hover:bg-slate-50/40 transition duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-slate-800">
                                        <div class="flex items-center gap-3">
                                            <div class="h-9 w-9 bg-blue-50 text-[#1e5cfb] rounded-full flex items-center justify-center font-extrabold text-sm uppercase">
                                                {{ substr($customer->name, 0, 1) }}
                                            </div>
                                            <span>{{ $customer->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-slate-500">
                                        {{ $customer->phone ?: '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-black">
                                        @if($hasDebt)
                                            <span class="text-rose-600">Rp {{ number_format($totalDebt, 0, ',', '.') }}</span>
                                        @else
                                            <span class="text-emerald-600">Rp 0</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @if($hasDebt)
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-600 border border-amber-200/50">
                                                Belum Lunas
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-600 border border-emerald-200/50">
                                                Lunas
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-xs font-semibold text-slate-500">
                                        {{ $lastTrxDate }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-xs font-bold pr-10">
                                        <a href="{{ route('kasir.hutang.show', $customer) }}" class="text-blue-600 hover:text-blue-800 transition select-none">
                                            Lihat Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <h4 class="text-sm font-bold text-slate-700">Tidak ada pelanggan ditemukan</h4>
                                        <p class="text-slate-400 text-xs mt-1">Coba gunakan kata kunci pencarian yang lain.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($customers->hasPages())
                    <div class="px-6 py-4 border-t border-slate-100">
                        {{ $customers->links() }}
                    </div>
                @endif
            </div>

        </main>
    </div>
</div>
@endsection
