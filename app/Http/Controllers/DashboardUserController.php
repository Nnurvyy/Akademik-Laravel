<?php
namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardUserController extends Controller{
    public function dashboardUser(Request $request)
    {
        $user = Auth::user();
        $student = $user->student;

        // Semua course (dengan search & sort)
        $courseSort = $request->get('course_sort', 'course_name');
        $courseOrder = $request->get('course_order', 'asc');
        $courseSearch = $request->get('course_search');

        $coursesQuery = Course::query();
        if ($courseSearch) {
            $coursesQuery->where('course_name', 'like', "%$courseSearch%")
                ->orWhere('credits', 'like', "%$courseSearch%");
        }
        if (in_array($courseSort, ['course_name', 'credits'])) {
            $coursesQuery->orderBy($courseSort, $courseOrder);
        }
        $courses = $coursesQuery->paginate(5, ['*'], 'courses')->appends($request->except('courses'));

        // Course yang sudah di-enroll
        $myCourses = $student
            ? $student->takes()->with('course')->paginate(5, ['*'], 'mycourses')
            : collect();

        // Ambil id course yang sudah di-enroll
        $enrolledCourseIds = $student
            ? $student->takes()->pluck('course_id')->toArray()
            : [];

        return view('dashboard-user', compact('courses', 'myCourses', 'enrolledCourseIds', 'courseSort', 'courseOrder', 'courseSearch'));
    }
}
