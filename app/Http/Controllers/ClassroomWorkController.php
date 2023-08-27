<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\ClassroomWork;
use Database\Seeders\UserSeeder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClassroomWorkController extends Controller
{
    protected function getType(Request $request)
    {
        // $type = request()->query('type');
        $type = $request->query('type');

        $allowed_types = [ ClassroomWork::TYPE_ASSIGNMENT , ClassroomWork::TYPE_MATERIAL , ClassroomWork::TYPE_QUESTION ];

        if(!in_array($type , $allowed_types)){
            abort(404);
            // $type = ClassroomWork::TYPE_ASSIGNMENT;
        }

        return $type;

    }

    public function index(Classroom $classroom)
    {
        $classWork = $classroom->classworks()
        ->with('topic')
        ->orderBy('published_at')
        ->get();

        //  $classWork = $classroom->classworks; //return the final result (collection of classworks)

        // $assignments = $classroom->classworks()
        // ->where('type' , '=' , ClassWork::TYPE_ASSIGNMENT)
        // ->get();

        return view('Classwork.index' ,
        [
            'classroom' => $classroom,
            'classWork' => $classWork->groupBy('type'), //groupBy according collection(not DB)
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request , Classroom $classroom)
    {
        $type = $this->getType($request);
        return view('Classwork.create' , compact('classroom' , 'type'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request , Classroom $classroom)
    {

        $type = $this->getType($request);

        $request->validate([
            'title' => ['required' , 'string', 'max:255' ],
            'descreption' => ['nullable' , 'string'] ,
            'topic_id' => ['nullable' , 'int' , 'exists:topics,id']
        ]);

        $request->merge([
            'user_id' => Auth::id(),
            'classroom_id' => $classroom->id,
            'type' => $type,
            'published_at' => now(),
        ]);

        DB::transaction(function () use($request ){
            $classwork = ClassroomWork::create($request->all());
            // $classwork =$classroom->classworks()->create($request->all());

            $classwork->users()->attach($request->input('students')); //students is the name of input in claawork create form
        });

        //PRG
        return redirect(route('classrooms.classworks.index' , $classroom->id))->with('success' , " $classroom->name classwork created!");

    }

    /**
     * Display the specified resource.
     */
    public function show(Classroom $classroom , ClassroomWork $classwork)
    {
        //  $classwork->load('comments.user'); // Eager Load
        return view('Classwork.show', compact('classroom' , 'classwork'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request ,Classroom $classroom ,ClassroomWork $classwork)
    {
        // $type = $this->getType($request);
        $assigned = $classwork->users()->pluck('id')->toArray();



        return view('Classwork.edit' , compact('classroom' , 'classwork' , 'assigned' ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,Classroom $classroom , ClassroomWork $classwork)
    {
        $request->validate([
            'title' => ['required' , 'string', 'max:255' ],
            'descreption' => ['nullable' , 'string'] ,
            'topic_id' => ['nullable' , 'int' , 'exists:topics,id']
        ]);

        $classwork->update($request->all());
        $classwork->users()->sync($request->input('students'));
        return back()->with('success', "$classwork->title updated successfuly " );

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Classroom $classroom , ClassroomWork $classwork)
    {
        $classwork->delete();
        return redirect()->route('classrooms.classworks.index' , $classroom->id)->with('success', " classwork deleted successfuly " );

    }
}