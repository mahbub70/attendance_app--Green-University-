<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Exception;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }


    // Student Registration
    protected function studentRegister(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'department_id'=>['required','numeric'],
            'roll_id_no' =>['required','numeric'],
            'mobile' => ['required','numeric'],
            'semester_id' => ['required', 'numeric'],
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ]);

        $error = [];
        $error['students-registration'] = 'Students Registration form.';

        // If Single Validation Fails
        if ($validator->stopOnFirstFailure()->fails()) {
            return  back()->with('error',$error)->withErrors($validator)->withInput();
        }
        $validated = $validator->safe()->all();
        $validated['role'] = 0; // For Student Role
        $validated['password'] = Hash::make($validated['password']);

        $create_user = User::create($validated);
        if($create_user != true) {
            $error['students-registration'] = "Opps! Something Worng! Please try again.";
            return back()->with('error','Something Worng! Please try again.');
        }

        if(Auth::attempt($request->only('email','password'))) {
            return redirect()->intended(route('front-end.index'));
        }else {
            $error['students-registration'] = "Credentials didn't match.";
            throw ValidationException::withMessages([
                'email' => "Credentials didn't match.",
                'students-login' => 'Faild!',
            ]);
        }

    }

    // Teacher Registration
    protected function teacherRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'department'=>['required','string','max:100'],
            'mobile' => ['required','numeric'],
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ]);

        $error = [];
        $error['teachers-registration'] = 'Teachers Registration form.';

        // If Single Validation Fails
        if ($validator->stopOnFirstFailure()->fails()) {
            return  back()->with('error',$error)->withErrors($validator)->withInput();
        }
        $validated = $validator->safe()->all();
        $validated['role'] = 1; // For Teacher Role
        $validated['password'] = Hash::make($validated['password']);

        $create_user = User::create($validated);

        if($create_user != true) {
            $error['teachers-registration'] = "Opps! Something Worng! Please try again.";
            return back()->with('error','Something Worng! Please try again.');
        }

        if(Auth::attempt(['email'=>$request->email,'password'=>$request->password,'status'=>1])) {
            return redirect()->intended(route('front-end.index'));
        }else {
            $error['teachers-registration'] = "Credentials didn't match.";
            throw ValidationException::withMessages([
                'email' => "Registration Success! Contact with Admin for Approve!",
                'teachers-login' => 'Faild!',
            ]);
        }
    }
}
