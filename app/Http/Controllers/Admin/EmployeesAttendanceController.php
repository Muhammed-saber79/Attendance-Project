<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\EmployeeAbsence;
use Illuminate\Http\Request;

class EmployeesAttendanceController extends Controller
{
    public function index()
    {
        $employees = Employee::paginate();
        return view('Admin.Attendance.employees', compact('employees'));
    }

    public function change_status(Request $request)
    {
        $employee = Employee::where('number', $request->employee_number)->first();
        if (!EmployeeAbsence::where('employee_id', $employee->id)->whereDate('created_at', now()->format('Y-m-d'))->first()) {
            EmployeeAbsence::create([
                'status' => $request->type,
                'employee_id' => $employee->id,
                'employee_number' => $request->employee_number
            ]);
        }

        $data = ['message' => 'تم تسجيل حالة المتابعة للموظف بنجاح'];
        return response()->json($data);
    }
}
