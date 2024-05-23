<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $data = [
            'student_count' => Student::where('status', '=', Student::STATUS_ACTIVE)->count()
        ];
        return view('admin.dashboard.index', compact('data'));
    }
}
