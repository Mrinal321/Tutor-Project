<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\FilterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TeacherProfileController;
use Illuminate\Support\Facades\Auth;
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

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Auth::routes(['verify' => true]);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Auth::routes();
Route::middleware(['auth'])->group(function (){
    Route::post('/teachers/{id}/rate', [TeacherController::class, 'rate'])->name('teachers.rate');
    Route::post('/vote/{id}', [TeacherController::class, 'incrementVote'])->name('vote');
});

// TeacherController
Route::get('/', [TeacherController::class, 'index'])->name('index');
Route::get("create", [TeacherProfileController::class,"create"])->name("create")->middleware('auth');
Route::post('/create', [TeacherProfileController::class, 'store'])->name('store');
Route::get('/post', [TeacherController::class, 'post'])->name('post');

// FilterController
Route::get('/university', [FilterController::class, 'university'])->name('university');
Route::get('/department', [FilterController::class, 'department'])->name('department');

// TeacherProfileController
Route::get('/teacher/{id}/profile', [TeacherProfileController::class, 'profile'])->name('teacher.profile');
Route::post('/teachers/{teacher}/comments', [CommentController::class, 'store'])->name('comments.store');
Route::get('teachers/{id}/edit', [TeacherProfileController::class, 'edit'])->name('teacher.edit');
Route::put('teacher/{id}/update', [TeacherProfileController::class, 'update'])->name('teacher.update');

// ScheduleController
Route::get('/schedules', [ScheduleController::class, 'index'])->name('schedules');
Route::get('/schedules/create/{id}', [ScheduleController::class, 'create'])->name('schedules.create');
Route::post('/schedules/store', [ScheduleController::class, 'store'])->name('schedules.store');

//
