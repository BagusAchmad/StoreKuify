@extends('layouts.app')

@section('title', 'Edit Data Kasir - StoreKuify')

@section('content')
<div x-data="{
    sidebarOpen: false,
    photoPreview: null,

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
        <!-- Header -->
        @include('partials.header', ['breadcrumbs' => [['label' => 'Dashboard', 'url' => route('owner.dashboard')], ['label' => 'Kelola Kasir', 'url' => route('owner.kelola_kasir')], ['label' => 'Edit Kasir']]])

        <!-- Main Scrollable Content -->
        <main class="flex-1 overflow-y-auto p-6 md:p-8 bg-slate-50 space-y-6">

            <!-- Title -->
            <div>
                <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">Edit Data Kasir</h2>
                <p class="text-slate-500 text-sm mt-0.5">Perbarui informasi akun kasir.</p>
            </div>

            <!-- Validation Errors Alert -->
            @if ($errors->any())
                <div class="p-4 rounded-2xl bg-rose-500/10 border border-rose-500/20 text-rose-600 text-xs font-semibold">
                    <div class="font-bold flex items-center gap-2 mb-1">
                        <svg class="h-4.5 w-4.5 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" /></svg>
                        <span>Gagal Perbarui Kasir:</span>
                    </div>
                    <ul class="list-disc list-inside space-y-0.5 text-rose-600/90 pl-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form Card matching Tambah Kasir layout -->
            <div class="bg-white border border-slate-200/60 rounded-2xl shadow-sm overflow-hidden p-6 md:p-10">
                <form action="{{ route('owner.kelola_kasir.update', $user) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf
                    @method('PUT')

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
                                        @if($user->profile_photo && file_exists(public_path($user->profile_photo)))
                                            <img src="{{ asset($user->profile_photo) }}" alt="{{ $user->name }}" class="h-36 w-36 rounded-full object-cover border-4 border-white shadow-md">
                                        @else
                                            @php
                                                $words = explode(' ', $user->name);
                                                $initials = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
                                            @endphp
                                            <div class="h-36 w-36 rounded-full border-2 border-dashed border-slate-300 hover:border-[#1e5cfb] bg-white flex flex-col items-center justify-center text-slate-400 hover:text-[#1e5cfb] transition duration-200 group">
                                                <span class="text-2xl font-black text-slate-600 mb-1">{{ $initials }}</span>
                                                <span class="text-xs font-bold">Ubah Foto</span>
                                            </div>
                                        @endif
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
                                <input id="name" name="name" type="text" required value="{{ old('name', $user->name) }}" placeholder="Masukkan nama lengkap"
                                    class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800 placeholder-slate-400 focus:outline-none focus:bg-white focus:border-[#1e5cfb] focus:ring-1 focus:ring-[#1e5cfb] transition">
                            </div>

                            <!-- Username -->
                            <div>
                                <label for="username" class="block text-xs font-bold text-slate-700 mb-1.5">Username</label>
                                <input id="username" name="username" type="text" required value="{{ old('username', $user->username) }}" placeholder="Masukkan username"
                                    class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800 placeholder-slate-400 focus:outline-none focus:bg-white focus:border-[#1e5cfb] focus:ring-1 focus:ring-[#1e5cfb] transition">
                            </div>

                            <div class="p-4 rounded-xl bg-blue-50/60 border border-blue-100 text-slate-600 text-xs space-y-1">
                                <p class="font-bold text-[#1e5cfb] flex items-center gap-1.5">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12v-.008z" /></svg>
                                    Pengaturan Kata Sandi:
                                </p>
                                <p class="text-slate-500 leading-relaxed">
                                    Kata sandi tidak diubah di halaman ini. Gunakan fitur <strong class="text-slate-700">Reset Password</strong> pada daftar kasir jika kasir lupa atau perlu mengganti kata sandi.
                                </p>
                            </div>
                        </div>

                    </div>

                    <!-- Footer Action Buttons -->
                    <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-100">
                        <a href="{{ route('owner.kelola_kasir') }}" class="px-5 py-2.5 rounded-xl text-xs font-bold text-slate-500 bg-slate-100 hover:bg-slate-200 transition">
                            Batal
                        </a>
                        <button type="submit" class="px-6 py-2.5 rounded-xl text-xs font-bold text-white bg-[#1e5cfb] hover:bg-blue-700 transition shadow-md shadow-blue-500/10 cursor-pointer">
                            Simpan Perubahan
                        </button>
                    </div>

                </form>
            </div>

        </main>
    </div>

</div>
@endsection
