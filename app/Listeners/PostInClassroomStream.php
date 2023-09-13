<?php

namespace App\Listeners;

use App\Events\ClassworkCreated;
use App\Models\ClassworkUser;
use App\Models\Stream;
use DragonCode\Contracts\Cashier\Http\Request;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PostInClassroomStream
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle( ClassworkCreated $event ): void
    {
       $classwork =  $event->classwork;
        // dd($classwork);

        $content = __(':name posted a new :type :title' , [ //translation function
                'name' => Auth::user()->name,
                'type' => __($classwork->type),
                'title'=> $classwork->title,
        ]) ; 

        Stream::create([
            // 'id' =>  Str::uuid(),
            'classroom_id' => $classwork->classroom_id,
            'user_id' => $classwork->user_id ,
            'content' =>  $content,
            'created_at' => now(),
            'link' => route('classrooms.classworks.show' ,[ $classwork->classroom_id , $classwork->id ])

        ]);
    }
}