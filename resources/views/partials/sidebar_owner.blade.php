@props(['active' => 'dashboard'])

@php
    $storeSettings = \App\Models\StoreSetting::current();
    $shopName = !empty($storeSettings->shop_name) ? $storeSettings->shop_name : 'Nama Toko';
    $roleName = (Auth::check() && Auth::user()->isKasir()) ? 'Kasir' : 'Owner';
@endphp

<!-- Mobile Sidebar Backdrop -->
<div x-show="sidebarOpen" @click="sidebarOpen = false" x-cloak 
    class="fixed inset-0 z-40 bg-slate-900/60 backdrop-blur-sm lg:hidden transition-opacity duration-300"
    x-transition:enter="ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0">
</div>

<!-- Sidebar Container -->
<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
    class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-slate-200/80 flex flex-col justify-between transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-auto shrink-0">
    
    <!-- Sidebar Header -->
    <div class="p-6 border-b border-slate-100 flex items-center justify-between">
        <div class="min-w-0 flex-1 pr-2">
            <h1 class="text-xl font-black text-[#1e5cfb] tracking-tight">StoreKuify</h1>
            <p class="text-slate-400 text-xs font-semibold mt-0.5 truncate" title="{{ $roleName }} • {{ $shopName }}">{{ $roleName }} • {{ $shopName }}</p>
        </div>
        <!-- Close Button for Mobile -->
        <button @click="sidebarOpen = false" class="lg:hidden p-1 rounded-lg text-slate-400 hover:bg-slate-100 focus:outline-none shrink-0">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- Sidebar Navigation -->
    <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
        <!-- Dashboard -->
        <a href="{{ route('owner.dashboard') }}" 
            class="flex items-center gap-3 px-4 py-3 text-sm font-bold rounded-xl transition duration-150 group {{ $active === 'dashboard' ? 'bg-blue-50 text-[#1e5cfb]' : 'text-slate-500 hover:text-[#1e5cfb] hover:bg-slate-50' }}">
            <svg class="h-5 w-5 {{ $active === 'dashboard' ? 'text-[#1e5cfb]' : 'text-slate-400 group-hover:text-[#1e5cfb]' }} transition duration-150" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z" />
            </svg>
            <span>Dashboard</span>
        </a>

        <!-- Data Barang -->
        <a href="{{ route('owner.barang') }}" 
            class="flex items-center gap-3 px-4 py-3 text-sm font-bold rounded-xl transition duration-150 group {{ $active === 'barang' ? 'bg-blue-50 text-[#1e5cfb]' : 'text-slate-500 hover:text-[#1e5cfb] hover:bg-slate-50' }}">
            <svg class="h-5 w-5 {{ $active === 'barang' ? 'text-[#1e5cfb]' : 'text-slate-400 group-hover:text-[#1e5cfb]' }} transition duration-150" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
            </svg>
            <span>Data Barang</span>
        </a>

        <!-- Kasir -->
        <a href="{{ route('owner.kasir') }}" 
            class="flex items-center gap-3 px-4 py-3 text-sm font-bold rounded-xl transition duration-150 group {{ $active === 'kasir' ? 'bg-blue-50 text-[#1e5cfb]' : 'text-slate-500 hover:text-[#1e5cfb] hover:bg-slate-50' }}">
            <svg class="h-5 w-5 {{ $active === 'kasir' ? 'text-[#1e5cfb]' : 'text-slate-400 group-hover:text-[#1e5cfb]' }} transition duration-150" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
            </svg>
            <span>Kasir</span>
        </a>

        <!-- Hutang Pelanggan -->
        <a href="{{ route('owner.hutang') }}" 
            class="flex items-center gap-3 px-4 py-3 text-sm font-bold rounded-xl transition duration-150 group {{ $active === 'hutang' ? 'bg-blue-50 text-[#1e5cfb]' : 'text-slate-500 hover:text-[#1e5cfb] hover:bg-slate-50' }}">
            <svg class="h-5 w-5 {{ $active === 'hutang' ? 'text-[#1e5cfb]' : 'text-slate-400 group-hover:text-[#1e5cfb]' }} transition duration-150" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>Hutang Pelanggan</span>
        </a>

        <!-- Laporan -->
        <a href="{{ route('owner.laporan') }}" 
            class="flex items-center gap-3 px-4 py-3 text-sm font-bold rounded-xl transition duration-150 group {{ $active === 'laporan' ? 'bg-blue-50 text-[#1e5cfb]' : 'text-slate-500 hover:text-[#1e5cfb] hover:bg-slate-50' }}">
            <svg class="h-5 w-5 {{ $active === 'laporan' ? 'text-[#1e5cfb]' : 'text-slate-400 group-hover:text-[#1e5cfb]' }} transition duration-150" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
            <span>Laporan</span>
        </a>

        <!-- Kelola Kasir -->
        <a href="{{ route('owner.kelola_kasir') }}" 
            class="flex items-center gap-3 px-4 py-3 text-sm font-bold rounded-xl transition duration-150 group {{ $active === 'kelola_kasir' ? 'bg-blue-50 text-[#1e5cfb]' : 'text-slate-500 hover:text-[#1e5cfb] hover:bg-slate-50' }}">
            <svg class="h-5 w-5 {{ $active === 'kelola_kasir' ? 'text-[#1e5cfb]' : 'text-slate-400 group-hover:text-[#1e5cfb]' }} transition duration-150" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <span>Kelola Kasir</span>
        </a>

        <!-- Pengaturan -->
        <a href="{{ route('owner.pengaturan') }}" 
            class="flex items-center gap-3 px-4 py-3 text-sm font-bold rounded-xl transition duration-150 group {{ $active === 'pengaturan' ? 'bg-blue-50 text-[#1e5cfb]' : 'text-slate-500 hover:text-[#1e5cfb] hover:bg-slate-50' }}">
            <svg class="h-5 w-5 {{ $active === 'pengaturan' ? 'text-[#1e5cfb]' : 'text-slate-400 group-hover:text-[#1e5cfb]' }} transition duration-150" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <span>Pengaturan</span>
        </a>
    </nav>

    <!-- Sidebar Footer -->
    <div class="p-4 border-t border-slate-100 space-y-1">
        <!-- Profil Saya -->
        <a href="{{ route('profile.edit') }}" 
            class="flex items-center gap-3 px-4 py-3 text-sm font-bold rounded-xl transition duration-150 group {{ $active === 'profil' ? 'bg-blue-50 text-[#1e5cfb]' : 'text-slate-500 hover:text-[#1e5cfb] hover:bg-slate-50' }}">
            <svg class="h-5 w-5 {{ $active === 'profil' ? 'text-[#1e5cfb]' : 'text-slate-400 group-hover:text-[#1e5cfb]' }} transition duration-150" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            <span>Profil Saya</span>
        </a>

        <!-- Keluar -->
        <form action="{{ route('logout') }}" method="POST" class="w-full">
            @csrf
            <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-sm font-bold text-slate-500 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition duration-150 text-left cursor-pointer">
                <svg class="h-5 w-5 text-slate-400 group-hover:text-rose-600 transition duration-150" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span>Keluar</span>
            </button>
        </form>
    </div>
</aside>
