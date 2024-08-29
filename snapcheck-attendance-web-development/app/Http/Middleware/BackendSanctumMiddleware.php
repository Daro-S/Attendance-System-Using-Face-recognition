<?php

namespace App\Http\Middleware;

use App\Models\PersonalAccessToken;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\Response;

class BackendSanctumMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = request()->session()->get('auth_session');
        if ($token) {
            $personal_token = PersonalAccessToken::findToken($token);
            if ($personal_token) {
                auth()->loginUsingId($personal_token->tokenable_id);
                return $next($request);
            }
        }
        return Redirect::route('login_form');
    }
}
