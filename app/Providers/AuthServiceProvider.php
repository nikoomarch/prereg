<?php

namespace studentPreRegisteration\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use studentPreRegisteration\Course;
use studentPreRegisteration\Field;
use studentPreRegisteration\Policies\CoursePolicy;
use studentPreRegisteration\Policies\FieldPolicy;
use studentPreRegisteration\Policies\SelectionPolicy;
use studentPreRegisteration\Policies\StudentCoursePolicy;
use studentPreRegisteration\Policies\TermPolicy;
use studentPreRegisteration\Selection;
use studentPreRegisteration\StudentCourse;
use studentPreRegisteration\Term;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Term::class => TermPolicy::class,
        Field::class => FieldPolicy::class,
        Course::class => CoursePolicy::class,
        Selection::class => SelectionPolicy::class,
        StudentCourse::class => StudentCoursePolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
