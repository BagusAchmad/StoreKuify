@extends('layouts.app')

@section('title', 'Masuk - StoreKuify')

@section('content')
<div class="min-h-screen lg:h-screen flex items-center justify-center bg-[#f4f7f9] p-4 sm:p-6 lg:p-8">
    <div class="w-full max-w-5xl bg-white rounded-3xl shadow-xl overflow-hidden grid grid-cols-1 lg:grid-cols-12 max-h-full lg:h-[85vh] lg:max-h-[640px] border border-slate-200/50">
        
        <!-- Left Side: Visual / Decorative Panel (Hidden on mobile/tablet) -->
        <div class="lg:col-span-5 bg-gradient-to-br from-blue-600 via-[#1e5cfb] to-emerald-500 text-white p-8 lg:p-10 flex flex-col justify-between relative overflow-hidden hidden lg:flex">
            <!-- Background circles patterns -->
            <div class="absolute -top-16 -left-16 w-48 h-48 rounded-full bg-white/10 blur-xl"></div>
            <div class="absolute -bottom-20 -right-20 w-72 h-72 rounded-full bg-emerald-400/20 blur-2xl"></div>
            
            <!-- Branding Header -->
            <div class="flex items-center gap-2 z-10">
                <div class="h-8 w-8 bg-white/15 rounded-lg flex items-center justify-center border border-white/25">
                    <svg class="h-4.5 w-4.5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <span class="font-extrabold tracking-tight text-lg">StoreKuify</span>
            </div>

            <!-- Custom Vector Grocery / POS Illustration -->
            <div class="my-4 z-10 flex items-center justify-center">
                <svg class="w-full max-w-[220px] opacity-95 filter drop-shadow-2xl" viewBox="0 0 400 400" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <!-- Base Platform Shadow -->
                    <ellipse cx="200" cy="340" rx="140" ry="15" fill="black" opacity="0.15"/>
                    
                    <!-- Dash Grid circles background -->
                    <circle cx="200" cy="200" r="160" stroke="white" stroke-width="1.2" stroke-dasharray="8 8" opacity="0.2"/>
                    <circle cx="200" cy="200" r="115" stroke="white" stroke-width="1.2" stroke-dasharray="4 4" opacity="0.25" />
                    
                    <!-- POS Tablet Monitor -->
                    <rect x="90" y="110" width="220" height="150" rx="18" fill="#0f172a" stroke="#475569" stroke-width="6"/>
                    <!-- Screen -->
                    <rect x="100" y="120" width="200" height="130" rx="10" fill="#1e293b"/>
                    
                    <!-- Mini Charts inside Screen -->
                    <rect x="115" y="135" width="60" height="8" rx="4" fill="#10b981"/>
                    <rect x="115" y="148" width="100" height="6" rx="3" fill="#3b82f6" opacity="0.6"/>
                    
                    <!-- Chart Bars -->
                    <rect x="115" y="170" width="14" height="60" rx="3" fill="#3b82f6"/>
                    <rect x="135" y="185" width="14" height="45" rx="3" fill="#10b981"/>
                    <rect x="155" y="160" width="14" height="70" rx="3" fill="#6366f1"/>
                    
                    <!-- Glowing Sales Line Chart -->
                    <path d="M190 190 Q215 150 240 175 T285 135" stroke="#10b981" stroke-width="4" stroke-linecap="round" fill="none"/>
                    <circle cx="285" cy="135" r="5" fill="#10b981"/>
                    
                    <!-- POS Stand -->
                    <path d="M170 260 L230 260 L240 310 L160 310 Z" fill="#334155"/>
                    <rect x="145" y="305" width="110" height="10" rx="5" fill="#1e293b"/>
                    
                    <!-- Shopping Cart Overlay -->
                    <g transform="translate(195, 205) scale(1.05)">
                        <!-- Wheels -->
                        <circle cx="35" cy="80" r="10" fill="#0f172a"/>
                        <circle cx="75" cy="80" r="10" fill="#0f172a"/>
                        <circle cx="35" cy="80" r="5" fill="#e2e8f0"/>
                        <circle cx="75" cy="80" r="5" fill="#e2e8f0"/>
                        <!-- Support -->
                        <path d="M15 20 L25 65 L85 65 L95 20" stroke="#f8fafc" stroke-width="4" stroke-linecap="round" fill="none"/>
                        <path d="M25 65 L15 15 L5 15" stroke="#f8fafc" stroke-width="4.5" stroke-linecap="round" fill="none"/>
                        <!-- Basket -->
                        <rect x="25" y="23" width="65" height="38" rx="8" fill="#10b981" fill-opacity="0.9" stroke="#f8fafc" stroke-width="3"/>
                        <line x1="42" y1="23" x2="42" y2="61" stroke="#f8fafc" stroke-width="1.8"/>
                        <line x1="58" y1="23" x2="58" y2="61" stroke="#f8fafc" stroke-width="1.8"/>
                        <line x1="74" y1="23" x2="74" y2="61" stroke="#f8fafc" stroke-width="1.8"/>
                        <line x1="25" y1="42" x2="90" y2="42" stroke="#f8fafc" stroke-width="1.8"/>
                    </g>

                    <!-- Apple Float -->
                    <circle cx="80" cy="290" r="16" fill="#ef4444"/>
                    <path d="M82 274 Q84 268 89 270" stroke="#10b981" stroke-width="3" stroke-linecap="round" fill="none"/>
                    
                    <!-- Paper Bag Box Float -->
                    <rect x="305" y="275" width="30" height="42" rx="3" fill="#d97706"/>
                    <path d="M305 275 L317 262 L335 275 Z" fill="#b45309"/>
                    <circle cx="320" cy="282" r="3.5" fill="#78350f"/>
                    
                    <!-- Sparkles & Coins -->
                    <circle cx="75" cy="180" r="12" fill="#fbbf24"/>
                    <path d="M75 174 V186 M70 178 H80 M70 184 H80" stroke="#78350f" stroke-width="2" stroke-linecap="round"/>
                    
                    <path d="M340 100 L342 106 L348 108 L342 110 L340 116 L338 110 L332 108 L338 106 Z" fill="#67e8f9"/>
                    <path d="M60 220 L61 223 L64 224 L61 225 L60 228 L59 225 L56 224 L59 223 Z" fill="#fbbf24"/>
                </svg>
            </div>

            <!-- Footer Copy -->
            <div class="z-10">
                <h3 class="text-xl font-bold tracking-tight">Kelola Toko Lebih Praktis</h3>
                <p class="text-white/80 text-xs mt-1.5 leading-relaxed">
                    Pantau inventaris, catat transaksi kasir secara real-time, dan pantau keuangan warung kelontong Anda dengan platform modern.
                </p>
            </div>
        </div>

        <!-- Right Side: Login Form -->
        <div class="lg:col-span-7 flex flex-col justify-center p-6 sm:p-10 lg:p-12 bg-white">
            <div class="w-full max-w-md mx-auto">
                
                <!-- Storefront Icon (Reference 1) -->
                <div class="h-12 w-12 bg-[#1e5cfb] rounded-2xl flex items-center justify-center text-white mx-auto shadow-md shadow-blue-500/20 mb-2.5">
                    <svg class="h-7 w-7 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <!-- Awning roof -->
                        <path d="M2 20V9l2-2h16l2 2v11a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2z" />
                        <path d="M2 9h20" />
                        <path d="M7 9v4m5-4v4m5-4v4" />
                        <!-- Valances -->
                        <path d="M6 13a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1" />
                        <path d="M11 13a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1" />
                        <path d="M16 13a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1" />
                        <!-- Door -->
                        <path d="M9 22V17h6v5" />
                    </svg>
                </div>

                <!-- Titles (Reference 1) -->
                <div class="text-center mb-6">
                    <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">StoreKuify</h2>
                    <p class="text-slate-500 text-xs font-medium mt-0.5">Manajemen Warung Kelontong</p>
                </div>

                <!-- Validation Alerts -->
                @if ($errors->any())
                    <div class="mb-4 p-3 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-600 text-xs flex items-start gap-2.5">
                        <svg class="h-4.5 w-4.5 text-rose-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12v-.008Z" />
                        </svg>
                        <div>
                            <span class="font-bold">Gagal Masuk:</span>
                            <ul class="list-disc list-inside mt-0.5 space-y-0.5 text-rose-600/90 font-medium">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <form action="{{ url('/login') }}" method="POST" class="space-y-4">
                    @csrf

                    <!-- Email / Username Field -->
                    <div>
                        <label for="email" class="block text-xs font-bold text-slate-700 mb-1.5">
                            Email atau Username
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                </svg>
                            </div>
                            <input id="email" name="email" type="text" autocomplete="username" required value="{{ old('email') }}"
                                class="block w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:bg-white focus:border-[#1e5cfb] focus:ring-1 focus:ring-[#1e5cfb] transition duration-200 @error('email') border-rose-400 focus:border-rose-500 focus:ring-rose-500 @enderror"
                                placeholder="Masukkan email atau username">
                        </div>
                    </div>

                    <!-- Password Field (Alpine.js Interactive Visibility Toggle) -->
                    <div x-data="{ showPassword: false }">
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="password" class="block text-xs font-bold text-slate-700">
                                Kata Sandi
                            </label>
                        </div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                                </svg>
                            </div>
                            
                            <!-- Input toggled between text and password types -->
                            <input :type="showPassword ? 'text' : 'password'" id="password" name="password" autocomplete="current-password" required
                                class="block w-full pl-10 pr-10 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:bg-white focus:border-[#1e5cfb] focus:ring-1 focus:ring-[#1e5cfb] transition duration-200 @error('password') border-rose-400 focus:border-rose-500 focus:ring-rose-500 @enderror"
                                placeholder="Masukkan kata sandi">
                            
                            <!-- Eye icon toggle button -->
                            <button type="button" @click="showPassword = !showPassword"
                                class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none cursor-pointer">
                                <!-- Eye Open SVG (Show Password) -->
                                <svg x-show="showPassword" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.8" />
                                </svg>
                                <!-- Eye Slashed SVG (Hide Password) -->
                                <svg x-show="!showPassword" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 0 1-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Remember Me checkbox -->
                    <div class="flex items-center justify-between pt-0.5">
                        <div class="flex items-center">
                            <input id="remember" name="remember" type="checkbox"
                                class="h-4 w-4 rounded border-slate-300 text-[#1e5cfb] focus:ring-[#1e5cfb] cursor-pointer">
                            <label for="remember" class="ml-2 block text-xs font-bold text-slate-500 cursor-pointer select-none">
                                Ingat saya
                            </label>
                        </div>
                    </div>

                    <!-- Submit Button (Reference 1) -->
                    <div class="pt-2">
                        <button type="submit"
                            class="w-full bg-[#1e5cfb] hover:bg-[#1a52db] active:bg-[#1546be] text-white py-2.5 px-4 rounded-xl font-bold tracking-wide transition duration-150 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#1e5cfb] shadow-md shadow-blue-500/10 active:scale-[0.98] text-center text-sm cursor-pointer">
                            Masuk
                        </button>
                    </div>
                </form>

            </div>
        </div>

    </div>
</div>
@endsection
