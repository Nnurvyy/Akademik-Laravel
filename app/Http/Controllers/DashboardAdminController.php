<?php
namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Course;
use Illuminate\Http\Request;


class DashboardAdminController extends Controller{
    public function dashboardAdmin(Request $request)
    {

        // Statistics
        $studentCount = Student::count();
        $courseCount = Course::count();

        return view('dashboard-admin', compact(
            'studentCount', 'courseCount'
        ));
    }
}
