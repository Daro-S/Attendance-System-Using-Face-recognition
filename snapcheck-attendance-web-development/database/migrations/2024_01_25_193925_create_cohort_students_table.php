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
        Schema::create('cohort_students', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cohort_id');
            $table->unsignedBigInteger('student_id');

            $table->foreign('student_id')
                ->references('id')
                ->on('students');
                //->noActionOnDelete();
            $table->foreign('cohort_id')
                ->references('id')
                ->on('cohorts');
                //->noActionOnDelete();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cohort_students');
    }
};
