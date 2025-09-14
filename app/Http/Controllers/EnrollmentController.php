<?php

namespace App\Http\Controllers;

use App\Models\Take;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnrollmentController extends Controller{
    public function enroll($course_id){
        $student = Auth::user()->student;
        Take::firstOrCreate([
            'student_id' => $student->student_id,
            'course_id' => $course_id,
        ], [
            'enroll_date' => now(),
        ]);
        return redirect()->route('dashboard.user')->with('status', 'enrolled');
    }
}