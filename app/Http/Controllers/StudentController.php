<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    
    public function index()
    {
        return view('kelola-mahasiswa');
    }

    public function store(Request $request){

        $user = User::create([
            'username' => $request->username,
            'full_name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);

        $student = Student::create([
            'user_id' => $user->user_id,
            'entry_year' => $request->entry_year,
        ]);
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(Student::with('user')->find($student->student_id));
        }
    }

    public function update(Request $request, Student $student){
        // Update user
        $user = $student->user;
        $user->username = $request->username;
        $user->full_name = $request->full_name;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        // Update student
        $student->entry_year = $request->entry_year;
        $student->save();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(Student::with('user')->find($student->student_id));
        }
    }

    public function destroy(Student $student) {
        $student->user->delete();
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json(['success' => true]);
        }
    }

}