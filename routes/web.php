<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\LessonWeekController;
use App\Http\Controllers\LessonMonthController;
use App\Http\Controllers\ApiLessonController;
use App\Http\Controllers\StudentController;

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
Route::get('/show/{id}', [LessonMonthController::class, 'show']);
Route::get('/change/{id}', [LessonMonthController::class, 'change']);
Route::get('student/api/read/{year}/{month}/{day}', [ApiLessonController::class, 'read']);//тут все надо переделать на гет запрос
Route::match(['post', 'get'], '/student/api/update', [ApiLessonController::class, 'update']);
Route::match(['get','post'], '/student/{id}', [LessonMonthController::class, 'change']);
Route::match(['get','post'], '/adminView', [LessonWeekController::class, 'adminView']);
Route::match(['get','post'], '/adminPanel', [StudentController::class, 'adminPanel']);
Route::get('/create', [StudentController::class, 'create']);
Route::post('/create_end', [StudentController::class, 'createEnd']);
Route::get('api/read', [ApiLessonController::class, 'read']);
Route::get('api/delete/{id}', [ApiLessonController::class, 'delete']);
require __DIR__.'/auth.php';
