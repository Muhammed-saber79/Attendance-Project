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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->string('teacher_name')->nullable();
            $table->string('teacher_number')->nullable();
            $table->string('department')->nullable();
            $table->string('building')->nullable();
            $table->string('room')->nullable();
            $table->string('day')->nullable();
            $table->string('lecture_time')->nullable();
            $table->string('lecture_number')->nullable();
            $table->string('subject_name')->nullable();
            $table->enum('status', ['pending', 'attendant', 'absent', 'late'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
