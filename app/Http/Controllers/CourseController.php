<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    // ADMIN: Create, edit, delete

    public function create(){
        return view('courses.create');
    }

    public function store(Request $request){
        $request->validate([
            'course_name' =>'required|string|max:255',
            'credits' => 'required|integer|min:1|max:10',
        ]);
        Course::create($request->only('course_name', 'credits'));
        return redirect()->route('dashboard.admin')->with('status', 'course-created');
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
        return redirect()->route('dashboard.admin')->with('status', 'course-updated');
    }

    public function destroy(Course $course){
        $course->delete();
        return redirect()->route('dashboard.admin')->with('status', 'course-deleted');
    }

}