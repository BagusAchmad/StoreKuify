<header class="h-16 bg-white border-b border-slate-200/80 flex items-center justify-between px-6 shrink-0">
    <!-- Left Navigation / Breadcrumbs -->
    <div class="flex items-center gap-4">
        <button @click="sidebarOpen = true" class="lg:hidden p-1 rounded-lg text-slate-500 hover:bg-slate-100 focus:outline-none">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
        @if(isset($breadcrumbs) && is_array($breadcrumbs))
            <div class="text-sm font-bold text-slate-400 flex items-center gap-1.5 flex-wrap">
                @foreach($breadcrumbs as $index => $item)
                    @if(is_array($item) && isset($item['url']))
                        <a href="{{ $item['url'] }}" class="hover:text-[#1e5cfb] transition duration-100">{{ $item['label'] }}</a>
                    @else
                        <span class="{{ $loop->last ? 'text-slate-800' : '' }}">{{ is_array($item) ? $item['label'] : $item }}</span>
                    @endif

                    @if(!$loop->last)
                        <span class="text-slate-300 font-normal">/</span>
                    @endif
                @endforeach
            </div>
        @else
            <h2 class="text-base font-extrabold text-slate-800 tracking-tight">{{ $title ?? 'StoreKuify' }}</h2>
        @endif
    </div>

    <!-- Right Notification & Profile Area -->
    <div class="flex items-center gap-3">
        
        <!-- Interactive Notification Bell Dropdown -->
        <div class="relative" x-data="{ notifOpen: false }">
            <button type="button" @click="notifOpen = !notifOpen" title="Notifikasi Stok" class="relative p-2 rounded-xl text-slate-400 hover:text-[#1e5cfb] hover:bg-slate-100 transition focus:outline-none cursor-pointer">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                </svg>

                @if(isset($globalLowStockProducts) && $globalLowStockProducts->count() > 0)
                    <span class="absolute top-1.5 right-1.5 h-4 min-w-[16px] px-1 bg-rose-500 text-white text-[9px] font-black rounded-full flex items-center justify-center border-2 border-white shadow-sm">
                        {{ $globalLowStockProducts->count() }}
                    </span>
                @endif
            </button>

            <!-- Dropdown Popover Container -->
            <div x-show="notifOpen" @click.outside="notifOpen = false" x-cloak
                class="absolute right-0 mt-2 w-80 sm:w-96 bg-white rounded-2xl border border-slate-200/80 shadow-2xl z-50 divide-y divide-slate-100 overflow-hidden"
                x-transition:enter="ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100">
                
                <!-- Popover Header -->
                <div class="px-4 py-3 bg-slate-50/80 flex items-center justify-between border-b border-slate-100">
                    <h4 class="text-xs font-extrabold text-slate-800 uppercase tracking-wide">Notifikasi Stok</h4>
                    @if(isset($globalLowStockProducts) && $globalLowStockProducts->count() > 0)
                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-rose-100 text-rose-600">
                            {{ $globalLowStockProducts->count() }} Perlu Perhatian
                        </span>
                    @else
                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-600">
                            Aman
                        </span>
                    @endif
                </div>

                <!-- Notification List -->
                <div class="max-h-80 overflow-y-auto divide-y divide-slate-100">
                    @if(isset($globalLowStockProducts) && $globalLowStockProducts->count() > 0)
                        @foreach($globalLowStockProducts as $prod)
                            @php
                                $editUrl = Auth::user()->isOwner() 
                                    ? ($prod->category ? route('owner.products.edit', ['category' => $prod->category->slug, 'product' => $prod->sku]) : route('owner.barang'))
                                    : route('kasir.dashboard');
                            @endphp
                            <a href="{{ $editUrl }}" @click="notifOpen = false" class="p-3.5 flex items-start gap-3 hover:bg-slate-50 transition group block">
                                <div class="h-8 w-8 rounded-lg shrink-0 flex items-center justify-center font-black text-xs {{ $prod->stock == 0 ? 'bg-rose-100 text-rose-600 border border-rose-200' : 'bg-amber-100 text-amber-600 border border-amber-200' }}">
                                    {{ $prod->stock }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between gap-2">
                                        <span class="text-xs font-bold text-slate-800 truncate group-hover:text-[#1e5cfb] transition">{{ $prod->name }}</span>
                                        @if($prod->stock == 0)
                                            <span class="text-[9px] font-black px-1.5 py-0.5 rounded bg-rose-50 text-rose-600 border border-rose-200 shrink-0">Stok Habis</span>
                                        @else
                                            <span class="text-[9px] font-black px-1.5 py-0.5 rounded bg-amber-50 text-amber-600 border border-amber-200 shrink-0">Stok Menipis</span>
                                        @endif
                                    </div>
                                    <p class="text-[10px] font-semibold text-slate-400 mt-0.5">
                                        Kategori: {{ $prod->category->name ?? 'Umum' }} &bull; Sisa {{ $prod->stock }} unit
                                    </p>
                                </div>
                            </a>
                        @endforeach
                    @else
                        <div class="p-6 text-center text-slate-400 space-y-2">
                            <div class="h-10 w-10 bg-emerald-50 text-emerald-500 rounded-full flex items-center justify-center mx-auto">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                            <h5 class="text-xs font-extrabold text-slate-700">Semua Stok Aman</h5>
                            <p class="text-[10px] text-slate-400 font-semibold">Tidak ada produk yang perlu diperhatikan.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- User Information & Avatar Area -->
        <div class="flex items-center gap-3 pl-2 border-l border-slate-200">
            <div class="text-right hidden sm:block">
                <p class="text-xs font-bold text-slate-800 leading-tight">{{ Auth::user()->name }}</p>
                <p class="text-[10px] font-semibold text-slate-400">{{ Auth::user()->username }}</p>
            </div>
            @if(Auth::user()->profile_photo && file_exists(public_path(Auth::user()->profile_photo)))
                <img src="{{ asset(Auth::user()->profile_photo) }}" alt="{{ Auth::user()->name }}" class="h-9 w-9 rounded-full object-cover border border-slate-200 shadow-sm">
            @else
                <div class="h-9 w-9 bg-[#1e5cfb] text-white font-extrabold rounded-full flex items-center justify-center text-sm shadow-md shadow-blue-500/10">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
            @endif
        </div>

    </div>
</header>
