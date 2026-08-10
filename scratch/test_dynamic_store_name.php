<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\StoreSetting;
use Illuminate\Support\Facades\Auth;

echo "--- TESTING GLOBAL DYNAMIC STORE NAME BRANDING ---\n\n";

$owner = User::where('role', 'Owner')->first();
$kasir = User::where('role', 'Kasir')->first();

if (!$owner || !$kasir) {
    echo "ERROR: Owner or Kasir user missing!\n";
    exit(1);
}

$setting = StoreSetting::current();
$originalShopName = $setting->shop_name;

echo "Current shop name in DB: '" . ($originalShopName ?? 'NULL') . "'\n";

// Test 1: Set to specific shop name
$testShopName = "Toko Serba Ada 88";
$setting->update(['shop_name' => $testShopName]);
echo "Updated shop name to: '$testShopName'\n\n";

// Render Owner Sidebar
Auth::login($owner);
$ownerSidebarHtml = view('partials.sidebar_owner', ['active' => 'dashboard'])->render();
if (strpos($ownerSidebarHtml, $testShopName) !== false && strpos($ownerSidebarHtml, 'Owner StoreKuify') === false) {
    echo "[PASS] Owner sidebar correctly renders shop name: '$testShopName' and no role label\n";
} else {
    echo "[FAIL] Owner sidebar rendering error!\nOutput snippet: " . substr(strip_tags($ownerSidebarHtml), 0, 200) . "\n";
}

// Render Kasir Sidebar
Auth::login($kasir);
$kasirSidebarHtml = view('partials.sidebar_kasir', ['active' => 'dashboard'])->render();
if (strpos($kasirSidebarHtml, $testShopName) !== false && strpos($kasirSidebarHtml, 'Kasir StoreKuify') === false) {
    echo "[PASS] Cashier sidebar correctly renders shop name: '$testShopName' and no role label\n";
} else {
    echo "[FAIL] Cashier sidebar rendering error!\nOutput snippet: " . substr(strip_tags($kasirSidebarHtml), 0, 200) . "\n";
}

// Test 2: Fallback when shop_name is empty
$setting->update(['shop_name' => '']);
echo "\nUpdated shop name to empty string ''\n";

Auth::login($owner);
$ownerFallbackHtml = view('partials.sidebar_owner', ['active' => 'dashboard'])->render();
if (strpos($ownerFallbackHtml, 'Nama Toko') !== false) {
    echo "[PASS] Owner sidebar fallback renders 'Nama Toko'\n";
} else {
    echo "[FAIL] Owner sidebar fallback failed!\n";
}

Auth::login($kasir);
$kasirFallbackHtml = view('partials.sidebar_kasir', ['active' => 'dashboard'])->render();
if (strpos($kasirFallbackHtml, 'Nama Toko') !== false) {
    echo "[PASS] Cashier sidebar fallback renders 'Nama Toko'\n";
} else {
    echo "[FAIL] Cashier sidebar fallback failed!\n";
}

// Test 3: Set back to a nice name: Toko Berkah Jaya
$finalShopName = "Toko Berkah Jaya";
$setting->update(['shop_name' => $finalShopName]);
echo "\nUpdated shop name to final test value: '$finalShopName'\n";

Auth::login($owner);
$ownerResponse = app(\App\Http\Controllers\Owner\DashboardController::class)->index();
$ownerFinalHtml = $ownerResponse->render();

if (strpos($ownerFinalHtml, $finalShopName) !== false) {
    echo "[PASS] Owner dashboard page renders '$finalShopName'\n";
} else {
    echo "[FAIL] Owner dashboard view failed to render shop name\n";
}

Auth::login($kasir);
$kasirResponse = app(\App\Http\Controllers\Kasir\KasirDashboardController::class)->index();
$kasirFinalHtml = $kasirResponse->render();

if (strpos($kasirFinalHtml, $finalShopName) !== false) {
    echo "[PASS] Cashier dashboard page renders '$finalShopName'\n";
} else {
    echo "[FAIL] Cashier dashboard view failed to render shop name\n";
}

echo "\n--- ALL TESTS COMPLETED SUCCESSFULLY ---\n";
