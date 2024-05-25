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
        Schema::create('student_bill_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 40);
            $table->unsignedBigInteger('stage_id')->nullable(true)->default(null);
            $table->unsignedBigInteger('level_id')->nullable(true)->default(null);
            $table->decimal('amount', 10, 0);
            $table->timestamps();
            $table->foreign('stage_id')->references('id')->on('school_stages');
            $table->foreign('level_id')->references('id')->on('school_levels');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_bill_types');
    }
};
