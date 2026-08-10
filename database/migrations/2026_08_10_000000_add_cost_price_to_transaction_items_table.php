<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('transaction_items', function (Blueprint $table) {
            $table->decimal('cost_price', 15, 2)->nullable()->after('price');
        });

        // Perform one-time backfill using product cost price baseline for historical transaction items
        DB::statement("
            UPDATE transaction_items 
            INNER JOIN products ON transaction_items.product_id = products.id 
            SET transaction_items.cost_price = products.cost_price 
            WHERE transaction_items.cost_price IS NULL
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaction_items', function (Blueprint $table) {
            $table->dropColumn('cost_price');
        });
    }
};
