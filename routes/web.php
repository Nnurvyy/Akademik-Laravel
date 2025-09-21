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

    Route::get('/dashboard-admin', [DashboardAdminController::class, 'dashboardAdmin'])->name('dashboard.admin');

    // Kelola Mahasiswa
    Route::get('/dashboard-admin/kelola-mahasiswa', [StudentController::class, 'index'])->name('students.index');
    Route::get('/dashboard-admin/kelola-mahasiswa/create', [StudentController::class, 'create'])->name('students.create');
    Route::post('/dashboard-admin/kelola-mahasiswa', [StudentController::class, 'store'])->name('students.store');
    Route::get('/dashboard-admin/kelola-mahasiswa/{student}/edit', [StudentController::class, 'edit'])->name('students.edit');
    Route::put('/dashboard-admin/kelola-mahasiswa/{student}', [StudentController::class, 'update'])->name('students.update');
    Route::delete('/dashboard-admin/kelola-mahasiswa/{student}', [StudentController::class, 'destroy'])->name('students.destroy');

    // Kelola Course
    Route::get('/dashboard-admin/kelola-course', [CourseController::class, 'index'])->name('courses.index');
    Route::get('/dashboard-admin/kelola-course/create', [CourseController::class, 'create'])->name('courses.create');
    Route::post('/dashboard-admin/kelola-course', [CourseController::class, 'store'])->name('courses.store');
    Route::get('/dashboard-admin/kelola-course/{course}/edit', [CourseController::class, 'edit'])->name('courses.edit');
    Route::put('/dashboard-admin/kelola-course/{course}', [CourseController::class, 'update'])->name('courses.update');
    Route::delete('/dashboard-admin/kelola-course/{course}', [CourseController::class, 'destroy'])->name('courses.destroy');

});

// JS
Route::middleware(['auth', 'role:admin'])->get('/api/students', function() {
    return \App\Models\Student::with('user')->get();
});


// middleware role USER
Route::middleware(['auth', 'role:user'])->group(function () {

    //dashboard
    Route::get('/dashboard-user', [DashboardUserController::class, 'dashboardUser'])->name('dashboard.user');
    Route::get('/dashboard-user/list-courses', [CourseController::class, 'list'])->name('courses.list');
    Route::get('/dashboard-user/my-courses', [CourseController::class, 'my'])->name('courses.my');

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