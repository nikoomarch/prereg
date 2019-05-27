<?php

namespace studentPreRegisteration\Http\Controllers;

use studentPreRegisteration\Course;
use studentPreRegisteration\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }

    /**
     * Show the application dashboard.
     *
     * @param null $message
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
//        $users = User::all();
//        foreach ($users as $user){
//            $user->password = Hash::make($user->password);
//            $user->save();
//        }
        return view('welcome', compact('state'));
    }

    public function create()
    {
        if (Auth::user()->courses()->count() != 0) {
            return redirect()->route('edit');
        }
        $courses = Course::all();
        return view('create', compact('courses', 'message'));
    }

    public function store(Request $request)
    {
        $course_ids = $request->post('course');
        $courses = Course::findMany($course_ids);
        $units = $courses->sum('unit');
        if ($units <= 18) {
            $user = Auth::user();
            return view('confirm', compact('user', 'courses'));
        }
        return Redirect::back()->withErrors(['لطفا حداکثر 18 واحد انتخاب کنید!']);
    }

    public function edit()
    {
        if (Auth::user()->courses()->count() == 0) {
            return redirect()->route('course.register');
        }
        $user = Auth::user();
        $user_courses = $user->courses->pluck('id');
        $courses = Course::all();
        return view('edit', compact('user_courses', 'courses'));
    }

    public function update(Request $request)
    {
        $course_ids = $request->post('course');
        $courses = Course::findMany($course_ids);
        $units = $courses->sum('unit');
        if ($units <= 18) {
            $user = Auth::user();
            return view('confirm', compact('user', 'courses'));
        }
        return Redirect::back()->withErrors(['لطفا حداکثر 18 واحد انتخاب کنید!']);
    }

    public function confirm(Request $request)
    {
        $course_ids = $request->post('course');
        $user = Auth::user();
        $user->courses()->sync($course_ids);
        Auth::logout();
        return Redirect::to('/login')->with('success', true);
    }

    public function hello()
    {

    }
}
