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
        Schema::create('student_bills', function (Blueprint $table) {
            $table->id();
            $table->string('description', 100);
            $table->date('date')->nullable(true)->default(null);
            $table->date('due_date')->nullable(true)->default(null);
            $table->date('date_paid')->nullable(true)->default(null);
            $table->unsignedBigInteger('student_id')->nullable(true);
            $table->decimal('amount', 10, 0)->default(0);
            $table->unsignedTinyInteger('paid')->default(0); // 0 blm lunas, 1 lunas
            $table->decimal('total_paid', 10, 0)->default(0);
            $table->unsignedBigInteger('type_id')->nullable(true);
            $table->timestamps();
            $table->foreign('student_id')->references('id')->on('students')->onDelete('set null');
            $table->foreign('type_id')->references('id')->on('student_bill_types')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_bills');
    }
};
