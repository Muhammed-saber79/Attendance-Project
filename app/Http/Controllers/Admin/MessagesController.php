<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absence;
use App\Models\Employee;
use App\Models\EmployeeAbsence;
use App\Models\Messages;
use App\Models\Teacher;
use App\Services\EmailService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MessagesController extends Controller
{
    protected $emailService;

    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }

    public function notifyTeacher(Request $request, $id)
    {
        $teacher = Teacher::findOrFail($id);

        $validatedData = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'type' => 'required|in:notification,decision',
        ]);

        DB::beginTransaction();
        try {
            $message = new Messages();
            $message->title = $validatedData['title'];
            $message->description = $validatedData['description'];
            $message->type = $validatedData['type'];
            $message->messageable_type = "App\\Models\\Teacher";
            $message->messageable_id = $teacher->id;
            $message->save();

            Absence::where('teacher_id', $teacher->id)->update([
                'is_replied' => 1
            ]);

            // Mail Service
            if (!$teacher->email) {
                return redirect()->back()->with('error', 'لا يوجد بريد الكتروني خاص بهذا المدرس, يرجى تحديث بياناته للتمكن من ارسال الاشعارات!');
            }
            $data = [
                'email' => $teacher->email,
                'title' => $request->title,
                'description' => $request->description,
                'type'=>$request->type,
            ];

            $result = $this->emailService->sendReplyEmail($data);
            if (! $result['status'] ) {
                return redirect()->back()->with('error', 'حدث خطأ اثناء ارسال الرد. يمكنك المحاولة مجددا.');
            }

            DB::commit();
            return redirect()->back()->with('success', 'تم الإرسال بنجاح');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'حدث خطأ اثناء الإرسال, حاول مجددا لاحقا!');
        }
    }
    // End of teacher notifications

    public function notifyEmployee(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);

        $validatedData = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'type' => 'required|in:notification,decision',
        ]);

        DB::beginTransaction();
        try {
            $message = new Messages();
            $message->title = $validatedData['title'];
            $message->description = $validatedData['description'];
            $message->type = $validatedData['type'];
            $message->messageable_type = "App\\Models\\Employee";
            $message->messageable_id = $employee->id;
            $message->save();

            EmployeeAbsence::where('employee_id', $employee->id)->update([
                'is_replied' => 1
            ]);

            // Mail Service
            $data = [
                'email' => $employee->email,
                'title' => $request->title,
                'description' => $request->description,
                'type'=>$request->type,
            ];

            $result = $this->emailService->sendReplyEmail($data);
            if (! $result['status'] ) {
                return redirect()->back()->with('error', 'حدث خطأ اثناء ارسال الرد. يمكنك المحاولة مجددا.');
            }

            DB::commit();
            return redirect()->back()->with('success', 'تم الإرسال بنجاح');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'حدث خطأ اثناء الإرسال, حاول مجددا لاحقا!');
        }
    }

    public function viewPDF($file, $data)
    {
        $pdf = PDF::loadView('Messages.usersdetails', array('data' =>  $data))
            ->setPaper('a4', 'portrait');

        return $pdf->stream();

    }

    public function downloadPDF($file, $data)
    {
        $pdf = PDF::loadView('pdf.usersdetails',  array('data' =>  $data))
            ->setPaper('a4', 'portrait');

        return $pdf->download('details.pdf');
    }
}
