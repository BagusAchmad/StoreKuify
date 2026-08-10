@extends('layouts.app')

@section('title', 'Hutang Pelanggan - StoreKuify')

@section('content')
<div x-data="{ sidebarOpen: false, showAddCustomerModal: false }" class="h-screen flex overflow-hidden bg-slate-50">
    
    @include('partials.sidebar_owner', ['active' => 'hutang'])

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col overflow-hidden">
        
        <!-- Header -->
        @include('partials.header', ['breadcrumbs' => [['label' => 'Dashboard', 'url' => route('owner.dashboard')], ['label' => 'Hutang Pelanggan']]])

        <!-- Main Scrollable Content -->
        <main class="flex-1 overflow-y-auto p-6 md:p-8 bg-slate-50 space-y-6">
            
            <!-- Breadcrumbs Action Header -->
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
                
                <button type="button" @click="showAddCustomerModal = true" class="inline-flex items-center gap-2 bg-[#1e5cfb] hover:bg-[#1a52db] text-white px-5 py-3 rounded-xl text-sm font-bold shadow-md shadow-blue-500/10 hover:shadow-blue-500/20 active:scale-[0.98] transition duration-150 cursor-pointer">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Tambah Pelanggan</span>
                </button>
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
                    <form action="{{ route('owner.hutang') }}" method="GET" class="relative flex-1 max-w-md">
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
                                    <!-- Name and Phone -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-slate-800">
                                        <div class="flex items-center gap-3">
                                            <div class="h-9 w-9 bg-blue-50 text-[#1e5cfb] rounded-full flex items-center justify-center font-extrabold text-sm uppercase">
                                                {{ substr($customer->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <span class="block text-slate-800">{{ $customer->name }}</span>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Phone -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-slate-500">
                                        {{ $customer->phone ?: '-' }}
                                    </td>
                                    
                                    <!-- Total Outstanding Debt -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-black {{ $totalDebt > 0 ? 'text-rose-600' : 'text-emerald-600' }}">
                                        Rp {{ number_format($totalDebt, 0, ',', '.') }}
                                    </td>
                                    
                                    <!-- Status Badge -->
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-xs font-bold">
                                        @if($hasDebt)
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-50 text-amber-600 border border-amber-200/50">
                                                Belum Lunas
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-200/50">
                                                Lunas
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Last Transaction Date -->
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-xs font-semibold text-slate-500">
                                        {{ $lastTrxDate }}
                                    </td>

                                    <!-- Actions links -->
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-xs font-bold pr-10">
                                        <a href="{{ route('owner.hutang.show', $customer) }}" class="text-blue-600 hover:text-blue-800 transition select-none">
                                            Lihat Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <div class="h-12 w-12 bg-slate-50 text-slate-400 rounded-full flex items-center justify-center mx-auto mb-3.5">
                                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </div>
                                        <h4 class="text-sm font-bold text-slate-700">
                                            {{ $search ? 'Hasil pencarian tidak ditemukan' : 'Belum ada pelanggan' }}
                                        </h4>
                                        <p class="text-slate-400 text-xs mt-1">
                                            {{ $search ? 'Coba masukkan kata kunci pencarian yang berbeda.' : 'Silakan tambahkan pelanggan baru menggunakan tombol di atas.' }}
                                        </p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Custom Table Pagination -->
                @if($customers->hasPages())
                    <div class="p-6 border-t border-slate-100 bg-slate-50/50">
                        {{ $customers->links() }}
                    </div>
                @endif

            </div>

        </main>
    </div>

    <!-- Tambah Pelanggan Modal (Alpine.js Interactive) -->
    <div x-show="showAddCustomerModal" 
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
        x-cloak>
        <div @click.away="showAddCustomerModal = false"
            class="bg-white rounded-2xl border border-slate-200/80 shadow-2xl p-6 w-full max-w-md"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="scale-95 opacity-0"
            x-transition:enter-end="scale-100 opacity-100">
            
            <div class="flex items-center gap-3 mb-4 pb-3 border-b border-slate-150">
                <div class="h-10 w-10 rounded-full bg-blue-50 text-[#1e5cfb] flex items-center justify-center">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                </div>
                <h3 class="text-base font-extrabold text-slate-800 tracking-tight">Tambah Pelanggan Baru</h3>
            </div>
            
            <form action="{{ route('owner.hutang.store') }}" method="POST" class="space-y-4 text-xs font-bold text-slate-700">
                @csrf
                <div>
                    <label class="block font-bold text-slate-500 mb-1.5">NAMA LENGKAP</label>
                    <input type="text" name="name" required class="w-full px-3.5 py-2.5 border border-slate-200 rounded-xl focus:outline-none focus:border-[#1e5cfb] bg-slate-50 focus:bg-white transition" placeholder="Masukkan nama pelanggan...">
                </div>
                
                <div>
                    <label class="block font-bold text-slate-500 mb-1.5">NO. HANDPHONE</label>
                    <input type="text" name="phone" required class="w-full px-3.5 py-2.5 border border-slate-200 rounded-xl focus:outline-none focus:border-[#1e5cfb] bg-slate-50 focus:bg-white transition" placeholder="Masukkan nomor handphone...">
                </div>

                <div class="flex justify-end gap-3 pt-3">
                    <button type="button" @click="showAddCustomerModal = false"
                        class="px-4.5 py-2.5 rounded-xl text-xs font-bold text-slate-500 bg-slate-100 hover:bg-slate-200 transition duration-150 cursor-pointer">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-4.5 py-2.5 rounded-xl text-xs font-bold text-white bg-[#1e5cfb] hover:bg-[#1a52db] transition duration-150 cursor-pointer shadow-md shadow-blue-500/10 hover:shadow-blue-500/20 active:scale-[0.98]">
                        Simpan Pelanggan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
