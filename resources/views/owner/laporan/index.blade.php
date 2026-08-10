@extends('layouts.app')

@section('title', 'Laporan Performa Bisnis - StoreKuify')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div x-data="{
    sidebarOpen: false,
    selectedPeriod: '{{ $period }}',
    showDatePicker: false,
    showDetailModal: false,
    selectedTransaction: null,

    // Calendar state
    viewMonth: {{ (int) $startDate->format('n') - 1 }},
    viewYear: {{ (int) $startDate->format('Y') }},
    pickerStart: '{{ $startDate->format('Y-m-d') }}',
    pickerEnd: '{{ $endDate->format('Y-m-d') }}',

    monthNames: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],

    get calendarDays() {
        let days = [];
        let firstDay = new Date(this.viewYear, this.viewMonth, 1).getDay();
        let daysInMonth = new Date(this.viewYear, this.viewMonth + 1, 0).getDate();

        for (let i = 0; i < firstDay; i++) {
            days.push(null);
        }

        for (let d = 1; d <= daysInMonth; d++) {
            let monthStr = String(this.viewMonth + 1).padStart(2, '0');
            let dayStr = String(d).padStart(2, '0');
            let dateStr = `${this.viewYear}-${monthStr}-${dayStr}`;
            days.push({ day: d, dateStr: dateStr });
        }

        return days;
    },

    prevMonth() {
        if (this.viewMonth === 0) {
            this.viewMonth = 11;
            this.viewYear--;
        } else {
            this.viewMonth--;
        }
    },

    nextMonth() {
        if (this.viewMonth === 11) {
            this.viewMonth = 0;
            this.viewYear++;
        } else {
            this.viewMonth++;
        }
    },

    handleDateClick(dateStr) {
        if (!dateStr) return;

        if (this.selectedPeriod === 'custom') {
            if (!this.pickerStart || (this.pickerStart && this.pickerEnd)) {
                this.pickerStart = dateStr;
                this.pickerEnd = '';
            } else if (dateStr < this.pickerStart) {
                this.pickerStart = dateStr;
                this.pickerEnd = '';
            } else {
                this.pickerEnd = dateStr;
            }
        } else {
            this.pickerStart = dateStr;
            this.pickerEnd = dateStr;
            this.applyFilter();
        }
    },

    isDateSelected(dateStr) {
        if (!dateStr) return false;
        if (this.selectedPeriod === 'custom') {
            if (this.pickerStart && this.pickerEnd) {
                return dateStr >= this.pickerStart && dateStr <= this.pickerEnd;
            }
            return dateStr === this.pickerStart;
        }
        return dateStr === this.pickerStart;
    },

    applyFilter() {
        let url = new URL('{{ route('owner.laporan') }}', window.location.origin);
        url.searchParams.set('period', this.selectedPeriod);
        if (this.pickerStart) {
            url.searchParams.set('start_date', this.pickerStart);
        }
        if (this.selectedPeriod === 'custom' && this.pickerEnd) {
            url.searchParams.set('end_date', this.pickerEnd);
        }
        window.location.href = url.toString();
    },

    clearFilter() {
        window.location.href = '{{ route('owner.laporan') }}';
    },

    openDetail(trx) {
        this.selectedTransaction = trx;
        this.showDetailModal = true;
    }
}" class="h-screen flex overflow-hidden bg-slate-50">
    
    @include('partials.sidebar_owner', ['active' => 'laporan'])

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col overflow-hidden">
        
        <!-- Header -->
        @include('partials.header', ['breadcrumbs' => [['label' => 'Beranda', 'url' => route('owner.dashboard')], ['label' => 'Laporan Performa Bisnis']]])

        <!-- Main Scrollable Content -->
        <main class="flex-1 overflow-y-auto p-6 md:p-8 bg-slate-50 space-y-6">

            <!-- Title & Unified Segmented Filter Controls Row -->
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">Laporan Performa Bisnis</h2>
                    <p class="text-slate-500 text-sm mt-0.5">Pantau penjualan dan keuntungan toko Anda secara real-time.</p>
                </div>

                <!-- Horizontal Period Segmented Control + Interactive Date Picker Button -->
                <div class="flex flex-wrap items-center gap-3">
                    
                    <!-- Segmented Control Pill Bar -->
                    <div class="bg-white border border-slate-200/80 rounded-xl p-1 flex items-center shadow-sm">
                        <a href="{{ route('owner.laporan', ['period' => 'harian', 'start_date' => request('start_date')]) }}" 
                            class="px-3.5 py-1.5 rounded-lg text-xs font-bold transition duration-150 {{ $period === 'harian' ? 'bg-[#1e5cfb] text-white shadow-sm shadow-blue-500/20' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                            Harian
                        </a>
                        <a href="{{ route('owner.laporan', ['period' => 'mingguan', 'start_date' => request('start_date')]) }}" 
                            class="px-3.5 py-1.5 rounded-lg text-xs font-bold transition duration-150 {{ $period === 'mingguan' ? 'bg-[#1e5cfb] text-white shadow-sm shadow-blue-500/20' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                            Mingguan
                        </a>
                        <a href="{{ route('owner.laporan', ['period' => 'bulanan', 'start_date' => request('start_date')]) }}" 
                            class="px-3.5 py-1.5 rounded-lg text-xs font-bold transition duration-150 {{ $period === 'bulanan' ? 'bg-[#1e5cfb] text-white shadow-sm shadow-blue-500/20' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                            Bulanan
                        </a>
                        <a href="{{ route('owner.laporan', ['period' => 'tahunan', 'start_date' => request('start_date')]) }}" 
                            class="px-3.5 py-1.5 rounded-lg text-xs font-bold transition duration-150 {{ $period === 'tahunan' ? 'bg-[#1e5cfb] text-white shadow-sm shadow-blue-500/20' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                            Tahunan
                        </a>
                        <a href="{{ route('owner.laporan', ['period' => 'custom', 'start_date' => request('start_date'), 'end_date' => request('end_date')]) }}" 
                            class="px-3.5 py-1.5 rounded-lg text-xs font-bold transition duration-150 {{ $period === 'custom' ? 'bg-[#1e5cfb] text-white shadow-sm shadow-blue-500/20' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                            Rentang Custom
                        </a>
                    </div>

                    <!-- Interactive Date Selector Button with Calendar Popover -->
                    <div class="relative" @click.outside="showDatePicker = false">
                        <button type="button" @click="showDatePicker = !showDatePicker" 
                            class="bg-white border border-slate-200/80 px-4 py-2 rounded-xl text-xs font-bold text-slate-700 hover:border-slate-300 hover:bg-slate-50 flex items-center gap-2 shadow-sm shrink-0 transition cursor-pointer select-none">
                            <svg class="h-4 w-4 text-[#1e5cfb]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            <span>{{ $periodLabel }}</span>
                            <svg class="h-3.5 w-3.5 text-slate-400 transition-transform duration-200" :class="showDatePicker ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                        </button>

                        <!-- Calendar Date Picker Popover -->
                        <div x-show="showDatePicker" 
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 translate-y-1 scale-95"
                            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                            x-transition:leave-end="opacity-0 translate-y-1 scale-95"
                            class="absolute right-0 mt-2 z-50 w-80 bg-white rounded-2xl border border-slate-200/90 shadow-2xl p-4 space-y-3" x-cloak>
                            
                            <!-- Calendar Header (Month + Year + Nav) -->
                            <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                                <button type="button" @click="prevMonth()" class="p-1 rounded-lg hover:bg-slate-100 text-slate-600 cursor-pointer">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
                                </button>
                                <span class="text-xs font-black text-slate-800" x-text="monthNames[viewMonth] + ' ' + viewYear"></span>
                                <button type="button" @click="nextMonth()" class="p-1 rounded-lg hover:bg-slate-100 text-slate-600 cursor-pointer">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
                                </button>
                            </div>

                            <!-- Weekday Headers -->
                            <div class="grid grid-cols-7 text-center text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                                <div>Min</div><div>Sen</div><div>Sel</div><div>Rab</div><div>Kam</div><div>Jum</div><div>Sab</div>
                            </div>

                            <!-- Days Grid -->
                            <div class="grid grid-cols-7 gap-1 text-center text-xs font-semibold">
                                <template x-for="(item, idx) in calendarDays" :key="idx">
                                    <div>
                                        <template x-if="item">
                                            <button type="button" @click="handleDateClick(item.dateStr)"
                                                :class="isDateSelected(item.dateStr) ? 'bg-[#1e5cfb] text-white font-bold shadow-sm shadow-blue-500/20' : 'hover:bg-slate-100 text-slate-700'"
                                                class="w-8 h-8 rounded-lg flex items-center justify-center mx-auto transition cursor-pointer select-none"
                                                x-text="item.day">
                                            </button>
                                        </template>
                                    </div>
                                </template>
                            </div>

                            <!-- Custom Period Date Range Helpers -->
                            <div x-show="selectedPeriod === 'custom'" class="pt-2 border-t border-slate-100 space-y-2 text-[11px] font-semibold text-slate-500">
                                <div class="flex justify-between">
                                    <span>Mulai: <strong class="text-slate-800" x-text="pickerStart || '-'"></strong></span>
                                    <span>Selesai: <strong class="text-slate-800" x-text="pickerEnd || '-'"></strong></span>
                                </div>
                            </div>

                            <!-- Popover Actions (Bersihkan & Terapkan) -->
                            <div class="flex justify-between items-center pt-2 border-t border-slate-100">
                                <button type="button" @click="clearFilter()" class="text-xs font-bold text-slate-400 hover:text-slate-600 cursor-pointer">
                                    Bersihkan
                                </button>
                                <button type="button" @click="applyFilter()" class="px-3.5 py-1.5 bg-[#1e5cfb] hover:bg-blue-700 text-white text-xs font-bold rounded-lg transition cursor-pointer shadow-sm shadow-blue-500/10">
                                    Terapkan
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Summary Cards Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6">
                <!-- Card 1: Total Penjualan -->
                <div class="bg-white border border-slate-200/60 rounded-2xl p-6 flex flex-col justify-between shadow-sm relative overflow-hidden">
                    <div class="flex justify-between items-start">
                        <div>
                            <span class="text-xs font-bold text-slate-400 block tracking-wide uppercase">Total Penjualan</span>
                            <span class="text-2xl font-black text-slate-800 block mt-2">
                                Rp {{ number_format($totalSales, 0, ',', '.') }}
                            </span>
                        </div>
                        <div class="h-10 w-10 bg-blue-50 text-[#1e5cfb] rounded-xl flex items-center justify-center shrink-0">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center gap-1.5 text-[11px] font-bold">
                        @if($salesChangePercent !== null)
                            <span class="{{ $salesChangePercent >= 0 ? 'text-emerald-600' : 'text-rose-500' }} flex items-center gap-0.5">
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $salesChangePercent >= 0 ? 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6' : 'M13 17h8m0 0v-8m0 8l-8-8-4 4-6-6' }}" /></svg>
                                {{ $salesChangePercent >= 0 ? '+' : '' }}{{ $salesChangePercent }}%
                            </span>
                            <span class="text-slate-400">vs {{ $prevPeriodLabel }}</span>
                        @else
                            <span class="text-slate-400">Belum ada data pembanding</span>
                        @endif
                    </div>
                </div>

                <!-- Card 2: Total Keuntungan -->
                <div class="bg-white border border-slate-200/60 rounded-2xl p-6 flex flex-col justify-between shadow-sm">
                    <div class="flex justify-between items-start">
                        <div>
                            <span class="text-xs font-bold text-slate-400 block tracking-wide uppercase">Total Keuntungan</span>
                            <span class="text-2xl font-black text-emerald-600 block mt-2">
                                Rp {{ number_format($totalProfit, 0, ',', '.') }}
                            </span>
                        </div>
                        <div class="h-10 w-10 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center shrink-0">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center gap-1.5 text-[11px] font-bold">
                        @if($profitChangePercent !== null)
                            <span class="{{ $profitChangePercent >= 0 ? 'text-emerald-600' : 'text-rose-500' }} flex items-center gap-0.5">
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $profitChangePercent >= 0 ? 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6' : 'M13 17h8m0 0v-8m0 8l-8-8-4 4-6-6' }}" /></svg>
                                {{ $profitChangePercent >= 0 ? '+' : '' }}{{ $profitChangePercent }}%
                            </span>
                            <span class="text-slate-400">vs {{ $prevPeriodLabel }}</span>
                        @else
                            <span class="text-slate-400">Belum ada data pembanding</span>
                        @endif
                    </div>
                </div>

                <!-- Card 3: Jumlah Transaksi -->
                <div class="bg-white border border-slate-200/60 rounded-2xl p-6 flex flex-col justify-between shadow-sm">
                    <div class="flex justify-between items-start">
                        <div>
                            <span class="text-xs font-bold text-slate-400 block tracking-wide uppercase">Jumlah Transaksi</span>
                            <span class="text-2xl font-black text-slate-800 block mt-2">
                                {{ number_format($transactionCount, 0, ',', '.') }} <span class="text-xs font-semibold text-slate-400">transaksi</span>
                            </span>
                        </div>
                        <div class="h-10 w-10 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center shrink-0">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center gap-1.5 text-[11px] font-bold">
                        @if($transactionCountChange != 0)
                            <span class="{{ $transactionCountChange > 0 ? 'text-emerald-600' : 'text-rose-500' }}">
                                {{ $transactionCountChange > 0 ? '+' : '' }}{{ $transactionCountChange }} transaksi
                            </span>
                            <span class="text-slate-400">vs {{ $prevPeriodLabel }}</span>
                        @else
                            <span class="text-slate-400">Stabil</span>
                        @endif
                    </div>
                </div>

                <!-- Card 4: Total Barang Terjual -->
                <div class="bg-white border border-slate-200/60 rounded-2xl p-6 flex flex-col justify-between shadow-sm">
                    <div class="flex justify-between items-start">
                        <div>
                            <span class="text-xs font-bold text-slate-400 block tracking-wide uppercase">Total Barang Terjual</span>
                            <span class="text-2xl font-black text-slate-800 block mt-2">
                                {{ number_format($itemsSold, 0, ',', '.') }} <span class="text-xs font-semibold text-slate-400">unit</span>
                            </span>
                        </div>
                        <div class="h-10 w-10 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center shrink-0">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center gap-1.5 text-[11px] font-bold">
                        @if($itemsSoldChange != 0)
                            <span class="{{ $itemsSoldChange > 0 ? 'text-emerald-600' : 'text-rose-500' }}">
                                {{ $itemsSoldChange > 0 ? '+' : '' }}{{ $itemsSoldChange }} unit
                            </span>
                            <span class="text-slate-400">vs {{ $prevPeriodLabel }}</span>
                        @else
                            <span class="text-slate-400">Stabil</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Trend Charts Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Sales Trend Chart -->
                <div class="bg-white border border-slate-200/60 rounded-2xl p-6 shadow-sm flex flex-col justify-between min-h-[360px]">
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <h3 class="text-base font-extrabold text-slate-800 tracking-tight">Tren Penjualan</h3>
                            <p class="text-slate-400 text-xs mt-0.5">Grafik pergerakan total nilai penjualan.</p>
                        </div>
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-blue-50 text-[#1e5cfb] border border-blue-200/50">
                            {{ $periodLabel }}
                        </span>
                    </div>

                    @if($trendData['has_data'])
                        <div class="flex-1 w-full relative min-h-[240px]">
                            <canvas id="salesTrendChart"></canvas>
                        </div>
                    @else
                        <div class="flex-1 border-2 border-dashed border-slate-200/80 rounded-xl p-8 flex flex-col items-center justify-center text-center my-4">
                            <svg class="h-10 w-10 text-slate-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 131l4-4 4 4 6-6 4 4 3-3" /></svg>
                            <p class="text-xs font-bold text-slate-500">Belum ada data penjualan pada periode ini.</p>
                            <p class="text-[10px] text-slate-400 mt-1">Transaksi penjualan baru akan secara otomatis memperbarui grafik ini.</p>
                        </div>
                    @endif
                </div>

                <!-- Profit Trend Chart -->
                <div class="bg-white border border-slate-200/60 rounded-2xl p-6 shadow-sm flex flex-col justify-between min-h-[360px]">
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <h3 class="text-base font-extrabold text-slate-800 tracking-tight">Tren Keuntungan</h3>
                            <p class="text-slate-400 text-xs mt-0.5">Grafik pergerakan estimasi laba bersih toko.</p>
                        </div>
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-200/50">
                            {{ $periodLabel }}
                        </span>
                    </div>

                    @if($trendData['has_data'])
                        <div class="flex-1 w-full relative min-h-[240px]">
                            <canvas id="profitTrendChart"></canvas>
                        </div>
                    @else
                        <div class="flex-1 border-2 border-dashed border-slate-200/80 rounded-xl p-8 flex flex-col items-center justify-center text-center my-4">
                            <svg class="h-10 w-10 text-slate-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            <p class="text-xs font-bold text-slate-500">Belum ada data keuntungan pada periode ini.</p>
                            <p class="text-[10px] text-slate-400 mt-1">Keuntungan dihitung dari harga jual dikurangi harga modal per barang.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Payment Methods Breakdown & Debt Summary -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Payment Method Distribution (2 cols) -->
                <div class="lg:col-span-2 bg-white border border-slate-200/60 rounded-2xl p-6 shadow-sm space-y-4">
                    <div>
                        <h3 class="text-base font-extrabold text-slate-800 tracking-tight">Distribusi Metode Pembayaran</h3>
                        <p class="text-slate-400 text-xs mt-0.5">Rincian nilai penjualan berdasarkan pilihan cara bayar pelanggan.</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">
                        <!-- Tunai -->
                        <div class="bg-slate-50/75 border border-slate-200/50 p-4 rounded-xl space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-slate-700">Tunai</span>
                                <span class="px-2 py-0.5 rounded text-[10px] font-extrabold bg-blue-100/70 text-[#1e5cfb]">{{ $paymentMethodsData['cash']['count'] }} trx</span>
                            </div>
                            <p class="text-lg font-black text-slate-800">Rp {{ number_format($paymentMethodsData['cash']['paid'], 0, ',', '.') }}</p>
                            <p class="text-[10px] text-slate-400 font-semibold">100% Lunas Tunai</p>
                        </div>

                        <!-- QRIS -->
                        <div class="bg-slate-50/75 border border-slate-200/50 p-4 rounded-xl space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-slate-700">QRIS</span>
                                <span class="px-2 py-0.5 rounded text-[10px] font-extrabold bg-indigo-100/70 text-indigo-600">{{ $paymentMethodsData['qris']['count'] }} trx</span>
                            </div>
                            <p class="text-lg font-black text-slate-800">Rp {{ number_format($paymentMethodsData['qris']['paid'], 0, ',', '.') }}</p>
                            <p class="text-[10px] text-slate-400 font-semibold">100% Transfer Non-Tunai</p>
                        </div>

                        <!-- Hutang Full -->
                        <div class="bg-slate-50/75 border border-slate-200/50 p-4 rounded-xl space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-slate-700">Hutang (Kredit)</span>
                                <span class="px-2 py-0.5 rounded text-[10px] font-extrabold bg-rose-100/70 text-rose-600">{{ $paymentMethodsData['debt']['count'] }} trx</span>
                            </div>
                            <p class="text-lg font-black text-rose-600">Rp {{ number_format($paymentMethodsData['debt']['debt'], 0, ',', '.') }}</p>
                            <p class="text-[10px] text-slate-400 font-semibold">Menjadi Hutang Pelanggan</p>
                        </div>

                        <!-- Tunai + Hutang -->
                        <div class="bg-slate-50/75 border border-slate-200/50 p-4 rounded-xl space-y-1.5">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-slate-700">Tunai + Hutang</span>
                                <span class="px-2 py-0.5 rounded text-[10px] font-extrabold bg-amber-100/70 text-amber-600">{{ $paymentMethodsData['cash_debt']['count'] }} trx</span>
                            </div>
                            <div class="text-xs font-bold text-slate-600 space-y-0.5 pt-1">
                                <div class="flex justify-between"><span>Dibayar Tunai:</span> <span class="text-emerald-600">Rp {{ number_format($paymentMethodsData['cash_debt']['paid'], 0, ',', '.') }}</span></div>
                                <div class="flex justify-between"><span>Sisa Hutang:</span> <span class="text-rose-500">Rp {{ number_format($paymentMethodsData['cash_debt']['debt'], 0, ',', '.') }}</span></div>
                            </div>
                        </div>

                        <!-- QRIS + Hutang -->
                        <div class="bg-slate-50/75 border border-slate-200/50 p-4 rounded-xl space-y-1.5">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-slate-700">QRIS + Hutang</span>
                                <span class="px-2 py-0.5 rounded text-[10px] font-extrabold bg-purple-100/70 text-purple-600">{{ $paymentMethodsData['qris_debt']['count'] }} trx</span>
                            </div>
                            <div class="text-xs font-bold text-slate-600 space-y-0.5 pt-1">
                                <div class="flex justify-between"><span>Dibayar QRIS:</span> <span class="text-emerald-600">Rp {{ number_format($paymentMethodsData['qris_debt']['paid'], 0, ',', '.') }}</span></div>
                                <div class="flex justify-between"><span>Sisa Hutang:</span> <span class="text-rose-500">Rp {{ number_format($paymentMethodsData['qris_debt']['debt'], 0, ',', '.') }}</span></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Debt Summary Card (1 col) -->
                <div class="bg-white border border-slate-200/60 rounded-2xl p-6 shadow-sm space-y-4 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center gap-2">
                            <div class="h-8 w-8 bg-rose-50 text-rose-600 rounded-lg flex items-center justify-center shrink-0">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                            </div>
                            <div>
                                <h3 class="text-base font-extrabold text-slate-800 tracking-tight">Ringkasan Piutang</h3>
                                <p class="text-slate-400 text-[11px]">Integrasi data Hutang Pelanggan.</p>
                            </div>
                        </div>

                        <div class="mt-4 space-y-3 divide-y divide-slate-100 text-xs font-semibold">
                            <div class="flex justify-between items-center pt-2">
                                <span class="text-slate-500">Total Penjualan Kredit</span>
                                <span class="font-bold text-slate-800">Rp {{ number_format($creditSalesTotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between items-center pt-2">
                                <span class="text-slate-500">Total Hutang Baru Periode Ini</span>
                                <span class="font-bold text-rose-600">+ Rp {{ number_format($newDebtGenerated, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between items-center pt-2">
                                <span class="text-slate-500">Pelunasan Hutang Diterima</span>
                                <span class="font-bold text-emerald-600">Rp {{ number_format($debtPaymentsCollected, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-rose-50/60 border border-rose-100 p-4 rounded-xl text-xs font-bold text-slate-700 space-y-1">
                        <span class="text-[10px] font-bold text-rose-500 uppercase tracking-wide block">Total Hutang Pelanggan Saat Ini</span>
                        <span class="text-xl font-black text-rose-600 block">Rp {{ number_format($totalCustomerDebt, 0, ',', '.') }}</span>
                        <p class="text-[9px] text-slate-400 font-semibold pt-0.5">Seluruh saldo hutang aktif di sistem StoreKuify.</p>
                    </div>
                </div>
            </div>

            <!-- Product Rankings (Produk Terlaris & Keuntungan Terbesar) -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Produk Terlaris -->
                <div class="bg-white border border-slate-200/60 rounded-2xl p-6 shadow-sm space-y-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-base font-extrabold text-slate-800 tracking-tight">Produk Terlaris</h3>
                            <p class="text-slate-400 text-xs mt-0.5">Peringkat barang berdasarkan kuantitas terjual.</p>
                        </div>
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-50 text-amber-600 border border-amber-200/50">Volume Terbanyak</span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-100">
                            <thead>
                                <tr class="text-left text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                                    <th class="py-2.5 px-3">Rank</th>
                                    <th class="py-2.5 px-3">Nama Barang</th>
                                    <th class="py-2.5 px-3 text-center">Terjual</th>
                                    <th class="py-2.5 px-3 text-right">Total Penjualan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-xs font-semibold text-slate-700">
                                @forelse($topSellingProducts as $idx => $prod)
                                    <tr class="hover:bg-slate-50/50 transition">
                                        <td class="py-3 px-3">
                                            <span class="h-6 w-6 rounded-full flex items-center justify-center font-black text-[11px] {{ $idx === 0 ? 'bg-amber-100 text-amber-700' : ($idx === 1 ? 'bg-slate-200 text-slate-700' : ($idx === 2 ? 'bg-amber-50 text-amber-600' : 'bg-slate-100 text-slate-500')) }}">
                                                {{ $idx + 1 }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-3 font-bold text-slate-800">{{ $prod['name'] }}</td>
                                        <td class="py-3 px-3 text-center font-black text-blue-600">{{ $prod['qty_sold'] }} unit</td>
                                        <td class="py-3 px-3 text-right font-bold text-slate-800">Rp {{ number_format($prod['sales'], 0, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-8 text-center text-xs font-bold text-slate-400">Belum ada data penjualan produk.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Produk Keuntungan Terbesar -->
                <div class="bg-white border border-slate-200/60 rounded-2xl p-6 shadow-sm space-y-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-base font-extrabold text-slate-800 tracking-tight">Keuntungan Terbesar</h3>
                            <p class="text-slate-400 text-xs mt-0.5">Peringkat barang berdasarkan kontribusi profit.</p>
                        </div>
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-200/50">Profit Margin</span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-100">
                            <thead>
                                <tr class="text-left text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                                    <th class="py-2.5 px-3">Rank</th>
                                    <th class="py-2.5 px-3">Nama Barang</th>
                                    <th class="py-2.5 px-3 text-center">Terjual</th>
                                    <th class="py-2.5 px-3 text-right">Total Keuntungan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-xs font-semibold text-slate-700">
                                @forelse($topProfitProducts as $idx => $prod)
                                    <tr class="hover:bg-slate-50/50 transition">
                                        <td class="py-3 px-3">
                                            <span class="h-6 w-6 rounded-full flex items-center justify-center font-black text-[11px] {{ $idx === 0 ? 'bg-emerald-100 text-emerald-700' : ($idx === 1 ? 'bg-slate-200 text-slate-700' : 'bg-slate-100 text-slate-500') }}">
                                                {{ $idx + 1 }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-3 font-bold text-slate-800">{{ $prod['name'] }}</td>
                                        <td class="py-3 px-3 text-center font-semibold text-slate-500">{{ $prod['qty_sold'] }} unit</td>
                                        <td class="py-3 px-3 text-right font-black text-emerald-600">Rp {{ number_format($prod['profit'], 0, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-8 text-center text-xs font-bold text-slate-400">Belum ada data keuntungan produk.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Transaction Recap Section -->
            <div class="bg-white border border-slate-200/60 rounded-2xl shadow-sm overflow-hidden space-y-4">
                <div class="p-6 pb-0 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h3 class="text-base font-extrabold text-slate-800 tracking-tight">Rekap Transaksi</h3>
                        <p class="text-slate-400 text-xs mt-0.5">Daftar rinci seluruh transaksi kasir yang tercatat pada periode ini.</p>
                    </div>
                    
                    <div class="flex items-center gap-3">
                        <a href="{{ route('owner.laporan.export', request()->query()) }}" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-xl text-xs font-bold transition shadow-md shadow-emerald-500/10 cursor-pointer">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                            <span>Export CSV</span>
                        </a>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100">
                        <thead class="bg-slate-50/75">
                            <tr>
                                <th class="px-6 py-3.5 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-3.5 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">No. Transaksi</th>
                                <th class="px-6 py-3.5 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">Kasir</th>
                                <th class="px-6 py-3.5 text-right text-xs font-bold text-slate-400 uppercase tracking-wider">Total Belanja</th>
                                <th class="px-6 py-3.5 text-center text-xs font-bold text-slate-400 uppercase tracking-wider">Metode</th>
                                <th class="px-6 py-3.5 text-right text-xs font-bold text-slate-400 uppercase tracking-wider">Dibayar</th>
                                <th class="px-6 py-3.5 text-right text-xs font-bold text-slate-400 uppercase tracking-wider">Sisa Hutang</th>
                                <th class="px-6 py-3.5 text-center text-xs font-bold text-slate-400 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3.5 text-center text-xs font-bold text-slate-400 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-100">
                            @forelse($recapTransactions as $trx)
                                <tr class="hover:bg-slate-50/50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap text-xs font-semibold text-slate-500">
                                        {{ $trx->created_at->format('d M Y, H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-xs font-bold text-slate-800">
                                        {{ $trx->transaction_number }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-xs font-semibold text-slate-600">
                                        {{ optional($trx->user)->name ?? 'Kasir' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-xs font-black text-slate-800">
                                        Rp {{ number_format($trx->total, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @php
                                            $methodBadge = match ($trx->payment_method) {
                                                'cash' => ['label' => 'Tunai', 'class' => 'bg-blue-50 text-blue-600 border-blue-200/50'],
                                                'qris' => ['label' => 'QRIS', 'class' => 'bg-indigo-50 text-indigo-600 border-indigo-200/50'],
                                                'debt' => ['label' => 'Hutang', 'class' => 'bg-rose-50 text-rose-600 border-rose-200/50'],
                                                'cash_debt' => ['label' => 'Tunai + Hutang', 'class' => 'bg-amber-50 text-amber-600 border-amber-200/50'],
                                                'qris_debt' => ['label' => 'QRIS + Hutang', 'class' => 'bg-purple-50 text-purple-600 border-purple-200/50'],
                                                default => ['label' => ucfirst($trx->payment_method), 'class' => 'bg-slate-50 text-slate-600 border-slate-200/50'],
                                            };
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold border {{ $methodBadge['class'] }}">
                                            {{ $methodBadge['label'] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-xs font-bold text-emerald-600">
                                        Rp {{ number_format($trx->amount_paid, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-xs font-bold {{ $trx->remaining_amount > 0 ? 'text-rose-500' : 'text-slate-400' }}">
                                        Rp {{ number_format($trx->remaining_amount, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @if($trx->status === 'paid')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[9px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-200/50">Lunas</span>
                                        @elseif($trx->status === 'partial')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[9px] font-bold bg-amber-50 text-amber-600 border border-amber-200/50">Sebagian</span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[9px] font-bold bg-rose-50 text-rose-600 border border-rose-200/50">Belum Lunas</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <button type="button" @click='openDetail(@json($trx))' class="text-xs font-bold text-[#1e5cfb] hover:text-blue-700 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition cursor-pointer">
                                            Rincian
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="px-6 py-12 text-center text-xs font-bold text-slate-400">
                                        Tidak ada transaksi tercatat pada periode ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($recapTransactions->hasPages())
                    <div class="p-4 border-t border-slate-100">
                        {{ $recapTransactions->links() }}
                    </div>
                @endif
            </div>

        </main>
    </div>

    <!-- Modal Rincian Item Transaksi -->
    <div x-show="showDetailModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm" x-cloak>
        <div @click.away="showDetailModal = false" class="bg-white rounded-2xl border border-slate-200 shadow-2xl w-full max-w-xl overflow-hidden" x-show="selectedTransaction">
            <div class="p-6 bg-slate-50 border-b border-slate-100 flex justify-between items-start">
                <div>
                    <span class="text-[10px] font-bold text-[#1e5cfb] uppercase tracking-wider block">Rincian Transaksi</span>
                    <h3 class="text-lg font-black text-slate-800 mt-0.5" x-text="selectedTransaction ? selectedTransaction.transaction_number : ''"></h3>
                    <p class="text-xs text-slate-400 font-semibold mt-0.5" x-text="selectedTransaction ? 'Kasir: ' + (selectedTransaction.user ? selectedTransaction.user.name : 'System') + (selectedTransaction.customer ? ' | Pelanggan: ' + selectedTransaction.customer.name : '') : ''"></p>
                </div>
                <button @click="showDetailModal = false" class="text-slate-400 hover:text-slate-600"><svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg></button>
            </div>

            <div class="p-6 max-h-[60vh] overflow-y-auto space-y-4">
                <table class="min-w-full divide-y divide-slate-100 text-xs">
                    <thead>
                        <tr class="text-left font-bold text-slate-400 uppercase tracking-wider">
                            <th class="py-2">Barang</th>
                            <th class="py-2 text-center">Qty</th>
                            <th class="py-2 text-right">Modal</th>
                            <th class="py-2 text-right">Jual</th>
                            <th class="py-2 text-right">Profit</th>
                            <th class="py-2 text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-semibold text-slate-700">
                        <template x-if="selectedTransaction && selectedTransaction.items">
                            <template x-for="item in selectedTransaction.items" :key="item.id">
                                <tr>
                                    <td class="py-2.5 font-bold text-slate-800" x-text="item.product ? item.product.name : 'Produk tidak tersedia'"></td>
                                    <td class="py-2.5 text-center font-bold" x-text="item.quantity"></td>
                                    <td class="py-2.5 text-right text-slate-500" x-text="'Rp ' + (parseFloat(item.cost_price || (item.product ? item.product.cost_price : 0))).toLocaleString('id-ID')"></td>
                                    <td class="py-2.5 text-right text-slate-800" x-text="'Rp ' + (parseFloat(item.price)).toLocaleString('id-ID')"></td>
                                    <td class="py-2.5 text-right text-emerald-600 font-bold" x-text="'Rp ' + ((parseFloat(item.price) - parseFloat(item.cost_price || (item.product ? item.product.cost_price : 0))) * parseInt(item.quantity)).toLocaleString('id-ID')"></td>
                                    <td class="py-2.5 text-right font-black text-slate-800" x-text="'Rp ' + (parseFloat(item.subtotal)).toLocaleString('id-ID')"></td>
                                </tr>
                            </template>
                        </template>
                    </tbody>
                </table>
            </div>

            <div class="p-6 bg-slate-50 border-t border-slate-100 flex justify-between items-center">
                <div class="text-xs font-bold text-slate-500 space-y-1">
                    <div>Total Belanja: <span class="text-slate-800 font-black" x-text="selectedTransaction ? 'Rp ' + (parseFloat(selectedTransaction.total)).toLocaleString('id-ID') : ''"></span></div>
                    <div>Dibayar: <span class="text-emerald-600 font-black" x-text="selectedTransaction ? 'Rp ' + (parseFloat(selectedTransaction.amount_paid)).toLocaleString('id-ID') : ''"></span></div>
                </div>
                <button type="button" @click="showDetailModal = false" class="px-5 py-2.5 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-xs font-bold transition">Tutup</button>
            </div>
        </div>
    </div>

</div>

@if($trendData['has_data'])
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const labels = @json($trendData['labels']);
        const sales = @json($trendData['sales']);
        const profit = @json($trendData['profit']);

        // Sales Trend Chart
        const ctxSales = document.getElementById('salesTrendChart');
        if (ctxSales) {
            new Chart(ctxSales, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Total Penjualan (Rp)',
                        data: sales,
                        borderColor: '#1e5cfb',
                        backgroundColor: 'rgba(30, 92, 251, 0.1)',
                        fill: true,
                        tension: 0.35,
                        borderWidth: 3,
                        pointBackgroundColor: '#1e5cfb',
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return 'Penjualan: Rp ' + context.parsed.y.toLocaleString('id-ID');
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: '#f1f5f9' },
                            ticks: {
                                callback: function(value) {
                                    return 'Rp ' + value.toLocaleString('id-ID');
                                },
                                font: { size: 10, weight: 'bold' }
                            }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { font: { size: 10, weight: 'bold' } }
                        }
                    }
                }
            });
        }

        // Profit Trend Chart
        const ctxProfit = document.getElementById('profitTrendChart');
        if (ctxProfit) {
            new Chart(ctxProfit, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Total Keuntungan (Rp)',
                        data: profit,
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        fill: true,
                        tension: 0.35,
                        borderWidth: 3,
                        pointBackgroundColor: '#10b981',
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return 'Keuntungan: Rp ' + context.parsed.y.toLocaleString('id-ID');
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: '#f1f5f9' },
                            ticks: {
                                callback: function(value) {
                                    return 'Rp ' + value.toLocaleString('id-ID');
                                },
                                font: { size: 10, weight: 'bold' }
                            }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { font: { size: 10, weight: 'bold' } }
                        }
                    }
                }
            });
        }
    });
</script>
@endif
@endsection
