<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('shipments', function (Blueprint $table) {
            if (! Schema::hasColumn('shipments', 'transport_type')) {
                $table->string('transport_type', 30)->default('self')->after('courier_id');
            }
            if (! Schema::hasColumn('shipments', 'driver_name')) {
                $table->string('driver_name', 150)->nullable()->after('transport_type');
            }
            if (! Schema::hasColumn('shipments', 'driver_phone')) {
                $table->string('driver_phone', 30)->nullable()->after('driver_name');
            }
            if (! Schema::hasColumn('shipments', 'vehicle_number')) {
                $table->string('vehicle_number', 50)->nullable()->after('driver_phone');
            }
            if (! Schema::hasColumn('shipments', 'vehicle_owner')) {
                $table->string('vehicle_owner', 150)->nullable()->after('vehicle_number');
            }
            if (! Schema::hasColumn('shipments', 'expected_arrival_at')) {
                $table->date('expected_arrival_at')->nullable()->after('shipped_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('shipments', function (Blueprint $table) {
            foreach (['transport_type', 'driver_name', 'driver_phone', 'vehicle_number', 'vehicle_owner', 'expected_arrival_at'] as $column) {
                if (Schema::hasColumn('shipments', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
