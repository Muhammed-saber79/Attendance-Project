<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\GeneratePDF;
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
            'type' => 'required|in:accountability,notification,decision',
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
                return redirect()->back()->with('error', 'لا يوجد بريد الكتروني خاص بهذا المدرب, يرجى تحديث بياناته للتمكن من ارسال الاشعارات!');
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
            'type' => 'required|in:accountability,notification,decision',
            'pdf' => ['required', 'in:yes,no']
        ]);

        DB::beginTransaction();
        try {
            Messages::create([
                'title' => $validatedData['title'],
                'description' => $validatedData['description'],
                'type' => $validatedData['type'],
                'messageable_type' => "App\\Models\\Employee",
                'messageable_id' => $employee->id,
            ]);

            // Mail Service
            $data = [
                'email' => $employee->email,
                'title' => $validatedData['title'],
                'description' => $validatedData['description'],
                'type' => $validatedData['type'],
            ];

            $result = $this->emailService->sendReplyEmail($data);
            if (! $result['status'] ) {
                return redirect()->back()->with('error', 'حدث خطأ اثناء ارسال الرد. يمكنك المحاولة مجددا.');
            }

            EmployeeAbsence::where('employee_id', $employee->id)->update([
                'is_replied' => 1,
            ]);

            DB::commit();

            if ($request->pdf == 'yes') {
                $data = [
                    'employee_id' => $employee->id,
                    'employee_name' => $employee->name,
                    'type' => $validatedData['type'],
                    'attachmentable_type' => "App\\Models\\Employee",
                    'attachmentable_id' => $employee->id,
                ];
                GeneratePDF::dispatch($data)->onQueue('pdf-generation');
            }

            return redirect()->back()->with('success', 'تم الإرسال بنجاح');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
                //, 'حدث خطأ اثناء الإرسال, حاول مجددا لاحقا!');
        }
    }

    public function employeeMessages($id)
    {
        $absence = EmployeeAbsence::findOrFail($id);
        $attachments = $absence->attachments;

        return view('Admin.Employees.Messages.index', compact('attachments'));
    }
}
