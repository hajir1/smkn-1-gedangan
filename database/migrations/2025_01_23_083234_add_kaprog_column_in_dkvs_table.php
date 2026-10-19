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
        Schema::table('dkvs', function (Blueprint $table) {
            $table->string("photo_kaprog")->default("");
            $table->string("nama_kaprog")->default("");
            $table->string("ket_kaprog")->default("");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dkvs', function (Blueprint $table) {
            $table->dropColumn(["photo_kaprog", "nama_kaprog", "ket_kaprog"]);
        });
    }
};
