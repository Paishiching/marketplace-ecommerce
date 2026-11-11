<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rfqs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('product_name', 180);
            $table->text('requirements');
            $table->json('attachments')->nullable();
            $table->unsignedInteger('quantity');
            $table->string('unit', 40);
            $table->boolean('share_business_card')->default(false);
            $table->string('status', 20)->default('open')->index();
            $table->timestamps();
        });

        Schema::create('rfq_quotes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rfq_id')->constrained('rfqs')->cascadeOnDelete();
            $table->foreignId('supplier_id')->constrained('suppliers')->cascadeOnDelete();
            $table->decimal('unit_price', 12, 2);
            $table->unsignedInteger('lead_time_days')->nullable();
            $table->text('message')->nullable();
            $table->timestamps();
            $table->unique(['rfq_id', 'supplier_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rfq_quotes');
        Schema::dropIfExists('rfqs');
    }
};
