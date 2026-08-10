@extends('layouts.app')

@section('title', 'Detail Hutang - ' . $customer->name . ' - StoreKuify')

@section('content')
<div x-data="{
    sidebarOpen: false,
    showPaymentModal: false,
    paymentMethod: 'cash',
    paymentAmount: '',
    showQrisStep: false,
    currentDebt: {{ $totalDebt }},
    get parsedAmount() {
        let v = parseFloat(this.paymentAmount);
        return isNaN(v) ? 0 : v;
    },
    get isPaymentValid() {
        return this.parsedAmount > 0 && this.parsedAmount <= this.currentDebt;
    },
    openPayment() {
        this.paymentMethod = 'cash';
        this.paymentAmount = '';
        this.showQrisStep = false;
        this.showPaymentModal = true;
    },
    handlePayConfirm() {
        if (!this.isPaymentValid) return;
        if (this.paymentMethod === 'qris') {
            this.showQrisStep = true;
        } else {
            this.$refs.payForm.submit();
        }
    },
    submitQrisPayment() {
        this.$refs.payForm.submit();
    }
}" class="h-screen flex overflow-hidden bg-slate-50">
    
    @include('partials.sidebar_owner', ['active' => 'hutang'])

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col overflow-hidden">
        
        <!-- Header -->
        @include('partials.header', ['breadcrumbs' => [['label' => 'Dashboard', 'url' => route('owner.dashboard')], ['label' => 'Hutang Pelanggan', 'url' => route('owner.hutang')], ['label' => $customer->name]]])

        <!-- Main Scrollable Content -->
        <main class="flex-1 overflow-y-auto p-6 md:p-8 bg-slate-50 space-y-6">

            <!-- Page Title + Back Button -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <div class="text-xs font-bold text-slate-400 flex items-center gap-1">
                        <span>Dashboard</span>
                        <span class="text-slate-300">/</span>
                        <a href="{{ route('owner.hutang') }}" class="hover:text-[#1e5cfb] transition">Hutang Pelanggan</a>
                        <span class="text-slate-300">/</span>
                        <span class="text-slate-600 font-extrabold">{{ $customer->name }}</span>
                    </div>
                    <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight mt-1.5">Detail Hutang Pelanggan</h2>
                </div>
                <a href="{{ route('owner.hutang') }}" class="inline-flex items-center gap-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-600 px-4 py-2.5 rounded-xl text-sm font-bold transition duration-150 cursor-pointer">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
                    <span>Kembali</span>
                </a>
            </div>

            <!-- Error Alert -->
            @if($errors->has('payment'))
                <div class="p-4 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-600 text-sm font-semibold flex items-center gap-3">
                    <svg class="h-5 w-5 text-rose-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126z" /></svg>
                    <span>{{ $errors->first('payment') }}</span>
                </div>
            @endif

            <!-- Customer Info Card -->
            <div class="bg-white border border-slate-200/60 rounded-2xl shadow-sm p-6">
                <div class="flex items-center gap-4">
                    <div class="h-14 w-14 bg-blue-50 text-[#1e5cfb] rounded-full flex items-center justify-center font-black text-xl uppercase shrink-0">
                        {{ substr($customer->name, 0, 1) }}
                    </div>
                    <div>
                        <h3 class="text-lg font-extrabold text-slate-800 tracking-tight">{{ $customer->name }}</h3>
                        <p class="text-sm text-slate-500 font-semibold mt-0.5">No. Handphone: {{ $customer->phone ?: '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Total Hutang Saat Ini -->
                <div class="bg-white border border-slate-200/60 rounded-2xl shadow-sm p-5">
                    <span class="text-[10px] font-bold text-slate-400 block uppercase tracking-wide">Total Hutang Saat Ini</span>
                    <span class="text-xl font-black block mt-2 {{ $totalDebt > 0 ? 'text-rose-600' : 'text-emerald-600' }}">
                        Rp {{ number_format($totalDebt, 0, ',', '.') }}
                    </span>
                </div>
                <!-- Total Transaksi -->
                <div class="bg-white border border-slate-200/60 rounded-2xl shadow-sm p-5">
                    <span class="text-[10px] font-bold text-slate-400 block uppercase tracking-wide">Total Transaksi</span>
                    <span class="text-xl font-black text-slate-800 block mt-2">{{ $totalTransactions }}</span>
                </div>
                <!-- Total Sudah Dibayar -->
                <div class="bg-white border border-slate-200/60 rounded-2xl shadow-sm p-5">
                    <span class="text-[10px] font-bold text-slate-400 block uppercase tracking-wide">Total Sudah Dibayar</span>
                    <span class="text-xl font-black text-emerald-600 block mt-2">
                        Rp {{ number_format($totalPaid, 0, ',', '.') }}
                    </span>
                </div>
                <!-- Status -->
                <div class="bg-white border border-slate-200/60 rounded-2xl shadow-sm p-5">
                    <span class="text-[10px] font-bold text-slate-400 block uppercase tracking-wide">Status</span>
                    <div class="mt-2">
                        @if($totalDebt > 0)
                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-amber-50 text-amber-600 border border-amber-200/50">Belum Lunas</span>
                        @else
                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-600 border border-emerald-200/50">Lunas</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Action: Bayar Hutang -->
            @if($totalDebt > 0)
                <div>
                    <button type="button" @click="openPayment()" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-3 rounded-xl text-sm font-bold shadow-md shadow-emerald-500/10 hover:shadow-emerald-500/20 active:scale-[0.98] transition duration-150 cursor-pointer">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <span>Bayar Hutang</span>
                    </button>
                </div>
            @endif

            <!-- Riwayat Hutang & Pembayaran -->
            <div class="bg-white border border-slate-200/60 rounded-2xl shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-100">
                    <h4 class="text-sm font-extrabold text-slate-800 tracking-tight">Riwayat Hutang & Pembayaran</h4>
                    <p class="text-xs text-slate-400 font-semibold mt-0.5">Semua riwayat transaksi dan pembayaran hutang pelanggan.</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100">
                        <thead class="bg-slate-50/75">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">Jenis</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">Referensi</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-slate-400 uppercase tracking-wider">Total / Dibayar</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-slate-400 uppercase tracking-wider">Perubahan Hutang</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-slate-400 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-100">
                            @forelse($history as $entry)
                                <tr class="align-top hover:bg-slate-50/40 transition duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-xs font-semibold text-slate-500">
                                        {{ $entry['date']->format('d M Y, H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($entry['type'] === 'purchase')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-blue-50 text-blue-600 border border-blue-200/50">Pembelian</span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-200/50">Pembayaran Hutang</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-xs font-bold text-slate-700">
                                        <div>{{ $entry['reference'] }}</div>
                                        @if($entry['type'] === 'purchase' && !empty($entry['items']) && $entry['items']->count() > 0)
                                            <div class="mt-2 text-[11px] font-normal text-slate-600">
                                                <span class="font-semibold text-slate-500 block mb-1">Barang:</span>
                                                <ul class="space-y-0.5">
                                                    @foreach($entry['items'] as $item)
                                                        <li class="flex items-start gap-1 text-slate-600">
                                                            <span class="text-slate-400 select-none">•</span>
                                                            <span>{{ optional($item->product)->name ?? 'Produk tidak tersedia' }}</span>
                                                            <span class="font-semibold text-slate-500 shrink-0">× {{ $item->quantity ?? 0 }}</span>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-xs font-bold text-slate-700">
                                        @if($entry['type'] === 'purchase')
                                            Rp {{ number_format($entry['total'], 0, ',', '.') }}
                                        @else
                                            Rp {{ number_format($entry['amount'], 0, ',', '.') }}
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-xs font-black">
                                        @if($entry['type'] === 'purchase')
                                            @php $debtChange = max(0, $entry['remaining']); @endphp
                                            @if($debtChange > 0)
                                                <span class="text-rose-500">+ Rp {{ number_format($debtChange, 0, ',', '.') }}</span>
                                            @else
                                                <span class="text-slate-400">Rp 0</span>
                                            @endif
                                        @else
                                            <span class="text-emerald-600">- Rp {{ number_format($entry['amount'], 0, ',', '.') }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @if($entry['type'] === 'purchase')
                                            @if($entry['status'] === 'paid')
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[9px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-200/50">Lunas</span>
                                            @elseif($entry['status'] === 'partial')
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[9px] font-bold bg-amber-50 text-amber-600 border border-amber-200/50">Sebagian</span>
                                            @else
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[9px] font-bold bg-rose-50 text-rose-600 border border-rose-200/50">Belum Lunas</span>
                                            @endif
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[9px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-200/50">Dibayar</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <h4 class="text-sm font-bold text-slate-700">Belum ada riwayat</h4>
                                        <p class="text-slate-400 text-xs mt-1">Riwayat transaksi dan pembayaran hutang akan muncul di sini.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
    </div>

    <!-- Bayar Hutang Modal -->
    <div x-show="showPaymentModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm" x-cloak>
        <div @click.away="showPaymentModal = false; showQrisStep = false"
            class="bg-white rounded-2xl border border-slate-200/80 shadow-2xl w-full max-w-md overflow-hidden"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="scale-95 opacity-0"
            x-transition:enter-end="scale-100 opacity-100">

            <!-- Step 1: Payment Input -->
            <div x-show="!showQrisStep" class="p-6 space-y-5">
                <div class="flex items-center gap-3 pb-3 border-b border-slate-150">
                    <div class="h-10 w-10 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <div>
                        <h3 class="text-base font-extrabold text-slate-800 tracking-tight">Bayar Hutang</h3>
                        <p class="text-xs text-slate-400 font-semibold">{{ $customer->name }}</p>
                    </div>
                </div>

                <!-- Current Debt Info -->
                <div class="bg-slate-50 border border-slate-200/50 p-4 rounded-xl">
                    <span class="text-[10px] font-bold text-slate-400 block uppercase tracking-wide">Hutang Saat Ini</span>
                    <span class="text-xl font-black text-rose-600 block mt-1">Rp {{ number_format($totalDebt, 0, ',', '.') }}</span>
                </div>

                <!-- Payment Method -->
                <div>
                    <span class="text-xs font-bold text-slate-400 block mb-2 uppercase tracking-wide">Metode Pembayaran</span>
                    <div class="grid grid-cols-2 gap-3">
                        <button type="button" @click="paymentMethod = 'cash'"
                            :class="paymentMethod === 'cash' ? 'border-[#1e5cfb] bg-blue-50 text-[#1e5cfb]' : 'border-slate-200 text-slate-500 hover:border-slate-300'"
                            class="px-4 py-3 rounded-xl border-2 text-xs font-bold transition cursor-pointer text-center select-none">
                            Tunai
                        </button>
                        <button type="button" @click="paymentMethod = 'qris'"
                            :class="paymentMethod === 'qris' ? 'border-[#1e5cfb] bg-blue-50 text-[#1e5cfb]' : 'border-slate-200 text-slate-500 hover:border-slate-300'"
                            class="px-4 py-3 rounded-xl border-2 text-xs font-bold transition cursor-pointer text-center select-none">
                            QRIS
                        </button>
                    </div>
                </div>

                <!-- Amount Input -->
                <div>
                    <span class="text-xs font-bold text-slate-400 block mb-2 uppercase tracking-wide">Jumlah Pembayaran</span>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 text-sm font-extrabold">Rp</span>
                        <input type="text" x-model="paymentAmount"
                            class="block w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-black text-slate-800 placeholder-slate-300 focus:outline-none focus:bg-white focus:border-[#1e5cfb] focus:ring-1 focus:ring-[#1e5cfb] transition"
                            placeholder="0">
                    </div>
                    <!-- Quick pay buttons -->
                    <div class="flex flex-wrap gap-2 mt-3">
                        <button type="button" @click="paymentAmount = currentDebt.toString()" class="px-3.5 py-2 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition select-none cursor-pointer">
                            Bayar Penuh
                        </button>
                    </div>
                    <!-- Live preview -->
                    <div class="mt-3 p-3 bg-blue-50/30 border border-blue-100/50 rounded-xl text-[10px] font-bold text-slate-500 space-y-1.5 select-none" x-show="parsedAmount > 0">
                        <div class="flex justify-between"><span>Hutang Saat Ini</span><span class="text-slate-700" x-text="'Rp ' + currentDebt.toLocaleString('id-ID')"></span></div>
                        <div class="flex justify-between"><span>Dibayar</span><span class="text-emerald-600" x-text="'- Rp ' + parsedAmount.toLocaleString('id-ID')"></span></div>
                        <div class="flex justify-between border-t border-slate-200/50 pt-1.5">
                            <span class="font-black text-slate-700">Sisa Hutang</span>
                            <span class="font-black" :class="(currentDebt - parsedAmount) > 0 ? 'text-rose-500' : 'text-emerald-600'" x-text="'Rp ' + Math.max(0, currentDebt - parsedAmount).toLocaleString('id-ID')"></span>
                        </div>
                    </div>
                    <!-- Validation message -->
                    <p class="text-[10px] text-rose-500 font-bold mt-2" x-show="parsedAmount > currentDebt">Jumlah melebihi hutang saat ini.</p>
                </div>

                <!-- Actions -->
                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" @click="showPaymentModal = false" class="px-4.5 py-2.5 rounded-xl text-xs font-bold text-slate-500 bg-slate-100 hover:bg-slate-200 transition cursor-pointer">
                        Batal
                    </button>
                    <button type="button" @click="handlePayConfirm()" :disabled="!isPaymentValid"
                        class="px-4.5 py-2.5 rounded-xl text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 disabled:bg-slate-200 disabled:text-slate-400 transition cursor-pointer disabled:cursor-not-allowed shadow-md shadow-emerald-500/10">
                        Konfirmasi Pembayaran
                    </button>
                </div>

                <!-- Hidden Form -->
                <form x-ref="payForm" action="{{ route('owner.hutang.pay', $customer) }}" method="POST" class="hidden">
                    @csrf
                    <input type="hidden" name="amount" :value="parsedAmount">
                    <input type="hidden" name="payment_method" :value="paymentMethod">
                </form>
            </div>

            <!-- Step 2: QRIS Confirmation -->
            <div x-show="showQrisStep" class="p-6 space-y-5" x-cloak>
                <div class="space-y-1.5">
                    <h3 class="text-base font-black tracking-widest text-[#1e5cfb] uppercase">StoreKuify</h3>
                    <p class="text-sm font-extrabold text-slate-800">Pembayaran Hutang via QRIS</p>
                </div>

                <!-- Payment Info -->
                <div class="bg-blue-50/50 border border-blue-100 p-4 rounded-2xl space-y-2 text-xs font-bold">
                    <div class="flex justify-between items-center text-slate-500">
                        <span>Pelanggan</span>
                        <span class="text-slate-800">{{ $customer->name }}</span>
                    </div>
                    <div class="flex justify-between items-center text-slate-500">
                        <span>Hutang Saat Ini</span>
                        <span class="text-slate-800" x-text="'Rp ' + currentDebt.toLocaleString('id-ID')"></span>
                    </div>
                    <div class="border-t border-blue-100 pt-2 flex justify-between items-center text-sm font-extrabold text-[#1e5cfb]">
                        <span>Dibayar via QRIS</span>
                        <span class="text-lg font-black" x-text="'Rp ' + parsedAmount.toLocaleString('id-ID')"></span>
                    </div>
                </div>

                <!-- QRIS Image -->
                <div class="aspect-square w-56 h-56 bg-slate-50 border border-slate-200/80 rounded-2xl mx-auto flex flex-col items-center justify-center p-4">
                    @php
                        $storeSettings = \App\Models\StoreSetting::current();
                        $qrisPath = $storeSettings->qris_image;
                        $qrisExists = $qrisPath && file_exists(public_path($qrisPath));
                    @endphp
                    @if($qrisExists)
                        <img src="{{ asset($qrisPath) }}" alt="QRIS StoreKuify" class="w-full h-full object-contain rounded-xl">
                    @else
                        <div class="text-center">
                            <svg class="h-10 w-10 text-slate-300 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" /></svg>
                            <p class="text-xs font-bold text-slate-400">QRIS Belum Dikonfigurasi</p>
                            <p class="text-[9px] text-slate-400 mt-0.5">Silakan atur QRIS di Pengaturan > QRIS.</p>
                        </div>
                    @endif
                </div>

                <p class="text-center text-[10px] font-bold text-slate-400">
                    {{ $qrisExists ? 'Minta pelanggan scan QR code di atas untuk membayar.' : 'QRIS harus dikonfigurasi terlebih dahulu.' }}
                </p>

                <!-- QRIS Actions -->
                <div class="flex gap-3">
                    <button type="button" @click="showQrisStep = false" class="flex-1 px-4 py-3 rounded-xl text-xs font-bold text-slate-500 bg-slate-100 hover:bg-slate-200 transition cursor-pointer text-center">
                        Kembali
                    </button>
                    <button type="button" @click="submitQrisPayment()" @if(!$qrisExists) disabled @endif class="flex-1 px-4 py-3 rounded-xl text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 disabled:bg-slate-200 disabled:text-slate-400 disabled:cursor-not-allowed transition cursor-pointer text-center shadow-md shadow-emerald-500/10">
                        Pembayaran Sudah Diterima
                    </button>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection
