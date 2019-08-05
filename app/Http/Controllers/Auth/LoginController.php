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
    protected $redirectTo = '/redirection';

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
        $entranceTerm = $user->entranceTerm;
        if($user->field_id!=null)
            $selection = $user->field->selection;
        if ($user->role == 'student' and ($selection->endDate < now() || $user->isAllowed == false)) {
            Auth::logout($request);


            return redirect()->back()
                ->withErrors([
                     'شما امکان ورود به این سامانه را ندارید.',
                ]);
        }
    }

    protected function validateLogin(Request $request)
    {
        if(\App::environment() === 'production') {
            $request->validate([
                $this->username() => 'required|string',
                'password' => 'required|string',
                'g-recaptcha-response' => 'required|recaptcha'
            ]);
        }
        else{
            $request->validate([
                $this->username() => 'required|string',
                'password' => 'required|string',
            ]);
        }
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
