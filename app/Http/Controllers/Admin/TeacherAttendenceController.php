<?php

namespace App\Http\Controllers\Admin;

use DataTables;
use App\Models\Absence;
use App\Models\Teacher;
use App\Models\Attendance;
use App\Imports\DataImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Date;
use Maatwebsite\Excel\Facades\Excel;

class TeacherAttendenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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
        $data = Attendance::where('day', $daysOfWeek[$today])->get();

        if ($request->ajax()) {
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $value = '';
                    if (Absence::where('teacher_number', $row->teacher_number)->where('attendence_id', $row->id)->whereDate('created_at', Date::now()->format('Y-m-d'))->first()) {
                        $value = 'disabled';
                    }
                    $btn = '<button ' . $value . ' onclick="change_status(this)"  class="btn btn-sm btn-warning change_status" data-type="delay" data-teacher_number="' . $row->teacher_number . '" data-id="' . $row->id . '">تاخير</button>
                            <button ' . $value . ' onclick="change_status(this)" class="btn btn-sm btn-danger change_status" data-type="absense" data-teacher_number="' . $row->teacher_number . '" data-id="' . $row->id . '">غياب</button>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('Admin.teachers_attendence.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        // Attendance::truncate();
        Teacher::truncate();
        // Absence::truncate();
        return 'ddddd';
    }
    public function delete_all(){
        // Attendance::truncate();
        $teachers = Teacher::all();
        foreach($teachers as $teacher){
            $teacher->delete();
        }
        // Absence::truncate();
        return back()->with('success','تم حذف البيانات بنجاح');
    }

    public function change_status(Request $request)
    {
        $teacher = Teacher::where('number', $request->teacher_number)->first();
        if (!Absence::where('teacher_id', $teacher->id)->where('attendence_id', $request->id)->whereDate('created_at', now()->format('Y-m-d'))->first()) {
            Absence::create([
                'attendence_id' => $request->id,
                'status' => $request->type,
                'teacher_id' => $teacher->id,
                'teacher_number' => $request->teacher_number
            ]);
        }

        $data = ['meassage' => 'تم تسجيل حالة المدرس بنجاح'];
        return response()->json($data);
    }
}
