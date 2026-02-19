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
        Schema::table('potentials', function (Blueprint $table) {
            if (!Schema::hasColumn('potentials', 'price_range')) {
                $table->string('price_range')->nullable()->after('description');
            }
            if (!Schema::hasColumn('potentials', 'whatsapp_number')) {
                $table->string('whatsapp_number', 50)->nullable()->after('price_range');
            }
            if (!Schema::hasColumn('potentials', 'location_address')) {
                $table->string('location_address')->nullable()->after('whatsapp_number');
            }
            if (!Schema::hasColumn('potentials', 'latitude')) {
                $table->decimal('latitude', 10, 7)->nullable()->after('location_address');
            }
            if (!Schema::hasColumn('potentials', 'longitude')) {
                $table->decimal('longitude', 10, 7)->nullable()->after('latitude');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('potentials', function (Blueprint $table) {
            $columns = ['price_range', 'whatsapp_number', 'location_address', 'latitude', 'longitude'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('potentials', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
