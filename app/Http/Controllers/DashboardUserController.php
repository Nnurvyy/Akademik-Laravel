<?php
namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Take;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardUserController extends Controller{
    public function dashboardUser(Request $request)
    {
        $user = Auth::user();
        $student = $user->student; // relasi ke tabel students

        $courseCount = Course::count();
        $myCourseCount = $student
            ? Take::where('student_id', $student->student_id)->count()
            : 0;

        return view('dashboard-user', compact('courseCount', 'myCourseCount'));
    }
}
