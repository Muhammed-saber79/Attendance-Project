<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\EmployeeAbsence;
use Illuminate\Http\Request;

class EmployeesAbsenceController extends Controller
{
    public function attend()
    {
        $attendEmployees = EmployeeAbsence::where('status', 'attend')->with(['employee'])->paginate();
        return view('Admin.Employees.attend', compact('attendEmployees'));
    }
    public function absence()
    {
        $absentEmployees = EmployeeAbsence::where('status', 'absent')->with(['employee'])->paginate();
        return view('Admin.Employees.absent', compact('absentEmployees'));
    }

    public function late()
    {
        $lateEmployees = EmployeeAbsence::where('status', 'late')->with(['employee'])->paginate();
        return view('Admin.Employees.late', compact('lateEmployees'));
    }
}
