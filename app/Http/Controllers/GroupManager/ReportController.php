<?php

namespace App\Http\Controllers\GroupManager;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\CourseRepository;
use App\Repositories\SelectionRepository;
use App\Repositories\StudentCourseRepository;
use App\Repositories\TermRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->selectionRepo = new SelectionRepository();
        $this->termRepository = new TermRepository();
        $this->courseRepository = new CourseRepository();
        $this->userRepository = new UserRepository();
        $this->studentCourseRepository = new StudentCourseRepository();
    }

    public function index(Request $request)
    {
        if($request->has('selection_id'))
            $defaultSelection = $this->selectionRepo->find($request->get('selection_id'));
        else
            $defaultSelection = $this->selectionRepo->getFieldActiveSelection(auth()->user()->field_id);

        !isset($defaultSelection) && abort(404, trans('messages.selection_not_exists'));

        $menCoursesDensity = $womenCoursesDensity = $menCoOccurredCourses = $womenCoOccurredCourses = null;
        $courseIds = $request->get('courses', []);
        if (!count($courseIds)) {
            $menCoursesDensity = $this->studentCourseRepository->getRegisteredCountByCourse($defaultSelection->id, 'M');
            $womenCoursesDensity = $this->studentCourseRepository->getRegisteredCountByCourse($defaultSelection->id, 'F');
        }
        else{
            $menCoOccurredCourses = $this->studentCourseRepository->getCoOccurredCourses($defaultSelection->id, 'M', $courseIds);
            $womenCoOccurredCourses = $this->studentCourseRepository->getCoOccurredCourses($defaultSelection->id, 'F', $courseIds);
        }

        $courses = $this->courseRepository->getBy('field_id', auth()->user()->field_id);
        $selections = $this->selectionRepo->getBy('field_id', auth()->user()->field_id);
        $termsRegisteredCount = $this->userRepository->getRegisteredCountByTerm($defaultSelection->id, $courseIds);

        return view('group_manager.report.index', compact('termsRegisteredCount', 'courses','defaultSelection','selections', 'menCoursesDensity', 'womenCoursesDensity', 'menCoOccurredCourses', 'womenCoOccurredCourses'));
    }

    public function students(Request $request)
    {
        $courses = $this->courseRepository->findMany($request->get('courses',[]));
        $entranceTerm = $this->termRepository->find($request->get('entrance_term'));
        $users = $this->userRepository->paginateRegisteredStudents($request->get('selection_id'), $request->get('gender'), $request->get('courses',[]));
        return view('group_manager.report.students', compact('users', 'courses', 'entranceTerm'));
    }

    public function courses(User $user, Request $request)
    {
        $courses = $this->courseRepository->getStudentRegisteredCourses($user->id, $request->get('selection_id') );
        return response()->json($courses);
    }
}
