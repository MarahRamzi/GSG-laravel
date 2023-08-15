<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Scopes\UserClassroomScope;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpParser\Builder\Class_;

class JoinClassroomController extends Controller
{
    public function create($id)
    {
        $classroom = Classroom::withoutGlobalScope(UserClassroomScope::class)->active('active')->findOrFail($id);


            try
            {
                $exists = $this->exists($id , Auth::id());

            }catch(Exception $e){
                return redirect()->route('classrooms.show' , $id);
           }

           return view('Classroom.join' , compact('classroom'));
    }

    public function store(Request $request , $id)
    {

        $request->validate([
            'rule' => 'in:student,teacher'
        ]);

        $classroom = Classroom::withoutGlobalScope(UserClassroomScope::class)->active('active')->findOrFail($id);
        //بدي اتاكد انو عندي كلاس روم بنفس قيمة idالموجودة في url
        try
        {
            $exists = $this->exists($id , Auth::id());

        }catch(Exception $e){
            return redirect()->route('classrooms.show' , $id);
       }

       $classroom->join( Auth::id() , $request->input('rule' , 'student'));

       return redirect(route('classrooms.show' , $id));
    }

    protected function exists($classroom_id , $user_id)
    {
        $exists = DB::table('classroom_user')
        ->where('classroom_id' , $classroom_id)
        ->where('user_id' , $user_id)
        ->exists();

        if($exists){
            throw new Exception('user already joined the classroom');

    }
}

}
