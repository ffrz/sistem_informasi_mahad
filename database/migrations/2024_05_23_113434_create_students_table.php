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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('nis', 10); // Nomor induk unik
            $table->string('fullname', 200);
            $table->unsignedBigInteger('level_id');
            $table->unsignedBigInteger('stage_id');
            $table->tinyInteger('status'); // 0:tidak aktif, 1:aktif, 2:lulus
            $table->foreign('level_id')->references('id')->on('school_levels');
            $table->foreign('stage_id')->references('id')->on('school_stages');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
