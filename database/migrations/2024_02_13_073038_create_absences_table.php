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
        Schema::create('absences', function (Blueprint $table) {
            $table->id();
            $table->integer('teacher_id')->nullable();
            $table->integer('teacher_number')->nullable();
            $table->string('status');
            $table->boolean('is_replied')->default(0);
            $table->unsignedBigInteger('attendence_id')->nullable();
            $table->foreign('attendence_id')->references('id')->on('attendances')->cascadeOnDelete()->cascadeOnUpdate() ;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absences');
    }
};
