@extends('layouts.app')

@section('title', 'Kelola Akun Kasir - StoreKuify')

@section('content')
<div x-data="{
    sidebarOpen: false,
    searchQuery: '{{ $search ?? '' }}',
    statusFilter: '{{ $status ?? 'all' }}',
    showResetModal: false,
    resetCashier: null,
    showConfirmModal: false,
    confirmAction: '',
    confirmCashier: null,
    confirmTitle: '',
    confirmBody: '',

    openReset(cashier) {
        this.resetCashier = cashier;
        this.showResetModal = true;
    },

    openConfirm(cashier, action) {
        this.confirmCashier = cashier;
        this.confirmAction = action;
        if (action === 'deactivate') {
            this.confirmTitle = 'Nonaktifkan akun kasir ini?';
            this.confirmBody = 'Akun tidak dapat digunakan untuk login, tetapi seluruh riwayat transaksi tetap tersimpan.';
        } else {
            this.confirmTitle = 'Aktifkan kembali akun kasir ini?';
            this.confirmBody = 'Kasir akan dapat melakukan login dan transaksi di sistem POS kembali.';
        }
        this.showConfirmModal = true;
    }
}" class="h-screen flex overflow-hidden bg-slate-50">
    
    @include('partials.sidebar_owner', ['active' => 'kelola_kasir'])

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col overflow-hidden">
        
        <!-- Header -->
        @include('partials.header', ['breadcrumbs' => [['label' => 'Dashboard', 'url' => route('owner.dashboard')], ['label' => 'Kelola Kasir']]])

        <!-- Main Scrollable Content -->
        <main class="flex-1 overflow-y-auto p-6 md:p-8 bg-slate-50 space-y-6">

            <!-- Flash Success Message -->
            @if(session('success'))
                <div class="p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-600 text-xs font-semibold flex items-center gap-3">
                    <svg class="h-5 w-5 text-emerald-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- Title & Add Cashier Button -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">Kelola Akun Kasir</h2>
                    <p class="text-slate-500 text-sm mt-0.5">Kelola hak akses dan akun staf kasir warung Anda.</p>
                </div>

                <a href="{{ route('owner.kelola_kasir.create') }}" class="inline-flex items-center justify-center gap-2 bg-[#1e5cfb] hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl text-xs font-bold transition shadow-md shadow-blue-500/15 cursor-pointer shrink-0">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                    <span>Tambah Kasir</span>
                </a>
            </div>

            <!-- Table Card Container -->
            <div class="bg-white border border-slate-200/60 rounded-2xl shadow-sm">
                
                <!-- Filter Bar -->
                <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <form action="{{ route('owner.kelola_kasir') }}" method="GET" class="flex-1 flex flex-col sm:flex-row items-center gap-3">
                        <!-- Search Input -->
                        <div class="relative w-full sm:max-w-xs">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /></svg>
                            </span>
                            <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama atau username..."
                                class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-800 placeholder-slate-400 focus:outline-none focus:bg-white focus:border-[#1e5cfb] transition">
                        </div>

                        <!-- Status Filter Dropdown -->
                        <div class="flex items-center gap-2 text-xs font-bold text-slate-500 w-full sm:w-auto">
                            <span class="shrink-0">Status:</span>
                            <select name="status" onchange="this.form.submit()" class="bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs font-bold text-slate-700 focus:outline-none focus:border-[#1e5cfb] cursor-pointer">
                                <option value="all" {{ $status === 'all' ? 'selected' : '' }}>Semua Status</option>
                                <option value="active" {{ $status === 'active' ? 'selected' : '' }}>Aktif</option>
                                <option value="inactive" {{ $status === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                        </div>
                    </form>
                </div>

                <!-- Cashiers Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100">
                        <thead class="bg-slate-50/75">
                            <tr>
                                <th class="px-6 py-4 text-left text-[11px] font-bold text-slate-400 uppercase tracking-wider">Foto</th>
                                <th class="px-6 py-4 text-left text-[11px] font-bold text-slate-400 uppercase tracking-wider">Nama Kasir</th>
                                <th class="px-6 py-4 text-left text-[11px] font-bold text-slate-400 uppercase tracking-wider">Username</th>
                                <th class="px-6 py-4 text-left text-[11px] font-bold text-slate-400 uppercase tracking-wider">Tanggal Dibuat</th>
                                <th class="px-6 py-4 text-center text-[11px] font-bold text-slate-400 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-right text-[11px] font-bold text-slate-400 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-100">
                            @forelse($cashiers as $cashier)
                                <tr class="hover:bg-slate-50/50 transition">
                                    <!-- Foto -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($cashier->profile_photo && file_exists(public_path($cashier->profile_photo)))
                                            <img src="{{ asset($cashier->profile_photo) }}" alt="{{ $cashier->name }}" class="h-10 w-10 rounded-full object-cover border border-slate-200">
                                        @else
                                            @php
                                                $words = explode(' ', $cashier->name);
                                                $initials = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
                                            @endphp
                                            <div class="h-10 w-10 rounded-full bg-slate-100 text-slate-500 font-bold text-xs flex items-center justify-center border border-slate-200/60 select-none">
                                                {{ $initials }}
                                            </div>
                                        @endif
                                    </td>

                                    <!-- Nama Kasir -->
                                    <td class="px-6 py-4 whitespace-nowrap text-xs font-bold text-slate-800">
                                        {{ $cashier->name }}
                                    </td>

                                    <!-- Username -->
                                    <td class="px-6 py-4 whitespace-nowrap text-xs font-semibold text-slate-500">
                                        {{ $cashier->username ?: '-' }}
                                    </td>

                                    <!-- Tanggal Dibuat -->
                                    <td class="px-6 py-4 whitespace-nowrap text-xs font-semibold text-slate-500">
                                        {{ $cashier->created_at->format('d M Y') }}
                                    </td>

                                    <!-- Status Badge -->
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @if($cashier->is_active)
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-200/50">
                                                Aktif
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-500 border border-slate-200/50">
                                                Nonaktif
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Direct Action Icon Buttons -->
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-xs font-bold">
                                        <div class="inline-flex items-center justify-end gap-1.5">
                                            <!-- 1. Edit Kasir -->
                                            <a href="{{ route('owner.kelola_kasir.edit', $cashier) }}"
                                               title="Edit Kasir"
                                               class="p-2 rounded-lg text-slate-500 hover:text-[#1e5cfb] bg-slate-50 hover:bg-blue-50 border border-slate-200/80 transition cursor-pointer shrink-0">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" /></svg>
                                            </a>

                                            <!-- 2. Reset Password -->
                                            <button type="button"
                                                    @click='openReset(@json($cashier))'
                                                    title="Reset Password"
                                                    class="p-2 rounded-lg text-slate-500 hover:text-amber-600 bg-slate-50 hover:bg-amber-50 border border-slate-200/80 transition cursor-pointer shrink-0">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z" /></svg>
                                            </button>

                                            <!-- 3. Nonaktifkan / Aktifkan Kembali -->
                                            @if($cashier->is_active)
                                                <button type="button"
                                                        @click='openConfirm(@json($cashier), "deactivate")'
                                                        title="Nonaktifkan"
                                                        class="p-2 rounded-lg text-slate-500 hover:text-rose-600 bg-slate-50 hover:bg-rose-50 border border-slate-200/80 transition cursor-pointer shrink-0">
                                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" /></svg>
                                                </button>
                                            @else
                                                <button type="button"
                                                        @click='openConfirm(@json($cashier), "activate")'
                                                        title="Aktifkan Kembali"
                                                        class="p-2 rounded-lg text-slate-500 hover:text-emerald-600 bg-slate-50 hover:bg-emerald-50 border border-slate-200/80 transition cursor-pointer shrink-0">
                                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <p class="text-xs font-bold text-slate-500">Belum ada akun kasir.</p>
                                        <p class="text-[11px] font-semibold text-slate-400 mt-1">Klik tombol <strong class="text-[#1e5cfb]">+ Tambah Kasir</strong> untuk membuat akun kasir baru.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($cashiers->hasPages())
                    <div class="p-4 border-t border-slate-100">
                        {{ $cashiers->links() }}
                    </div>
                @endif
            </div>

        </main>
    </div>

    <!-- Modal Success Initial / Reset Password Credentials -->
    @if(session('new_cashier_credentials') || session('new_reset_credentials'))
        @php
            $creds = session('new_cashier_credentials') ?: session('new_reset_credentials');
            $isNew = session()->has('new_cashier_credentials');
        @endphp
        <div x-data="{ copied: false, copyCreds() { navigator.clipboard.writeText('{{ $creds['password'] }}'); this.copied = true; setTimeout(() => this.copied = false, 2000); } }" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-2xl w-full max-w-md p-6 space-y-4">
                <div class="flex items-center gap-3 pb-3 border-b border-slate-100">
                    <div class="h-10 w-10 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <div>
                        <h3 class="text-base font-extrabold text-slate-800">{{ $isNew ? 'Kasir Berhasil Dibuat' : 'Password Berhasil Direset' }}</h3>
                        <p class="text-xs text-slate-400 font-semibold">Berikan kredensial ini kepada kasir untuk login.</p>
                    </div>
                </div>

                <div class="bg-slate-50 border border-slate-200/70 rounded-xl p-4 space-y-2 text-xs font-semibold text-slate-600">
                    <div class="flex justify-between"><span>Nama Kasir:</span> <strong class="text-slate-800">{{ $creds['name'] }}</strong></div>
                    <div class="flex justify-between"><span>Username:</span> <strong class="text-[#1e5cfb]">{{ $creds['username'] }}</strong></div>
                    <div class="flex justify-between items-center pt-2 border-t border-slate-200/50">
                        <span>Password Awal:</span>
                        <code class="bg-white border border-slate-200 px-2.5 py-1 rounded text-sm font-black text-rose-600">{{ $creds['password'] }}</code>
                    </div>
                </div>

                <p class="text-[10px] font-bold text-slate-400 text-center">Password ini hanya ditampilkan sekali untuk keamanan.</p>

                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" @click="copyCreds()" class="flex-1 px-4 py-2.5 rounded-xl text-xs font-bold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 transition cursor-pointer text-center">
                        <span x-text="copied ? 'Tersalin!' : 'Salin Password'"></span>
                    </button>
                    <button type="button" onclick="this.closest('.fixed').remove()" class="px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-slate-800 hover:bg-slate-900 transition cursor-pointer">
                        Selesai
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Reset Password Input Modal -->
    <div x-show="showResetModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm" x-cloak>
        <div @click.away="showResetModal = false" class="bg-white rounded-2xl border border-slate-200 shadow-2xl w-full max-w-md p-6 space-y-5" x-data="{ newPass: '', showPass: false }">
            <div class="flex justify-between items-center pb-3 border-b border-slate-100">
                <h3 class="text-base font-extrabold text-slate-800">Reset Password Kasir</h3>
                <button @click="showResetModal = false" class="text-slate-400 hover:text-slate-600"><svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg></button>
            </div>

            <form :action="'{{ url('/owner/kelola-kasir') }}/' + (resetCashier ? resetCashier.id : '') + '/reset-password'" method="POST" class="space-y-4">
                @csrf
                <p class="text-xs text-slate-500 font-semibold">Masukkan kata sandi baru untuk kasir <strong class="text-slate-800" x-text="resetCashier ? resetCashier.name : ''"></strong>.</p>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Kata Sandi Baru</label>
                    <div class="relative">
                        <input :type="showPass ? 'text' : 'password'" name="password" x-model="newPass" required minlength="6" placeholder="Masukkan kata sandi baru"
                            class="w-full pl-3.5 pr-10 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-800 focus:outline-none focus:border-[#1e5cfb]">
                        <button type="button" @click="showPass = !showPass" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400">
                            <svg x-show="!showPass" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><circle cx="12" cy="12" r="3" /></svg>
                            <svg x-show="showPass" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21" /></svg>
                        </button>
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" @click="showResetModal = false" class="px-4 py-2.5 rounded-xl text-xs font-bold text-slate-500 bg-slate-100 hover:bg-slate-200 transition">Batal</button>
                    <button type="submit" class="px-4 py-2.5 rounded-xl text-xs font-bold text-white bg-[#1e5cfb] hover:bg-blue-700 transition shadow-md shadow-blue-500/10">Simpan Password Baru</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Activation / Deactivation Confirmation Modal -->
    <div x-show="showConfirmModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm" x-cloak>
        <div @click.away="showConfirmModal = false" class="bg-white rounded-2xl border border-slate-200 shadow-2xl w-full max-w-md p-6 space-y-4">
            <div class="flex items-center gap-3 pb-3 border-b border-slate-100">
                <div class="h-10 w-10 rounded-full flex items-center justify-center shrink-0" :class="confirmAction === 'deactivate' ? 'bg-rose-50 text-rose-600' : 'bg-emerald-50 text-emerald-600'">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" /></svg>
                </div>
                <div>
                    <h3 class="text-base font-extrabold text-slate-800" x-text="confirmTitle"></h3>
                    <p class="text-xs text-slate-400 font-semibold" x-text="confirmCashier ? confirmCashier.name : ''"></p>
                </div>
            </div>

            <p class="text-xs font-semibold text-slate-600 leading-relaxed" x-text="confirmBody"></p>

            <form :action="'{{ url('/owner/kelola-kasir') }}/' + (confirmCashier ? confirmCashier.id : '') + '/' + confirmAction" method="POST">
                @csrf
                @method('PATCH')
                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" @click="showConfirmModal = false" class="px-4 py-2.5 rounded-xl text-xs font-bold text-slate-500 bg-slate-100 hover:bg-slate-200 transition">Batal</button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl text-xs font-bold text-white transition shadow-md" :class="confirmAction === 'deactivate' ? 'bg-rose-600 hover:bg-rose-700 shadow-rose-500/10' : 'bg-emerald-600 hover:bg-emerald-700 shadow-emerald-500/10'">
                        <span x-text="confirmAction === 'deactivate' ? 'Ya, Nonaktifkan' : 'Ya, Aktifkan'"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
