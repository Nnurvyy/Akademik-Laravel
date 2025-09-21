<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    // ADMIN: Create, edit, delete
    public function index(Request $request)
    {
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
        $courses = $coursesQuery->paginate(10)->appends($request->except('page'));

        return view('kelola-course', compact('courses', 'courseSort', 'courseOrder', 'courseSearch'));
    }

    public function list(Request $request) {
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
        $courses = $coursesQuery->paginate(10, ['*'], 'courses')->appends($request->except('courses'));

        // Course yang sudah di-enroll
        $myCourses = $student
            ? $student->takes()->with('course')->paginate(10, ['*'], 'mycourses')
            : collect();

        // Ambil id course yang sudah di-enroll
        $enrolledCourseIds = $student
            ? $student->takes()->pluck('course_id')->toArray()
            : [];

        return view('list-courses', compact('courses', 'myCourses', 'enrolledCourseIds', 'courseSort', 'courseOrder', 'courseSearch'));
    }

    public function my(Request $request) {
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
        $courses = $coursesQuery->paginate(10, ['*'], 'courses')->appends($request->except('courses'));

        // Course yang sudah di-enroll
        $myCourses = $student
            ? $student->takes()->with('course')->paginate(10, ['*'], 'mycourses')
            : collect();

        // Ambil id course yang sudah di-enroll
        $enrolledCourseIds = $student
            ? $student->takes()->pluck('course_id')->toArray()
            : [];

        return view('my-courses', compact('courses', 'myCourses', 'enrolledCourseIds', 'courseSort', 'courseOrder', 'courseSearch'));
    }

    public function create(){
        return view('courses.create');
    }

    public function store(Request $request){
        $request->validate([
            'course_name' =>'required|string|max:255',
            'credits' => 'required|integer|min:1|max:10',
        ]);
        Course::create($request->only('course_name', 'credits'));
        return redirect()->route('courses.index')->with('status', 'course-created');
    }

    public function edit(Course $course) {
        return view('courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course){
        $request->validate([
            'course_name' =>'required|string|max:255',
            'credits' => 'required|integer|min:1|max:10',
        ]);
        $course->update($request->only('course_name', 'credits'));
        return redirect()->route('courses.index')->with('status', 'course-updated');
    }

    public function destroy(Course $course){
        $course->delete();
        return redirect()->route('courses.index')->with('status', 'course-deleted');
    }

}