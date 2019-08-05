<?php

namespace studentPreRegisteration\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use studentPreRegisteration\Course;
use Illuminate\Http\Request;
use studentPreRegisteration\Http\Requests\CourseRequest;
use studentPreRegisteration\Policies\CoursePolicy;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAll',Course::class);
        $courses = Auth::user()->field->courses()->paginate(20);
        return view('course.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CourseRequest $request)
    {
        $this->authorize('create',Course::class);
        Course::create($request->except('_token'));
        return back()->with('message', ['success', 'ثبت درس با موفقیت انجام شد.']);
    }

    /**
     * Display the specified resource.
     *
     * @param \studentPreRegisteration\Course $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \studentPreRegisteration\Course $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \studentPreRegisteration\Course $course
     * @return \Illuminate\Http\Response
     */
    public function update(CourseRequest $request, Course $course)
    {
        $this->authorize('update',$course);
        $course->update($request->except('_token'));
        return back()->with('message', ['success', 'تغییر درس با موفقیت انجام شد.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \studentPreRegisteration\Course $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        $this->authorize('delete',$course);
        $course->delete();
        return response(null, 204);
    }
}
