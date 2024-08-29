<?php

namespace App\Http\Controllers\Api;

use App\Enum\AttendanceStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Services\PusherService;
use App\Models\Attendance;
use App\Models\AttendanceCohort;
use App\Models\Cohort;
use App\Models\Course;
use App\Models\Student;
use App\Models\StudentAttendance;
use Carbon\Carbon;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Pusher\ApiErrorException;
use Pusher\Pusher;
use Pusher\PusherException;
use function Psy\debug;

class AttendanceController extends Controller
{
    protected $pusherService;

    public function __construct(PusherService $pusherService)
    {
        $this->pusherService = $pusherService;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Attendance $attendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attendance $attendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Attendance $attendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */


    /**
     * @throws PusherException
     * @throws ApiErrorException
     * @throws GuzzleException
     */
    public function markStudentAttendance(Request $request): JsonResponse
    {
        // check if the probability is below 90
        $probability = ($request->probability) / 100;
        if ($probability < getenv('MINIMUM_PROBABILITY')) {
            return response()->json(['message' => 'Probability is below '. getenv('MINIMUM_PROBABILITY') .'%, '. $probability. '% given.']);
        }

        $attendance = Attendance::find($request->attendance_id);
//        dd($request->student_id);
        $student = Student::with('cohort')->where('label_id', $request->label_id)->first();
        if (empty($student)) {
            return response()->json(
                [
                    'code' => 404,
                    'label_id' => $request->label_id,
                    'attendance_id' => $request->attendance_id,
                    'message' => 'Student not found',
                    'data' => null,
                ]
            );
        }
        $cohortId = $student->cohort->id;
        //dd($cohortId);
        // compare attendance start_time with the request->capture_time and set status == on_time only if only the student come before time_start after 30 minutes otherwise `late`
        $attendanceStartTime = date('H:i:s', strtotime($attendance->time_start));
        $attendanceStartTimeLateInterval = date('H:i:s', strtotime('+30 minutes', strtotime($attendanceStartTime)));

        $attendanceEndTime = date('H:i:s', strtotime($attendance->time_end));

        $capturedTime = date('H:i:s', strtotime($request->captured_at));
        //dd($capturedTime);
        //dd($capturedTime, $attendanceStartTime);
//        dd($capturedTime <= $attendanceStartTimeLateInterval);
        //dd($capturedTime >= $attendanceStartTime , $capturedTime <= $attendanceStartTimeLateInterval);
        if ($capturedTime >= $attendanceStartTime && $capturedTime <= $attendanceStartTimeLateInterval) {
            $status = 'on_time';
        } else {
            $status = 'late';
        }

        // prevent insert duplicate studentAttendace record
        $studentAttendance = StudentAttendance::where('student_id', $student->id)
            ->where('attendance_id', $request->attendance_id)
            ->where('cohort_id', $cohortId)
            ->first();
        if ($studentAttendance) {
            return response()->json([
                'code' => 201,
                'label_id' => $request->label_id,
                'attendance_id' => $request->attendance_id,
                'message' => 'Student Already Marked Attendance',
                'data' => null,
            ]);
        }

        // insert new record to student_attendance table
        $studentAttendanceRecord = new StudentAttendance();
        $studentAttendanceRecord->student_id = $student->id;
        $studentAttendanceRecord->attendance_id = $request->attendance_id;
        $studentAttendanceRecord->status = $status;
        $studentAttendanceRecord->cohort_id = $cohortId;
        $studentAttendanceRecord->probability = $request->probability;
        $studentAttendanceRecord->capture_at = $request->captured_at;
        $studentAttendanceRecord->save();


        //convert date format '2024-02-29 15:01:51' to 07:37 AM
        $captureTime = date('h:i A', strtotime($request->captured_at));
        // find cohort base on cohort_id for report
        $cohort = Cohort::findOrFail($cohortId);
        $students = StudentAttendance::with('student')
            ->where('cohort_id', $cohortId)
            ->where('attendance_id', $request->attendance_id)->get();
        $cohort->students = $students;
        $onTime = 0;
        $late = 0;
        foreach ($cohort->students as $studentAttendance) {
            if ($studentAttendance->status == 'on_time') {
                $onTime++;
            } elseif ($studentAttendance->status == 'late') {
                $late++;
            }
        }
        $present = $onTime + $late;

        $data = [
            'message' => 'hello world',
            'student' => $student,
            'label_id' => $request->label_id,
            'cohort_id' => $cohortId,
            // this element below is the information of attendance
            'attendance' => [
                'captured_image' => '',
                'captured_time' => $captureTime,
                'attendance_schedule_id' => $request->attendance_id,
                'status' => $status,
            ],
            'reports' => [
                'cohort_id' => $cohortId,
                'present' => $present,
                'on_time' => $onTime,
                'late' => $late,
            ]
        ];

        $this->pusherService->triggerEvent('mark_student_attendance', 'update_attendance', $data);

        return response()->json(
            [
                'code' => 200,
                'label_id' => $request->label_id,
                'attendance_id' => $request->attendance_id,
                'message' => 'Attendance marked successfully',
                'data' => $data
            ]);
    }

    public function deleteLatestStudentAttendance(Request $request): JsonResponse
    {
        //dd($request->student_id);
        $studentAttendance = StudentAttendance::where('student_id', $request->student_id)
            ->where('attendance_id', $request->attendance_id)
            ->where('cohort_id', $request->cohort_id)
            ->first();
        if (empty($studentAttendance)) {
            return response()->json(['message' => 'Record Not found']);
        }
        //dd('hi');
        $studentAttendance->delete();
        return response()->json(['message' => 'Delete Success']);

    }

    public function setExpired(Request $request)
    {
        // find if there is any expired attendance
        $now = now();
        //dd($currentDateTime->toDateString());
        $expiredAttendance = Attendance::where(function ($query) use ($now) {
            $query->whereDate('date', '<', $now->toDateString())
                ->orWhere(function ($query) use ($now) {
                    $query->whereDate('date', '=', $now->toDateString())
                        ->where(DB::raw('CONCAT(date, " ", time_end)'), '<', $now->toDateTimeString());
                });
        })
            ->where('is_expired', 0)
            ->first();
        //dd($expiredAttendance);
        if (empty($expiredAttendance)) {
            return response()->json(['message' => 'No expired attendance found']);
        }
        $expiredAttendance->is_expired = 1;
        $expiredAttendance->save();
        return response()->json(['message' => '1 Expired attendance set successfully']);
    }

    public function setAbsentStudent(): JsonResponse
    {
        // find the attendance with is_expired is true and is_defined_absent is false
        $attendance = Attendance::where('is_expired', 1)
            ->where('is_defined_absent', 0)
            ->first();
        if (empty($attendance)) {
            return response()->json(['message' => 'No attendance found to set absent']);
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
        return response()->json(['message' => 'Absent students set successfully']);
    }

    public function getAttendanceIdByCourseId(Request $request): JsonResponse
    {
        //convert this date format "26/02/2024" to "Y-m-d"
        //dd($request->all());
        $date = Carbon::createFromFormat('d/m/Y', $request->date)->format('Y-m-d');
        $attendances = Attendance::where('course_id', $request->course_id)->where('date', $date)->get();
        return response()->json(['attendances' => $attendances]);
    }

    public function getCohortsByAttendanceId(Request $request): JsonResponse
    {
        // It should get From table Attendance_cohort_table
        $attendance = Attendance::with('cohorts')->findOrFail($request->attendance_id);
        //dd($attendance);
        $cohorts = $attendance->cohorts;
        //dd($cohorts);

        return response()->json(['cohorts' => $cohorts]);
    }

    public function getAttendanceById(Request $request): JsonResponse
    {
        $attendance = Attendance::findOrFail($request->attendance_id);
        //dd($attendance);
        return response()->json(['attendance' => $attendance]);
    }

    public function getAttendance(Request $request)
    {
        $date = Carbon::createFromFormat('d/m/Y', $request->date)->format('Y-m-d');
        $cohort_id = $request->cohort_id;

        $attendanceIds = Attendance::where('date', $date)
            ->pluck('id');

        $cohorts = Cohort::with(['attendanceCohorts.attendance.course'])
            ->whereHas('attendanceCohorts.attendance', function ($query) use ($attendanceIds) {
                $query->whereIn('id', $attendanceIds);
            });

        if (!empty($cohort_id)) {
            $cohorts->where('id', $cohort_id);
        }

        $cohorts = $cohorts->get();
        if(empty($cohorts)){
            return response()->json(['status'=>'empty']);
        }else{
            return response()->json([ 'data' => $cohorts]);
        }


    }
    public function destroy(Attendance $attendance)
    {
        $attendance = Attendance::findOrFail($attendance->id);
        $attendance->delete();

        return response()->json(['message'=> 'Delete successfully']);
    }
}

