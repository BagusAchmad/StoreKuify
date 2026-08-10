@extends('layouts.app')

@section('title', 'Pembayaran Berhasil - StoreKuify')

@section('content')
<style>
    @media print {
        body {
            background: white !important;
            color: black !important;
        }
        /* Hide everything except the receipt card */
        div.h-screen, 
        button, 
        a, 
        form,
        .no-print {
            display: none !important;
        }
        #receipt-card {
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
        
        <!-- Status Icon (no-print decoration) -->
        <div class="no-print h-10 w-10 rounded-full flex items-center justify-center mb-2 shadow-sm shrink-0
            @if($transaction->status === 'paid') bg-emerald-100 text-emerald-600 
            @elseif($transaction->status === 'partial') bg-amber-100 text-amber-600 
            @else bg-rose-100 text-rose-600 @endif">
            
            @if($transaction->status === 'paid')
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            @elseif($transaction->status === 'partial')
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            @else
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            @endif
        </div>

        <!-- Success Message (no-print decoration) -->
        <h2 class="no-print text-sm font-black text-slate-800 tracking-tight text-center shrink-0">
            @if($transaction->status === 'paid')
                Pembayaran Berhasil
            @elseif($transaction->status === 'partial')
                Pembayaran Berhasil
            @else
                Transaksi Berhasil
            @endif
        </h2>
        
        <p class="no-print text-[10px] text-slate-400 font-semibold mt-0.5 text-center mb-3.5 shrink-0">
            @if($transaction->status === 'paid')
                Transaksi telah tersimpan di sistem.
            @elseif($transaction->status === 'partial')
                Transaksi tercatat dengan sisa hutang.
            @else
                Transaksi dicatat sebagai hutang pelanggan.
            @endif
        </p>

        @php
            $storeSettings = \App\Models\StoreSetting::current();
        @endphp

        <!-- Dynamic Receipt Card -->
        <div id="receipt-card" class="w-full bg-white border border-slate-200/60 rounded-xl p-4.5 shadow-md mb-4.5">
            
            <!-- Store Details Header -->
            <div class="text-center mb-3">
                @if($storeSettings->shop_logo && file_exists(public_path($storeSettings->shop_logo)))
                    <img src="{{ asset($storeSettings->shop_logo) }}" alt="{{ $storeSettings->shop_name }}" class="h-10 w-auto mx-auto mb-1.5 object-contain">
                @endif
                <h3 class="text-xs font-black tracking-widest text-[#1e5cfb] uppercase">{{ $storeSettings->shop_name }}</h3>
                @if($storeSettings->shop_address)
                    <p class="text-[9px] text-slate-400 font-semibold mt-0.5 whitespace-pre-line">{{ $storeSettings->shop_address }}</p>
                @endif
            </div>

            <!-- Metadata parameters -->
            <div class="grid grid-cols-2 gap-y-1.5 text-[9px] font-bold text-slate-500 border-b border-slate-100 pb-3 mb-3">
                <div>
                    <span class="block text-slate-400 font-medium">No. Transaksi</span>
                    <span class="text-slate-800">{{ $transaction->transaction_number }}</span>
                </div>
                <div class="text-right">
                    <span class="block text-slate-400 font-medium">Waktu</span>
                    <span class="text-slate-800">{{ $transaction->created_at->format('d M Y, H:i') }}</span>
                </div>
                <div>
                    <span class="block text-slate-400 font-medium">Kasir</span>
                    <span class="text-slate-800">{{ $transaction->user->name }}</span>
                </div>
                @if($transaction->customer)
                    <div class="text-right">
                        <span class="block text-slate-400 font-medium">Pelanggan</span>
                        <span class="text-slate-800">{{ $transaction->customer->name }}</span>
                    </div>
                @endif
            </div>

            <!-- Items Table -->
            <div class="space-y-2.5 mb-3 border-b border-slate-100 pb-3">
                @foreach($transaction->items as $item)
                    <div class="flex justify-between items-start text-[10px]">
                        <div class="min-w-0 flex-1 pr-4">
                            <span class="font-bold text-slate-800 block break-words leading-tight">{{ $item->product->name }}</span>
                            <span class="text-[9px] text-slate-400 font-semibold block mt-0.5">
                                {{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}
                            </span>
                        </div>
                        <span class="font-extrabold text-slate-800 shrink-0">
                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                        </span>
                    </div>
                @endforeach
            </div>

            <!-- Calculations totals -->
            <div class="space-y-2 text-[10px] font-bold text-slate-500">
                <div class="flex justify-between items-center">
                    <span>Total Belanja</span>
                    <span class="text-slate-800 font-black">
                        Rp {{ number_format($transaction->total, 0, ',', '.') }}
                    </span>
                </div>

                <div class="flex justify-between items-center">
                    <span>Metode Pembayaran</span>
                    <span class="text-slate-800">
                        @if($transaction->payment_method === 'cash')
                            Tunai
                        @elseif($transaction->payment_method === 'qris')
                            QRIS
                        @elseif($transaction->payment_method === 'debt')
                            Hutang
                        @elseif($transaction->payment_method === 'cash_debt')
                            Tunai + Hutang
                        @else
                            QRIS + Hutang
                        @endif
                    </span>
                </div>

                <!-- Payment details based on Status -->
                <div class="flex justify-between items-center">
                    <span>
                        @if(in_array($transaction->payment_method, ['qris', 'qris_debt']))
                            Dibayar via QRIS
                        @else
                            Jumlah Dibayar
                        @endif
                    </span>
                    <span class="text-slate-800">
                        Rp {{ number_format($transaction->amount_paid, 0, ',', '.') }}
                    </span>
                </div>

                <!-- Sisa Transaksi (Current transaction unpaid balance) -->
                @if(in_array($transaction->payment_method, ['debt', 'cash_debt', 'qris_debt']))
                    <div class="flex justify-between items-center">
                        <span>Sisa Transaksi</span>
                        <span class="text-slate-800">
                            Rp {{ number_format(max(0, (float) ($transaction->total - $transaction->amount_paid)), 0, ',', '.') }}
                        </span>
                    </div>
                @endif

                <!-- Kembalian and Allocation calculations -->
                @php
                    $previousDebt = 0;
                    if ($transaction->customer) {
                        $previousDebt = (float) $transaction->customer->transactions()->where('id', '<', $transaction->id)->sum('remaining_amount');
                    }

                    $pembayaranTransaksi = min($transaction->total, $transaction->amount_paid);
                    $pembayaranHutangLama = max(0, $transaction->amount_paid - $transaction->total);
                    if ($pembayaranHutangLama > $previousDebt) {
                        $pembayaranHutangLama = $previousDebt;
                    }

                    $change = 0;
                    if (in_array($transaction->payment_method, ['cash', 'cash_debt'])) {
                        if ($transaction->payment_method === 'cash') {
                            $change = max(0, (float) ($transaction->amount_paid - $transaction->total));
                        } else {
                            $change = max(0, (float) ($transaction->amount_paid - ($transaction->total + $previousDebt)));
                        }
                    }
                @endphp

                @if(in_array($transaction->payment_method, ['cash_debt', 'qris_debt']) && $transaction->amount_paid > 0)
                    <div class="flex justify-between items-center text-slate-450 mt-1">
                        <span>Pembayaran Transaksi</span>
                        <span class="text-slate-700">
                            Rp {{ number_format($pembayaranTransaksi, 0, ',', '.') }}
                        </span>
                    </div>
                    @if($pembayaranHutangLama > 0)
                        <div class="flex justify-between items-center text-slate-455 mt-1">
                            <span>Pembayaran Hutang Lama</span>
                            <span class="text-slate-700">
                                Rp {{ number_format($pembayaranHutangLama, 0, ',', '.') }}
                            </span>
                        </div>
                    @endif
                @endif

                @if($change > 0)
                    <div class="flex justify-between items-center border-t border-slate-100 pt-2 mt-1">
                        <span class="text-slate-800 font-extrabold">Kembalian</span>
                        <span class="text-xs font-black text-emerald-600">
                            Rp {{ number_format($change, 0, ',', '.') }}
                        </span>
                    </div>
                @endif

            <!-- HUTANG PELANGGAN SECTION (visible only when customer and debt-involved transaction) -->
            @if($transaction->customer && (in_array($transaction->payment_method, ['debt', 'cash_debt', 'qris_debt']) || $previousDebt > 0))
                @php
                    // Unpaid portion generated by the current purchase
                    $hutangBaru = max(0, (float) ($transaction->total - $transaction->amount_paid));
                    $totalHutangSaatIni = max(0, $previousDebt + $hutangBaru - $pembayaranHutangLama);
                @endphp
                <div class="border-t border-dashed border-slate-200 pt-3 mt-4 space-y-2 text-[10px] font-bold text-slate-500">
                    <span class="text-[9px] font-extrabold text-slate-400 block tracking-wide uppercase">Hutang Pelanggan</span>
                    
                    <div class="flex justify-between items-center">
                        <span>Hutang Sebelum Transaksi</span>
                        <span class="text-slate-700">
                            Rp {{ number_format($previousDebt, 0, ',', '.') }}
                        </span>
                    </div>

                    @if($hutangBaru > 0)
                        <div class="flex justify-between items-center">
                            <span>Tambahan Hutang</span>
                            <span class="text-rose-500">
                                Rp {{ number_format($hutangBaru, 0, ',', '.') }}
                            </span>
                        </div>
                    @endif

                    @if($pembayaranHutangLama > 0)
                        <div class="flex justify-between items-center">
                            <span>Pengurangan Hutang Lama</span>
                            <span class="text-emerald-600">
                                - Rp {{ number_format($pembayaranHutangLama, 0, ',', '.') }}
                            </span>
                        </div>
                    @endif

                    <div class="flex justify-between items-center border-t border-slate-100 pt-2 mt-1">
                        <span class="text-slate-800 font-extrabold">Total Hutang Saat Ini</span>
                        <span class="text-xs font-black {{ $totalHutangSaatIni > 0 ? 'text-rose-600' : 'text-emerald-600' }}">
                            Rp {{ number_format($totalHutangSaatIni, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            @endif

                <!-- Payment Status Indicator row (always printed) -->
                <div class="flex justify-between items-center border-t border-slate-100 pt-2 mt-1">
                    <span class="text-slate-400 font-bold">Status Transaksi</span>
                    @if($transaction->status === 'paid')
                        <span class="text-[9px] font-black text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded uppercase border border-emerald-100">LUNAS</span>
                    @else
                        <span class="text-[9px] font-black text-rose-600 bg-rose-50 px-1.5 py-0.5 rounded uppercase border border-rose-100">BELUM LUNAS</span>
                    @endif
                </div>
            </div>

            <!-- Receipt Card footer note -->
            <div class="text-center border-t border-slate-100 pt-3 mt-4">
                <p class="text-[9px] text-slate-400 font-bold italic tracking-wide">Terima kasih atas kunjungan Anda!</p>
                <p class="text-[8px] text-slate-300 font-bold tracking-wide mt-0.5">Barang yang sudah dibeli tidak dapat ditukar.</p>
            </div>
        </div>

        <!-- Print & Return Action buttons (no-print) -->
        <div class="no-print flex gap-3.5 w-full shrink-0">
            <button onclick="window.print()" class="flex-1 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 py-3 rounded-xl text-xs font-bold transition duration-150 flex items-center justify-center gap-1.5 cursor-pointer shadow-sm">
                <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                <span>Cetak Struk</span>
            </button>

            <a href="{{ Auth::user()->role === 'Owner' ? route('owner.kasir') : route('kasir.pos') }}" 
                class="flex-1 bg-[#1e5cfb] hover:bg-[#1a52db] text-white py-3 rounded-xl text-xs font-bold transition duration-150 flex items-center justify-center gap-1.5 cursor-pointer shadow-md shadow-blue-500/10 hover:shadow-blue-500/20 active:scale-[0.99]">
                <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <span>Transaksi Baru</span>
            </a>
        </div>

    </div>
</div>
@endsection
