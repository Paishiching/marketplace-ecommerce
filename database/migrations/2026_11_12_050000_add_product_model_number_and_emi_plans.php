<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('products')) {
            Schema::table('products', function (Blueprint $table) {
                if (! Schema::hasColumn('products', 'model_number')) {
                    $table->string('model_number', 150)->nullable()->after('sku')->index();
                }
                if (! Schema::hasColumn('products', 'warranty')) {
                    $table->string('warranty', 190)->nullable()->after('model_number');
                }
            });
        }

        if (! Schema::hasTable('product_emi_plans')) {
            Schema::create('product_emi_plans', function (Blueprint $table) {
                $table->id();
                $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
                $table->string('bank_name', 150);
                $table->unsignedSmallInteger('tenure_months');
                $table->decimal('fee_percentage', 5, 2)->default(0);
                $table->boolean('is_active')->default(true);
                $table->unsignedInteger('sort_order')->default(0);
                $table->timestamps();
                $table->index(['product_id', 'is_active', 'sort_order']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('product_emi_plans');
        if (Schema::hasTable('products') && Schema::hasColumn('products', 'warranty')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn(['model_number', 'warranty']);
            });
        }
    }
};
