<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('shipments', function (Blueprint $table) {
            if (! Schema::hasColumn('shipments', 'delivery_estimate')) {
                $table->string('delivery_estimate', 120)->nullable();
            }
            if (! Schema::hasColumn('shipments', 'customer_remark')) {
                $table->text('customer_remark')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('shipments', function (Blueprint $table) {
            foreach (['delivery_estimate', 'customer_remark'] as $column) {
                if (Schema::hasColumn('shipments', $column)) $table->dropColumn($column);
            }
        });
    }
};
