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
            $table->unsignedBigInteger('cohort_id');
            $table->unsignedBigInteger('course_id');
            $table->string('time_start');
            $table->string('time_end')->nullable();
            $table->date('date');

            $table->foreign('course_id')
                ->references('id')
                ->on('courses');
            $table->foreign('cohort_id')
                ->references('id')
                ->on('cohorts');
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
        Schema::dropIfExists('attendances');
    }
};
