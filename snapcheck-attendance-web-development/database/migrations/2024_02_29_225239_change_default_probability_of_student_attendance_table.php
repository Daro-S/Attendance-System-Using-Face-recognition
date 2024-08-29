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
        // change type of probability column in student_attendances table
        Schema::table('student_attendances', function (Blueprint $table) {
            $table->integer('probability')->nullable()->change();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_attendances', function (Blueprint $table) {
            $table->integer('probability');
        });
    }
};
