<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\PersonalAccessToken;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{

    public function login_form()
    {
        return view('backend.auth.login');
    }

    public function login(LoginRequest $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
//            'password' => 'required|min:8',
            'password' => 'required',
        ]);
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return redirect()->intended('/')->withErrors([
                'message' => 'Invalid Credential (40012)'
            ]);
        }
        $doctor = auth()->user();
        $token = $this->__generateToken($doctor);
        request()->session()->put('auth_session', $token);
        return redirect()->route('admin');
    }

    public function logout()
    {
        PersonalAccessToken::findToken(request()->session()->get('auth_session'))->delete();
        request()->session()->put('auth_session', null);
        return redirect()->route('login_form');
    }

    private function __generateToken(object $user)
    {
        $token = $user->createToken('SnapCheck Backend')->plainTextToken;

        $personal_token = PersonalAccessToken::findToken($token);
        $personal_token->refresh_token = Password::getRepository()->createNewToken();
        $personal_token->expires_at = now()->addYears();
        $personal_token->refresh_token_expired_at = now()->addYears();
        $personal_token->save();

        return $token;
    }
}
