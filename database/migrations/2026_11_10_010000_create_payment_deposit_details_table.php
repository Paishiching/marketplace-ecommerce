<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_deposit_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_id')->unique()->constrained('payments')->cascadeOnDelete();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->date('deposit_date');
            $table->string('depositor_bank', 150);
            $table->string('depositor_branch', 150);
            $table->string('deposit_type', 30);
            $table->decimal('amount', 12, 2);
            $table->string('company_account', 190);
            $table->string('bank_name', 150);
            $table->string('company_name', 150);
            $table->string('receipt_id', 190)->nullable();
            $table->string('receipt_path');
            $table->text('remark')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_deposit_details');
    }
};
