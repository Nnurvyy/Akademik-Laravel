<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardUserController;
use App\Http\Controllers\DashboardAdminController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// WELCOME (HOME)
Route::get('/', [HomeController::class, 'welcome']);

// dispatcher dashboard 
Route::get('/dashboard', [HomeController::class, 'dashboard'])->middleware(['auth'])->name('dashboard');



// middleware role ADMIN
Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/dashboard-admin', [DashboardAdminController::class, 'dashboardAdmin'])->name('dashboard.admin');

    // Kelola Mahasiswa
    Route::get('/dashboard-admin/kelola-mahasiswa', [StudentController::class, 'index'])->name('students.index');
    Route::post('/dashboard-admin/kelola-mahasiswa', [StudentController::class, 'store'])->name('students.store');
    Route::put('/dashboard-admin/kelola-mahasiswa/{student}', [StudentController::class, 'update'])->name('students.update');
    Route::delete('/dashboard-admin/kelola-mahasiswa/{student}', [StudentController::class, 'destroy'])->name('students.destroy');

    // Kelola Course
    Route::get('/dashboard-admin/kelola-course', [CourseController::class, 'index'])->name('courses.index');
    Route::post('/dashboard-admin/kelola-course', [CourseController::class, 'store'])->name('courses.store');
    Route::put('/dashboard-admin/kelola-course/{course}', [CourseController::class, 'update'])->name('courses.update');
    Route::delete('/dashboard-admin/kelola-course/{course}', [CourseController::class, 'destroy'])->name('courses.destroy');

    // JS
    Route::get('/api/students-all', [ApiController::class, 'studentsAll']);
    Route::get('/api/courses-all', [ApiController::class, 'coursesAll']);

});




// middleware role USER
Route::middleware(['auth', 'role:user'])->group(function () {

    //dashboard
    Route::get('/dashboard-user', [DashboardUserController::class, 'dashboardUser'])->name('dashboard.user');
    Route::get('/dashboard-user/list-courses', [CourseController::class, 'list'])->name('courses.list');
    Route::get('/dashboard-user/my-courses', [CourseController::class, 'my'])->name('courses.my');

    // JS
    Route::get('/api/all-courses-user', [ApiController::class, 'allCoursesUser']);
    Route::post('/mahasiswa/enroll-courses', [EnrollmentController::class, 'enrollMany']);

});


// PROFILE
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';