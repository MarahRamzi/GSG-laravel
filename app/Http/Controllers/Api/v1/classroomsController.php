<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClassroomResource;
use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\Rule;

class classroomsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         // token authorization
         if (!Auth::guard('sanctum')->user()->tokenCan('classrooms.read')) {
            abort(403, 'can not read classroom');
        }
        //  return Classroom::all(); //convert collection to json automaticaly (using json encode enternaly)
        $classrooms = Classroom::with('user:id,name')
         ->withCount('students')
         ->paginate(1);

        //  return response()->json($classrooms , 200 ,[
        //     'x-test' => 'test',
        //  ]);

        return ClassroomResource::collection($classrooms);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         // token authorization
         if (!Auth::guard('sanctum')->user()->tokenCan('classrooms.create')) {
            abort(403, 'can not create classroom');
        }

        $request->validate([
            'name' => ['required'],
        ]);

        $classroom = Classroom::create($request->all()); //create resource
        return Response::json([
            'message'=> __('classroom Created'),
            'classroom' => $classroom
        ],201); //201 => success and create
    }

    /**
     * Display the specified resource.
     */
    public function show(Classroom $classroom)
    {
         // token authorization
         if (!Auth::guard('sanctum')->user()->tokenCan('classrooms.read')) {
            abort(403, 'can not show classroom');
        }

        // return Classroom::findOrFail($id); //without model binding
        return $classroom->load('user')->loadCount('students'); // model binding
        // return new ClassroomResource($classroom);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Classroom $classroom)
    {
         // token authorization
         if (!Auth::guard('sanctum')->user()->tokenCan('classrooms.update')) {
            abort(403, 'can not update classroom');
        }

        $request->validate([
            'name' => ['sometimes','required' , Rule::unique('classrooms' , 'name')->ignore($classroom->id)],
            'section'=> ['sometimes','required'],
        ]);

        $classroom->update($request->all());
        return Response::json([
            'message' => 'classroom Updated',
            'classroom' => $classroom
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         // token authorization
        if (!Auth::guard('sanctum')->user()->tokenCan('classrooms.delete')) {
            abort(403, 'can not delet classroom');
        }

        Classroom::destroy($id);
        // return response()->json([
        //     'message' => 'classroom Deleted'
        // ],200);
        return response()->json([],204); //204=> response without data
    }
}