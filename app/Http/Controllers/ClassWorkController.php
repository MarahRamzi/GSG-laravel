<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\ClassWork;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClassWorkController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Classroom $classroom)
    {
        $classWorks = $classroom->classworks()
        ->orderBy('published_at')
        ->get();

        // $assignments = $classroom->classworks()
        // ->where('type' , '=' , ClassWork::TYPE_ASSIGNMENT)
        // ->get();

        return view('Classwork.index' ,
        [
            'classroom' => $classroom,
            'classworks' => $classWorks,
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Classroom $classroom)
    {
        return view('Classwork.create' , compact('classroom'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request , Classroom $classroom)
    {
        $request->validate([
            'title' => ['required' , 'string', 'max:255' ],
            'description' => ['nullable' , 'string'] ,
            'topic_id' => ['nullable' , 'int' , 'exists:topics,id']
        ]);

        $request->merge([
            'user_id' => Auth::id(),
            'classroom_id' => $classroom->id
        ]);

        $classwork = Classwork::create($request->all());
        // $classwork =$classroom->classworks()->create($request->all());

        return redirect(route('classrooms.classworks.index' , $classroom->id))->with('success' , 'classwork created!');

    }

    /**
     * Display the specified resource.
     */
    public function show(Classroom $classroom , ClassWork $classWork)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Classroom $classroom  , ClassWork $classWork)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ClassWork $classWork)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClassWork $classWork)
    {
        //
    }
}