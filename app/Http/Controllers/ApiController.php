<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use App\Models\Course;

class ApiController extends Controller
{
    public function studentsAll()
    {
        return Student::with('user')->get();
    }

    public function coursesAll()
    {
        return Course::all();
    }

    public function allCoursesUser()
    {
        $user = Auth::user();
        $student = $user->student;
        $courses = Course::all();
        $enrolled = $student ? $student->takes()->pluck('course_id')->toArray() : [];
        return response()->json([
            'courses' => $courses,
            'enrolled' => $enrolled,
        ]);
    }
}