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
        Schema::table('transactions', function (Blueprint $table) {
            $table->index('created_at', 'transactions_created_at_index');
            $table->index(['user_id', 'created_at'], 'transactions_user_id_created_at_index');
            $table->index(['customer_id', 'created_at'], 'transactions_customer_id_created_at_index');
            $table->index(['status', 'created_at'], 'transactions_status_created_at_index');
        });

        Schema::table('transaction_items', function (Blueprint $table) {
            $table->index('created_at', 'transaction_items_created_at_index');
            $table->index(['product_id', 'created_at'], 'transaction_items_product_id_created_at_index');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->index(['is_active', 'stock'], 'products_is_active_stock_index');
            $table->index(['category_id', 'is_active'], 'products_category_id_is_active_index');
        });

        Schema::table('debt_payments', function (Blueprint $table) {
            $table->index(['customer_id', 'created_at'], 'debt_payments_customer_id_created_at_index');
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->index('name', 'customers_name_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropIndex('customers_name_index');
        });

        Schema::table('debt_payments', function (Blueprint $table) {
            $table->dropIndex('debt_payments_customer_id_created_at_index');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex('products_category_id_is_active_index');
            $table->dropIndex('products_is_active_stock_index');
        });

        Schema::table('transaction_items', function (Blueprint $table) {
            $table->dropIndex('transaction_items_product_id_created_at_index');
            $table->dropIndex('transaction_items_created_at_index');
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->dropIndex('transactions_status_created_at_index');
            $table->dropIndex('transactions_customer_id_created_at_index');
            $table->dropIndex('transactions_user_id_created_at_index');
            $table->dropIndex('transactions_created_at_index');
        });
    }
};
