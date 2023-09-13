<?php

namespace App\Http\Controllers;

use App\Events\ClassworkCreated;
use App\Models\Classroom;
use App\Models\ClassroomWork;
use Database\Seeders\UserSeeder;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class ClassroomWorkController extends Controller
{
    protected function getType(Request $request)
    {
        // $type = request()->query('type');
        $type = $request->query('type');

        $allowed_types = [ ClassroomWork::TYPE_ASSIGNMENT , ClassroomWork::TYPE_MATERIAL , ClassroomWork::TYPE_QUESTION ];

        if(!in_array($type , $allowed_types)){
            abort(404);
            // $type = ClassroomWork::TYPE_ASSIGNMENT;
        }

        return $type;

    }

    public function index(Request $request , Classroom $classroom)
    {
        $this->authorize('viewAny' , [ClassroomWork::class , $classroom]);

        $classWork = $classroom->classworks()
        ->with('topic')
        ->withCount([
            'users as assigned_count' => function($query){
                $query->where('classroom_work_user.status' , '=', 'assigned');
            },
            'users as submited_count' => function($query){
                $query->where('classroom_work_user.status' , '=', 'submited');
            },
            'users as graded_count' => function($query){
                $query->whereNotNull('classroom_work_user.grade');
            },
        ])
        ->filter($request->query()) // scope for filter
         ->latest('created_at') //query builder
         ->latest('published_at')
         ->paginate(3);

        // if($request->search){
        //     $query->where('title' , 'LIKE' , "%{$request->search}%")
        //           ->orWhere('descreption', 'LIKE' , "%{$request->search}%");
        // }
        // $classWork = $query->paginate(3);

        //  $classWork = $classroom->classworks; //return the final result (collection of classworks)

        // $assignments = $classroom->classworks()
        // ->where('type' , '=' , ClassWork::TYPE_ASSIGNMENT)
        // ->get();

        return view('Classwork.index' ,
        [
            'classroom' => $classroom,
            'classWork' => $classWork,
            //'classWork' => $classWork->groupBy('type'), //groupBy according collection(not DB)

            // 'type' => $classWork->type
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request , Classroom $classroom)
    {
        $response = Gate::inspect('create', [ClassroomWork::class , $classroom]);
        if($response->denied()){
            abort(403 , $response->message() ?? '');
        }

        //   $this->authorize('create' ,  [ClassroomWork::class , $classroom]);

        // Gate::authorize('classworks.crate', [$classroom]);
        $classwork = new ClassroomWork();
        $type = $this->getType($request);
        return view('Classwork.create' , compact('classroom' , 'type' , 'classwork'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request , Classroom $classroom)
    {
        // $response = Gate::inspect('classworks.crate', [$classroom]);
        // if($response->denied()){
        //     abort(403 , $response->message() ?? '');
        // }

        $this->authorize('create' ,[ClassroomWork::class , $classroom]);


        //   Gate::authorize('classworks.crate', [$classroom]);
        // if(Gate::denise('classworks.crate', [$classroom])){
        //    return  abort(403);
        // }


        $type = $this->getType($request);
        //dd($type);

        $request->validate([
            'title' => ['required' , 'string', 'max:255' ],
            'descreption' => ['nullable' , 'string'] ,
            'topic_id' => ['nullable' , 'int' , 'exists:topics,id'],
            // 'options.grade' => [Rule::requiredIf(fn () => $type == 'assignment'), 'numeric', 'min:0' ],
            // 'options.due' => ['nullable' , 'date' , 'after:today'] //after:published_at(column name) , after:now (now object)
        ]);


            try{
            DB::transaction(function () use($request , $type , $classroom ){

                $data = [
                'user_id' => Auth::id(),
                'classroom_id' => $classroom->id,
                'type' => $type,
                'published_at' => $request->input('published_at'),
                'title' => $request->input('title'),
                'descreption' => $request->input('descreption'),
                'topic_id' => $request->input('topic_id'),
                'options' => [
                    'grade' => $request->input('grade'),
                    'due' => $request->input('due'),
                ],
                // // 'options' =>json_encode([ //solve Array to String Conversion
                //     'grade' => $request->input('grade'),
                //     'due' => $request->input('due'),
                // ]),
                ];
                $classwork = ClassroomWork::create($data);
                // dd($classwork, $data);
                // $classwork =$classroom->classworks()->create($request->all());

                $classwork->users()->attach($request->input('students')); //students is the name of input in claawork create form

                // Trigger Event
                event(new ClassworkCreated($classwork));

                // ClassworkCreated::dispatch($classwork);

            });
        }catch(QueryException $e){
            return back()->with('error' , $e->getMessage());
        }

        //PRG
        return redirect(route('classrooms.classworks.index' , $classroom->id))->with('success' , " $classroom->name classwork created!");

    }

    /**
     * Display the specified resource.
     */
    public function show(Classroom $classroom , ClassroomWork $classwork)
 {
        $this->authorize('view' ,$classwork);
        // Gate::authorize('classworks.view' , [$classroom ,$classwork ]);

        //  $classwork->load('comments.user'); // Eager Load
        $submissions = Auth::user()->submissions()->where('classroom_work_id' , $classwork->id )->get();
        //  collection(object) of all  submissions to this user to current classwork
        //  $classwork->load('comments.user'); // Eager Load
        return view('Classwork.show', compact('classroom' , 'classwork' , 'submissions' ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request ,Classroom $classroom ,ClassroomWork $classwork)
    {
        $this->authorize('update' , $classwork );
        $type =$classwork->type;
        // dd( $type);
        $assigned = $classwork->users()->pluck('id')->toArray();



        return view('Classwork.edit' , compact('classroom' , 'classwork' , 'assigned' , 'type'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,Classroom $classroom , ClassroomWork $classwork)
    {
        $this->authorize('update' , $classwork);

        $type = $classwork->type;
        $request->validate([
            'title' => ['required' , 'string', 'max:255' ],
            'descreption' => ['nullable' , 'string'] ,
            'topic_id' => ['nullable' , 'int' , 'exists:topics,id'],
            'options.grade' => [Rule::requiredIf(fn () => $type == 'assignment'), 'numeric', 'min:0' ],
            'options.due' => ['nullable' , 'date' , 'after:today'] //after:published_at(column name) , after:now (now object)
        ]);

        $data =[
            // 'user_id' => Auth::id(),
            // 'classroom_id' => $classroom->id,
            // 'type' => $type,
            'published_at' => $request->input('published_at'),
            'title' => $request->input('title'),
            'descreption' => $request->input('descreption'),
            'topic_id' => $request->input('topic_id'),
            'options' => [
                'grade' => $request->input('grade'),
                'due' => $request->input('due'),
            ],
        ];

        // dd($classwork->published_at);
        $classwork->update($data);
        $classwork->users()->sync($request->input('students'));
        return back()->with('success', "$classwork->title updated successfuly " );

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Classroom $classroom , ClassroomWork $classwork)
    {
        $this->authorize('delete' , $classwork);

        $classwork->delete();
        return redirect()->route('classrooms.classworks.index' , $classroom->id)->with('success', " classwork deleted successfuly " );

    }
}
