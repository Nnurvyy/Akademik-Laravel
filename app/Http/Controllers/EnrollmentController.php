<?php

namespace App\Http\Controllers;

use App\Models\Take;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnrollmentController extends Controller{

     public function enrollMany(Request $request)
    {
        $request->validate([
            'course_ids' => 'required|array',
            'course_ids.*' => 'exists:courses,course_id',
        ]);

        $student = Auth::user()->student;

        foreach ($request->course_ids as $courseId) {
            Take::firstOrCreate([
                'student_id' => $student->student_id,
                'course_id'  => $courseId,
            ], [
                'enroll_date' => now(),
            ]);
        }

        // update list enrolled terbaru
        $enrolled = $student->takes()->pluck('course_id')->toArray();

        return response()->json([
            'success' => true,
            'enrolled' => $enrolled
        ]);
    }
}