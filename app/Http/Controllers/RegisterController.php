<?php

namespace studentPreRegisteration\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use studentPreRegisteration\Course;
use studentPreRegisteration\Field;
use studentPreRegisteration\StudentCourse;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', StudentCourse::class);
        if (Auth::user()->courses->count() != 0) {
            return redirect()->route('register.edit');
        }
        $courses = Auth::user()->field->courses;
        return view('register.create', compact('courses'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit()
    {
        $this->authorize('create', StudentCourse::class);
        if (Auth::user()->courses->count() == 0) {
            return redirect()->route('register.create');
        }
        $user = Auth::user();
        $user_courses = $user->courses()->select('courses.id')->get();
        $courses = Auth::user()->field->courses;
        return view('register.edit', compact('user_courses', 'courses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request)
    {
        $this->authorize('create', StudentCourse::class);
        $course_ids = $request->post('course');
        $courses = Course::findMany($course_ids);
        $units = $courses->sum('unit');
        $max = Auth::user()->field->selection->max;
        if ($units <= $max)
            return view('register.confirm', compact('courses'));
        return Redirect::back()->withErrors(['لطفا حداکثر ' . $max . ' واحد انتخاب کنید.']);
    }

    public function confirm(Request $request)
    {
        $this->authorize('create', StudentCourse::class);
        $course_ids = $request->post('course');
        $user = Auth::user();
        $user->courses()->sync($course_ids);
        Auth::logout();
        return Redirect::to('/login')->with('success', true);
    }
}
