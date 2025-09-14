<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{

    public function create()
    {
        return view('students.create');
    }

    public function store(Request $request){
        $request->validate([
            'username' => ['required', 'string', 'max:15', 'unique:users,username'],
            'full_name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'entry_year' => ['required', 'integer'],
        ]);

        $user = User::create([
            'username' => $request->username,
            'full_name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);

        Student::create([
            'user_id' => $user->user_id,
            'entry_year' => $request->entry_year,
        ]);
        return redirect()->route('dashboard.admin')->with('status', 'student-created');
    }

    public function edit(Student $student){
        $student->load('user');
        return view('students.edit', compact('student'));
    }

    public function update(Request $request, Student $student){
        $request->validate([
            'username' => ['required', 'string', 'max:15', 'unique:users,username,' . $student->user->user_id . ',user_id'],
            'full_name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $student->user->user_id . ',user_id'],
            'password' => ['nullable', 'string', 'min:6'],
            'entry_year' => ['required', 'integer'],
        ]);
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

        return redirect()->route('dashboard.admin')->with('status', 'student-updated');
    }

    public function destroy(Student $student) {
        // Hapus user (otomatis hapus student karena ada foreign key cascade)
        $student->user->delete();
        return redirect()->route('dashboard.admin')->with('status', 'student-deleted');
    }



}