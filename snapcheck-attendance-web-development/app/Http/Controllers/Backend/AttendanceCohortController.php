<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\AttendanceCohort;
use Illuminate\Http\Request;

class AttendanceCohortController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function show(AttendanceCohort $attendanceCohort)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AttendanceCohort $attendanceCohort)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AttendanceCohort $attendanceCohort)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $attendanceCohortId = $request->input('attendance_cohort_id');
        $attendanceCohort = AttendanceCohort::find($attendanceCohortId);
        $attendanceCohort->delete();
        return redirect()->route('attendance.index')->with('success', 'Attendance Cohort deleted successfully');
    }
}