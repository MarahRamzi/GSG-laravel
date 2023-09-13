<?php

use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\ClassroomPeople;
use App\Http\Controllers\ClassroomPeopleController;
use App\Http\Controllers\ClassroomWorkController;
use App\Http\Controllers\ClassWorkController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\JoinClassroomController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\PlansController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\SubscriptionsController;
use App\Http\Controllers\TopicsController;
use App\Models\Classroom;
use App\Models\Post;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
}); 

// require __DIR__.'/auth.php';

// Route::get('classrooms/{{classroom}}' , [ClassroomController::class , 'show'])
// ->name('classrooms.show')
// ->where( 'classroom' , '\d+');

// Route::resource('/classrooms', ClassroomController::class)
// ->where(['Classroom' => '\d+']);


Route::view('master' , 'layoute/master');

Route::middleware(['auth'])->group(function () {

    Route::post('subscriptions' , [SubscriptionsController::class , 'store'])
    ->name('subscriptions.store');

    Route::post('payments' , [PaymentsController::class , 'store'])->name('payments.store');

    Route::get('payments/success' , [PaymentsController::class , 'success'])->name('payments.success');

    Route::get('payments/cancel' , [PaymentsController::class , 'cancel'])->name('payments.cancel');
    
    Route::get('subscriptions/{subscription}/checkout' , [PaymentsController::class , 'create'])->name('checkout');
    


    Route::prefix('/classrooms/trashed')
    ->controller(ClassroomController::class)
    ->group(function(){
        Route::get('/', 'Trashed')->name('classrooms.trashed');
        Route::put('/{classroom}', 'restore')->name('classrooms.restore');
        Route::delete('/{classroom}','forceDelete')->name('classrooms.force-delete');
    });

    Route::prefix('/topics/trashed')
    ->as('topics.')
    ->controller(TopicsController::class)
    ->group(function(){
        Route::get('/', 'Trashed')->name('topics.trashed');
        Route::put('/{topic}', 'restore')->name('topics.restore');
        Route::delete('/{topic}', 'forceDelete')->name('topics.force-delete');
    });

    Route::get('classrooms/{classroom}/join' , [JoinClassroomController::class , 'create'])->middleware('signed')->name('classrooms.join');
    Route::post('classrooms/{classroom}/join' , [JoinClassroomController::class , 'store'])->name('classrooms.join.store');


    Route::resources([
        'topics'=>TopicsController::class,
        'classrooms' => ClassroomController::class ,
        'classrooms.classworks'=> ClassroomWorkController::class,
        'classrooms.posts' => PostController::class,
    ]);

    // Route::resource('classrooms.classworks', ClassWorkController::class)->shallow();



  //Route::get('classroom/{classroom}/people' , ClassroomPeopleController::class); //call to invoke magic method

    Route::get('classrooms/{classroom}/people' , [ClassroomPeopleController::class , 'index'])->name('classrooms.people');
    Route::delete('classrooms/{classroom}/people' , [ClassroomPeopleController::class , 'destroy'])->name('classrooms.people.destroy');

    Route::post('comments' , [CommentController::class , 'store'])->name('comments.store');

    Route::post('classworks/{classwork}/submissions/' , [SubmissionController::class , 'store'])->name('submissions.store');

    Route::get('submissions/{submission}/file/' , [SubmissionController::class , 'file'])->name('submissions.file');

});

Route::get('plans' , [PlansController::class , 'index'])
->name('plans');














// Route::get('classrooms', [ClassroomController::class , 'index'])->name('classrooms.index')->middleware('auth');
// Route::get('classrooms/create', [ClassroomController::class , 'create'])->name('classrooms.create')->middleware('auth');