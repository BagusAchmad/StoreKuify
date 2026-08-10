@extends('layouts.app')

@section('title', 'Data Barang - StoreKuify Kasir')

@section('content')
<div x-data="{ sidebarOpen: false }" class="h-screen flex overflow-hidden bg-slate-50">
    
    <!-- Kasir Sidebar -->
    @include('partials.sidebar_kasir', ['active' => 'barang'])

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col overflow-hidden">
        
        <!-- Header -->
        @include('partials.header', ['breadcrumbs' => [['label' => 'Dashboard', 'url' => route('kasir.dashboard')], ['label' => 'Data Barang']]])

        <!-- Main Scrollable Content -->
        <main class="flex-1 overflow-y-auto p-6 md:p-8 bg-slate-50 space-y-6">
            
            <!-- Header Title -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <div class="text-xs font-bold text-slate-400 flex items-center gap-1">
                        <span>Dashboard</span>
                        <span class="text-slate-300">/</span>
                        <span class="text-slate-600 font-extrabold">Data Barang</span>
                    </div>
                    <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight mt-1.5">Kategori & Stok Barang</h2>
                </div>
            </div>

            <!-- Summary Cards Grid (Matching Owner Style without Financial Metrics) -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <!-- Card 1: Total Kategori -->
                <div class="bg-white border border-slate-200/60 rounded-2xl p-6 flex flex-col justify-between shadow-sm">
                    <div class="flex justify-between items-start">
                        <div>
                            <span class="text-xs font-bold text-slate-400 block tracking-wide uppercase">Total Kategori</span>
                            <span class="text-2xl font-extrabold text-slate-800 block mt-2">{{ $totalCategories }}</span>
                        </div>
                        <div class="h-10 w-10 bg-blue-50 text-[#1e5cfb] rounded-xl flex items-center justify-center">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Total Varian Barang -->
                <div class="bg-white border border-slate-200/60 rounded-2xl p-6 flex flex-col justify-between shadow-sm">
                    <div class="flex justify-between items-start">
                        <div>
                            <span class="text-xs font-bold text-slate-400 block tracking-wide uppercase">Total Varian Barang</span>
                            <span class="text-2xl font-extrabold text-slate-800 block mt-2">{{ $totalProducts }}</span>
                        </div>
                        <div class="h-10 w-10 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Card 3: Barang Hampir Habis -->
                <div class="bg-white border border-slate-200/60 rounded-2xl p-6 flex flex-col justify-between shadow-sm">
                    <div class="flex justify-between items-start">
                        <div>
                            <span class="text-xs font-bold text-slate-400 block tracking-wide uppercase">Barang Hampir Habis</span>
                            <span class="text-2xl font-extrabold text-amber-600 block mt-2">{{ $lowStockCount }}</span>
                        </div>
                        <div class="h-10 w-10 bg-amber-50 text-amber-500 rounded-xl flex items-center justify-center">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Categories Table Section -->
            <div class="bg-white border border-slate-200/60 rounded-2xl shadow-sm overflow-hidden">
                
                <!-- Search Form -->
                <div class="p-6 border-b border-slate-100">
                    <form action="{{ route('kasir.barang') }}" method="GET" class="relative max-w-md">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ $search }}" 
                               class="block w-full pl-11 pr-10 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:bg-white focus:border-[#1e5cfb] focus:ring-1 focus:ring-[#1e5cfb] transition"
                               placeholder="Cari kategori...">
                        @if($search)
                            <a href="{{ route('kasir.barang') }}" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </a>
                        @endif
                    </form>
                </div>

                <!-- Table Container -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/80 text-[10px] font-black text-slate-400 uppercase tracking-wider border-b border-slate-100">
                                <th class="px-6 py-3">Nama Kategori</th>
                                <th class="px-6 py-3">Deskripsi</th>
                                <th class="px-6 py-3 text-center">Jumlah Barang</th>
                                <th class="px-6 py-3 text-center">Total Stok</th>
                                <th class="px-6 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-xs font-semibold text-slate-700">
                            @forelse($categories as $cat)
                                <tr class="hover:bg-slate-50/60 transition">
                                    <td class="px-6 py-4 font-bold text-slate-800 whitespace-nowrap">
                                        {{ $cat->name }}
                                    </td>
                                    <td class="px-6 py-4 text-slate-500 max-w-xs truncate">
                                        {{ $cat->description ?: '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-center whitespace-nowrap">
                                        <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-blue-50 text-[#1e5cfb]">
                                            {{ $cat->products()->count() }} Produk
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center font-bold text-slate-800 whitespace-nowrap">
                                        {{ number_format($cat->products()->sum('stock'), 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 text-right whitespace-nowrap">
                                        <a href="{{ route('kasir.barang.show', $cat) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-50 text-[#1e5cfb] hover:bg-blue-100 font-extrabold text-xs rounded-xl transition">
                                            <span>Lihat Barang</span>
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-slate-400 font-bold">
                                        Tidak ada kategori barang ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($categories->hasPages())
                    <div class="px-6 py-4 border-t border-slate-100">
                        {{ $categories->links() }}
                    </div>
                @endif
            </div>

        </main>
    </div>
</div>
@endsection
