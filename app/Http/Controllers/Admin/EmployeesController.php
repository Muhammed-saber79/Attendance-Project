<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeesController extends Controller
{
    public function index()
    {
        $employees = Employee::paginate();
        return view('Admin.Employees.index', compact('employees'));
    }

    public function store(Request $request)
    {
        $validData = $request->validate([
            'number' => ['required', 'string'],
            'name' => ['required', 'string'],
            'department' => ['required', 'string'],
            'phone' => ['required', 'numeric'],
            'email' => ['required', 'email'],
            'image' => ['required', 'mimes:png,jpg,jpeg'],
        ]);

        $employee = Employee::create($validData);
        if($request->hasFile('image') && $request->file('image')->isValid()){
            $employee->addMediaFromRequest('image')->toMediaCollection('image');
        }

        return redirect()->route('admin.employees.index')->with('success', 'تم تسجيل بيانات الموظف بنجاح');
    }

    public function update(Request $request, $id)
    {
        // Validate the incoming request
        $validData = $request->validate([
            'number' => ['required', 'string'],
            'name' => ['required', 'string'],
            'department' => ['required', 'string'],
            'phone' => ['required', 'numeric'],
            'email' => ['required', 'email'],
            'image' => ['nullable', 'mimes:png,jpg,jpeg'],
        ]);

        // Find the employee by ID
        $employee = Employee::findOrFail($id);

        // Update the employee with the validated data
        $employee->update($validData);

        // Check if the request contains a valid file
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            // Store the new image using Media Library
            $employee->clearMediaCollection('image');
            $employee->addMediaFromRequest('image')->toMediaCollection('image');
        }

        return redirect()->route('admin.employees.index')->with('success', 'تم تحديث بيانات الموظف بنجاح');
    }

    public function destroy($id)
    {
        // Find the employee by ID
        $employee = Employee::findOrFail($id);

        // Delete the employee
        $employee->delete();

        return redirect()->route('admin.employees.index')->with('success', 'تم حذف بيانات الموظف بنجاح');
    }
}
