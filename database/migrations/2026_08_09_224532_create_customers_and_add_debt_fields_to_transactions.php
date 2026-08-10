<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->decimal('debt_limit', 15, 2)->default(500000.00);
            $table->timestamps();
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->foreignId('customer_id')->nullable()->after('user_id')->constrained('customers')->nullOnDelete();
            $table->decimal('amount_paid', 15, 2)->default(0)->after('total');
            $table->decimal('remaining_amount', 15, 2)->default(0)->after('amount_paid');
            $table->string('status')->default('paid')->after('remaining_amount'); // 'paid', 'partial', 'unpaid'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['customer_id']);
            $table->dropColumn(['customer_id', 'amount_paid', 'remaining_amount', 'status']);
        });

        Schema::dropIfExists('customers');
    }
};
