@extends('layouts.app')

@section('title', 'Pengaturan Toko - StoreKuify')

@section('content')
<div x-data="{
    sidebarOpen: false,
    activeTab: '{{ $activeTab ?? 'toko' }}',
    logoPreview: null,
    qrisPreview: null,
    showDeleteQrisModal: false,

    previewLogo(event) {
        const file = event.target.files[0];
        if (file) {
            this.logoPreview = URL.createObjectURL(file);
        }
    },
    previewQris(event) {
        const file = event.target.files[0];
        if (file) {
            this.qrisPreview = URL.createObjectURL(file);
        }
    }
}" class="h-screen flex overflow-hidden bg-slate-50">
    
    @include('partials.sidebar_owner', ['active' => 'pengaturan'])

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col overflow-hidden">
        
        <!-- Header -->
        @include('partials.header', ['breadcrumbs' => [['label' => 'Dashboard', 'url' => route('owner.dashboard')], ['label' => 'Pengaturan']]])

        <!-- Main Scrollable Content -->
        <main class="flex-1 overflow-y-auto p-6 md:p-8 bg-slate-50 space-y-6">

            <!-- Flash Success Message -->
            @if(session('success'))
                <div class="p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-600 text-xs font-semibold flex items-center gap-3">
                    <svg class="h-5 w-5 text-emerald-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="p-4 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-600 text-xs font-semibold space-y-1">
                    <div class="font-bold flex items-center gap-2">
                        <svg class="h-4.5 w-4.5 text-rose-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" /></svg>
                        <span>Gagal Menyimpan Pengaturan:</span>
                    </div>
                    <ul class="list-disc list-inside space-y-0.5 text-rose-600/90 pl-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Title & Navigation Tabs (Strictly TWO Tabs: Profil Toko & QRIS) -->
            <div class="space-y-4">
                <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">Pengaturan</h2>

                <div class="border-b border-slate-200">
                    <nav class="-mb-px flex space-x-8">
                        <button type="button" @click="activeTab = 'toko'"
                            :class="activeTab === 'toko' ? 'border-[#1e5cfb] text-[#1e5cfb]' : 'border-transparent text-slate-400 hover:text-slate-600 hover:border-slate-300'"
                            class="py-3 px-1 border-b-2 font-bold text-sm transition cursor-pointer select-none">
                            Profil Toko
                        </button>
                        <button type="button" @click="activeTab = 'qris'"
                            :class="activeTab === 'qris' ? 'border-[#1e5cfb] text-[#1e5cfb]' : 'border-transparent text-slate-400 hover:text-slate-600 hover:border-slate-300'"
                            class="py-3 px-1 border-b-2 font-bold text-sm transition cursor-pointer select-none">
                            QRIS
                        </button>
                    </nav>
                </div>
            </div>

            <!-- TAB 1: PROFIL TOKO (Matching Screenshot 1) -->
            <div x-show="activeTab === 'toko'" class="bg-white border border-slate-200/60 rounded-2xl shadow-sm overflow-hidden p-6 md:p-10 space-y-8">
                <div>
                    <h3 class="text-lg font-extrabold text-slate-800 tracking-tight">Identitas Toko</h3>
                    <p class="text-slate-400 text-xs font-semibold mt-0.5">Atur nama, alamat, dan logo yang akan muncul di struk transaksi.</p>
                </div>

                <form action="{{ route('owner.pengaturan.toko.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Logo Toko -->
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-slate-700">Logo Toko</label>
                        <div class="flex flex-col sm:flex-row items-center gap-6">
                            <!-- Left Square Preview Box -->
                            <div class="h-28 w-28 rounded-2xl bg-slate-100 border border-slate-200 shrink-0 flex items-center justify-center overflow-hidden">
                                <template x-if="logoPreview">
                                    <img :src="logoPreview" class="h-full w-full object-cover">
                                </template>
                                <template x-if="!logoPreview">
                                    @if($settings->shop_logo && file_exists(public_path($settings->shop_logo)))
                                        <img src="{{ asset($settings->shop_logo) }}" alt="Logo Toko" class="h-full w-full object-cover">
                                    @else
                                        <div class="text-slate-400 flex flex-col items-center justify-center">
                                            <svg class="h-10 w-10 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.25A2.25 2.25 0 010 18.75V10.5M13.5 21h7.5A2.25 2.25 0 0023.25 18.75V10.5m-21 0a2.25 2.25 0 012.25-2.25h16.5a2.25 2.25 0 012.25 2.25m-21 0V4.5A2.25 2.25 0 014.5 2.25h15A2.25 2.25 0 0121.75 4.5v6" />
                                            </svg>
                                        </div>
                                    @endif
                                </template>
                            </div>

                            <!-- Right Dashed Dropzone -->
                            <label for="logo" class="flex-1 w-full border-2 border-dashed border-slate-200 hover:border-[#1e5cfb] rounded-2xl p-6 flex flex-col items-center justify-center text-center cursor-pointer bg-slate-50/50 hover:bg-slate-50 transition group">
                                <svg class="h-8 w-8 text-slate-400 group-hover:text-[#1e5cfb] transition mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z" />
                                </svg>
                                <p class="text-xs font-bold text-slate-700">
                                    <span class="text-[#1e5cfb]">Upload file</span> atau drag and drop
                                </p>
                                <p class="text-[10px] font-semibold text-slate-400 mt-1">JPG, PNG hingga 2MB</p>
                                <input id="logo" name="logo" type="file" accept="image/jpeg,image/png,image/jpg" @change="previewLogo" class="sr-only">
                            </label>
                        </div>
                    </div>

                    <!-- Nama Toko -->
                    <div>
                        <label for="shop_name" class="block text-xs font-bold text-slate-700 mb-1.5">Nama Toko <span class="text-rose-500">*</span></label>
                        <input id="shop_name" name="shop_name" type="text" required value="{{ old('shop_name', $settings->shop_name) }}" placeholder="Masukkan nama toko"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800 placeholder-slate-400 focus:outline-none focus:bg-white focus:border-[#1e5cfb] focus:ring-1 focus:ring-[#1e5cfb] transition">
                    </div>

                    <!-- Alamat Toko -->
                    <div>
                        <label for="shop_address" class="block text-xs font-bold text-slate-700 mb-1.5">Alamat Toko</label>
                        <textarea id="shop_address" name="shop_address" rows="3" placeholder="Masukkan alamat toko lengkap"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800 placeholder-slate-400 focus:outline-none focus:bg-white focus:border-[#1e5cfb] focus:ring-1 focus:ring-[#1e5cfb] transition">{{ old('shop_address', $settings->shop_address) }}</textarea>
                    </div>

                    <!-- Submit Action Button -->
                    <div class="flex justify-end pt-4 border-t border-slate-100">
                        <button type="submit" class="px-6 py-2.5 rounded-xl text-xs font-bold text-white bg-[#1e5cfb] hover:bg-blue-700 transition shadow-md shadow-blue-500/10 cursor-pointer">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>

            <!-- TAB 2: QRIS (Matching Screenshot 2) -->
            <div x-show="activeTab === 'qris'" class="bg-white border border-slate-200/60 rounded-2xl shadow-sm overflow-hidden p-6 md:p-10 space-y-8" x-cloak>
                <div>
                    <h3 class="text-lg font-extrabold text-slate-800 tracking-tight">Metode Pembayaran QRIS</h3>
                    <p class="text-slate-400 text-xs font-semibold mt-0.5">Unggah gambar QRIS statis toko Anda untuk menerima pembayaran non-tunai di modul Kasir.</p>
                </div>

                <!-- Info Notice Box -->
                <div class="p-4 rounded-xl bg-blue-50/70 border border-blue-100/80 text-slate-600 text-xs font-semibold flex items-center gap-3">
                    <svg class="h-5 w-5 text-[#1e5cfb] shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12v-.008z" /></svg>
                    <span>Metode pembayaran QRIS akan otomatis aktif di halaman Kasir setelah Anda mengunggah gambar QRIS.</span>
                </div>

                <form action="{{ route('owner.pengaturan.qris.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-slate-700">Gambar QRIS Toko</label>
                        
                        <div class="border-2 border-dashed border-slate-200 rounded-2xl p-8 flex flex-col items-center justify-center text-center bg-slate-50/50 space-y-4">
                            <!-- Preview Card -->
                            <div class="h-64 w-64 rounded-2xl bg-white border border-slate-200 p-4 shadow-sm flex items-center justify-center overflow-hidden">
                                <template x-if="qrisPreview">
                                    <img :src="qrisPreview" class="h-full w-full object-contain">
                                </template>
                                <template x-if="!qrisPreview">
                                    @if($settings->qris_image && file_exists(public_path($settings->qris_image)))
                                        <img src="{{ asset($settings->qris_image) }}" alt="QRIS Toko" class="h-full w-full object-contain">
                                    @else
                                        <div class="text-slate-400 flex flex-col items-center justify-center p-4">
                                            <svg class="h-12 w-12 text-slate-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5zM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5zM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0113.5 9.375v-4.5z" />
                                            </svg>
                                            <span class="text-xs font-bold text-slate-500">Belum ada QRIS</span>
                                        </div>
                                    @endif
                                </template>
                            </div>

                            <!-- Upload Button -->
                            <label for="qris" class="px-5 py-2 rounded-xl bg-blue-50 hover:bg-blue-100 text-[#1e5cfb] text-xs font-bold transition cursor-pointer inline-flex items-center gap-2">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" /></svg>
                                <span>Ganti Gambar</span>
                            </label>
                            <input id="qris" name="qris" type="file" accept="image/jpeg,image/png,image/jpg" @change="previewQris" class="sr-only">

                            <p class="text-[10px] font-semibold text-slate-400">Format didukung: JPG, PNG. Maksimal 2MB.</p>
                        </div>
                    </div>

                    <!-- Footer Controls -->
                    <div class="flex items-center justify-between pt-4 border-t border-slate-100">
                        @if($settings->qris_image)
                            <button type="button" @click="showDeleteQrisModal = true" class="px-4 py-2.5 rounded-xl border border-rose-200 text-rose-600 hover:bg-rose-50 text-xs font-bold transition flex items-center gap-2 cursor-pointer">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
                                <span>Hapus QRIS</span>
                            </button>
                        @else
                            <div></div>
                        @endif

                        <button type="submit" class="px-6 py-2.5 rounded-xl text-xs font-bold text-white bg-[#1e5cfb] hover:bg-blue-700 transition shadow-md shadow-blue-500/10 cursor-pointer">
                            Simpan QRIS
                        </button>
                    </div>
                </form>
            </div>

        </main>
    </div>

    <!-- Confirmation Modal for Delete QRIS -->
    <div x-show="showDeleteQrisModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm" x-cloak>
        <div @click.away="showDeleteQrisModal = false" class="bg-white rounded-2xl border border-slate-200 shadow-2xl w-full max-w-md p-6 space-y-4">
            <div class="flex items-center gap-3 pb-3 border-b border-slate-100">
                <div class="h-10 w-10 rounded-full bg-rose-50 text-rose-600 flex items-center justify-center shrink-0">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" /></svg>
                </div>
                <div>
                    <h3 class="text-base font-extrabold text-slate-800">Hapus QRIS Toko?</h3>
                    <p class="text-xs text-slate-400 font-semibold">Konfirmasi hapus metode QRIS</p>
                </div>
            </div>

            <p class="text-xs font-semibold text-slate-600 leading-relaxed">
                Menghapus QRIS akan membuat pembayaran QRIS di modul Kasir tidak dapat digunakan hingga Anda mengunggah gambar QRIS baru.
            </p>

            <form action="{{ route('owner.pengaturan.qris.delete') }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" @click="showDeleteQrisModal = false" class="px-4 py-2.5 rounded-xl text-xs font-bold text-slate-500 bg-slate-100 hover:bg-slate-200 transition">Batal</button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-rose-600 hover:bg-rose-700 transition shadow-md shadow-rose-500/10">Ya, Hapus QRIS</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
