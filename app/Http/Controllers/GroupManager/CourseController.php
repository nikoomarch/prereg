<?php

namespace App\Http\Controllers\GroupManager;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRequest;
use App\Models\Course;
use App\Repositories\CourseRepository;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Course::class);
        $this->courseRepository = new CourseRepository();
    }

    public function index()
    {
        $courses = $this->courseRepository->paginateBy('field_id', auth()->user()->field_id);
        return view('group_manager.course.index', compact('courses'));
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
        $fields = $request->only(['name','unit']) + ['field_id' => \auth()->user()->field_id];
        $this->courseRepository->create($fields);
        return response(null,201);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Course $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Course $course
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
     * @param \App\Models\Course $course
     * @return \Illuminate\Http\Response
     */
    public function update(CourseRequest $request, Course $course)
    {
        $this->courseRepository->update($course, $request->only(['name','unit']));
        return response(null,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Course $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        $this->courseRepository->delete($course->id);
        return response(null, 204);
    }
}
