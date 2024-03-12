<?php

namespace App\Http\Controllers;

use App\Repositories\CourseRepository;
use App\Repositories\SelectionRepository;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->selectionRepository = new SelectionRepository();
        $this->courseRepository = new CourseRepository();
        $this->courseRepository = new CourseRepository();
    }

    public function create()
    {
        $selection = $this->selectionRepository->getFieldActiveSelection(auth()->user()->field_id);
        $registeredCourses = \auth()->user()->registeredCourses()->where('selection_id', $selection->id)->get();
        $courses = $this->courseRepository->getBy('field_id', auth()->user()->field_id);
        return view('register.create', compact('courses', 'selection', 'registeredCourses'));
    }

    public function store(Request $request)
    {
        $courseIds = $request->post('courses', []);
        $courses = $this->courseRepository->findMany($courseIds);
        $selection = $this->selectionRepository->getFieldActiveSelection(auth()->user()->field_id);

        if ($courses->sum('unit') > $selection->max)
            return back()->withErrors([trans('messages.max_units', ['units' => $selection->max])])->withInput();

        auth()->user()->registeredCourses()->where('student_courses.selection_id',$selection->id)->detach();
        auth()->user()->registeredCourses()->attach($courseIds, ['selection_id' => $selection->id]);

        return redirect()->route('register.create')->with('alert', ['message' => trans('messages.course_selection_success'), 'icon' => 'success', 'title' => trans('messages.success')]);
    }
}
