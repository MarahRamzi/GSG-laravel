<?php

namespace App\Http\Controllers;

use App\Models\ClassroomWork;
use App\Models\ClassworkUser;
use App\Models\Submission;
use App\Rules\ForbiddenFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Throwable;

class SubmissionController extends Controller
{
    public function store(Request $request , ClassroomWork $classwork)
    {
        Gate::authorize('submissions.create' , [$classwork]);
        $request->validate([

            'files' => ['required' , 'array'], // validate on arrayy
            'files.*' => ['file' , new ForbiddenFile('application/x-httpd-php' , 'application/x-msdownload	' , 'text/x-php')] , // validate on item in array
        ]);

        $assigned = $classwork->users()->where('id' , Auth::id())->exists();

        if(! $assigned)
        {
            abort(403);
        }

        DB::beginTransaction();

        try{

            $data = [];
                foreach($request->file('files') as $file){
                    $data[] = [ //push in array
                        // 'user_id' => Auth::id(),
                        'classroom_work_id' => $classwork->id,
                        'content' => $file->store("submissions/{$classwork->id}"),
                        'type' => 'file',
                        // 'created_at' => now(),
                        // 'updated_at' => now(),
                    ];
                }

                // Submission::insert($data); //mass assignment using model , $data => array of array
                 $user = Auth::user();
                $user->submissions()->createMany($data);

                ClassworkUser::where([
                    'user_id' => $user->id,
                    'classroom_work_id' => $classwork->id,
                ])->update([
                    'status' => 'submited',
                    'submited_at' => now(),
                ]);

                DB::commit();

            }catch(Throwable $e){

                DB::rollBack();
                return back()->with('error' , $e->getMessage());
            }

        return back()->with('success', 'classWork Submited' );



    }

    public function file(Submission $submission)
    {

        $user = Auth::user();
        $isTeacher = $submission->classwork->classroom->teachers()->where('id' , $user->id)->exists();
        // dd($submission);
        $isOwner = $submission->user_id == $user->id;

        if(!$isTeacher & ! $isOwner ){
            return back()->with('error', 'can not show file');
        }

        return response()->file(storage_path('app/'.$submission->content));
        // return Storage::disk('local')->download($submission->content);

    }
}
