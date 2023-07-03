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

/*Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});*/

Route::get('/', function(){
    return view('resume');
})->name('Обо мне');
Route::get('/contacts', function(){
   return view('contacts');
})->name('Контакты');
Route::middleware('auth')->group(function () {
    Route::get('/show/{id}', [LessonMonthController::class, 'show'])->name('Просмотр занятий учеником');
    Route::middleware('teacher')->group(function(){
        Route::match(['get', 'post'], '/change/{id}', [LessonMonthController::class, 'change']);
        Route::match(['get','post'], '/student/{id}', [LessonMonthController::class, 'change']);
        Route::match(['get','post'], '/adminView', [LessonWeekController::class, 'adminView'])->name('Недельное расписания учителя');
        Route::match(['get','post'], '/adminPanel', [StudentController::class, 'adminPanel'])->name('Панель управления учителя');
        Route::get('/create', [StudentController::class, 'create'])->name('Создать нового ученика');
        Route::post('/create_end', [StudentController::class, 'createEnd']);
        Route::get('api/read', [ApiLessonController::class, 'read']);
        Route::get('api/delete/{id}', [ApiLessonController::class, 'delete']);
        Route::get('student/api/read', [ApiLessonController::class, 'read']);
        Route::match(['post', 'get'], '/student/api/update', [ApiLessonController::class, 'update']);
    });
});
require __DIR__.'/auth.php';
