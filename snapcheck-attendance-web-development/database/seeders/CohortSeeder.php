<?php

namespace Database\Seeders;

use App\Models\Cohort;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CohortSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cohorts = [
            ['name' => 'default'],
            ['name' => 'CS-Gen7-GroupB'],
        ];
        foreach ($cohorts as $cohort) {
            DB::table('cohorts')->insert($cohort);
        }
    }
}
