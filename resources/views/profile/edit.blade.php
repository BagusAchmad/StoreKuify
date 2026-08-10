@extends('layouts.app')

@section('title', 'Profil Saya - StoreKuify')

@section('content')
<div x-data="{
    sidebarOpen: false,
    photoPreview: null,
    previewPhoto(event) {
        const file = event.target.files[0];
        if (file) {
            this.photoPreview = URL.createObjectURL(file);
        }
    }
}" class="h-screen flex overflow-hidden bg-slate-50">
    
    @if(Auth::user()->isKasir())
        @include('partials.sidebar_kasir', ['active' => 'profil'])
    @else
        @include('partials.sidebar_owner', ['active' => 'profil'])
    @endif

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col overflow-hidden">
        
        <!-- Header -->
        @include('partials.header', ['breadcrumbs' => [['label' => 'Dashboard', 'url' => Auth::user()->isOwner() ? route('owner.dashboard') : route('kasir.dashboard')], ['label' => 'Profil Saya']]])

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
                        <span>Gagal Memperbarui Profil:</span>
                    </div>
                    <ul class="list-disc list-inside space-y-0.5 text-rose-600/90 pl-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Page Title -->
            <div class="space-y-1">
                <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">Pengaturan</h2>
            </div>

            <!-- Single Form wrapping both Cards -->
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- CARD 1: Informasi Pribadi -->
                <div class="bg-white border border-slate-200/60 rounded-2xl shadow-sm overflow-hidden p-6 md:p-8 space-y-6">
                    <h3 class="text-base font-extrabold text-slate-800 tracking-tight">Informasi Pribadi</h3>

                    <!-- Foto Profil -->
                    <div class="flex items-center gap-6 pb-2">
                        <!-- Profile Photo Circle with Camera Badge -->
                        <div class="relative shrink-0">
                            <div class="h-24 w-24 rounded-full bg-slate-100 border border-slate-200 flex items-center justify-center overflow-hidden">
                                <template x-if="photoPreview">
                                    <img :src="photoPreview" class="h-full w-full object-cover">
                                </template>
                                <template x-if="!photoPreview">
                                    @if($user->profile_photo && file_exists(public_path($user->profile_photo)))
                                        <img src="{{ asset($user->profile_photo) }}" alt="{{ $user->name }}" class="h-full w-full object-cover">
                                    @else
                                        <div class="h-full w-full bg-slate-200 text-slate-500 font-black flex items-center justify-center text-3xl">
                                            <svg class="h-12 w-12 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                            </svg>
                                        </div>
                                    @endif
                                </template>
                            </div>
                            <label for="photo" class="absolute bottom-0 right-0 p-1.5 rounded-full bg-white border border-slate-200 shadow-sm text-slate-600 hover:text-[#1e5cfb] cursor-pointer transition">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" /></svg>
                            </label>
                        </div>

                        <div class="space-y-2">
                            <span class="block text-xs font-bold text-slate-700">Foto Profil</span>
                            <p class="text-[10px] font-semibold text-slate-400">Format disarankan: JPG, PNG. Ukuran maksimal: 2MB.</p>
                            <label for="photo" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition cursor-pointer inline-block">
                                Pilih Foto
                            </label>
                            <input id="photo" name="photo" type="file" accept="image/jpeg,image/png,image/jpg" @change="previewPhoto" class="sr-only">
                        </div>
                    </div>

                    <!-- 2-Column Form Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nama Lengkap -->
                        <div>
                            <label for="name" class="block text-xs font-bold text-slate-700 mb-1.5">Nama Lengkap</label>
                            @if(Auth::user()->isKasir())
                                <input id="name" type="text" readonly value="{{ $user->name }}"
                                    class="w-full px-4 py-2.5 bg-slate-100/80 border border-slate-200 rounded-xl text-sm font-semibold text-slate-500 cursor-not-allowed focus:outline-none select-none">
                                <p class="text-[10px] font-semibold text-slate-400 mt-1">Identitas nama dikelola oleh Owner melalui Kelola Kasir.</p>
                            @else
                                <input id="name" name="name" type="text" required value="{{ old('name', $user->name) }}" placeholder="Masukkan nama lengkap"
                                    class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800 placeholder-slate-400 focus:outline-none focus:bg-white focus:border-[#1e5cfb] focus:ring-1 focus:ring-[#1e5cfb] transition">
                            @endif
                        </div>

                        <!-- Username -->
                        <div>
                            <label for="username" class="block text-xs font-bold text-slate-700 mb-1.5">Username</label>
                            @if(Auth::user()->isKasir())
                                <input id="username" type="text" readonly value="{{ $user->username }}"
                                    class="w-full px-4 py-2.5 bg-slate-100/80 border border-slate-200 rounded-xl text-sm font-semibold text-slate-500 cursor-not-allowed focus:outline-none select-none">
                                <p class="text-[10px] font-semibold text-slate-400 mt-1">Username akun dikelola oleh Owner melalui Kelola Kasir.</p>
                            @else
                                <input id="username" name="username" type="text" required value="{{ old('username', $user->username) }}" placeholder="Masukkan username"
                                    class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800 placeholder-slate-400 focus:outline-none focus:bg-white focus:border-[#1e5cfb] focus:ring-1 focus:ring-[#1e5cfb] transition">
                            @endif
                        </div>
                    </div>
                </div>

                <!-- CARD 2: Keamanan Akun -->
                <div class="bg-white border border-slate-200/60 rounded-2xl shadow-sm overflow-hidden p-6 md:p-8 space-y-6">
                    <div>
                        <h3 class="text-base font-extrabold text-slate-800 tracking-tight">Keamanan Akun</h3>
                        <p class="text-slate-400 text-xs font-semibold mt-0.5">Ubah kata sandi akun Anda secara berkala untuk menjaga keamanan data.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Kata Sandi Baru -->
                        <div x-data="{ show: false }">
                            <label for="password" class="block text-xs font-bold text-slate-700 mb-1.5">Kata Sandi Baru</label>
                            <div class="relative">
                                <input id="password" name="password" :type="show ? 'text' : 'password'" placeholder="Masukkan kata sandi baru"
                                    class="w-full px-4 py-2.5 pr-11 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800 placeholder-slate-400 focus:outline-none focus:bg-white focus:border-[#1e5cfb] focus:ring-1 focus:ring-[#1e5cfb] transition">
                                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none cursor-pointer">
                                    <svg x-show="!show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                    <svg x-show="show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" x-cloak><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" /></svg>
                                </button>
                            </div>
                        </div>

                        <!-- Konfirmasi Kata Sandi Baru -->
                        <div x-data="{ show: false }">
                            <label for="password_confirmation" class="block text-xs font-bold text-slate-700 mb-1.5">Konfirmasi Kata Sandi Baru</label>
                            <div class="relative">
                                <input id="password_confirmation" name="password_confirmation" :type="show ? 'text' : 'password'" placeholder="Ulangi kata sandi baru"
                                    class="w-full px-4 py-2.5 pr-11 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800 placeholder-slate-400 focus:outline-none focus:bg-white focus:border-[#1e5cfb] focus:ring-1 focus:ring-[#1e5cfb] transition">
                                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none cursor-pointer">
                                    <svg x-show="!show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                    <svg x-show="show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" x-cloak><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" /></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer Action Buttons -->
                <div class="flex items-center justify-end gap-3 pt-2">
                    <a href="{{ Auth::user()->isOwner() ? route('owner.dashboard') : route('kasir.dashboard') }}" class="px-6 py-2.5 rounded-xl text-xs font-bold text-slate-500 bg-slate-100 hover:bg-slate-200 transition">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-2.5 rounded-xl text-xs font-bold text-white bg-[#1e5cfb] hover:bg-blue-700 transition shadow-md shadow-blue-500/10 cursor-pointer">
                        Simpan Perubahan
                    </button>
                </div>
            </form>

        </main>
    </div>
</div>
@endsection
