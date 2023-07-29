<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function create()  {
        return view('login');
    }

    public function store(Request $request){
        $request->validate([
            'email' => 'required' ,
            'password' => 'required' ,
        ]);

        $credentials = [
            'email'=> $request->email,
            'password' => $request->password ,
        ];
        
       $result = Auth::attempt($credentials , $request->boolean('remember'));

       if($result){
             return redirect(route('classrooms.index'));
       }
       return back()->withInput()->withErrors([
            'email' => 'invalid email' ,
            'password' => 'invalid password'  ,
        ]);

        // $user = User::where('email' , '=' , $request->email)->first(); //return object from User model with all fields
        // if($user && Hash::check($request->password , $user->password)){
        //     Auth::login($user);
        //     return redirect(route('classrooms.index'));
        // }return back()->withInput()->withErrors([
        //     'email' => 'invalid email' ,
        //     'password' => 'invalid password'  ,
        // ]);
    }
}