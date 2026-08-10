@extends('layouts.app')

@section('title', 'Pembayaran Hutang Berhasil - StoreKuify')

@section('content')
<style>
    @media print {
        body {
            background: white !important;
            color: black !important;
        }
        div.min-h-screen > div > .no-print {
            display: none !important;
        }
        #debt-receipt-card {
            display: block !important;
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            max-width: 100% !important;
            border: none !important;
            box-shadow: none !important;
            padding: 0 !important;
            margin: 0 !important;
        }
    }
</style>

<div class="min-h-screen flex items-center justify-center py-4 px-4 bg-slate-50">
    <div class="w-full max-w-sm flex flex-col items-center">
        
        <!-- Status Icon -->
        <div class="no-print h-10 w-10 rounded-full flex items-center justify-center mb-2 shadow-sm shrink-0
            {{ $debtPayment->debt_after <= 0 ? 'bg-emerald-100 text-emerald-600' : 'bg-amber-100 text-amber-600' }}">
            @if($debtPayment->debt_after <= 0)
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            @else
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            @endif
        </div>

        <h2 class="no-print text-sm font-black text-slate-800 tracking-tight text-center shrink-0">Pembayaran Hutang Berhasil</h2>
        <p class="no-print text-[10px] text-slate-400 font-semibold mt-0.5 text-center mb-3.5 shrink-0">Pembayaran telah tercatat di sistem.</p>

        @php
            $storeSettings = \App\Models\StoreSetting::current();
        @endphp

        <!-- Receipt Card -->
        <div id="debt-receipt-card" class="w-full bg-white border border-slate-200/60 rounded-xl p-4.5 shadow-md mb-4.5">
            
            <!-- Store Header -->
            <div class="text-center mb-3">
                @if($storeSettings->shop_logo && file_exists(public_path($storeSettings->shop_logo)))
                    <img src="{{ asset($storeSettings->shop_logo) }}" alt="{{ $storeSettings->shop_name }}" class="h-10 w-auto mx-auto mb-1.5 object-contain">
                @endif
                <h3 class="text-xs font-black tracking-widest text-[#1e5cfb] uppercase">{{ $storeSettings->shop_name }}</h3>
                @if($storeSettings->shop_address)
                    <p class="text-[9px] text-slate-400 font-semibold mt-0.5 whitespace-pre-line">{{ $storeSettings->shop_address }}</p>
                @endif
            </div>

            <!-- Title -->
            <div class="text-center border-b border-slate-100 pb-3 mb-3">
                <span class="text-[10px] font-extrabold text-slate-800 uppercase tracking-wider">Pembayaran Hutang</span>
            </div>

            <!-- Details -->
            <div class="space-y-2 text-[10px] font-bold text-slate-500">
                <!-- Reference & Date -->
                <div class="grid grid-cols-2 gap-y-1.5 border-b border-slate-100 pb-3 mb-3">
                    <div>
                        <span class="block text-slate-400 font-medium">No. Referensi</span>
                        <span class="text-slate-800">{{ $debtPayment->reference }}</span>
                    </div>
                    <div class="text-right">
                        <span class="block text-slate-400 font-medium">Waktu</span>
                        <span class="text-slate-800">{{ $debtPayment->created_at->format('d M Y, H:i') }}</span>
                    </div>
                </div>

                <!-- Customer Info -->
                <div class="flex justify-between items-center">
                    <span>Pelanggan</span>
                    <span class="text-slate-800">{{ $debtPayment->customer->name }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span>No. Handphone</span>
                    <span class="text-slate-800">{{ $debtPayment->customer->phone ?: '-' }}</span>
                </div>

                <!-- Payment Method -->
                <div class="flex justify-between items-center">
                    <span>Metode Pembayaran</span>
                    <span class="text-slate-800">{{ $debtPayment->payment_method === 'qris' ? 'QRIS' : 'Tunai' }}</span>
                </div>

                <!-- Debt Breakdown -->
                <div class="border-t border-dashed border-slate-200 pt-3 mt-3 space-y-2">
                    <div class="flex justify-between items-center">
                        <span>Hutang Sebelum Pembayaran</span>
                        <span class="text-slate-800">Rp {{ number_format($debtPayment->debt_before, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span>Dibayar</span>
                        <span class="text-emerald-600 font-extrabold">- Rp {{ number_format($debtPayment->amount, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center border-t border-slate-100 pt-2 mt-1">
                        <span class="text-slate-800 font-extrabold">Sisa Hutang</span>
                        <span class="text-xs font-black {{ $debtPayment->debt_after > 0 ? 'text-rose-600' : 'text-emerald-600' }}">
                            Rp {{ number_format(max(0, $debtPayment->debt_after), 0, ',', '.') }}
                        </span>
                    </div>
                </div>

                <!-- Status -->
                <div class="flex justify-between items-center border-t border-slate-100 pt-2 mt-1">
                    <span class="text-slate-400 font-bold">Status</span>
                    @if($debtPayment->debt_after <= 0)
                        <span class="text-[9px] font-black text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded uppercase border border-emerald-100">LUNAS</span>
                    @else
                        <span class="text-[9px] font-black text-rose-600 bg-rose-50 px-1.5 py-0.5 rounded uppercase border border-rose-100">BELUM LUNAS</span>
                    @endif
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center border-t border-slate-100 pt-3 mt-4">
                <p class="text-[9px] text-slate-400 font-bold italic tracking-wide">Terima kasih atas pembayaran Anda!</p>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="no-print flex gap-3.5 w-full shrink-0">
            <button onclick="window.print()" class="flex-1 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 py-3 rounded-xl text-xs font-bold transition duration-150 flex items-center justify-center gap-1.5 cursor-pointer shadow-sm">
                <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
                <span>Cetak Struk</span>
            </button>
            <a href="{{ Auth::user()->isKasir() ? route('kasir.hutang.show', $debtPayment->customer) : route('owner.hutang.show', $debtPayment->customer) }}" 
                class="flex-1 bg-[#1e5cfb] hover:bg-[#1a52db] text-white py-3 rounded-xl text-xs font-bold transition duration-150 flex items-center justify-center gap-1.5 cursor-pointer shadow-md shadow-blue-500/10 hover:shadow-blue-500/20 active:scale-[0.99]">
                <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
                <span>Kembali ke Detail</span>
            </a>
        </div>

    </div>
</div>
@endsection
