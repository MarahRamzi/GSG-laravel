<?php

use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\JoinClassroomController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TopicsController;
use App\Models\Classroom;
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

// Route::get('classrooms',[ClassroomController::class , 'index'] )->name('classrooms.index');
// Route::get('classrooms/create',[ClassroomController::class , 'create'] )->name('classrooms.create');
// Route::post('classrooms',[ClassroomController::class , 'store'] )->name('classrooms.store');
// Route::get('classrooms/{{classroom}}' , [ClassroomController::class , 'show'])
// ->name('classrooms.show')
// ->where( 'classroom' , '\d+');

// Route::resource('/classrooms', ClassroomController::class)
// ->where(['Classroom' => '\d+']);


Route::view('master' , 'layoute/master');

Route::get('/classrooms/trashed',[ClassroomController::class , 'Trashed'])->name('classrooms.trashed');
Route::put('/classrooms/trashed/{classroom}',[ClassroomController::class , 'restore'])->name('classrooms.restore');
Route::delete('/classrooms/trashed/{classroom}',[ClassroomController::class , 'forceDelete'])->name('classrooms.force-delete');


Route::get('/topics/trashed',[TopicsController::class , 'Trashed'])->name('topics.trashed');
Route::put('/topics/trashed/{topic}',[TopicsController::class , 'restore'])->name('topics.restore');
Route::delete('/topics/trashed/{topic}',[TopicsController::class , 'forceDelete'])->name('topics.force-delete');

Route::get('/classrooms/{classroom}/join' , [JoinClassroomController::class , 'create'])
->name('classrooms.join');

Route::post('/classrooms/{classroom}/join' , [JoinClassroomController::class , 'store']);

Route::get('/login' , [LoginController::class , 'create'])->name('login')->middleware('guest');
Route::post('/login' , [LoginController::class , 'store'])->name('login')->middleware('guest');

Route::resources([
    'topics'=>TopicsController::class,
    'classrooms' => ClassroomController::class ,
]);