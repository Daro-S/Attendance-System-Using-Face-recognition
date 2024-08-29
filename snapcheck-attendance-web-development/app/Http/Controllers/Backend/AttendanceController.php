<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\AttendanceCohort;
use App\Models\Cohort;
use App\Models\CohortStudent;
use App\Models\Course;
use App\Models\Student;
use App\Models\StudentAttendance;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $selected_date = $request->target_date;
        if ($selected_date) {
            $date = $request->target_date;;
        }
        else {
            $date = Carbon::now()->format('Y-m-d');
        }

        $viewType = $this->__getViewType($request);

        $courses = Course::all();
        $attendances = Attendance::with('course', 'cohortattendances.cohort')
            ->orderBy('date', 'desc')
            ->paginate(20);

        $selectedDateAttendances = Attendance::with('cohorts','course')->where('date', $date)->get();
        $cohortattendances = AttendanceCohort::with('cohort', 'attendance')->get();
//        $attendanceCohorts = Attendance::with('course')->select('course_id')->distinct('course_id')->where('date', $date)->get();
        $cohorts = Cohort::all();
        //dd($selectedDateAttendances);
        $cohortWithItsCourses = [];
        foreach ($selectedDateAttendances as $attendance) {
            foreach ($attendance->cohorts as $cohort) {
                // check if the cohort is already in the array
                $attendanceCohortId = AttendanceCohort::select('id')->where('attendance_id', $cohort->pivot->attendance_id)->where('cohort_id', $cohort->pivot->cohort_id)->first();
//                dd($attendanceCohortId->id);
                $course = [
                        'course' => $attendance->course,
                        // convert time format "13:00" to "1:00 PM"
                        'time_start' => Carbon::parse($attendance->time_start)->format('g:i A'),
                        'time_end' => Carbon::parse($attendance->time_end)->format('g:i A'),
                        'date' => $attendance->date,
                        'day' => Carbon::parse($attendance->date)->format('l'),
                        'attendance_id' => $attendance->id,
                        'attendance_cohort_id' => $attendanceCohortId->id
                    ];
                if (!array_key_exists($cohort->id, $cohortWithItsCourses)) {
                    $cohortWithItsCourses[$cohort->id]['cohort'] = $cohort;
                }
                $cohortWithItsCourses[$cohort->id]['courses'][] = $course;
            }
        }
//        dd($cohortWithItsCourses);
        //convert color format #ffffff to rgb(255,255,255)


        return view('backend.attendances.index', [
            'cohorts' => $cohorts,
            'courses' => $courses,
            'viewType' => $viewType,
            'attendances' => $attendances,
            'cohortattendances' => $cohortattendances,
            'date' => $date,
            'selectedDateAttendances' => $selectedDateAttendances,
            'cohortWithItsCourses' => $cohortWithItsCourses,
        ]);
    }

    private function __getViewType(&$request)
    {
        return $request->get('view') !== null ? $request->get('view') : 'list';
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = Course::all();
        $cohorts = Cohort::all();
        return view('backend.attendances.create',[
            'courses' => $courses,
            'cohorts' => $cohorts

        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        //dd($request->all());
        $validator = Validator::make($request->all(), [
            'course_id' => 'required|exists:courses,id',
            'cohort_id' => 'required|array',
            'cohort_id.*' => 'exists:cohorts,id',
            'time_start' => 'required|date_format:H:i',
            'time_end' => 'required|date_format:H:i|after:start_time',
            // format "17/03/2024"
            'date' => 'required|date_format:d/m/Y',
            'repeat' => 'nullable|integer|min:1',
        ], [
            'required' => ':attribute is required.',
            'exists' => 'The selected :attribute is invalid.',
            'date_format' => 'The :attribute must be in the format H:i.',
            'after' => 'The :attribute must be after the start time.',
            'integer' => 'The :attribute must be an integer.',
            'min' => 'The :attribute must be at least :min.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        //dd($request->time_start, $request->time_end);

        $cohortIds = $request->cohort_id; // Array of selected cohort IDs

        $repeatWeeks = $request->repeat; // Number of weeks to repeat the attendance
        //convert date format "17/03/2024" to "2024-03-17"
        $startDate = Carbon::createFromFormat('d/m/Y', $request->date)->startOfDay();

        for ($i = 0; $i < $repeatWeeks; $i++) {
            $attendance = new Attendance();
            $attendance->course_id = $request->course_id;
            $attendance->time_start = $request->time_start;
            $attendance->time_end = $request->time_end;
            $attendance->date = $startDate->addWeek($i)->format('Y-m-d');
            $attendance->save();

            foreach ($cohortIds as $cohortId) {
                $attendanceCohort = new AttendanceCohort();
                $attendanceCohort->attendance_id = $attendance->id;
                $attendanceCohort->cohort_id = $cohortId;
                $attendanceCohort->save();
            }
        }

        return redirect()->route('attendance.index')->with('success','Create new attendance schedule successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Attendance $attendance)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attendance $attendance): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $attendance = Attendance::with('course','cohorts')->findOrFail($attendance->id);
        $courses = Course::all();
        $cohorts = Cohort::all();
        //$cohortIds = $attendance->cohorts->pluck('id')->toArray();
        // get all cohorts that are in cohortIds
        //$cohorts = Cohort::whereIn('id', $cohortIds)->get();
        $cohortattendances = AttendanceCohort::all();
        return view('backend.attendances.edit',[
            'attendance' => $attendance,
            'courses' => $courses,
            'cohorts' => $cohorts,
            'cohortattendances' => $cohortattendances

        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Attendance $attendance)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required|date_format:d/m/Y',
            'time_start' => 'required',
            'time_end' => 'required',
            'course_id' => 'required|exists:courses,id',
            'cohort_ids' => 'array',
            'cohort_ids.*' => 'exists:cohorts,id',
        ], [
            'date.required' => 'The date field is required.',
            'date.date' => 'The date field must be a valid date.',
            'time_start.required' => 'The start time field is required.',
            'time_end.required' => 'The end time field is required.',
            'cohort_ids.array' => 'The cohorts must be an array.',
            'cohort_ids.*.exists' => 'The selected cohort is invalid.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $startDate = Carbon::createFromFormat('d/m/Y', $request->date)->startOfDay();

        $attendance = Attendance::findOrFail($attendance->id);
        $attendance->course_id = $request->input('course_id');
        $attendance->date = $startDate;
        $attendance->time_start = $request->input('time_start');
        $attendance->time_end = $request->input('time_end');
        $attendance->save();

        if ($request->has('cohort_ids')) {
            $attendance->cohorts()->sync($request->cohort_ids);
        } else {
            $attendance->cohorts()->detach();
        }

        return redirect()->route('attendance.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attendance $attendance)
    {
        $attendance = Attendance::findOrFail($attendance->id);
        $attendance->delete();

        return redirect()->route('attendance.index');
    }

    public function attendanceCameraOrStatistic(Request $request): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        // selected date
        $selected_date = $request->target_date;
        if ($selected_date) {
            $date = $request->target_date;;
        }
        else {
            $date = Carbon::now()->format('Y-m-d');
        }

        $attendances = Attendance::with('course')->select('course_id')->distinct('course_id')->where('date', $date)->get();
//        dd($attendances->count());
        //dd($date);
        return view('backend.attendances.camera_or_statistic',[
            'attendances' => $attendances,
            'date' => $date
        ]);
    }


    public function getAttendance(Request $request)
    {
        $date = Carbon::createFromFormat('d/m/Y', $request->date)->format('Y-m-d');
        $cohort_id = $request->cohort_id;

        $query = Attendance::where('date', $date);

        if (!empty($cohort_id)) {
            $query->whereHas('cohorts', function ($query) use ($cohort_id) {
                $query->where('cohort_id', $cohort_id);
            });
        }

        $attendance = $query->with('course')->get();
        //dd($attendance);
        return response()->json( $attendance);
    }

    public function attendanceReportSpecificCourseSession(Request $request): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $attendance = null;
        if ($request->attendance_id) {
            //check the target date

            $attendance = Attendance::with('cohorts')->findOrFail($request->attendance_id);
            // compare attendance date (format "2024-02-29") combine with time_end (format "13:00") with current timeStamp
            $attendance->isExpired = Carbon::parse($attendance->date . ' ' . $attendance->time_end)->isPast();
            // compare attendance date (format "2024-02-29") combine with time_start (format "13:00") with current timeStamp
            $attendance->isStarted = Carbon::parse($attendance->date . ' ' . $attendance->time_start)->isPast();
            //dd($attendance);
            foreach ($attendance->cohorts as $cohort) {
                // find the student attendance base on the cohort_id and attendance_id
                $students = StudentAttendance::with('student')->where('cohort_id', $cohort->id)->where('attendance_id', $attendance->id)->orderByRaw("FIELD(status, 'on_time', 'late', 'absent')")->get();
                $cohort->students = $students;
            }


            //each cohort we count the number of Present student in total as well as "on time", "late", and "absent"
            // count number of student in each cohort
            foreach ($attendance->cohorts as $cohort) {

                $onTime = 0;
                $late = 0;

                foreach ($cohort->students as $student) {
                    if ($student->status == 'on_time') {
                        $onTime++;
                    }
                    elseif ($student->status == 'late') {
                        $late++;
                    }
                }
                $present = $onTime + $late;
                //pivot as array by count number "male" and "female" and total student

                $cohortReport = Cohort::withCount([
                    'students as num_male' => function ($query) {
                        $query->where('gender', 'male');
                    },
                    'students as num_female' => function ($query) {
                        $query->where('gender', 'female');
                    },
                    'students as total_students',
                ])->find($cohort->id);
                $cohortInfo = [
                    'num_male' => $cohortReport->num_male,
                    'num_female' => $cohortReport->num_female,
                    'total_students' => $cohortReport->total_students,
                    'present' => $present,
                    'on_time' => $onTime,
                    'late' => $late,
                    'absent' => $cohortReport->total_students - $present

                ];
                $cohort->reports = $cohortInfo;
                //dd($cohort);
            }

        }

        $selected_date = $request->target_date;
        if ($selected_date) {
            $date = $request->target_date;;
        }
        else {
            $date = Carbon::now()->format('Y-m-d');
        }
        //dd($date);
        // attendance course for the selected date
        $attendanceCourses = Attendance::with('course')->select('course_id')->distinct()->where('date', $date)->get();
        //dd($date);
        //dd($attendanceCourses->first();
        return view('backend.attendances.course_session_report', [
            'attendance' => $attendance,
//            'cohorts' => $cohorts
            'attendanceCourses' => $attendanceCourses,
            'date' => $date
        ]);
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
    public function setExpired(Request $request)
    {
        // find if there is any expired attendance
        $currentDateTime = now();
        $expiredAttendance = Attendance::whereDate('date', '=', $currentDateTime->toDateString())
            ->whereTime('time_end', '<', $currentDateTime->format('H:i'))
            ->where('is_expired', 0)
            ->firstOrFail();
//        dd($expiredAttendance);
        if (empty($expiredAttendance)) {
            echo 'No expired attendance found';
            return;
        }
        $expiredAttendance->is_expired = 1;
        $expiredAttendance->save();
        echo 'Expired attendance set successfully';
    }

}
