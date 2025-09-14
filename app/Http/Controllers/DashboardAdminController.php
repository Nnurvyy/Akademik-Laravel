<?php
namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Course;
use Illuminate\Http\Request;


class DashboardAdminController extends Controller{
    public function dashboardAdmin(Request $request)
    {
        // Students
        $studentSort = $request->get('student_sort', 'username');
        $studentOrder = $request->get('student_order', 'asc');
        $studentSearch = $request->get('student_search');

        $studentsQuery = Student::with('user');
        if ($studentSearch) {
            $studentsQuery->whereHas('user', function($q) use ($studentSearch) {
                $q->where('username', 'like', "%$studentSearch%")
                ->orWhere('full_name', 'like', "%$studentSearch%")
                ->orWhere('email', 'like', "%$studentSearch%");
            })->orWhere('entry_year', 'like', "%$studentSearch%");
        }
        if (in_array($studentSort, ['username', 'full_name', 'entry_year'])) {
            if ($studentSort === 'entry_year') {
                $studentsQuery->orderBy('entry_year', $studentOrder);
            } else {
                $studentsQuery->join('users', 'students.user_id', '=', 'users.user_id')
                    ->orderBy("users.$studentSort", $studentOrder)
                    ->select('students.*');
            }
        }
        $students = $studentsQuery->paginate(5, ['*'], 'students')->appends($request->except('students'));

        // Courses
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

        return view('dashboard-admin', compact(
            'students', 'courses',
            'studentSort', 'studentOrder', 'studentSearch',
            'courseSort', 'courseOrder', 'courseSearch'
        ));
    }
}
