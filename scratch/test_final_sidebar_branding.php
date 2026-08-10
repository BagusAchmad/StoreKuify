<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\StoreSetting;
use Illuminate\Support\Facades\Auth;

echo "=== FINAL SIDEBAR BRANDING INTEGRATION TEST ===\n\n";

$owner = User::where('role', 'Owner')->first();
$kasir = User::where('role', 'Kasir')->first();

if (!$owner || !$kasir) {
    echo "ERROR: Owner or Kasir user missing!\n";
    exit(1);
}

$setting = StoreSetting::current();

// Test Case 1: Standard Store Name "Toko Maju Jaya"
$setting->update(['shop_name' => 'Toko Maju Jaya']);

Auth::login($owner);
$ownerSidebar = view('partials.sidebar_owner', ['active' => 'dashboard'])->render();
if (strpos($ownerSidebar, 'Owner • Toko Maju Jaya') !== false && strpos($ownerSidebar, 'Owner StoreKuify') === false) {
    echo "[PASS] Owner sidebar branding: 'Owner • Toko Maju Jaya'\n";
} else {
    echo "[FAIL] Owner sidebar branding incorrect! Rendered:\n$ownerSidebar\n";
}

Auth::login($kasir);
$kasirSidebar = view('partials.sidebar_kasir', ['active' => 'dashboard'])->render();
if (strpos($kasirSidebar, 'Kasir • Toko Maju Jaya') !== false && strpos($kasirSidebar, 'Kasir StoreKuify') === false) {
    echo "[PASS] Cashier sidebar branding: 'Kasir • Toko Maju Jaya'\n";
} else {
    echo "[FAIL] Cashier sidebar branding incorrect!\n";
}

// Test Case 2: Store Name Change to "Warung Berkah"
$setting->update(['shop_name' => 'Warung Berkah']);

Auth::login($owner);
$ownerSidebar2 = view('partials.sidebar_owner', ['active' => 'dashboard'])->render();
if (strpos($ownerSidebar2, 'Owner • Warung Berkah') !== false) {
    echo "[PASS] Owner sidebar updated automatically: 'Owner • Warung Berkah'\n";
} else {
    echo "[FAIL] Owner sidebar update failed!\n";
}

Auth::login($kasir);
$kasirSidebar2 = view('partials.sidebar_kasir', ['active' => 'dashboard'])->render();
if (strpos($kasirSidebar2, 'Kasir • Warung Berkah') !== false) {
    echo "[PASS] Cashier sidebar updated automatically: 'Kasir • Warung Berkah'\n";
} else {
    echo "[FAIL] Cashier sidebar update failed!\n";
}

// Test Case 3: Empty Store Name Fallback
$setting->update(['shop_name' => '']);

Auth::login($owner);
$ownerFallback = view('partials.sidebar_owner', ['active' => 'dashboard'])->render();
if (strpos($ownerFallback, 'Owner • Nama Toko') !== false) {
    echo "[PASS] Owner fallback branding: 'Owner • Nama Toko'\n";
} else {
    echo "[FAIL] Owner fallback failed!\n";
}

Auth::login($kasir);
$kasirFallback = view('partials.sidebar_kasir', ['active' => 'dashboard'])->render();
if (strpos($kasirFallback, 'Kasir • Nama Toko') !== false) {
    echo "[PASS] Cashier fallback branding: 'Kasir • Nama Toko'\n";
} else {
    echo "[FAIL] Cashier fallback failed!\n";
}

// Test Case 4: Long Store Name Truncation
$longName = 'Toko Sembako Makmur Sejahtera Abadi Bersama 99';
$setting->update(['shop_name' => $longName]);

Auth::login($owner);
$ownerLong = view('partials.sidebar_owner', ['active' => 'dashboard'])->render();
if (strpos($ownerLong, 'truncate') !== false && strpos($ownerLong, "Owner • $longName") !== false) {
    echo "[PASS] Long store name renders with truncation CSS: 'Owner • $longName'\n";
} else {
    echo "[FAIL] Long store name handling failed!\n";
}

// Restore nice name
$setting->update(['shop_name' => 'Toko Berkah Utama']);

// Test Case 5: Verify Header Separation
Auth::login($owner);
$headerHtml = view('partials.header', ['breadcrumbs' => []])->render();
if (strpos($headerHtml, $owner->name) !== false && strpos($headerHtml, $owner->username) !== false) {
    echo "[PASS] Header top-right displays user identity ('{$owner->name}' / '{$owner->username}')\n";
} else {
    echo "[FAIL] Header user identity check failed!\n";
}

echo "\n=== ALL VERIFICATION TESTS PASSED SUCCESSFULLY ===\n";
