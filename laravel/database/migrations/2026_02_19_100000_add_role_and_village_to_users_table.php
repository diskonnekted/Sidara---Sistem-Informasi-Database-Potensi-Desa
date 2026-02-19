<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddRoleAndVillageToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('owner')->after('password');
            $table->unsignedBigInteger('village_id')->nullable()->after('role');
            $table->string('avatar_path')->nullable()->after('village_id');

            $table->foreign('village_id')
                ->references('id')
                ->on('villages')
                ->onDelete('set null');
        });

        DB::table('users')->where('is_admin', true)->update(['role' => 'admin']);
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['village_id']);
            $table->dropColumn(['role', 'village_id', 'avatar_path']);
        });
    }
}

