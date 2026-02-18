<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('villages', function (Blueprint $table) {
            $table->id();
            $table->string('district_name')->index();
            $table->string('village_name')->index();
            $table->string('slug')->unique();
            $table->string('website_url')->nullable();
            $table->string('api_endpoint')->nullable();
            $table->enum('platform', ['opensid', 'wordpress', 'custom', 'unknown'])->default('unknown');
            $table->boolean('has_active_website')->default(false);
            $table->timestamp('last_scraped_at')->nullable();
            $table->integer('population')->nullable()->default(0);
            $table->json('source_meta')->nullable();
            $table->timestamps();
            $table->unique(['district_name', 'village_name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('villages');
    }
};
