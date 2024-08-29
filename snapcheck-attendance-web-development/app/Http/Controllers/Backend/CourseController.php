<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::all();
        $data = [
            'courses' => $courses
        ];
        return view('backend.courses.index', with($data));
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:courses',
        ],[
            'required'=>':attribute is required.',
        ]);

        if ($validator->fails()) {
            //dd($validator);
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $course = new Course();
        $course->name = trim($request->name);
        $course->description = trim($request->description);
        $course->color = trim($request->color);




        if($course->save()){
            return redirect()->route('course.index')->with('success','Create new course successfully');
        }
        return redirect()->route('course.index')->with('error','Create new course unsuccessfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        return view('backend.courses.show',[
            'course' => $course
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        return view('backend.courses.edit',[
            'course' => $course
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string:courses',
        ],[
            'required'=>':attribute is required.',
        ]);

        if ($validator->fails()) {
            //dd($validator);
            return redirect()->back()->withErrors($validator)->withInput();
        }
        //$user = new User();
        $course->name = trim($request->name);
        $course->description = trim($request->description);
        $course->color = trim($request->color);


        if($course->save()){
            return redirect()->route('course.index')->with('success','Edit course successfully');
        }
        return redirect()->route('course.index')->with('error','Edit course unsuccessfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        if($course->delete()){
            return redirect()->route('course.index')->with('success','Course deleted successfully');
        }

    }
}
