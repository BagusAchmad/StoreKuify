@extends('layouts.app')

@section('title', 'Kasir POS - StoreKuify')

@section('content')
<div x-data="{ 
    sidebarOpen: false, 
    cartOpen: false,
    showPaymentModal: false,
    
    // Core cart array
    cart: [],
    
    // Customers database serialized to Alpine
    customers: {{ json_encode($customers) }},
    
    // Payment workflow variables
    paymentMethod: 'cash', // 'cash', 'qris', 'debt', 'cash_debt', 'qris_debt'
    selectedCustomerId: '',
    amountPaid: 0,
    cashReceivedInput: '',
    showQrisConfirmStep: false,
    
    handleConfirmClick() {
        if (['qris', 'qris_debt'].includes(this.paymentMethod)) {
            this.showQrisConfirmStep = true;
        } else {
            this.$refs.checkoutForm.submit();
        }
    },
    
    // Customer search & registration variables
    customerSearchQuery: '',
    showCustomerDropdown: false,
    showNewCustomerForm: false,
    newCustomerName: '',
    newCustomerPhone: '',
    
    get filteredCustomers() {
        if (!this.customerSearchQuery) return this.customers;
        let q = this.customerSearchQuery.toLowerCase();
        return this.customers.filter(c => c.name.toLowerCase().includes(q) || c.phone.includes(q));
    },
    
    submitNewCustomer() {
        if (!this.newCustomerName || !this.newCustomerPhone) {
            alert('Nama dan No. HP wajib diisi.');
            return;
        }
        fetch('{{ route("kasir.customer.create") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                name: this.newCustomerName,
                phone: this.newCustomerPhone
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                this.customers.push(data.customer);
                this.selectedCustomerId = data.customer.id;
                this.customerSearchQuery = data.customer.name;
                this.showNewCustomerForm = false;
                this.newCustomerName = '';
                this.newCustomerPhone = '';
            } else {
                alert(data.message || 'Gagal membuat pelanggan.');
            }
        })
        .catch(err => {
            alert('Gagal menghubungi server.');
        });
    },
    
    addToCart(product) {
        if (product.stock <= 0) return;
        let item = this.cart.find(i => i.id === product.id);
        if (item) {
            if (item.quantity >= product.stock) {
                alert('Stok tidak mencukupi.');
                return;
            }
            item.quantity++;
        } else {
            this.cart.push({
                id: product.id,
                name: product.name,
                selling_price: parseFloat(product.selling_price),
                quantity: 1,
                stock: product.stock,
                image: product.image
            });
        }
    },
    increaseQty(item) {
        if (item.quantity >= item.stock) {
            alert('Stok tidak mencukupi.');
            return;
        }
        item.quantity++;
    },
    decreaseQty(item) {
        item.quantity--;
        if (item.quantity <= 0) {
            this.removeFromCart(item);
        }
    },
    removeFromCart(item) {
        this.cart = this.cart.filter(i => i.id !== item.id);
    },
    clearCart() {
        this.cart = [];
    },
    get subtotal() {
        return this.cart.reduce((sum, item) => sum + (item.selling_price * item.quantity), 0);
    },
    get total() {
        return this.subtotal;
    },
    
    // Payment helpers
    openPayment() {
        if (this.cart.length === 0) return;
        this.paymentMethod = 'cash';
        this.selectedCustomerId = '';
        this.customerSearchQuery = '';
        this.showCustomerDropdown = false;
        this.showNewCustomerForm = false;
        this.newCustomerName = '';
        this.newCustomerPhone = '';
        this.cashReceivedInput = this.total.toString();
        this.amountPaid = this.total;
        this.showQrisConfirmStep = false;
        this.showPaymentModal = true;
    },
    changePaymentMethod(method) {
        this.paymentMethod = method;
        if (method === 'qris') {
            this.amountPaid = this.total;
            this.cashReceivedInput = this.total.toString();
        } else if (method === 'debt') {
            this.amountPaid = 0;
            this.cashReceivedInput = '0';
        } else {
            // cash_debt or qris_debt partial payments: default DP to 0
            this.amountPaid = 0;
            this.cashReceivedInput = '';
        }
    },
    get maxObligation() {
        let prev = this.getSelectedCustomer()?.total_debt || 0;
        return this.total + prev;
    },
    updateAmountPaid() {
        let val = parseFloat(this.cashReceivedInput);
        if (isNaN(val)) {
            this.amountPaid = 0;
            return;
        }
        if (['cash_debt', 'qris_debt'].includes(this.paymentMethod)) {
            let maxObl = this.maxObligation;
            if (val < 0) val = 0;
            if (val > maxObl) val = maxObl;
            this.cashReceivedInput = val.toString();
        }
        this.amountPaid = val;
    },
    setQuickCash(value) {
        if (['cash_debt', 'qris_debt'].includes(this.paymentMethod)) {
            let maxObl = this.maxObligation;
            if (value > maxObl) value = maxObl;
        }
        this.cashReceivedInput = value.toString();
        this.amountPaid = value;
    },
    getSelectedCustomer() {
        if (!this.selectedCustomerId) return null;
        return this.customers.find(c => c.id == this.selectedCustomerId);
    },
    get remainingDebt() {
        return Math.max(0, this.total - this.amountPaid);
    },
    get changeAmount() {
        if (this.paymentMethod !== 'cash') return 0;
        return Math.max(0, this.amountPaid - this.total);
    },
    get quickCashOptions() {
        let val = this.total;
        let options = [];
        let next10k = Math.ceil(val / 10000) * 10000;
        if (next10k > val) options.push(next10k);
        let next50k = Math.ceil(val / 50000) * 50000;
        if (next50k > val && !options.includes(next50k)) options.push(next50k);
        let next100k = Math.ceil(val / 100000) * 100000;
        if (next100k > val && !options.includes(next100k)) options.push(next100k);
        return options.slice(0, 3);
    },
    get isCheckoutDisabled() {
        if (this.cart.length === 0) return true;
        
        // QRIS and Cash full payment validation
        if (this.paymentMethod === 'cash') {
            return this.amountPaid < this.total;
        }
        
        // Debt/Credit validation
        if (['debt', 'cash_debt', 'qris_debt'].includes(this.paymentMethod)) {
            if (!this.selectedCustomerId) return true;
            if (this.amountPaid < 0 || this.amountPaid > this.maxObligation) return true;
        }
        return false;
    }
}" class="h-screen flex overflow-hidden bg-slate-50">
    
    <!-- Mobile Sidebar Backdrop -->
    @if(Auth::user()->role === 'Kasir')
        @include('partials.sidebar_kasir', ['active' => 'kasir'])
    @else
        @include('partials.sidebar_owner', ['active' => 'kasir'])
    @endif

    <!-- Main Content Area split-screen -->
    <div class="flex-1 flex flex-col overflow-hidden lg:flex-row">
        
        <!-- Left Side: Product Grid -->
        <div class="flex-1 flex flex-col overflow-hidden">
            
            <!-- Header -->
            @include('partials.header', ['title' => 'Kasir POS'])

            <!-- Product search and filter area -->
            <div class="p-6 bg-white border-b border-slate-200/80 space-y-4 shrink-0 shadow-sm">
                <!-- Search Form -->
                <form action="{{ Auth::user()->role === 'Owner' ? route('owner.kasir') : route('kasir.pos') }}" method="GET" class="relative max-w-2xl">
                    <input type="hidden" name="category" value="{{ $selectedCategory }}">

                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ $search }}"
                        class="block w-full pl-11 pr-10 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:bg-white focus:border-[#1e5cfb] focus:ring-1 focus:ring-[#1e5cfb] transition duration-150"
                        placeholder="Cari barang atau scan barcode...">
                    @if($search)
                        <a href="{{ Auth::user()->role === 'Owner' ? route('owner.kasir', ['category' => $selectedCategory]) : route('kasir.pos', ['category' => $selectedCategory]) }}" 
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 transition">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </a>
                    @endif
                </form>

                <!-- Category Chips list -->
                <div class="flex items-center gap-2 overflow-x-auto pb-1 scrollbar-none">
                    <a href="{{ Auth::user()->role === 'Owner' ? route('owner.kasir', array_filter(['search' => $search, 'category' => 'all'])) : route('kasir.pos', array_filter(['search' => $search, 'category' => 'all'])) }}"
                        class="px-4 py-2 rounded-xl text-xs font-bold transition whitespace-nowrap {{ $selectedCategory === 'all' ? 'bg-[#1e5cfb] text-white shadow-md shadow-blue-500/10' : 'bg-slate-100 text-slate-600 hover:bg-slate-200/80' }}">
                        Semua
                    </a>
                    
                    @foreach($categories as $category)
                        <a href="{{ Auth::user()->role === 'Owner' ? route('owner.kasir', array_filter(['search' => $search, 'category' => $category->slug])) : route('kasir.pos', array_filter(['search' => $search, 'category' => $category->slug])) }}"
                            class="px-4 py-2 rounded-xl text-xs font-bold transition whitespace-nowrap {{ $selectedCategory === $category->slug ? 'bg-[#1e5cfb] text-white shadow-md shadow-blue-500/10' : 'bg-slate-100 text-slate-600 hover:bg-slate-200/80' }}">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Scrollable product listing container -->
            <div class="flex-1 overflow-y-auto p-6">
                <!-- Errors and warnings -->
                @error('checkout')
                    <div class="mb-5 p-4 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-600 text-sm font-semibold flex items-center gap-3">
                        <svg class="h-5 w-5 text-rose-500" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <span>{{ $message }}</span>
                    </div>
                @enderror

                <!-- Products Grid -->
                <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-4 gap-4">
                    @forelse($products as $product)
                        @php
                            $isOutOfStock = $product->stock <= 0;
                            $isLowStock = !$isOutOfStock && $product->stock <= config('storekuify.low_stock_threshold', 5);
                        @endphp
                        
                        <div @click="addToCart({
                                id: {{ $product->id }},
                                name: '{{ addslashes($product->name) }}',
                                selling_price: {{ $product->selling_price }},
                                stock: {{ $product->stock }},
                                image: '{{ $product->image ? asset($product->image) : '' }}'
                             })" 
                             class="bg-white border border-slate-200/60 rounded-2xl p-4 flex flex-col justify-between shadow-sm transition hover:shadow-md cursor-pointer group select-none relative overflow-hidden active:scale-[0.98] {{ $isOutOfStock ? 'opacity-65 pointer-events-none' : '' }}">
                            
                            @if($isOutOfStock)
                                <div class="absolute inset-0 bg-slate-900/10 backdrop-blur-[0.5px] z-10 flex items-center justify-center">
                                    <span class="bg-rose-600/90 text-white text-[10px] font-extrabold px-3 py-1 rounded-full shadow-md tracking-wider uppercase">
                                        Stok Habis
                                    </span>
                                </div>
                            @endif

                            <div>
                                <div class="aspect-square bg-slate-50 border border-slate-100 rounded-xl overflow-hidden mb-3.5 flex items-center justify-center shrink-0">
                                    @if($product->image)
                                        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="h-full w-full object-cover group-hover:scale-105 transition duration-300">
                                    @else
                                        <svg class="h-8 w-8 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    @endif
                                </div>

                                <h4 class="text-xs font-bold text-slate-800 line-clamp-2 leading-tight tracking-tight">{{ $product->name }}</h4>
                            </div>

                            <div class="mt-3.5">
                                <div class="text-sm font-extrabold text-[#1e5cfb]">
                                    Rp {{ number_format($product->selling_price, 0, ',', '.') }}
                                </div>
                                
                                <div class="mt-1.5 flex items-center justify-between text-[10px] font-bold">
                                    @if($isOutOfStock)
                                        <span class="text-rose-500">Stok: 0</span>
                                    @elseif($isLowStock)
                                        <span class="text-amber-500">Stok: {{ $product->stock }} (Menipis)</span>
                                    @else
                                        <span class="text-slate-400 font-semibold">Stok: {{ $product->stock }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-16 text-center">
                            <div class="h-12 w-12 bg-slate-100 text-slate-400 rounded-full flex items-center justify-center mx-auto mb-3.5">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                            <h4 class="text-sm font-bold text-slate-700">Belum Ada Barang</h4>
                            <p class="text-slate-400 text-xs mt-1.5 max-w-sm mx-auto leading-relaxed">
                                {{ $search ? 'Hasil pencarian barang tidak ditemukan.' : 'Silakan tambahkan barang terlebih dahulu melalui menu Data Barang untuk mulai melakukan transaksi.' }}
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Right Side: POS Shopping Cart Panel -->
        <aside :class="cartOpen ? 'translate-x-0' : 'translate-x-full lg:translate-x-0'" 
            class="fixed inset-y-0 right-0 z-40 lg:z-10 lg:static lg:inset-auto w-full sm:w-96 lg:w-100 bg-white border-l border-slate-200/80 flex flex-col justify-between transition-transform duration-300 ease-in-out shadow-lg lg:shadow-none">
            
            <div class="p-6 border-b border-slate-100 flex items-center justify-between shrink-0">
                <div class="flex items-center gap-2">
                    <svg class="h-5.5 w-5.5 text-slate-800" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    <h3 class="text-sm font-extrabold text-slate-800">Keranjang</h3>
                </div>
                <div class="flex items-center gap-3">
                    <button type="button" @click="clearCart" x-show="cart.length > 0" class="text-xs font-bold text-rose-500 hover:text-rose-700 transition cursor-pointer">
                        Kosongkan
                    </button>
                    <button @click="cartOpen = false" class="lg:hidden p-1.5 rounded-lg text-slate-400 hover:bg-slate-100 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Cart Items list -->
            <div class="flex-1 overflow-y-auto p-6 space-y-4">
                <div x-show="cart.length === 0" class="h-full flex flex-col items-center justify-center text-center text-slate-400 p-6">
                    <div class="h-10 w-10 bg-slate-50 text-slate-300 rounded-full flex items-center justify-center mb-3">
                        <svg class="h-5.5 w-5.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                    <p class="text-xs font-bold text-slate-700">Keranjang Kosong</p>
                    <p class="text-[10px] text-slate-400 mt-1 max-w-[200px]">Silakan pilih barang di daftar sebelah kiri untuk memulai transaksi.</p>
                </div>

                <template x-for="item in cart" :key="item.id">
                    <div class="flex items-center gap-3.5 bg-slate-50/50 border border-slate-100 p-3.5 rounded-2xl relative">
                        <div class="h-12 w-12 rounded-xl bg-white border border-slate-200 overflow-hidden shrink-0 flex items-center justify-center">
                            <template x-if="item.image">
                                <img :src="item.image" :alt="item.name" class="h-full w-full object-cover">
                            </template>
                            <template x-if="!item.image">
                                <svg class="h-5 w-5 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </template>
                        </div>

                        <div class="flex-1 min-w-0">
                            <h4 class="text-xs font-bold text-slate-800 truncate" x-text="item.name">Teh Pucuk</h4>
                            <p class="text-[10px] text-slate-400 font-semibold mt-0.5">
                                Rp <span x-text="item.selling_price.toLocaleString('id-ID')">4.000</span>
                            </p>
                            
                            <div class="flex items-center gap-2 mt-2">
                                <button type="button" @click="decreaseQty(item)" class="h-6 w-6 rounded-lg bg-white border border-slate-200 hover:bg-slate-100 flex items-center justify-center text-xs font-extrabold text-slate-600 transition cursor-pointer select-none">
                                    -
                                </button>
                                <span class="text-xs font-extrabold text-slate-800 w-6 text-center select-none" x-text="item.quantity">1</span>
                                <button type="button" @click="increaseQty(item)" class="h-6 w-6 rounded-lg bg-white border border-slate-200 hover:bg-slate-100 flex items-center justify-center text-xs font-extrabold text-slate-600 transition cursor-pointer select-none">
                                    +
                                </button>
                            </div>
                        </div>

                        <div class="text-right shrink-0">
                            <span class="text-xs font-extrabold text-slate-800 block">
                                Rp <span x-text="(item.selling_price * item.quantity).toLocaleString('id-ID')">4.000</span>
                            </span>
                            <button type="button" @click="removeFromCart(item)" class="text-[10px] font-bold text-rose-500 hover:text-rose-700 mt-2 transition cursor-pointer">
                                Hapus
                            </button>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Cart Footer -->
            <div class="p-6 border-t border-slate-100 shrink-0 bg-slate-50/50 space-y-4">
                <div class="space-y-2.5 text-xs font-bold text-slate-500">
                    <div class="flex justify-between items-center">
                        <span>Subtotal</span>
                        <span class="text-slate-800">
                            Rp <span x-text="subtotal.toLocaleString('id-ID')">0</span>
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span>Diskon</span>
                        <span class="text-rose-500">- Rp 0</span>
                    </div>
                    
                    <div class="flex justify-between items-end border-t border-slate-200/50 pt-3.5 mt-1">
                        <span class="text-slate-800 font-extrabold">Total Tagihan</span>
                        <span class="text-2xl font-black text-[#1e5cfb] tracking-tight">
                            Rp <span x-text="total.toLocaleString('id-ID')">0</span>
                        </span>
                    </div>
                </div>

                <button type="button" @click="openPayment" :disabled="cart.length === 0"
                    class="w-full bg-[#1e5cfb] hover:bg-[#1a52db] disabled:bg-slate-200 disabled:text-slate-400 text-white py-3.5 rounded-xl text-sm font-bold shadow-md shadow-blue-500/10 hover:shadow-blue-500/20 active:scale-[0.99] transition duration-150 flex items-center justify-center gap-2 cursor-pointer disabled:cursor-not-allowed disabled:shadow-none select-none">
                    <span>Bayar</span>
                    <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </button>
            </div>
        </aside>

    </div>

    <!-- PAYMENT WORKFLOW MODAL OVERLAY (Alpine.js Interactive) -->
    <div x-show="showPaymentModal" 
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
        x-cloak>
        
        <div @click.away="showPaymentModal = false"
            :class="showQrisConfirmStep ? 'max-w-md p-8 text-center' : 'max-w-4xl p-6 flex flex-col md:flex-row gap-6'"
            class="bg-white rounded-3xl border border-slate-200/80 shadow-2xl w-full max-h-[90vh] overflow-y-auto transition-all duration-300"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="scale-95 opacity-0"
            x-transition:enter-end="scale-100 opacity-100">
            
            <!-- Step 1: Payment Parameters and Summary (visible when not in QRIS confirm stage) -->
            <div x-show="!showQrisConfirmStep" class="w-full flex flex-col md:flex-row gap-6">
                <!-- Left Side: Payment Parameters -->
                <div class="flex-1 space-y-5">
                    <div>
                        <h3 class="text-base font-extrabold text-slate-800 tracking-tight">Selesaikan Pembayaran</h3>
                        <p class="text-xs text-slate-400 font-semibold mt-0.5">Pilih metode pembayaran dan masukkan nominal bayar.</p>
                    </div>

                    <!-- Payment Method Selection Chips -->
                    <div>
                        <span class="text-xs font-bold text-slate-400 block mb-2 uppercase tracking-wide">Metode Pembayaran</span>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                            <!-- Tunai -->
                            <button type="button" @click="changePaymentMethod('cash')"
                                :class="paymentMethod === 'cash' ? 'border-[#1e5cfb] bg-blue-50/50 text-[#1e5cfb] ring-1 ring-[#1e5cfb]' : 'border-slate-200 text-slate-600 hover:bg-slate-50'"
                                class="border rounded-xl py-3 text-xs font-extrabold flex items-center justify-center gap-1.5 transition select-none cursor-pointer">
                                <span>Tunai</span>
                            </button>

                            <!-- QRIS -->
                            <button type="button" @click="changePaymentMethod('qris')"
                                :class="paymentMethod === 'qris' ? 'border-[#1e5cfb] bg-blue-50/50 text-[#1e5cfb] ring-1 ring-[#1e5cfb]' : 'border-slate-200 text-slate-600 hover:bg-slate-50'"
                                class="border rounded-xl py-3 text-xs font-extrabold flex items-center justify-center gap-1.5 transition select-none cursor-pointer">
                                <span>QRIS</span>
                            </button>

                            <!-- Hutang Penuh -->
                            <button type="button" @click="changePaymentMethod('debt')"
                                :class="paymentMethod === 'debt' ? 'border-[#1e5cfb] bg-blue-50/50 text-[#1e5cfb] ring-1 ring-[#1e5cfb]' : 'border-slate-200 text-slate-600 hover:bg-slate-50'"
                                class="border rounded-xl py-3 text-xs font-extrabold flex items-center justify-center gap-1.5 transition select-none cursor-pointer">
                                <span>Hutang</span>
                            </button>

                            <!-- Tunai + Hutang -->
                            <button type="button" @click="changePaymentMethod('cash_debt')"
                                :class="paymentMethod === 'cash_debt' ? 'border-[#1e5cfb] bg-blue-50/50 text-[#1e5cfb] ring-1 ring-[#1e5cfb]' : 'border-slate-200 text-slate-600 hover:bg-slate-50'"
                                class="border rounded-xl py-3 text-xs font-extrabold flex items-center justify-center gap-1.5 transition select-none cursor-pointer">
                                <span>Tunai + Hutang</span>
                            </button>

                            <!-- QRIS + Hutang -->
                            <button type="button" @click="changePaymentMethod('qris_debt')"
                                :class="paymentMethod === 'qris_debt' ? 'border-[#1e5cfb] bg-blue-50/50 text-[#1e5cfb] ring-1 ring-[#1e5cfb]' : 'border-slate-200 text-slate-600 hover:bg-slate-50'"
                                class="border rounded-xl py-3 text-xs font-extrabold flex items-center justify-center gap-1.5 transition select-none cursor-pointer">
                                <span>QRIS + Hutang</span>
                            </button>
                        </div>
                    </div>

                    <!-- Customer Selection (Visible only when debt is involved) -->
                    <div x-show="['debt', 'cash_debt', 'qris_debt'].includes(paymentMethod)" class="space-y-3.5">
                        <div class="relative" @click.away="showCustomerDropdown = false">
                            <span class="text-xs font-bold text-slate-400 block mb-2 uppercase tracking-wide">Pilih Pelanggan</span>
                            <div class="relative">
                                <input type="text" x-model="customerSearchQuery" @focus="showCustomerDropdown = true" @input="selectedCustomerId = ''; showCustomerDropdown = true;"
                                    class="block w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-700 focus:outline-none focus:bg-white focus:border-[#1e5cfb] focus:ring-1 focus:ring-[#1e5cfb] transition"
                                    placeholder="Cari nama pelanggan atau nomor HP...">
                                <button type="button" @click="showNewCustomerForm = true; showCustomerDropdown = false" class="absolute inset-y-0 right-0 pr-4 flex items-center text-xs font-bold text-[#1e5cfb] hover:text-[#1a52db] transition cursor-pointer select-none">
                                    + Pelanggan Baru
                                </button>
                            </div>

                            <!-- Autocomplete dropdown suggestions -->
                            <div x-show="showCustomerDropdown && filteredCustomers.length > 0"
                                class="absolute left-0 right-0 mt-1.5 bg-white border border-slate-200 rounded-xl shadow-lg max-h-48 overflow-y-auto z-50 border-t-0"
                                x-cloak>
                                <template x-for="c in filteredCustomers" :key="c.id">
                                    <div @click="selectedCustomerId = c.id; customerSearchQuery = c.name; showCustomerDropdown = false"
                                        class="px-4 py-3 hover:bg-slate-50 cursor-pointer border-b border-slate-100 last:border-0 flex justify-between items-center transition select-none">
                                        <div>
                                            <span class="text-xs font-bold text-slate-700 block" x-text="c.name"></span>
                                            <span class="text-[10px] text-slate-400 font-semibold mt-0.5 block" x-text="c.phone"></span>
                                        </div>
                                        <span class="text-[10px] font-extrabold bg-blue-50 px-2 py-0.5 rounded-md" :class="c.total_debt > 0 ? 'text-rose-500' : 'text-emerald-600'" x-text="'Hutang: Rp ' + c.total_debt.toLocaleString('id-ID')"></span>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- New Customer Inline Form -->
                        <div x-show="showNewCustomerForm" class="bg-slate-50 border border-slate-200 p-4.5 rounded-2xl space-y-3 select-none">
                            <div class="flex justify-between items-center pb-2 border-b border-slate-200/60">
                                <span class="text-xs font-extrabold text-slate-800">Tambah Pelanggan Baru</span>
                                <button type="button" @click="showNewCustomerForm = false" class="text-[10px] font-bold text-slate-400 hover:text-slate-600 cursor-pointer">
                                    Batal
                                </button>
                            </div>
                            <div class="space-y-3 text-xs font-bold">
                                <div>
                                    <label class="block font-bold text-slate-400 mb-1">NAMA LENGKAP</label>
                                    <input type="text" x-model="newCustomerName" class="w-full px-3.5 py-2.5 border border-slate-200 rounded-xl bg-white focus:outline-none focus:border-[#1e5cfb]" placeholder="Masukkan nama...">
                                </div>
                                <div>
                                    <label class="block font-bold text-slate-400 mb-1">NO. HANDPHONE</label>
                                    <input type="text" x-model="newCustomerPhone" class="w-full px-3.5 py-2.5 border border-slate-200 rounded-xl bg-white focus:outline-none focus:border-[#1e5cfb]" placeholder="Masukkan nomor HP...">
                                </div>

                                <button type="button" @click="submitNewCustomer" class="w-full bg-[#1e5cfb] text-white py-3 rounded-xl font-bold text-xs hover:bg-[#1a52db] transition mt-2 cursor-pointer shadow-sm select-none">
                                    Simpan & Pilih Pelanggan
                                </button>
                            </div>
                        </div>

                        <!-- Selected Customer dynamic debt cards -->
                        <div x-show="selectedCustomerId" class="bg-blue-50/30 border border-blue-100/60 p-4.5 rounded-2xl space-y-2 select-none">
                            <div class="flex justify-between items-center text-xs font-bold">
                                <span class="text-slate-500">Nama Pelanggan</span>
                                <span class="text-slate-800" x-text="getSelectedCustomer()?.name">Budi Santoso</span>
                            </div>
                            <div class="flex justify-between items-center text-[10px] font-bold">
                                <span class="text-slate-400">No. HP</span>
                                <span class="text-slate-500" x-text="getSelectedCustomer()?.phone">-</span>
                            </div>
                            <div class="grid grid-cols-2 gap-3.5 pt-2 border-t border-slate-200/50 mt-2">
                                <div class="bg-white border border-slate-100 rounded-xl p-2.5 text-center">
                                    <span class="text-[9px] font-bold text-slate-400 block uppercase tracking-wide">Hutang Berjalan</span>
                                    <span class="text-xs font-black text-rose-500 block mt-1">
                                        Rp <span x-text="getSelectedCustomer()?.total_debt.toLocaleString('id-ID')">0</span>
                                    </span>
                                </div>
                                <div class="bg-white border border-slate-100 rounded-xl p-2.5 text-center">
                                    <span class="text-[9px] font-bold text-slate-400 block uppercase tracking-wide">Hutang Setelah Transaksi</span>
                                    <span class="text-xs font-black text-emerald-600 block mt-1">
                                        Rp <span x-text="Math.max(0, (getSelectedCustomer()?.total_debt || 0) + total - amountPaid).toLocaleString('id-ID')">0</span>
                                    </span>
                                </div>
                            </div>
                            <div class="flex justify-end pt-1">
                                <button type="button" @click="selectedCustomerId = ''; customerSearchQuery = '';" class="text-[10px] font-bold text-rose-500 hover:text-rose-700 transition cursor-pointer">
                                    Batal Pilih Pelanggan
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Received amount input box -->
                    <div x-show="paymentMethod !== 'qris' && paymentMethod !== 'debt'">
                        <span class="text-xs font-bold text-slate-400 block mb-2 uppercase tracking-wide">
                            <span x-show="paymentMethod === 'cash_debt'">JUMLAH DIBAYAR TUNAI</span>
                            <span x-show="paymentMethod === 'qris_debt'">JUMLAH DIBAYAR VIA QRIS</span>
                            <span x-show="paymentMethod === 'cash'">NOMINAL UANG DITERIMA</span>
                        </span>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-4.5 flex items-center pointer-events-none text-slate-400 text-sm font-extrabold">Rp</span>
                            <input type="text" x-model="cashReceivedInput" @input="updateAmountPaid"
                                class="block w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-black text-slate-800 placeholder-slate-300 focus:outline-none focus:bg-white focus:border-[#1e5cfb] focus:ring-1 focus:ring-[#1e5cfb] transition"
                                placeholder="0">
                        </div>

                        <!-- Debt allocation dynamic details box -->
                        <template x-if="['cash_debt', 'qris_debt'].includes(paymentMethod) && selectedCustomerId">
                            <div class="mt-3.5 p-3.5 bg-blue-50/20 border border-blue-100/50 rounded-xl text-[10px] font-bold text-slate-500 space-y-2 select-none">
                                <div class="flex justify-between items-center text-slate-400">
                                    <span>Total Belanja</span>
                                    <span class="text-slate-700" x-text="'Rp ' + total.toLocaleString('id-ID')">0</span>
                                </div>
                                <div class="flex justify-between items-center text-slate-400">
                                    <span>Hutang Sebelumnya</span>
                                    <span class="text-slate-700" x-text="'Rp ' + (getSelectedCustomer()?.total_debt || 0).toLocaleString('id-ID')">0</span>
                                </div>
                                <div class="flex justify-between items-center text-slate-450 border-t border-slate-200/50 pt-1.5 mt-1.5">
                                    <span>Maksimal Pembayaran</span>
                                    <span class="text-slate-800" x-text="'Rp ' + maxObligation.toLocaleString('id-ID')">0</span>
                                </div>
                                <div class="border-t border-slate-200/50 pt-2 space-y-1.5">
                                    <div class="flex justify-between items-center">
                                        <span>Pembayaran Transaksi Ini</span>
                                        <span class="text-[#1e5cfb]" x-text="'Rp ' + Math.min(amountPaid, total).toLocaleString('id-ID')">0</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span>Pengurangan Hutang Lama</span>
                                        <span class="text-emerald-600" x-text="'- Rp ' + Math.max(0, amountPaid - total).toLocaleString('id-ID')">0</span>
                                    </div>
                                    <div class="flex justify-between items-center border-t border-slate-100 pt-1.5 mt-1.5">
                                        <span class="text-slate-850 font-black">Sisa Hutang setelah Transaksi</span>
                                        <span class="text-rose-500 font-extrabold" x-text="'Rp ' + Math.max(0, (getSelectedCustomer()?.total_debt || 0) + total - amountPaid).toLocaleString('id-ID')">0</span>
                                    </div>
                                </div>
                            </div>
                        </template>

                        <!-- Quick money selection keys for Cash method -->
                        <div x-show="paymentMethod === 'cash'" class="flex flex-wrap items-center gap-2 mt-3">
                            <button type="button" @click="setQuickCash(total)" class="px-3.5 py-2 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition select-none cursor-pointer">
                                Uang Pas
                            </button>
                            <template x-for="opt in quickCashOptions" :key="opt">
                                <button type="button" @click="setQuickCash(opt)" 
                                    class="px-3.5 py-2 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition select-none cursor-pointer">
                                    Rp <span x-text="opt.toLocaleString('id-ID')">50.000</span>
                                </button>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Right Side: Order summary & totals -->
                <div class="w-full md:w-80 lg:w-90 border-t md:border-t-0 md:border-l border-slate-150 pt-5 md:pt-0 md:pl-6 flex flex-col justify-between shrink-0">
                    <div class="space-y-4 flex-1">
                        <span class="text-xs font-bold text-slate-400 block uppercase tracking-wide">Ringkasan Pesanan</span>
                        
                        <!-- Small items list -->
                        <div class="space-y-2.5 max-h-40 overflow-y-auto pr-1">
                            <template x-for="item in cart" :key="item.id">
                                <div class="flex justify-between items-center text-xs">
                                    <div class="truncate pr-4 flex-1">
                                        <span class="font-bold text-slate-800" x-text="item.name">Teh Pucuk</span>
                                        <span class="text-[10px] text-slate-400 font-semibold block" x-text="item.quantity + ' x Rp ' + item.selling_price.toLocaleString('id-ID')">1 x 4.000</span>
                                    </div>
                                    <span class="font-extrabold text-slate-800 shrink-0">
                                        Rp <span x-text="(item.selling_price * item.quantity).toLocaleString('id-ID')">4.000</span>
                                    </span>
                                </div>
                            </template>
                        </div>

                        <!-- Totals grid -->
                        <div class="border-t border-slate-100 pt-4 space-y-2 text-xs font-bold text-slate-500">
                            <div class="flex justify-between items-center">
                                <span>Subtotal</span>
                                <span class="text-slate-800">
                                    Rp <span x-text="subtotal.toLocaleString('id-ID')">0</span>
                                </span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span>Diskon</span>
                                <span class="text-rose-500">- Rp 0</span>
                            </div>
                            <div class="flex justify-between items-center border-t border-slate-100 pt-3 text-slate-800">
                                <span class="font-extrabold">Total Tagihan</span>
                                <span class="text-base font-black text-[#1e5cfb]">
                                    Rp <span x-text="total.toLocaleString('id-ID')">0</span>
                                </span>
                            </div>

                            <!-- Change/Kembalian box -->
                            <div x-show="paymentMethod === 'cash' && changeAmount > 0" class="flex justify-between items-center bg-emerald-50 text-emerald-700 p-3.5 rounded-xl mt-3 select-none">
                                <span>Kembalian</span>
                                <span class="text-sm font-black">
                                    Rp <span x-text="changeAmount.toLocaleString('id-ID')">0</span>
                                </span>
                            </div>

                            <!-- Remaining Debt box -->
                            <div x-show="['debt', 'cash_debt', 'qris_debt'].includes(paymentMethod)" class="flex justify-between items-center bg-rose-50 text-rose-700 p-3.5 rounded-xl mt-3 select-none">
                                <span>Sisa Hutang</span>
                                <span class="text-sm font-black">
                                    Rp <span x-text="remainingDebt.toLocaleString('id-ID')">0</span>
                                </span>
                            </div>

                            <!-- No limit validation alert -->
                        </div>
                    </div>

                    <!-- Submit Action buttons -->
                    <div class="flex gap-3 mt-6">
                        <button type="button" @click="showPaymentModal = false"
                            class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-600 py-3.5 rounded-xl text-xs font-bold transition select-none cursor-pointer">
                            Batal
                        </button>
                        
                        <form x-ref="checkoutForm" action="{{ route('kasir.checkout') }}" method="POST" class="flex-1 inline">
                            @csrf
                            <input type="hidden" name="cart_data" :value="JSON.stringify(cart)">
                            <input type="hidden" name="payment_method" :value="paymentMethod">
                            <input type="hidden" name="customer_id" :value="selectedCustomerId">
                            <input type="hidden" name="amount_paid" :value="amountPaid">

                            <button type="button" @click="handleConfirmClick" :disabled="isCheckoutDisabled"
                                class="w-full bg-[#1e5cfb] hover:bg-[#1a52db] disabled:bg-slate-200 disabled:text-slate-400 text-white py-3.5 rounded-xl text-xs font-bold transition flex items-center justify-center gap-1.5 cursor-pointer disabled:cursor-not-allowed select-none shadow-md shadow-blue-500/10 hover:shadow-blue-500/20 active:scale-[0.99] disabled:shadow-none">
                                <span>Konfirmasi</span>
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Step 2: QRIS Payment Confirmation Screen -->
            <div x-show="showQrisConfirmStep" class="w-full space-y-6 select-none" x-cloak>
                <div class="space-y-1.5">
                    <h3 class="text-base font-black tracking-widest text-[#1e5cfb] uppercase">StoreKuify</h3>
                    <p class="text-sm font-extrabold text-slate-800">Pembayaran QRIS</p>
                </div>

                <!-- QRIS Amount info box -->
                <div class="bg-blue-50/50 border border-blue-100 p-4.5 rounded-2xl">
                    <template x-if="paymentMethod === 'qris'">
                        <div>
                            <span class="text-xs font-bold text-slate-400 block tracking-wide uppercase">Nominal Pembayaran via QRIS</span>
                            <span class="text-2xl font-black text-[#1e5cfb] block mt-1.5">
                                Rp <span x-text="amountPaid.toLocaleString('id-ID')">0</span>
                            </span>
                        </div>
                    </template>
                    <template x-if="paymentMethod === 'qris_debt'">
                        <div class="space-y-2 text-xs font-bold">
                            <div class="flex justify-between items-center text-slate-500">
                                <span>Total Kewajiban</span>
                                <span class="text-slate-800" x-text="'Rp ' + maxObligation.toLocaleString('id-ID')">0</span>
                            </div>
                            <div class="flex justify-between items-center text-slate-500">
                                <span>Pembayaran Transaksi</span>
                                <span class="text-slate-800" x-text="'Rp ' + Math.min(amountPaid, total).toLocaleString('id-ID')">0</span>
                            </div>
                            <div class="flex justify-between items-center text-slate-500">
                                <span>Pengurangan Hutang</span>
                                <span class="text-emerald-600" x-text="'- Rp ' + Math.max(0, amountPaid - total).toLocaleString('id-ID')">0</span>
                            </div>
                            <div class="flex justify-between items-center text-slate-500 border-t border-blue-100 pt-2">
                                <span>Sisa Hutang</span>
                                <span class="text-rose-500" x-text="'Rp ' + Math.max(0, (getSelectedCustomer()?.total_debt || 0) + total - amountPaid).toLocaleString('id-ID')">0</span>
                            </div>
                            <div class="border-t border-blue-100 pt-2 flex justify-between items-center text-sm font-extrabold text-[#1e5cfb]">
                                <span>Dibayar via QRIS</span>
                                <span class="text-lg font-black" x-text="'Rp ' + amountPaid.toLocaleString('id-ID')">0</span>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- QRIS Image Container -->
                <div class="aspect-square w-64 h-64 bg-slate-50 border border-slate-200/80 rounded-2xl mx-auto flex flex-col items-center justify-center p-4">
                    @php
                        $storeSettings = \App\Models\StoreSetting::current();
                        $qrisPath = $storeSettings->qris_image;
                        $qrisExists = $qrisPath && file_exists(public_path($qrisPath));
                    @endphp
                    @if($qrisExists)
                        <img src="{{ asset($qrisPath) }}" alt="QRIS Toko" class="w-full h-full object-contain">
                    @else
                        <!-- QRIS Belum Diatur Empty State -->
                        <svg class="h-10 w-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v1m0 11v3m0-6h.01M12 12h.01M16 12h.01M8 12h.01M12 16h.01M16 16h.01M8 16h.01" />
                        </svg>
                        <h4 class="text-xs font-bold text-slate-700 mt-3">QRIS Belum Dikonfigurasi</h4>
                        <p class="text-[10px] text-slate-400 font-semibold mt-1 px-4 leading-relaxed">
                            Metode QRIS belum dikonfigurasi oleh Owner. Silakan hubungi Owner untuk mengunggah gambar QRIS.
                        </p>
                    @endif
                </div>

                <p class="text-xs text-slate-500 font-semibold leading-relaxed px-4">
                    @if($qrisExists)
                        Silakan scan QRIS menggunakan aplikasi pembayaran pelanggan.
                    @else
                        <span class="text-rose-500 font-bold">Harap hubungi Owner untuk mengonfigurasi QRIS di menu Pengaturan.</span>
                    @endif
                </p>

                <!-- Cashier Action buttons -->
                <div class="flex gap-4">
                    <button type="button" @click="showQrisConfirmStep = false"
                        class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-600 py-3.5 rounded-xl text-xs font-bold transition select-none cursor-pointer">
                        Kembali
                    </button>
                    
                    @if($qrisExists)
                        <button type="button" @click="$refs.checkoutForm.submit()"
                            class="flex-1 bg-[#1e5cfb] hover:bg-[#1a52db] text-white py-3.5 rounded-xl text-xs font-bold transition select-none cursor-pointer shadow-md shadow-blue-500/10 hover:shadow-blue-500/20 active:scale-[0.99]">
                            Pembayaran Sudah Diterima
                        </button>
                    @else
                        <button type="button" disabled
                            class="flex-1 bg-slate-200 text-slate-400 py-3.5 rounded-xl text-xs font-bold transition select-none cursor-not-allowed">
                            QRIS Belum Siap
                        </button>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
