@extends('layouts.app')

@section('title', 'Detail Barang - ' . $category->name . ' - StoreKuify Kasir')

@section('content')
<div x-data="{ sidebarOpen: false }" class="h-screen flex overflow-hidden bg-slate-50">
    
    <!-- Kasir Sidebar -->
    @include('partials.sidebar_kasir', ['active' => 'barang'])

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col overflow-hidden">
        
        <!-- Header -->
        @include('partials.header', ['breadcrumbs' => [['label' => 'Dashboard', 'url' => route('kasir.dashboard')], ['label' => 'Data Barang', 'url' => route('kasir.barang')], ['label' => $category->name]]])

        <!-- Main Scrollable Content -->
        <main class="flex-1 overflow-y-auto p-6 md:p-8 bg-slate-50 space-y-6">
            
            <!-- Breadcrumbs Action Header -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <div class="text-xs font-bold text-slate-400 flex items-center gap-1">
                        <span>Dashboard</span>
                        <span class="text-slate-300">/</span>
                        <a href="{{ route('kasir.barang') }}" class="hover:text-slate-500 transition duration-150">Data Barang</a>
                        <span class="text-slate-300">/</span>
                        <span class="text-slate-600 font-extrabold">{{ $category->name }}</span>
                    </div>
                    <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight mt-1.5">Kategori: {{ $category->name }}</h2>
                    <p class="text-slate-500 text-xs mt-1">
                        {{ $category->description ?: 'Daftar barang dalam kategori ini (Mode Lihat).' }}
                    </p>
                </div>

                <a href="{{ route('kasir.barang') }}" class="inline-flex items-center gap-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-600 px-4 py-2.5 rounded-xl text-sm font-bold transition duration-150 cursor-pointer">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
                    <span>Kembali</span>
                </a>
            </div>

            <!-- Summary Cards Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Card 1: Total Varian Barang -->
                <div class="bg-white border border-slate-200/60 rounded-2xl p-6 flex flex-col justify-between shadow-sm">
                    <div class="flex justify-between items-start">
                        <div>
                            <span class="text-xs font-bold text-slate-400 block tracking-wide uppercase">Total Varian Barang</span>
                            <span class="text-2xl font-extrabold text-slate-800 block mt-2">{{ $totalProducts }}</span>
                        </div>
                        <div class="h-10 w-10 bg-blue-50 text-[#1e5cfb] rounded-xl flex items-center justify-center">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Total Unit Stok -->
                <div class="bg-white border border-slate-200/60 rounded-2xl p-6 flex flex-col justify-between shadow-sm">
                    <div class="flex justify-between items-start">
                        <div>
                            <span class="text-xs font-bold text-slate-400 block tracking-wide uppercase">Total Unit Stok</span>
                            <span class="text-2xl font-extrabold text-slate-800 block mt-2">{{ number_format($totalStock, 0, ',', '.') }}</span>
                        </div>
                        <div class="h-10 w-10 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products Table Section -->
            <div class="bg-white border border-slate-200/60 rounded-2xl shadow-sm overflow-hidden">
                
                <!-- Search Filter -->
                <div class="p-6 border-b border-slate-100">
                    <form action="{{ route('kasir.barang.show', $category) }}" method="GET" class="relative max-w-md">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ $search }}" 
                               class="block w-full pl-11 pr-10 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:bg-white focus:border-[#1e5cfb] focus:ring-1 focus:ring-[#1e5cfb] transition"
                               placeholder="Cari nama barang atau SKU...">
                        @if($search)
                            <a href="{{ route('kasir.barang.show', $category) }}" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </a>
                        @endif
                    </form>
                </div>

                <!-- Products Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/80 text-[10px] font-black text-slate-400 uppercase tracking-wider border-b border-slate-100">
                                <th class="px-6 py-4">Nama Barang</th>
                                <th class="px-6 py-4">SKU</th>
                                <th class="px-6 py-4 text-right">Harga Jual</th>
                                <th class="px-6 py-4 text-center">Stok</th>
                                <th class="px-6 py-4 text-right">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-xs font-semibold text-slate-700">
                            @forelse($products as $product)
                                <tr class="hover:bg-slate-50/60 transition">
                                    <td class="px-6 py-4 flex items-center gap-3">
                                        @if($product->image && file_exists(public_path($product->image)))
                                            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="h-10 w-10 rounded-xl object-cover border border-slate-200 shrink-0">
                                        @else
                                            <div class="h-10 w-10 bg-slate-100 rounded-xl flex items-center justify-center text-slate-400 border border-slate-200 shrink-0">
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                        <div>
                                            <h4 class="font-extrabold text-slate-800">{{ $product->name }}</h4>
                                            <p class="text-[10px] text-slate-400 font-semibold mt-0.5">{{ $category->name }}</p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-slate-500 font-bold whitespace-nowrap">
                                        {{ $product->sku ?: '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-right font-extrabold text-slate-800 whitespace-nowrap">
                                        Rp {{ number_format($product->selling_price, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 text-center font-extrabold text-slate-800 whitespace-nowrap">
                                        {{ number_format($product->stock, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 text-right whitespace-nowrap">
                                        @if($product->stock == 0)
                                            <span class="px-2.5 py-1 rounded-full text-[10px] font-black bg-rose-100 text-rose-600 border border-rose-200">
                                                Stok Habis
                                            </span>
                                        @elseif($product->stock <= 5)
                                            <span class="px-2.5 py-1 rounded-full text-[10px] font-black bg-amber-100 text-amber-600 border border-amber-200">
                                                Stok Menipis ({{ $product->stock }})
                                            </span>
                                        @else
                                            <span class="px-2.5 py-1 rounded-full text-[10px] font-black bg-emerald-100 text-emerald-600 border border-emerald-200">
                                                Tersedia
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-slate-400 font-bold">
                                        Belum ada barang dalam kategori ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($products->hasPages())
                    <div class="px-6 py-4 border-t border-slate-100">
                        {{ $products->links() }}
                    </div>
                @endif
            </div>

        </main>
    </div>
</div>
@endsection
