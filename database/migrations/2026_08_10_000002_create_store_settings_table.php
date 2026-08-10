<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('store_settings')) {
            Schema::create('store_settings', function (Blueprint $table) {
                $table->id();
                $table->string('shop_name')->default('StoreKuify');
                $table->text('shop_address')->nullable();
                $table->string('shop_logo')->nullable();
                $table->string('qris_image')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_settings');
    }
};
