<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('debt_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->decimal('amount', 15, 2);
            $table->string('payment_method'); // 'cash' or 'qris'
            $table->decimal('debt_before', 15, 2);
            $table->decimal('debt_after', 15, 2);
            $table->string('reference')->nullable()->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('debt_payments');
    }
};
