<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class AccessTokenController extends Controller
{
    // list token
    public function index()
    {
         return Auth::guard('sanctum')->user()->tokens;
        //  return $request->user('sanctum')->tokens;
    }

        //login
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required' , 'email'],
            'password' => ['required'],
            'device_name'=> ['sometimes' , 'required'],
            'abilities' => ['array'],
        ]);

        $user = User::whereEmail($request->email)->first();
        // dd($request->password , $user->password);
        if ($user && Hash::check($request->password , $user->password)){
            $name = $request->post('device_name', $request->userAgent());
            $abilities = $request->post('abilities' ,['*;']);
            $token =  $user->createToken($name , $abilities , now()->addDays(30)); //$token => object

            return Response::json([
                'message' => 'logined successfuy',
                'token' => $token->plainTextToken,
                'user' => $user ,
            ],201);
        }

        return Response::json([
            'message' => __('Invalid credentials'),
        ],401);

    }

    public function destroy($id = null)
    {
        $user = Auth::guard('sanctum')->user();

        if($id){
           //  Revoke(logout from current device)
            if($id == 'current'){
                $user->currentAccessToken()->delete();
                return response()->json(['message' => 'current token deleted successfuly']);
            }else{
           //  Revoke(logout from specific device)
                $user->tokens()->findOrFail($id)->delete();
                return response()->json(['message' => 'token deleted successfuly']);

            }
        }else{
            // (logout from all devices)
            $user->tokens()->delete();
            return response()->json(['message' => 'All tokens deleted successfuly']);

        }
    }
}
// م عملت الصلاحيات لل token