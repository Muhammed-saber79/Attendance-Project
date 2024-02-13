<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeesAttendanceController extends Controller
{
    public function index()
    {
        $employees = Employee::paginate();
        return view('Admin.Attendance.employees', compact('employees'));
    }
}
