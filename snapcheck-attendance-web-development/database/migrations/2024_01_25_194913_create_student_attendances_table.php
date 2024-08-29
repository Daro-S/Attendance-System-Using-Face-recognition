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
        Schema::create('student_attendances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('attendance_id');
            $table->unsignedBigInteger('student_id');
            $table->timestamp('capture_at')->nullable();
            $table->string('status')->nullable();
            $table->text('capture_image_path')->nullable();
            $table->integer('probability');
            $table->foreign('student_id')
                ->references('id')
                ->on('students');
            $table->foreign('attendance_id')
                ->references('id')
                ->on('attendances');
//                ->noActionOnDelete();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_attendances');
    }
};
