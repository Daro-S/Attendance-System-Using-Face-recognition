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
        Schema::table('student_attendances', function (Blueprint $table) {
            if (!Schema::hasColumn('student_attendances', 'cohort_id')) {
                $table->unsignedBigInteger('cohort_id')->nullable();
                $table->foreign('cohort_id')->references('id')->on('cohorts');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_attendances', function (Blueprint $table) {
            if (Schema::hasColumn('student_attendances', 'cohort_id')) {
                $table->dropForeign(['cohort_id']);
                $table->dropColumn('cohort_id');
            }
        });
    }
};
