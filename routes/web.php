<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeacherController;
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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
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

Route::get('/', [TeacherController::class, 'index'])->name('index');
Route::get("create", [TeacherController::class,"create"])->name("create")->middleware('auth');
Route::post('/create', [TeacherController::class, 'store'])->name('store');
Route::get('/post', [TeacherController::class, 'post'])->name('post');
Route::get('/teacher/{id}/profile', [TeacherController::class, 'profile'])->name('teacher.profile');
