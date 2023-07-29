<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TopicsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $user = User::all();
        // $classroom = Classroom::all();
        $topic = Topic::get();
        $success = session('success');
        return view('Topic.index' ,compact('topic' , 'success'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = User::all();
        $classroom = Classroom::all();
       return view('Topic.create' ,compact('classroom' ,'user' ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request )
    {
        $topic = Topic::create($request->all());

        return redirect(route('topics.index'))->with('success' , 'topic created');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Topic $topic)
    {

      $classroom = Classroom::all();
      $user = User::all();
      return view('Topic.edit' , compact('classroom' , 'topic' , 'user'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Topic $topic)
    {
            $topic->update($request->all());
            return redirect()->route('topics.index')->with('success' , 'topic updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Topic $topic)
    {
        $topic->delete();

        return redirect()->route('topics.index')
        ->with('success' , 'topic deleted');

    }

    public function Trashed(){
        $topic = Topic::onlyTrashed()->latest('deleted_at')->get();

        return view('Topic.trashed' ,compact('topic'));
    }

    public function restore($id) {
        $topic = Topic::onlyTrashed()->findOrFail($id);
        $topic->restore();

        return redirect()
        ->route('topics.index')
        ->with('success' , "topic  ({$topic->name}) restored");

    }

    public function  forceDelete($id){
            $topic = Topic::onlyTrashed()->findOrFail($id);
            $topic->forceDelete();

            return redirect()
        ->route('topics.trashed')
        ->with('success' , "topic  ({$topic->name}) deleted forever");
    }
}