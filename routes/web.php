<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\DashboardUserController;
use App\Http\Controllers\DashboardAdminController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// WELCOME (HOME)
Route::get('/', function () {
    if (Auth::check()){
        return redirect()->route('dashboard'); // jika sudah login langsung ke dashboard
    }
    return redirect()->route('login'); // jika belum login maka ke route login
});

// dispatcher dashboard 
Route::get('/dashboard', function () {
    $user = Auth::user();
    if ($user && $user->role === 'admin') {
        return redirect()->route('dashboard.admin');
    } elseif ($user && $user->role === 'user') {
        return redirect()->route('dashboard.user');
    }
    return redirect('/');
})->middleware(['auth'])->name('dashboard');

// middleware role ADMIN
Route::middleware(['auth', 'role:admin'])->group(function () {

    // dashboard
    Route::get('/dashboard-admin', [DashboardAdminController::class, 'dashboardAdmin'])->name('dashboard.admin');

    // Kelola Courses
    Route::resource('courses', CourseController::class)->except(['show', 'index']);
    // Route resource Laravel untuk courses otomatis membuat 7 route standar: 
        //courses.index (GET /courses → index), courses.create (GET /courses/create → create), courses.store (POST /courses → store), 
        //courses.show (GET /courses/{course} → show), courses.edit (GET /courses/{course}/edit → edit), 
        //courses.update (PUT/PATCH /courses/{course} → update), dan courses.destroy (DELETE /courses/{course} → destroy).
    // Route otomatis yang dibuat adalah: create, store, edit, update, destroy
    // Route 'show' dan 'index' tidak akan dibuat karena kita mengecualikannya dengan ->except()


    // Kelola Students
    Route::get('students/create', [StudentController::class, 'create'])->name('students.create');
    Route::post('students', [StudentController::class, 'store'])->name('students.store');
    Route::get('students/{student}/edit', [StudentController::class, 'edit'])->name('students.edit');
    Route::put('students/{student}', [StudentController::class, 'update'])->name('students.update');
    Route::delete('students/{student}', [StudentController::class, 'destroy'])->name('students.destroy');
});

// middleware role USER
Route::middleware(['auth', 'role:user'])->group(function () {

    //dashboard
    Route::get('/dashboard-user', [DashboardUserController::class, 'dashboardUser'])->name('dashboard.user');

    //Enroll course
    Route::post('courses/{course}/enroll', [EnrollmentController::class, 'enroll'])->name('courses.enroll');
});

// PROFILE
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';