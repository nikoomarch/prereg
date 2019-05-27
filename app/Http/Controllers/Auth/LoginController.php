<?php

namespace studentPreRegisteration\Http\Controllers\Auth;

use studentPreRegisteration\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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
    protected $redirectTo = '/course/register';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'username';
    }

    protected function authenticated(Request $request, $user)
    {
        $entrance_year = substr($user->username,0,2);
        $whitelist = [
            '9123088011'
        ];
        if (($entrance_year>96 || $entrance_year<94)&&!in_array($request->username,$whitelist)) {
            Auth::logout($request);


            return redirect()->back()
                ->withErrors([
                     'تنها ورودی های سال 94، 95 و 96 امکان ورود به این سامانه را دارند.',
                ]);
        }
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
            'g-recaptcha-response' => 'required|recaptcha'
        ]);
    }

    public function showLoginForm()
    {
        $success = Session::get('success');
        return view('auth.login',compact('success'));
    }
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect()->route('login');
    }
}
