<?php

namespace App\Http\Controllers\Admin;

use App\Models\Attendance;
use App\Imports\DataImport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Absence;
use App\Models\Teacher;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use DataTables;
class TeacherAttendenceController extends Controller
{
    public function index(Request $request)
    {
        $today = date('N'); // Get the current day of the week as a number (1 = Monday, 7 = Sunday)

        $daysOfWeek = [
            1 => 'الاثنين',
            2 => 'الثلاثاء',
            3 => 'الأربعاء',
            4 => 'الخميس',
            5 => 'الجمعة',
            6 => 'السبت',
            7 => 'الأحد',
        ];
        $data = Attendance::where('day',$daysOfWeek[$today])->get();

        if ($request->ajax()) {
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){

                            $btn = '<button onclick="change_status(this)"  class="btn btn-sm btn-warning change_status" data-type="delay" data-teacher_number="'.$row->teacher_number .'" data-id="'.$row->id .'">تاخير</button>
                            <button onclick="change_status(this)" class="btn btn-sm btn-danger change_status" data-type="absense" data-teacher_number="'.$row->teacher_number .'" data-id="'.$row->id .'">غياب</button>';

                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('Admin.teachers_attendence.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);
        try {
            $file = $request->file('file');
            DB::beginTransaction();

            // Handle data import using the single DataImport class
            $dataImport = new DataImport();
            Excel::import($dataImport, $file);
            // You can access imported data using $dataImport->getData()
            DB::commit();
            // Redirect or return a response
            return redirect()->route('admin.teacher_attendence.index')->with('success', 'File uploaded successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'something went wrong');
        }
    }

    public function change_status(Request $request){
        $teacher = Teacher::where('number',$request->teacher_number)->first();
        Absence::create([
            'attendence_id'=>$request->id ,
            'status'=>$request->type ,
            'teacher_id'=>$teacher->id ,
            'teacher_number'=>$request ->teacher_number
        ]);
    return true ;
    }
}
