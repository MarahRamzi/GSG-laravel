<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'content' => ['required' , 'string'],
            'id' => ['required' , 'integer'],
            'type' => ['required']
        ]);

        Auth::user()->comments()->create([
           'commentable_id'=> $request->input('id'), // id of the post or comment that we want to add a new comment on it
            'commentable_type' => $request->input('type'),//type is name of class model
            'content' => $request->input('content'),
            'ip'=> $request->ip(),
            'user_agent' => $request->userAgent(),
            // $request->header('user-agent')

        ]);

        return back()->with('success' , 'comment added');


    }
}