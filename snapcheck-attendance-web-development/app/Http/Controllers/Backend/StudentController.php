<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Services\RegisterStudentFaceApiService;
use App\Models\Cohort;
use App\Models\CohortStudent;
use App\Models\Student;
use App\Models\StudentDetail;
use Database\Seeders\CohortSeeder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::with('cohort')
            ->orderBy('id','desc')
            ->paginate(20);
        //dd($students);
        return view('backend.students.index',[
           'students' => $students
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Student $student)
    {
        $cohorts = Cohort::all();
        return view('backend.students.create',[
            'student' => $student,
            'cohorts' => $cohorts
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, RegisterStudentFaceApiService $registerStudentFaceApiService)
    {
        //dd(env('SUBMIT_STUDENT_FACE'));

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:students',
            'profile_image' => 'nullable|mimes:png,jpg,jpeg',
            // Add more validation rules for other fields
        ],[
            'required'=>':attribute is required.',
            'mimes' => ':attribute type is not accepted.'
        ]);

        if ($validator->fails()) {
            //dd($validator);
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $student = new Student();
        $student->name = trim($request->name);
        $student->gender = $request->gender;


        //dd($student->id);
        if(!empty($request->profile_image)){
            $student->profile_path = $this->__moveImage($request,'profile_image','uploads/student_profiles');
        }

        if($student->save()){
            if(isset($request->cohort_id)){
                $cohortStudent = new CohortStudent();
                $cohortStudent->cohort_id = $request->cohort_id;
                $cohortStudent->student_id = $student->id;
                if(!$cohortStudent->save()){
                    $student->delete();
                    return redirect()->route('student.index')->with('error','Create new student failed!');
                }
            }
            /*Save student Cohort*/
            /*Save student face*/
            if(!empty($request->student_faces)){
                if(env('SUBMIT_STUDENT_FACE')){
                    $trainStatus = $registerStudentFaceApiService->submitStudentIdentity($student->name, $request->student_faces);
                }

                foreach ($request->student_faces as $image){
                    $studentDetail = new StudentDetail();
                    $studentDetail->student_id = $student->id;
                    $studentDetail->image_path = $this->__moveImageFace($image, 'uploads/students/'.$student->name);
                    if(!$studentDetail->save()){
                        $student->delete();
                        return redirect()->route('student.index')->with('error','Create new student failed!');
                    }
                }
            }
            return redirect()->route('student.index')->with('success','Create new student successfully');
        }
        return redirect()->route('student.index')->with('error','Create new student unsuccessfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        $student = Student::with('cohort')->find($student->id);
        //dd($student);
        return view('backend.students.show',[
           'student' => $student
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        $cohorts = Cohort::all();
        $student = Student::with('studentDetails','cohort')->find($student->id);
        return view('backend.students.edit',[
            'student' => $student,
            'cohorts' => $cohorts
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:students,name,'.$student->id,
            'profile_image' => 'nullable|mimes:png,jpg,jpeg',
            // Add more validation rules for other fields
        ],[
            'required'=>':attribute is required.',
            'mimes' => ':attribute type is not accepted.'
        ]);

        if ($validator->fails()) {
            //dd($validator);
            return redirect()->back()->withErrors($validator)->withInput();
        }
        //$student = new Student();
        $student->name = trim($request->name);
        $student->gender = $request->gender;
//        $student->cohort_id = $request->cohort_id;

        //dd($student->id);
        if(!empty($request->profile_image)){
            $student->profile_path = $this->__moveImage($request,'profile_image','uploads/student_profiles');
        }

        if($student->save()){
            /*Save student Cohort*/
            if(isset($request->cohort_id)){
                $cohortStudent = CohortStudent::whereStudentId($student->id)->first();
                if(!empty($cohortStudent)){
                    if($cohortStudent->cohort_id != $request->cohort_id){
                        $cohortStudent->delete();
                        $cohortStudentNew = new CohortStudent();
                        $cohortStudentNew->cohort_id = $request->cohort_id;
                        $cohortStudentNew->student_id = $student->id;
                        if(!$cohortStudentNew->save()){
                            //$student->delete();
                            return redirect()->route('student.index')->with('error','Edit student failed!');
                        }
                    }
                    return redirect()->route('student.index')->with('success','Edit student failed!');
                }
                $cohortStudent = new CohortStudent();
                $cohortStudent->cohort_id = $request->cohort_id;
                $cohortStudent->student_id = $student->id;
                if(!$cohortStudent->save()){
                    $student->delete();
                    return redirect()->route('student.index')->with('error','Edit student failed!');
                }
                return redirect()->route('student.index')->with('success','Create new student failed!');
            }
            /*Save student face*/
            return redirect()->route('student.index')->with('success','Update student successfully');
        }
        return redirect()->route('student.index')->with('error','Update student unsuccessfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        $student->name = $student->name . '_'.time();
        $student->save();
        if($student->delete()){
            return redirect()->route('student.index')->with('success','Student deleted successfully');
        }
        return redirect()->route('student.index')->with('error','Student cannot be deleted.');

    }
    public function storeImage(Request $request)
    {

        if ($request->hasFile('student_images')) {
            return 'hello';
//            $originName = $request->file('upload')->getClientOriginalName();
//            $fileName = pathinfo($originName, PATHINFO_FILENAME);
//            $extension = $request->file('upload')->getClientOriginalExtension();
//            $fileName = $fileName . '_' . time() . '.' . $extension;
//
//            $request->file('upload')->move(public_path('uploads/students'), $fileName);
//
//            $url = asset('uploads/students/' . $fileName);
//            return response()->json(['fileName' => $fileName, 'uploaded' => 1, 'url' => $url]);
        }
        return null;
    }
    private function __moveImage(&$request, $keyInput ,$dir,)
    {
        if (!is_dir(public_path() . '/'.$dir))
        {
            @mkdir(public_path() . '/'. $dir);
        }
        $targetPathImage = public_path() . '/' . $dir;
        $targetBasePathImage = $dir;
        $image = $request->file($keyInput);
        //dd(file_get_contents($image->path()));
        //dd($image);
        $extension = $image->getClientOriginalExtension();
        $imageName = uniqid() . '-' . time() . '.' . $extension;
        $image->move($targetPathImage, $imageName);
        return $targetBasePathImage . '/' . $imageName;
    }
    private function __moveImageFace($image, $dir)
    {
        if (!is_dir(public_path() . '/'.$dir))
        {
            @mkdir(public_path() . '/'. $dir);
        }
        $targetPathImage = public_path() . '/' . $dir;
        $targetBasePathImage = $dir;
        $extension = $image->getClientOriginalExtension();
        $imageName = uniqid() . '-' . time() . '.' . $extension;
        $image->move($targetPathImage, $imageName);
        return $targetBasePathImage . '/' . $imageName;
    }
}
