<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ApplyUserPreferences
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $supported = ['en' , 'ar'];

        $headerlang = $request->header('accept-language');
        $locales = explode(',' , $headerlang);// يفصلهم في مصفوفة
        $locale  = config('app.locale');
        // dd($locales);
        if($locales){
            foreach($locales as $locale){
                if(($i=strpos($locale , ';')) !== false  ){
                $locale = substr($locale , 0 , $i );
                }

                if(in_array($locale ,$supported )){
                    break;
                }
            }

        // dd($locale);


        $user = Auth::user();
        if($user){
            App::setlocale($user->profile->local ?? $locale );
        }
        return $next($request);
    }
}}
