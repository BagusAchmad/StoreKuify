<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

// Guest / Authentication routes
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Owner routes
Route::middleware(['auth', 'role:Owner'])->group(function () {
    Route::get('/owner/dashboard', [App\Http\Controllers\Owner\DashboardController::class, 'index'])->name('owner.dashboard');
    
    // Category management inside Data Barang
    Route::get('/owner/barang', [App\Http\Controllers\Owner\CategoryController::class, 'index'])->name('owner.barang');
    Route::get('/owner/barang/tambah', [App\Http\Controllers\Owner\CategoryController::class, 'create'])->name('owner.barang.create');
    Route::post('/owner/barang', [App\Http\Controllers\Owner\CategoryController::class, 'store'])->name('owner.barang.store');
    Route::get('/owner/barang/{category}/edit', [App\Http\Controllers\Owner\CategoryController::class, 'edit'])->name('owner.barang.edit');
    Route::put('/owner/barang/{category}', [App\Http\Controllers\Owner\CategoryController::class, 'update'])->name('owner.barang.update');
    Route::delete('/owner/barang/{category}', [App\Http\Controllers\Owner\CategoryController::class, 'destroy'])->name('owner.barang.destroy');

    // Product management inside Category
    Route::get('/owner/barang/{category}', [App\Http\Controllers\Owner\ProductController::class, 'showCategoryDetails'])->name('owner.barang.show');
    Route::get('/owner/barang/{category}/tambah', [App\Http\Controllers\Owner\ProductController::class, 'create'])->name('owner.products.create');
    Route::post('/owner/barang/{category}', [App\Http\Controllers\Owner\ProductController::class, 'store'])->name('owner.products.store');
    Route::get('/owner/barang/{category}/{product}/edit', [App\Http\Controllers\Owner\ProductController::class, 'edit'])->name('owner.products.edit');
    Route::put('/owner/barang/{category}/{product}', [App\Http\Controllers\Owner\ProductController::class, 'update'])->name('owner.products.update');
    Route::delete('/owner/barang/{category}/{product}', [App\Http\Controllers\Owner\ProductController::class, 'destroy'])->name('owner.products.destroy');

    Route::get('/owner/kasir', [App\Http\Controllers\KasirController::class, 'index'])->name('owner.kasir');
    Route::get('/owner/kasir/success/{transaction}', [App\Http\Controllers\KasirController::class, 'success'])->name('owner.kasir.success');

    Route::get('/owner/hutang', [App\Http\Controllers\Owner\HutangController::class, 'index'])->name('owner.hutang');
    Route::post('/owner/hutang', [App\Http\Controllers\Owner\HutangController::class, 'store'])->name('owner.hutang.store');
    Route::get('/owner/hutang/pembayaran/{debtPayment}', [App\Http\Controllers\Owner\HutangController::class, 'paymentSuccess'])->name('owner.hutang.payment.success');
    Route::get('/owner/hutang/{customer}', [App\Http\Controllers\Owner\HutangController::class, 'show'])->name('owner.hutang.show');
    Route::post('/owner/hutang/{customer}/bayar', [App\Http\Controllers\Owner\HutangController::class, 'payDebt'])->name('owner.hutang.pay');

    Route::get('/owner/laporan', [App\Http\Controllers\Owner\LaporanController::class, 'index'])->name('owner.laporan');
    Route::get('/owner/laporan/export', [App\Http\Controllers\Owner\LaporanController::class, 'export'])->name('owner.laporan.export');

    Route::get('/owner/kelola-kasir', [App\Http\Controllers\Owner\KelolaKasirController::class, 'index'])->name('owner.kelola_kasir');
    Route::get('/owner/kelola-kasir/tambah', [App\Http\Controllers\Owner\KelolaKasirController::class, 'create'])->name('owner.kelola_kasir.create');
    Route::post('/owner/kelola-kasir', [App\Http\Controllers\Owner\KelolaKasirController::class, 'store'])->name('owner.kelola_kasir.store');
    Route::patch('/owner/kelola-kasir/{user}/activate', [App\Http\Controllers\Owner\KelolaKasirController::class, 'activate'])->name('owner.kelola_kasir.activate');
    Route::patch('/owner/kelola-kasir/{user}/deactivate', [App\Http\Controllers\Owner\KelolaKasirController::class, 'deactivate'])->name('owner.kelola_kasir.deactivate');
    Route::post('/owner/kelola-kasir/{user}/reset-password', [App\Http\Controllers\Owner\KelolaKasirController::class, 'resetPassword'])->name('owner.kelola_kasir.reset_password');
    Route::get('/owner/kelola-kasir/user/{user}/edit', [App\Http\Controllers\Owner\KelolaKasirController::class, 'edit'])->name('owner.kelola_kasir.edit');
    Route::put('/owner/kelola-kasir/user/{user}', [App\Http\Controllers\Owner\KelolaKasirController::class, 'update'])->name('owner.kelola_kasir.update');

    Route::get('/owner/pengaturan', [App\Http\Controllers\Owner\PengaturanController::class, 'index'])->name('owner.pengaturan');
    Route::put('/owner/pengaturan/toko', [App\Http\Controllers\Owner\PengaturanController::class, 'updateShop'])->name('owner.pengaturan.toko.update');
    Route::post('/owner/pengaturan/qris', [App\Http\Controllers\Owner\PengaturanController::class, 'updateQris'])->name('owner.pengaturan.qris.update');
    Route::delete('/owner/pengaturan/qris', [App\Http\Controllers\Owner\PengaturanController::class, 'deleteQris'])->name('owner.pengaturan.qris.delete');

    Route::get('/owner/profil', function () {
        return redirect()->route('profile.edit');
    })->name('owner.profil');
});

// Kasir routes
Route::middleware(['auth', 'role:Kasir'])->group(function () {
    Route::get('/kasir/dashboard', [App\Http\Controllers\Kasir\KasirDashboardController::class, 'index'])->name('kasir.dashboard');
    Route::get('/kasir/success/{transaction}', [App\Http\Controllers\KasirController::class, 'success'])->name('kasir.success');
});

// Shared routes for Owner and Kasir
Route::middleware(['auth', 'role:Owner,Kasir'])->group(function () {
    Route::get('/profil', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profil', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');

    Route::get('/kasir/pos', [App\Http\Controllers\KasirController::class, 'index'])->name('kasir.pos');
    Route::get('/kasir/barang', [App\Http\Controllers\Kasir\KasirBarangController::class, 'index'])->name('kasir.barang');
    Route::get('/kasir/barang/{category}', [App\Http\Controllers\Kasir\KasirBarangController::class, 'show'])->name('kasir.barang.show');
    Route::get('/kasir/hutang', [App\Http\Controllers\Kasir\KasirHutangController::class, 'index'])->name('kasir.hutang');
    Route::get('/kasir/hutang/pembayaran/{debtPayment}', [App\Http\Controllers\Kasir\KasirHutangController::class, 'paymentSuccess'])->name('kasir.hutang.payment.success');
    Route::get('/kasir/hutang/{customer}', [App\Http\Controllers\Kasir\KasirHutangController::class, 'show'])->name('kasir.hutang.show');
    Route::post('/kasir/hutang/{customer}/bayar', [App\Http\Controllers\Kasir\KasirHutangController::class, 'payDebt'])->name('kasir.hutang.pay');

    Route::post('/kasir/checkout', [App\Http\Controllers\KasirController::class, 'checkout'])->name('kasir.checkout');
    Route::post('/kasir/customer/create', [App\Http\Controllers\KasirController::class, 'createCustomer'])->name('kasir.customer.create');
});
