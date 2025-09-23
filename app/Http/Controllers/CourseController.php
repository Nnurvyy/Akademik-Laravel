<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    // ADMIN: Create, edit, delete
    public function index()
    {
       return view('kelola-course');
    }

    public function list()
    {
        return view('list-courses');
    }

    public function my()
    {
        return view('my-courses');
    }


    public function store(Request $request){
        $course = Course::create($request->only('course_name', 'credits'));
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json($course);
        }
    }



    public function update(Request $request, Course $course){
        $course->update($request->only('course_name', 'credits'));
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json($course);
        }
    }


    public function destroy(Course $course){
    $course->delete();
    if (request()->ajax() || request()->wantsJson()) {
        return response()->json(['success' => true]);
    }
    
}

}