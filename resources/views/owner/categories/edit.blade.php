@extends('layouts.app')

@section('title', 'Ubah Kategori - StoreKuify')

@section('content')
<div x-data="{ sidebarOpen: false }" class="h-screen flex overflow-hidden bg-slate-50">
    
    @include('partials.sidebar_owner', ['active' => 'barang'])

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col overflow-hidden">
        
        <!-- Header -->
        @include('partials.header', ['breadcrumbs' => [['label' => 'Beranda', 'url' => route('owner.dashboard')], ['label' => 'Data Barang', 'url' => route('owner.barang')], ['label' => 'Ubah Kategori']]])

        <!-- Main Form Content -->
        <main class="flex-1 overflow-y-auto p-6 md:p-8 bg-slate-50">
            <div class="max-w-2xl mx-auto space-y-6">
                <!-- Heading -->
                <div>
                    <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">Ubah Kategori</h2>
                    <p class="text-slate-500 text-xs mt-0.5">Ubah informasi Kategori "{{ $category->name }}" di bawah ini.</p>
                </div>

                <!-- Form Card -->
                <div class="bg-white border border-slate-200/60 rounded-2xl p-6 sm:p-8 shadow-sm">
                    <form action="{{ route('owner.barang.update', $category->slug) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Nama Kategori -->
                        <div>
                            <label for="name" class="block text-xs font-bold text-slate-700 mb-2">
                                Nama Kategori <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" id="name" name="name" required value="{{ old('name', $category->name) }}"
                                class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:bg-white focus:border-[#1e5cfb] focus:ring-1 focus:ring-[#1e5cfb] transition duration-150 @error('name') border-rose-400 focus:border-rose-500 focus:ring-rose-500 @enderror"
                                placeholder="Contoh: Makanan, Minuman, Sabun Cuci">
                            @error('name')
                                <p class="mt-1.5 text-xs font-semibold text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Deskripsi -->
                        <div>
                            <label for="description" class="block text-xs font-bold text-slate-700 mb-2">
                                Deskripsi <span class="text-slate-400 font-semibold">(Opsional)</span>
                            </label>
                            <textarea id="description" name="description" rows="3"
                                class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:bg-white focus:border-[#1e5cfb] focus:ring-1 focus:ring-[#1e5cfb] transition duration-150 @error('description') border-rose-400 focus:border-rose-500 focus:ring-rose-500 @enderror"
                                placeholder="Keterangan opsional tentang kategori ini">{{ old('description', $category->description) }}</textarea>
                            @error('description')
                                <p class="mt-1.5 text-xs font-semibold text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status Aktif -->
                        <div>
                            <label for="is_active" class="block text-xs font-bold text-slate-700 mb-2">
                                Status Kategori
                            </label>
                            <select id="is_active" name="is_active" required
                                class="block w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 focus:outline-none focus:bg-white focus:border-[#1e5cfb] focus:ring-1 focus:ring-[#1e5cfb] transition duration-150">
                                <option value="1" {{ old('is_active', $category->is_active ? '1' : '0') === '1' ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ old('is_active', $category->is_active ? '1' : '0') === '0' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                            <p class="text-[10.5px] font-semibold text-slate-400 mt-1.5 leading-relaxed">
                                Kategori dengan status Nonaktif tidak akan ditawarkan pada halaman penambahan barang baru di masa mendatang.
                            </p>
                        </div>

                        <!-- Actions Buttons -->
                        <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                            <a href="{{ route('owner.barang') }}" 
                                class="px-5 py-2.5 rounded-xl text-xs font-bold text-slate-500 bg-slate-100 hover:bg-slate-200 transition duration-150">
                                Batal
                            </a>
                            <button type="submit" 
                                class="px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-[#1e5cfb] hover:bg-[#1a52db] active:scale-[0.98] transition duration-150 shadow-md shadow-blue-500/10 hover:shadow-blue-500/20 cursor-pointer">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
