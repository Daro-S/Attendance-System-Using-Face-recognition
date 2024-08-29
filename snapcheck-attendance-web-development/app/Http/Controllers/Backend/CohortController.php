<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Cohort;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class CohortController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cohorts = Cohort::all();
        $data = [
            'cohorts' => $cohorts
        ];
        return view('backend.cohorts.index', with($data));
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
            'name' => 'required|string|unique:cohorts',
            'profile_image' => 'nullable|mimes:png,jpg,jpeg',

        ],[
            'required'=>':attribute is required.',
            'mimes' => ':attribute type is not accepted.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $cohort = new Cohort();
        $cohort->name = trim($request->name);

        if(!empty($request->profile_image)){
            $cohort->profile_path = $this->__moveImage($request,'profile_image','uploads/cohorts');
        }

        if($cohort->save()){
            return redirect()->route('cohort.index')->with('success','Create new cohort successfully');
        }
        return redirect()->route('cohort.index')->with('error','Create new cohort unsuccessfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cohort $cohort)
    {
        $cohort = Cohort::with('students')->find($cohort->id);
        //dd($cohort->students);
        return view('backend.cohorts.show',[
            'cohort' => $cohort
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cohort $cohort)
    {
        return view('backend.cohorts.edit',[
            'cohort' => $cohort
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cohort $cohort)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:cohorts,name,'.$cohort->id,
            'profile_image' => 'nullable|mimes:png,jpg,jpeg',
        ],[
            'required'=>':attribute is required.',
            'mimes' => ':attribute type is not accepted.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        if(!empty($request->profile_image)){
            $cohort->profile_path = $this->__moveImage($request,'profile_image','uploads/cohorts');
        }
        //$user = new User();
        $cohort->name = trim($request->name);


        if($cohort->save()){
            return redirect()->route('cohort.index')->with('success','Edit cohort successfully');
        }
        return redirect()->route('cohort.index')->with('error','Edit cohort unsuccessfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cohort $cohort)
    {
        if($cohort->delete()){
            return redirect()->route('cohort.index')->with('success','Cohort deleted successfully');
        }
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
        $extension = $image->getClientOriginalExtension();
        $imageName = uniqid() . '-' . time() . '.' . $extension;
        $image->move($targetPathImage, $imageName);
        return $targetBasePathImage . '/' . $imageName;
    }
}
