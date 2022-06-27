<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // Student Login
    protected function studentLogin(Request $request)
    {
        $error['students-login'] = "Something Worng! Please try again.";
        if(!Auth::attempt($request->only('email','password'))) {
            throw ValidationException::withMessages([
                'email' => "Credentials didn't match.",
                'students-login' => 'Faild!',
            ]);
        }
        return redirect()->intended(route('front-end.index'));
    }

    // teacher login
    protected function teacherLogin(Request $request)
    {
        $error['teachers-login'] = "Something Worng! Please try again.";
        if(!Auth::attempt(['email'=>$request->email,'password'=>$request->password,'role'=>1,'status'=>1])) {
            throw ValidationException::withMessages([
                'email' => "Credentials didn't match.",
                'teachers-login' => 'Faild!',
            ]);
        }
        return redirect()->intended(route('front-end.index'));
    }

    // Admin login
    protected function adminLogin(Request $request)
    {
        if(!Auth::attempt(['email'=>$request->email,'password'=>$request->password,'role'=>5])) {
            throw ValidationException::withMessages([
                'email' => "Credentials didn't match.",
            ]);
        }else {
            return redirect()->intended(route('admin.dashboard'));
        }
    }
}
