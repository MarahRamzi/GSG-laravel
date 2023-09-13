<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Classroom;
use App\Models\ClassroomWork;
use App\Models\Scopes\UserClassroomScope;
use App\Models\User;
use App\Policies\ClassroomWorkPolicy;
use Illuminate\Auth\Access\Response;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use PhpParser\Node\Expr\FuncCall;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        ClassroomWork::class => ClassroomWorkPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {

        Gate::before(function(User $user , $ability){
            // if($user->super_admin){
            //     return True;
            // }
        });
        //Define Gates(abilites)
        // Gate::define('classworks.crate', function(User $user , Classroom $classroom ){
        //     $result =  $user->classrooms()
        //     ->withoutGlobalScope(UserClassroomScope::class)
        //     ->wherePivot('classroom_id' , '=' , $classroom->id)
        //     ->wherePivot('rule' , '=' , 'teacher')
        //     ->exists();

        //     return $result
        //     ? Response::allow()
        //     :Response::deny('You are not a teacher in this classwork');
        // });


        // Gate::define('classworks.view' , function (User $user , Classroom $classroom , ClassroomWork $classwork )
        // {
        //    $isTeacher = $user->classrooms()->withoutGlobalScope(UserClassroomScope::class)
        //    ->wherePivot('classroom_id' , '=' , $classroom->id)
        //    ->wherePivot('rule' , '=' , 'teacher')
        //    ->exists();

        //    $isAssigned  = $user->classroomWorks()
        //    ->wherePivot('classroom_work_id' , '=' , $classwork->id)
        //    ->exists();

        //    return ($isTeacher || $isAssigned);


        // });

        Gate::define('submissions.create' , function(User $user ,ClassroomWork $classwork ){
            $isStudent = $user->classrooms()
            ->withoutGlobalScope(UserClassroomScope::class)
            ->wherePivot('classroom_id' , '=' , $classwork->classroom_id)
            ->wherePivot('rule' , '=' , 'student')
            ->exists();

            $isAssigned  = $user->classroomWorks()
            ->wherePivot('classroom_work_id' , '=' , $classwork->id)
            ->exists();

            return ($isStudent && $isAssigned);
        });
    }
}