<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Selection;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating group_manager for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect group_manager after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

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
        if($user->hasRole('student') and !$user->is_allowed){
            Auth::logout();
            return redirect()->back()
                ->withErrors([
                    trans('messages.not_allowed'),
                ]);
        }
    }

    protected function validateLogin(Request $request)
    {
        if (App::environment() === 'production') {
            $request->validate([
                $this->username() => 'required|string',
                'password' => 'required|string',
                'captcha' => 'required|captcha'
            ]);
        } else {
            $request->validate([
                $this->username() => 'required|string',
                'password' => 'required|string',
            ]);
        }
    }

    public function showLoginForm()
    {
        $success = Session::get('success');
        return view('auth.login', compact('success'));
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect()->route('login');
    }

    protected function attemptLogin(Request $request)
    {
        $fields = $request->only($this->username(),'password');
        if(strlen($fields['password']) != 10)
            return $this->guard()->attempt(
                $fields, $request->filled('remember')
            );
        else{
            $fields['password'] = ltrim($fields['password'],'0');
            return $this->guard()->attempt(
                $fields, $request->filled('remember')
            );
        }
    }
}
