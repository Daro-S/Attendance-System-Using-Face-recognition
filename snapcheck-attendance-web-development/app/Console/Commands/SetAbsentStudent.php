<?php

namespace App\Console\Commands;

use App\Enum\AttendanceStatusEnum;
use App\Models\Attendance;
use App\Models\StudentAttendance;
use Illuminate\Console\Command;
use Illuminate\Http\JsonResponse;

class SetAbsentStudent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:set-absent-student';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        // find the attendance with is_expired is true and is_defined_absent is false
        $attendance = Attendance::where('is_expired', 1)
            ->where('is_defined_absent', 0)
            ->first();
        if (empty($attendance)) {
            $this->info('No attendance found to set absent');
            return;
        }
        // find the cohort of the attendance
        $cohorts = $attendance->cohorts;
        //dd($cohorts);
        // pluck student_id in cohort
        foreach ($cohorts as $cohort) {
            $students = $cohort->students->pluck('id');
            //dd($students);
            // find all student that not in the student_attendance table
            $studentAttendanceIds = StudentAttendance::where('attendance_id', $attendance->id)
                ->where('cohort_id', $cohort->id)
                ->pluck('student_id');
            //dd($studentAttendanceIds);

            $studentAbsentIds = $students->diff($studentAttendanceIds);
            if (!empty($studentAbsentIds)) {
                foreach ($studentAbsentIds as $studentAbsentId) {
                    $studentAttendance = new StudentAttendance();
                    $studentAttendance->student_id = $studentAbsentId;
                    $studentAttendance->attendance_id = $attendance->id;
                    $studentAttendance->cohort_id = $cohort->id;
                    $studentAttendance->status = AttendanceStatusEnum::ABSENT;
                    $studentAttendance->save();
                }
            }
        }
        // set the is_defined_absent to true
        $attendance->is_defined_absent = 1;
        $attendance->save();
        $this->info( 'Absent students set successfully');
    }
}
