<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class JoinClassroomController extends Controller
{
    public function create($id)
    {
        $classroom = Classroom::active()->findOrFail($id);

        try{
            $this->exists($id , Auth::id());
        }catch(Exception $e){
            return redirect()->route('classrooms.show' , $id);


        }

        return view('Classroom.join' , compact('classroom'));
    }

    public function store(Request $request , $id)
    {

        $request->validate([
            'role' => 'in:student,teacher'
        ]);

        $classroom = Classroom::withoutGlobalScope(UserClassroomScope::class)->active()->findOrFail($id);

        try{
            $this->exists($id , Auth::id());
        }catch(Exception $e){
            return redirect()->route('classrooms.show' , $id);


        }

        DB::table('classroom_user')->insert([ //join
            'classroom_id' => $classroom->id,
            'user_id' => Auth::id(),
            'role' => $request->input('role' , 'student'),
            'created_at' => now()
        ]);

        return redirect()->route('classrooms.show' , $id);
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