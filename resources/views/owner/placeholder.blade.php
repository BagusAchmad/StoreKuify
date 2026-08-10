@extends('layouts.app')

@section('title', $title . ' - StoreKuify')

@section('content')
<div x-data="{ sidebarOpen: false }" class="h-screen flex overflow-hidden bg-slate-50">
    
    @include('partials.sidebar_owner', ['active' => 'dashboard'])

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col overflow-hidden">
        
        <!-- Header -->
        @include('partials.header', ['breadcrumbs' => [['label' => 'Beranda', 'url' => route('owner.dashboard')], ['label' => $title ?? 'StoreKuify']]])

        <!-- Dynamic Content Body -->
        <main class="flex-1 overflow-y-auto p-6 md:p-8 bg-slate-50">
            <div class="bg-white border border-slate-200/60 rounded-2xl p-8 max-w-2xl mx-auto shadow-sm text-center my-12">
                <div class="h-16 w-16 bg-blue-50 text-[#1e5cfb] rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                    </svg>
                </div>
                <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">Halaman {{ $title }}</h2>
                <p class="text-slate-500 text-sm mt-2 leading-relaxed">
                    Modul <strong>{{ $title }}</strong> saat ini sedang dalam tahap persiapan arsitektur dan belum diimplementasikan.
                </p>
                <div class="mt-6">
                    <a href="{{ route('owner.dashboard') }}" class="inline-flex justify-center bg-[#1e5cfb] hover:bg-[#1a52db] text-white py-2.5 px-6 rounded-xl text-sm font-bold transition duration-150">
                        Kembali ke Dashboard
                    </a>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
