<?php

namespace App\Policies;

use App\Models\Classroom;
use App\Models\ClassroomWork;
use App\Models\Scopes\UserClassroomScope;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ClassroomWorkPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user , Classroom $classroom): bool
    {
        // dd($classroom);
        return $user->classrooms()->withoutGlobalScope(UserClassroomScope::class)
        ->wherePivot('classroom_id' , '=' , $classroom->id)
        ->exists();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ClassroomWork $classroomWork): bool
    {
        $isTeacher = $user->classrooms()->withoutGlobalScope(UserClassroomScope::class)
        ->wherePivot('classroom_id' , '=' , $classroomWork->classroom_id)
        ->wherePivot('rule' , '=' , 'teacher')
        ->exists();

        $isAssigned  = $user->classroomWorks()
        ->wherePivot('classroom_work_id' , '=' , $classroomWork->id)
        ->exists();

        return ($isTeacher || $isAssigned);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user , Classroom $classroom): Response
    {
        $result = $user->classrooms()
        ->withoutGlobalScope(UserClassroomScope::class)
        ->wherePivot('classroom_id' , '=' , $classroom->id)
        ->wherePivot('rule' , '=' , 'teacher')
        ->exists();

        return $result
        ? Response::allow()
        : Response::deny('You are not teacher in this classwork');

        // return $result;

    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ClassroomWork $classwork): bool
    {
        $assigned =  $classwork->user_id == $user->id ;

       $teacher =  $user->classrooms()
        ->withoutGlobalScope(UserClassroomScope::class)
        ->wherePivot('classroom_id' , '=' , $classwork->classroom_id)
        ->wherePivot('rule' , '=' , 'teacher')
        ->exists();

        return ($assigned && $teacher );
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ClassroomWork $classwork): bool
    {
        return $classwork->user_id == $user->id &&
        $user->classrooms()
        ->withoutGlobalScope(UserClassroomScope::class)
        ->wherePivot('classroom_id' , '=' , $classwork->classroom_id)
        ->wherePivot('rule' , '=' , 'teacher')
        ->exists();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ClassroomWork $classroomWork)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ClassroomWork $classroomWork)
    {
        //
    }
}
