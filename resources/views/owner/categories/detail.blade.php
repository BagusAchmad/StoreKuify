@extends('layouts.app')

@section('title', 'Kategori ' . $category->name . ' - StoreKuify')

@section('content')
<div x-data="{ sidebarOpen: false, showDeleteModal: false, deleteActionUrl: '' }" class="h-screen flex overflow-hidden bg-slate-50">
    
    @include('partials.sidebar_owner', ['active' => 'barang'])

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col overflow-hidden">
        
        <!-- Header -->
        @include('partials.header', ['breadcrumbs' => [['label' => 'Dashboard', 'url' => route('owner.dashboard')], ['label' => 'Data Barang', 'url' => route('owner.barang')], ['label' => $category->name]]])

        <!-- Main Scrollable Content -->
        <main class="flex-1 overflow-y-auto p-6 md:p-8 bg-slate-50 space-y-6">
            
            <!-- Breadcrumbs Module Path & Action Header -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <div class="text-xs font-bold text-slate-400 flex items-center gap-1">
                        <span>Dashboard</span>
                        <span class="text-slate-300">/</span>
                        <a href="{{ route('owner.barang') }}" class="hover:text-slate-500 transition duration-150">Data Barang</a>
                        <span class="text-slate-300">/</span>
                        <span class="text-slate-600 font-extrabold">{{ $category->name }}</span>
                    </div>
                    <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight mt-1.5">Kategori: {{ $category->name }}</h2>
                    <p class="text-slate-500 text-xs mt-1">
                        {{ $category->description ?: 'Kelola semua barang dalam kategori ini.' }}
                    </p>
                </div>
                
                <a href="{{ route('owner.products.create', $category->slug) }}" class="inline-flex items-center gap-2 bg-[#1e5cfb] hover:bg-[#1a52db] text-white px-5 py-3 rounded-xl text-sm font-bold shadow-md shadow-blue-500/10 hover:shadow-blue-500/20 active:scale-[0.98] transition duration-150 cursor-pointer">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Tambah Barang</span>
                </a>
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

            <!-- Summary Cards Grid (Stitch values dynamic based on selected category) -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <!-- Card 1: Total Varian Barang -->
                <div class="bg-white border border-slate-200/60 rounded-2xl p-6 flex flex-col justify-between shadow-sm">
                    <div class="flex justify-between items-start">
                        <div>
                            <span class="text-xs font-bold text-slate-400 block tracking-wide uppercase">Total Varian Barang</span>
                            <span class="text-2xl font-extrabold text-slate-800 block mt-2">{{ $totalVariants }}</span>
                        </div>
                        <div class="h-10 w-10 bg-blue-50 text-[#1e5cfb] rounded-xl flex items-center justify-center">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Stok Menipis -->
                <div class="bg-white border border-slate-200/60 rounded-2xl p-6 flex flex-col justify-between shadow-sm">
                    <div class="flex justify-between items-start">
                        <div>
                            <span class="text-xs font-bold text-slate-400 block tracking-wide uppercase">Stok Menipis</span>
                            <span class="text-2xl font-extrabold text-slate-800 block mt-2">
                                {{ $lowStockCount }} <span class="text-sm font-semibold text-slate-400">Item</span>
                            </span>
                        </div>
                        <div class="h-10 w-10 bg-amber-50 text-amber-500 rounded-xl flex items-center justify-center">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Card 3: Estimasi Nilai Stok -->
                <div class="bg-white border border-slate-200/60 rounded-2xl p-6 flex flex-col justify-between shadow-sm">
                    <div class="flex justify-between items-start">
                        <div>
                            <span class="text-xs font-bold text-slate-400 block tracking-wide uppercase">Est. Nilai Stok</span>
                            <span class="text-2xl font-extrabold text-slate-800 block mt-2">
                                Rp {{ number_format($totalEstimatedValue, 0, ',', '.') }}
                            </span>
                        </div>
                        <div class="h-10 w-10 bg-emerald-50 text-emerald-500 rounded-xl flex items-center justify-center">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search Bar & Product Table -->
            <div class="bg-white border border-slate-200/60 rounded-2xl shadow-sm overflow-hidden flex flex-col justify-between">
                
                <!-- Search Form Bar -->
                <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-stretch sm:items-center gap-4">
                    <!-- Search Input -->
                    <form action="{{ route('owner.barang.show', $category->slug) }}" method="GET" class="relative flex-1 max-w-md">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ $search }}"
                            class="block w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:bg-white focus:border-[#1e5cfb] focus:ring-1 focus:ring-[#1e5cfb] transition duration-150"
                            placeholder="Cari nama barang atau SKU...">
                    </form>
                </div>

                <!-- Table Content -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100">
                        <thead class="bg-slate-50/75">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-400 uppercase tracking-wider pl-10">
                                    Info Barang
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">
                                    Harga Modal
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">
                                    Harga Jual
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">
                                    Untung
                                </th>
                                <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-slate-400 uppercase tracking-wider">
                                    Stok
                                </th>
                                <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-slate-400 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-slate-400 uppercase tracking-wider pr-10">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-100">
                            @forelse($products as $product)
                                <tr class="hover:bg-slate-50/40 transition duration-150">
                                    <!-- Info Barang -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-slate-800 pl-10">
                                        <div class="flex items-center gap-3">
                                            <!-- Product image/thumbnail -->
                                            <div class="h-11 w-11 rounded-lg bg-slate-100 border border-slate-200 overflow-hidden shrink-0 flex items-center justify-center">
                                                @if($product->image)
                                                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
                                                @else
                                                    <!-- Photo placeholder icon -->
                                                    <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                @endif
                                            </div>
                                            <!-- Product title & SKU -->
                                            <div>
                                                <div class="text-sm font-bold text-slate-800">{{ $product->name }}</div>
                                                <div class="text-[10px] text-slate-400 font-semibold mt-0.5 uppercase tracking-wide">
                                                    SKU: {{ $product->sku }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Harga Modal -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-slate-600">
                                        Rp {{ number_format($product->cost_price, 0, ',', '.') }}
                                    </td>

                                    <!-- Harga Jual -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-slate-600">
                                        Rp {{ number_format($product->selling_price, 0, ',', '.') }}
                                    </td>

                                    <!-- Untung (Automatic) -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-emerald-600">
                                        + Rp {{ number_format($product->profit, 0, ',', '.') }}
                                    </td>

                                    <!-- Stok -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-extrabold text-slate-800 text-center">
                                        {{ $product->stock }}
                                    </td>

                                    <!-- Status Badge (Dynamic logic) -->
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-xs">
                                        @if($product->stock_status === 'Aktif')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-200/50">
                                                AKTIF
                                            </span>
                                        @elseif($product->stock_status === 'Menipis')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-50 text-amber-600 border border-amber-200/50">
                                                MENIPIS
                                            </span>
                                        @elseif($product->stock_status === 'Habis')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-rose-50 text-rose-600 border border-rose-200/50">
                                                HABIS
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-500 border border-slate-200">
                                                NONAKTIF
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Aksi Actions -->
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-bold pr-10">
                                        <div class="flex items-center justify-end gap-4">
                                            <!-- Edit Product -->
                                            <a href="{{ route('owner.products.edit', [$category->slug, $product->sku]) }}" 
                                                class="text-indigo-600 hover:text-indigo-900 transition duration-150 inline-flex items-center gap-1 cursor-pointer">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                </svg>
                                                <span>Ubah</span>
                                            </a>
                                            <!-- Delete Product -->
                                            <button type="button" 
                                                @click="deleteActionUrl = '{{ route('owner.products.destroy', [$category->slug, $product->sku]) }}'; showDeleteModal = true" 
                                                class="text-rose-600 hover:text-rose-900 transition duration-150 inline-flex items-center gap-1 cursor-pointer">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                <span>Hapus</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-16 text-center">
                                        <div class="h-12 w-12 bg-slate-50 text-slate-400 rounded-full flex items-center justify-center mx-auto mb-3.5">
                                            <svg class="h-6.5 w-6.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                            </svg>
                                        </div>
                                        <h4 class="text-sm font-bold text-slate-700">
                                            {{ $search ? 'Hasil pencarian barang tidak ditemukan' : 'Belum Ada Barang' }}
                                        </h4>
                                        <p class="text-slate-400 text-xs mt-1.5">
                                            {{ $search ? 'Coba cari dengan kata kunci barang atau SKU lainnya.' : 'Belum ada barang yang ditambahkan ke kategori ' . $category->name . ' ini.' }}
                                        </p>
                                        @if(!$search)
                                            <a href="{{ route('owner.products.create', $category->slug) }}" class="inline-flex items-center gap-2 mt-4.5 bg-blue-50 hover:bg-blue-100 text-[#1e5cfb] px-4.5 py-2.5 rounded-xl text-xs font-bold transition duration-150 cursor-pointer">
                                                <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                                </svg>
                                                <span>Tambah Barang</span>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Custom Table Pagination (Laravel Tailwind rendering) -->
                @if($products->hasPages())
                    <div class="p-6 border-t border-slate-100 bg-slate-50/50">
                        {{ $products->links() }}
                    </div>
                @endif

            </div>

        </main>
    </div>

    <!-- Soft Delete Product Confirmation Modal (Alpine.js Interactive) -->
    <div x-show="showDeleteModal" 
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
        x-cloak>
        <div @click.away="showDeleteModal = false"
            class="bg-white rounded-2xl border border-slate-200/80 shadow-2xl p-6 w-full max-w-md"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="scale-95 opacity-0"
            x-transition:enter-end="scale-100 opacity-100">
            
            <div class="flex items-center gap-3 mb-4">
                <div class="h-10 w-10 rounded-full bg-rose-50 text-rose-600 flex items-center justify-center">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <h3 class="text-base font-extrabold text-slate-800 tracking-tight">Konfirmasi Hapus Barang</h3>
            </div>
            
            <p class="text-xs text-slate-500 leading-relaxed mb-6">
                Apakah Anda yakin ingin menghapus barang ini? Barang ini akan dimasukkan ke arsip (dihapus sementara) dan dapat dipulihkan kembali nanti.
            </p>

            <div class="flex justify-end gap-3">
                <button type="button" @click="showDeleteModal = false"
                    class="px-4.5 py-2.5 rounded-xl text-xs font-bold text-slate-500 bg-slate-100 hover:bg-slate-200 transition duration-150 cursor-pointer">
                    Batal
                </button>
                <form :action="deleteActionUrl" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="px-4.5 py-2.5 rounded-xl text-xs font-bold text-white bg-rose-600 hover:bg-rose-700 transition duration-150 cursor-pointer">
                        Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
