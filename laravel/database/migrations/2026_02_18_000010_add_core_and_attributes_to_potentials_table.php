<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('potentials', function (Blueprint $table) {
            $table->string('whatsapp_number')->nullable()->after('description');
            $table->string('location_address')->nullable()->after('whatsapp_number');
            $table->json('attributes')->nullable()->after('images');
        });
    }

    public function down(): void
    {
        Schema::table('potentials', function (Blueprint $table) {
            $table->dropColumn(['whatsapp_number', 'location_address', 'attributes']);
        });
    }
};

