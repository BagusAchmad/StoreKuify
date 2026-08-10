@extends('layouts.app')

@section('title', 'Ubah Barang - StoreKuify')

@section('content')
<div x-data="{ sidebarOpen: false }" class="h-screen flex overflow-hidden bg-slate-50">
    
    @include('partials.sidebar_owner', ['active' => 'barang'])

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col overflow-hidden">
        
        <!-- Header -->
        @include('partials.header', ['breadcrumbs' => [['label' => 'Dashboard', 'url' => route('owner.dashboard')], ['label' => 'Data Barang', 'url' => route('owner.barang')], ['label' => $category->name, 'url' => route('owner.barang.show', $category->slug)], ['label' => 'Ubah Barang']]])

        <!-- Main Form Scrollable Content -->
        <main class="flex-1 overflow-y-auto p-6 md:p-8 bg-slate-50">
            <div class="max-w-5xl mx-auto space-y-6">
                <!-- Title Header -->
                <div>
                    <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">Ubah Barang</h2>
                    <p class="text-slate-500 text-xs mt-0.5">Ubah informasi barang "{{ $product->name }}" di bawah ini.</p>
                </div>

                <!-- Two-Column Product Form Box -->
                <form action="{{ route('owner.products.update', [$category->slug, $product->sku]) }}" method="POST" enctype="multipart/form-data" 
                    x-data="{ 
                        cost: {{ old('cost_price', $product->cost_price) }}, 
                        selling: {{ old('selling_price', $product->selling_price) }}, 
                        imagePreview: '{{ $product->image ? asset($product->image) : null }}' 
                    }"
                    class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                    @csrf
                    @method('PUT')

                    <!-- LEFT SIDE: Foto Produk Upload Dropzone -->
                    <div class="lg:col-span-4 bg-white border border-slate-200/60 rounded-2xl p-6 shadow-sm flex flex-col items-center">
                        <h3 class="text-sm font-bold text-slate-800 tracking-tight mb-4 w-full text-left">Foto Produk</h3>
                        
                        <div class="w-full aspect-[3/4] border-2 border-dashed border-slate-200 hover:border-blue-500/80 rounded-2xl flex flex-col items-center justify-center p-4 text-center cursor-pointer transition relative overflow-hidden group">
                            
                            <!-- Hidden File Input -->
                            <input type="file" name="image" id="product-image" accept="image/jpeg,image/png,image/webp" 
                                class="absolute inset-0 opacity-0 cursor-pointer z-10"
                                @change="
                                    const file = $event.target.files[0];
                                    if (file) {
                                        if (file.size > 2 * 1024 * 1024) {
                                            alert('Ukuran file foto maksimal 2MB!');
                                            $event.target.value = '';
                                        } else {
                                            imagePreview = URL.createObjectURL(file);
                                        }
                                    }
                                ">

                            <!-- Preview State -->
                            <template x-if="imagePreview">
                                <div class="absolute inset-0 bg-white z-0 flex items-center justify-center">
                                    <img :src="imagePreview" alt="Preview" class="h-full w-full object-cover">
                                    <div class="absolute inset-0 bg-slate-900/40 opacity-0 group-hover:opacity-100 flex items-center justify-center text-white text-xs font-bold transition duration-150">
                                        Ganti Foto
                                    </div>
                                </div>
                            </template>

                            <!-- Default Icon/Text state -->
                            <div x-show="!imagePreview" class="flex flex-col items-center justify-center space-y-3 z-0">
                                <div class="h-12 w-12 rounded-full bg-blue-50 text-[#1e5cfb] flex items-center justify-center">
                                    <svg class="h-6.5 w-6.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-700">Klik untuk unggah foto</p>
                                    <p class="text-[10px] text-slate-400 font-semibold mt-1">atau seret dan lepas file di sini</p>
                                </div>
                                <p class="text-[9.5px] text-slate-400 font-semibold mt-2 border-t pt-2 border-slate-100 w-full">
                                    Format: JPG, PNG, WEBP. Maks 2MB.
                                </p>
                            </div>

                        </div>
                        @error('image')
                            <p class="mt-2.5 text-xs font-semibold text-rose-500 text-left w-full">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- RIGHT SIDE: Detail Barang Form fields -->
                    <div class="lg:col-span-8 bg-white border border-slate-200/60 rounded-2xl p-6 sm:p-8 shadow-sm space-y-6">
                        <h3 class="text-sm font-bold text-slate-800 tracking-tight pb-4 border-b border-slate-100">Detail Barang</h3>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <!-- Nama Barang -->
                            <div class="sm:col-span-1">
                                <label for="name" class="block text-xs font-bold text-slate-700 mb-2">
                                    Nama Barang <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" id="name" name="name" required value="{{ old('name', $product->name) }}"
                                    class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:bg-white focus:border-[#1e5cfb] focus:ring-1 focus:ring-[#1e5cfb] transition duration-150 @error('name') border-rose-400 @enderror">
                                @error('name')
                                    <p class="mt-1.5 text-xs font-semibold text-rose-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Kategori (Read-only, disabled dropdown, pre-assigned value) -->
                            <div class="sm:col-span-1">
                                <label for="category_display" class="block text-xs font-bold text-slate-700 mb-2">
                                    Kategori <span class="text-rose-500">*</span>
                                </label>
                                <select id="category_display" disabled
                                    class="block w-full px-4 py-2.5 bg-slate-100 border border-slate-200 rounded-xl text-sm text-slate-500 cursor-not-allowed focus:outline-none">
                                    <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                                </select>
                                <input type="hidden" name="category_id" value="{{ $category->id }}">
                            </div>

                            <!-- SKU (Read-only for reference) -->
                            <div class="sm:col-span-1">
                                <label class="block text-xs font-bold text-slate-700 mb-2">
                                    SKU Barang
                                </label>
                                <input type="text" disabled value="{{ $product->sku }}"
                                    class="block w-full px-4 py-2.5 bg-slate-100 border border-slate-200 rounded-xl text-sm text-slate-500 cursor-not-allowed focus:outline-none">
                            </div>

                            <!-- Stok Awal -->
                            <div class="sm:col-span-1">
                                <label for="stock" class="block text-xs font-bold text-slate-700 mb-2">
                                    Stok Barang <span class="text-rose-500">*</span>
                                </label>
                                <input type="number" id="stock" name="stock" required min="0" value="{{ old('stock', $product->stock) }}"
                                    class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 focus:outline-none focus:bg-white focus:border-[#1e5cfb] focus:ring-1 focus:ring-[#1e5cfb] transition duration-150 @error('stock') border-rose-400 @enderror">
                                @error('stock')
                                    <p class="mt-1.5 text-xs font-semibold text-rose-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Status Barang -->
                            <div class="sm:col-span-1 col-span-1">
                                <label for="is_active" class="block text-xs font-bold text-slate-700 mb-2">
                                    Status Barang
                                </label>
                                <select id="is_active" name="is_active" required
                                    class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 focus:outline-none focus:bg-white focus:border-[#1e5cfb] focus:ring-1 focus:ring-[#1e5cfb] transition duration-150">
                                    <option value="1" {{ old('is_active', $product->is_active ? '1' : '0') === '1' ? 'selected' : '' }}>Aktif</option>
                                    <option value="0" {{ old('is_active', $product->is_active ? '1' : '0') === '0' ? 'selected' : '' }}>Nonaktif</option>
                                </select>
                            </div>
                        </div>

                        <!-- Harga & Untung Subsection card -->
                        <div class="bg-slate-50/70 border border-slate-100 rounded-2xl p-5 space-y-5">
                            <h4 class="text-xs font-extrabold text-slate-800 flex items-center gap-1.5">
                                <svg class="h-4.5 w-4.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>Informasi Harga</span>
                            </h4>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <!-- Harga Modal -->
                                <div>
                                    <label for="cost_price" class="block text-xs font-bold text-slate-700 mb-2">
                                        Harga Modal (Rp) <span class="text-rose-500">*</span>
                                    </label>
                                    <input type="number" id="cost_price" name="cost_price" required min="0" 
                                        x-model.number="cost"
                                        class="block w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm text-slate-800 focus:outline-none focus:border-[#1e5cfb] focus:ring-1 focus:ring-[#1e5cfb] transition duration-150 @error('cost_price') border-rose-400 @enderror"
                                        placeholder="0">
                                    @error('cost_price')
                                        <p class="mt-1.5 text-xs font-semibold text-rose-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Harga Jual -->
                                <div>
                                    <label for="selling_price" class="block text-xs font-bold text-slate-700 mb-2">
                                        Harga Jual (Rp) <span class="text-rose-500">*</span>
                                    </label>
                                    <input type="number" id="selling_price" name="selling_price" required min="0"
                                        x-model.number="selling"
                                        class="block w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm text-slate-800 focus:outline-none focus:border-[#1e5cfb] focus:ring-1 focus:ring-[#1e5cfb] transition duration-150 @error('selling_price') border-rose-400 @enderror"
                                        placeholder="0">
                                    @error('selling_price')
                                        <p class="mt-1.5 text-xs font-semibold text-rose-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Live calculated profit badge -->
                            <div class="flex items-center justify-between border-t border-slate-200/50 pt-4 mt-2">
                                <span class="text-xs font-bold text-slate-500">Estimasi Keuntungan / Item:</span>
                                <span class="text-sm font-extrabold" :class="selling - cost >= 0 ? 'text-emerald-600' : 'text-rose-600'">
                                    Rp <span x-text="isNaN(selling - cost) ? '0' : (selling - cost).toLocaleString('id-ID')">0</span>
                                </span>
                            </div>
                        </div>

                        <!-- Action Submit & Cancel button footer -->
                        <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-100">
                            <a href="{{ route('owner.barang.show', $category->slug) }}" 
                                class="px-5 py-2.5 rounded-xl text-xs font-bold text-slate-500 bg-slate-100 hover:bg-slate-200 transition duration-150">
                                Batal
                            </a>
                            <button type="submit" 
                                class="px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-[#1e5cfb] hover:bg-[#1a52db] active:scale-[0.98] transition duration-150 shadow-md shadow-blue-500/10 hover:shadow-blue-500/20 cursor-pointer">
                                Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>
@endsection
