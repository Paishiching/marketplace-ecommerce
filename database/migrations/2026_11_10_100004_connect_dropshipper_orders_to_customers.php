<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('dropshipper_orders', function (Blueprint $table) {
            $table->foreignId('customer_id')->nullable()->after('dropshipper_id')->constrained('customers')->nullOnDelete();
        });

        Schema::create('dropshipper_order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dropshipper_order_id')->constrained('dropshipper_orders')->cascadeOnDelete();
            $table->foreignId('supplier_product_id')->nullable()->constrained('supplier_products')->nullOnDelete();
            $table->string('product_name');
            $table->unsignedInteger('quantity');
            $table->decimal('unit_cost', 12, 2);
            $table->decimal('unit_price', 12, 2);
            $table->decimal('line_total', 12, 2);
            $table->timestamps();
            $table->index(['dropshipper_order_id', 'supplier_product_id'], 'dropship_order_item_product_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dropshipper_order_items');
        Schema::table('dropshipper_orders', function (Blueprint $table) {
            $table->dropConstrainedForeignId('customer_id');
        });
    }
};
