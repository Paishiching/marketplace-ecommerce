<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dropshipper_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dropshipper_id')->constrained('dropshippers')->cascadeOnDelete();
            $table->foreignId('supplier_product_id')->constrained('supplier_products')->cascadeOnDelete();
            $table->decimal('markup_price', 12, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->unique(['dropshipper_id', 'supplier_product_id'], 'dropshipper_supplier_product_unique');
            $table->index(['dropshipper_id', 'is_active'], 'dropshipper_product_active_index');
        });

        Schema::create('dropshipper_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dropshipper_id')->constrained('dropshippers')->cascadeOnDelete();
            $table->foreignId('source_order_id')->nullable()->constrained('orders')->nullOnDelete();
            $table->foreignId('supplier_id')->nullable()->constrained('suppliers')->nullOnDelete();
            $table->string('status', 30)->default('pending');
            $table->decimal('sales_total', 12, 2)->default(0);
            $table->decimal('total_cost', 12, 2)->default(0);
            $table->decimal('profit', 12, 2)->default(0);
            $table->timestamps();
            $table->index(['dropshipper_id', 'status'], 'dropshipper_order_status_index');
        });

        Schema::table('wholesale_products', function (Blueprint $table) {
            $table->foreignId('wholesaler_id')->nullable()->after('id')->constrained('wholesalers')->nullOnDelete();
            $table->index(['wholesaler_id', 'is_wholesale_enabled'], 'wholesaler_product_enabled_index');
        });

        Schema::table('bulk_orders', function (Blueprint $table) {
            $table->foreignId('wholesaler_id')->nullable()->after('id')->constrained('wholesalers')->nullOnDelete();
            $table->index(['wholesaler_id', 'status'], 'wholesaler_order_status_index');
        });
    }

    public function down(): void
    {
        Schema::table('bulk_orders', function (Blueprint $table) {
            $table->dropForeign(['wholesaler_id']);
            $table->dropIndex('wholesaler_order_status_index');
            $table->dropColumn('wholesaler_id');
        });

        Schema::table('wholesale_products', function (Blueprint $table) {
            $table->dropForeign(['wholesaler_id']);
            $table->dropIndex('wholesaler_product_enabled_index');
            $table->dropColumn('wholesaler_id');
        });

        Schema::dropIfExists('dropshipper_orders');
        Schema::dropIfExists('dropshipper_products');
    }
};
