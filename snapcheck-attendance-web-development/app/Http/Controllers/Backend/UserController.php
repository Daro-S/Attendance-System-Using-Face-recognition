<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Services\RegisterStudentFaceApiService;
use App\Models\PersonalAccessToken;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
//        dd(PersonalAccessToken::findToken(request()->session()->get('auth_session')));
//        dd(request()->session());
        $users = User::paginate(20);
        return view('backend.users.index',[
            'users' => $users
        ]);
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
        //dd($request);
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|unique:users',
            'email' => 'required|string|unique:users',
            'password' => 'required',
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
        $user = new User();
        $user->username = trim($request->username);
        $user->email = trim($request->email);
        $user->password = $request->password;

        if(!empty($request->profile_image)){
            $user->profile_path = $this->__moveImage($request,'profile_image','uploads/users');
        }

        if($user->save()){
            return redirect()->route('user.index')->with('success','Create new user successfully');
        }
        return redirect()->route('user.index')->with('error','Create new user unsuccessfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('backend.users.show',[
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('backend.users.edit',[
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|unique:users,username,'.$user->id,
            'email' => 'required|string|unique:users,email,'.$user->id,
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
        //$user = new User();
        $user->username = trim($request->username);
        $user->email = trim($request->email);

        if(!empty($request->profile_image)){
            $user->profile_path = $this->__moveImage($request,'profile_image','uploads/users');
        }

        if($user->save()){
            return redirect()->route('user.index')->with('success','Edit new user successfully');
        }
        return redirect()->route('user.index')->with('error','Edit new user unsuccessfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if($user->id == Auth::user()->id) {
            return redirect()->route('user.index')->with('error','You cannot delete yourself');
        }
        $user->username = $user->username . '_'.time();
        $user->email = $user->email . '_'.time();
        $user->save();
        if($user->delete()){
            return redirect()->route('user.index')->with('success','User deleted successfully');
        }
        return redirect()->route('user.index')->with('error','User cannot be deleted.');
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
