<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClassroomRequest;
use App\Models\Classroom;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\str;
use Illuminate\Validation\Rule;

class ClassroomController extends Controller
{

    public function index(Request $request): Renderable{
        $classroom = Classroom::orderBy('created_at' , 'DESC')->get();
        // $classroom = DB::table('classrooms')->orderBy('created_at' , 'DESC')->get();

        $success = session('success');
        return view('Classroom.index' ,compact('classroom' , 'success'));
    }

    public function create()
    {
        return view()->make('Classroom.create');
    }

    public function store(ClassroomRequest $request) : RedirectResponse{
        //method 1
        //$classroom = new Classroom();
        // $classroom->name = $request->post('name'); //to all column
        // $classroom->save();

        // if($request->hasFile('cover_image_path')){
        //         $file = $request->file('cover_image_path');
        //         $file->store('/');
        // }

        // validation



        if ($request->hasFile('cover_image_path')) {
            $file = $request->file('cover_image_path'); //uplodedFile object
            $imageName = time() . '-' . $file->getClientOriginalName();
            $file->move(public_path('storage/covers'), $imageName);

            $request = $request->merge([
                'cover_image_path' => $imageName
            ]);
        }


        // dd($request->cover_image_path);

        // $request->merge(['code' => Str::random(7)]);

        DB::beginTransaction();
      try{
        //method 2 mass asignment
        $classroom = Classroom::create($request->all()); //create=>new classroom() +save()

       $classroom->join(Auth::id() , 'teacher');

        DB::commit();
    }catch(Exception $e){
        DB::rollBack();
        return back()
        ->with('error' , $e->getMessage())
        ->withInput();
    }
        // dd($request->all());


        //PRG
        return redirect(route('classrooms.index'))
        ->with('success' , 'classroom created');

    }

    public function show(Classroom $classroom){

           return View('Classroom.show',compact('classroom'))
            ->with([
                'classroom' => $classroom,
            ]);

    }

    public function edit(Classroom $classroom){
        return view('Classroom.edit' , compact('classroom'));

    }

    public function update(ClassroomRequest $request , Classroom $classroom)
    {



        // if($request->hasFile('cover_image_path')){
        //     // dd($request->cover_image_path);
        //     $file = $request->file('cover_image_path'); //uplodedFile object
        //     $path = Classroom::uploadCoverImage($file);
        //     $validated['cover_image_path'] =$path;


        // }

        // $old= $classroom->cover_image_path;
        $validated = $request->validated(); //Returns the data it has validation

         $classroom->update($validated);

        // if($old && $old != $classroom->cover_image_path){
        //     Classroom::deleteCoverImage($old);
        // }

        return redirect(route('classrooms.index'))
        ->with('success' , 'classroom updated');
     }


    public function destroy(Classroom $classroom){

        $classroom->delete();

        return redirect(route('classrooms.index'))
        ->with('success' , 'classroom deleted');

    }

    public function Trashed(){
        $classroom = Classroom::onlyTrashed()->latest('deleted_at')->get();

        return view('Classroom.trashed' ,compact('classroom'));
    }

    public function restore($id) {
        $classroom = Classroom::onlyTrashed()->findOrFail($id);
        $classroom->restore();

        return redirect()
        ->route('classrooms.index')
        ->with('success' , "classroom  ({$classroom->name}) restored");

    }

    public function  forceDelete($id){
            $classroom = Classroom::onlyTrashed()->findOrFail($id);
            $classroom->forceDelete();

            return redirect()
        ->route('classrooms.trashed')
        ->with('success' , "classroom  ({$classroom->name}) deleted forever");
    }

}
