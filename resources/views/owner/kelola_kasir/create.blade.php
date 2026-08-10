@extends('layouts.app')

@section('title', 'Tambah Kasir Baru - StoreKuify')

@section('content')
<div x-data="{
    sidebarOpen: false,
    photoPreview: null,
    showPassword: false,
    showConfirmPassword: false,

    previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            this.photoPreview = URL.createObjectURL(file);
        }
    }
}" class="h-screen flex overflow-hidden bg-slate-50">
    
    @include('partials.sidebar_owner', ['active' => 'kelola_kasir'])

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col overflow-hidden">
        
        <!-- Header -->
        @include('partials.header', ['breadcrumbs' => [['label' => 'Dashboard', 'url' => route('owner.dashboard')], ['label' => 'Kelola Kasir', 'url' => route('owner.kelola_kasir')], ['label' => 'Tambah Kasir']]])

        <!-- Main Scrollable Content -->
        <main class="flex-1 overflow-y-auto p-6 md:p-8 bg-slate-50 space-y-6">

            <!-- Title -->
            <div>
                <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">Tambah Kasir Baru</h2>
            </div>

            <!-- Validation Errors Alert -->
            @if ($errors->any())
                <div class="p-4 rounded-2xl bg-rose-500/10 border border-rose-500/20 text-rose-600 text-xs font-semibold">
                    <div class="font-bold flex items-center gap-2 mb-1">
                        <svg class="h-4.5 w-4.5 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" /></svg>
                        <span>Gagal Menyimpan Kasir:</span>
                    </div>
                    <ul class="list-disc list-inside space-y-0.5 text-rose-600/90 pl-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form Card matching Mockup 2 -->
            <div class="bg-white border border-slate-200/60 rounded-2xl shadow-sm overflow-hidden p-6 md:p-10">
                <form action="{{ route('owner.kelola_kasir.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf

                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                        
                        <!-- Left Side: Profil Kasir (Photo Upload) -->
                        <div class="lg:col-span-5 bg-slate-50/75 border border-slate-100 rounded-2xl p-8 flex flex-col items-center justify-center text-center space-y-4 min-h-[300px]">
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Profil Kasir</span>

                            <div class="relative group">
                                <label for="photo" class="block cursor-pointer">
                                    <template x-if="photoPreview">
                                        <img :src="photoPreview" class="h-36 w-36 rounded-full object-cover border-4 border-white shadow-md">
                                    </template>
                                    <template x-if="!photoPreview">
                                        <div class="h-36 w-36 rounded-full border-2 border-dashed border-slate-300 hover:border-[#1e5cfb] bg-white flex flex-col items-center justify-center text-slate-400 hover:text-[#1e5cfb] transition duration-200 group">
                                            <svg class="h-8 w-8 mb-1 transition group-hover:scale-110" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z" />
                                            </svg>
                                            <span class="text-xs font-bold">Unggah Foto</span>
                                        </div>
                                    </template>
                                </label>
                                <input id="photo" name="photo" type="file" accept="image/jpeg,image/png,image/jpg" @change="previewImage" class="sr-only">
                            </div>

                            <p class="text-[11px] font-semibold text-slate-400 max-w-[200px]">
                                Format: JPG, PNG. Maksimal 2MB.
                            </p>
                        </div>

                        <!-- Right Side: Data Akun Form -->
                        <div class="lg:col-span-7 space-y-5">
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Data Akun</span>

                            <!-- Nama Lengkap -->
                            <div>
                                <label for="name" class="block text-xs font-bold text-slate-700 mb-1.5">Nama Lengkap</label>
                                <input id="name" name="name" type="text" required value="{{ old('name') }}" placeholder="Masukkan nama lengkap"
                                    class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800 placeholder-slate-400 focus:outline-none focus:bg-white focus:border-[#1e5cfb] focus:ring-1 focus:ring-[#1e5cfb] transition">
                            </div>

                            <!-- Username -->
                            <div>
                                <label for="username" class="block text-xs font-bold text-slate-700 mb-1.5">Username</label>
                                <input id="username" name="username" type="text" required value="{{ old('username') }}" placeholder="Masukkan username"
                                    class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800 placeholder-slate-400 focus:outline-none focus:bg-white focus:border-[#1e5cfb] focus:ring-1 focus:ring-[#1e5cfb] transition">
                            </div>

                            <!-- Password -->
                            <div>
                                <label for="password" class="block text-xs font-bold text-slate-700 mb-1.5">Kata Sandi</label>
                                <div class="relative">
                                    <input id="password" name="password" :type="showPassword ? 'text' : 'password'" required minlength="6" placeholder="Masukkan kata sandi"
                                        class="w-full pl-4 pr-10 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800 placeholder-slate-400 focus:outline-none focus:bg-white focus:border-[#1e5cfb] focus:ring-1 focus:ring-[#1e5cfb] transition">
                                    <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none cursor-pointer">
                                        <svg x-show="!showPassword" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><circle cx="12" cy="12" r="3" /></svg>
                                        <svg x-show="showPassword" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21" /></svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Konfirmasi Password -->
                            <div>
                                <label for="password_confirmation" class="block text-xs font-bold text-slate-700 mb-1.5">Konfirmasi Kata Sandi</label>
                                <div class="relative">
                                    <input id="password_confirmation" name="password_confirmation" :type="showConfirmPassword ? 'text' : 'password'" required minlength="6" placeholder="Ulangi kata sandi"
                                        class="w-full pl-4 pr-10 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800 placeholder-slate-400 focus:outline-none focus:bg-white focus:border-[#1e5cfb] focus:ring-1 focus:ring-[#1e5cfb] transition">
                                    <button type="button" @click="showConfirmPassword = !showConfirmPassword" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none cursor-pointer">
                                        <svg x-show="!showConfirmPassword" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><circle cx="12" cy="12" r="3" /></svg>
                                        <svg x-show="showConfirmPassword" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21" /></svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Footer Action Buttons -->
                    <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-100">
                        <a href="{{ route('owner.kelola_kasir') }}" class="px-5 py-2.5 rounded-xl text-xs font-bold text-slate-500 bg-slate-100 hover:bg-slate-200 transition">
                            Batal
                        </a>
                        <button type="submit" class="px-6 py-2.5 rounded-xl text-xs font-bold text-white bg-[#1e5cfb] hover:bg-blue-700 transition shadow-md shadow-blue-500/10 cursor-pointer">
                            Simpan Akun
                        </button>
                    </div>

                </form>
            </div>

        </main>
    </div>

</div>
@endsection
