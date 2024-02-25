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
                    $btn = '<button ' . $value . ' onclick="change_status(this)" class="btn btn-sm btn-success change_status" data-type="attend" data-teacher_number="' . $row->teacher_number . '" data-id="' . $row->id . '">حضور</button>
                            <button ' . $value . ' onclick="change_status(this)"  class="btn btn-sm btn-warning change_status" data-type="delay" data-teacher_number="' . $row->teacher_number . '" data-id="' . $row->id . '">تاخير</button>
                            <button ' . $value . ' onclick="change_status(this)" class="btn btn-sm btn-danger change_status" data-type="absense" data-teacher_number="' . $row->teacher_number . '" data-id="' . $row->id . '">غياب</button>
                            <button ' . $value . ' class="btn btn-sm btn-warning" data-toggle="modal" data-target="#statusChangeModal-' . @$row->id . '">تاخير</button>
                            <div class="modal fade" id="statusChangeModal-' . @$row->id . '" tabindex="-1" role="dialog" aria-labelledby="statusChangeModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="statusChangeModalLabel">تغيير الحالة</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="statusChangeForm-' . @$row->id . '" onsubmit="submitForm(this, event)">
                                                <!-- Hidden inputs to hold employee data -->
                                                <input type="hidden" name="employee_number" id="employee_number" value="' . @$row->teacher_number . '">
                                                <input type="hidden" name="id" id="employee_id" value="' . @$row->id . '">
                                                <input type="hidden" name="type" id="type" value="late">
                                                <input type="hidden" name="elementId" id="elementId" value="parent-' . @$row->id . '">
                                                <input type="hidden" name="modalId" id="modalId" value="statusChangeModal-' . @$row->id . '">

                                                <div class="form-group">
                                                    <label for="fromTime">بداية من الساعة: </label>
                                                    <input oninput="limitTimeRange(this, \'statusChangeForm-' . @$row->id . '\')" type="time" name="fromTime" id="fromTime" class="form-control"  min="00:00" max="23:59" required>
                                                </div>

                                                <div class="form-group">
                                                    <label for="toTime">إلى الساعة: </label>
                                                    <input type="time" name="toTime" id="toTime" class="form-control" max="23:59" required>
                                                </div>

                                                <button type="submit" class="btn btn-primary">حفظ</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        ';

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
                'teacher_number' => $request->teacher_number,
                'from' => $request->from,
                'to' => $request->to,
            ]);
        }

        $data = ['meassage' => 'تم تسجيل حالة المدرب بنجاح'];
        return response()->json($data);
    }
}
