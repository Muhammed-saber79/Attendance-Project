<?php

namespace App\Jobs;

use App\Models\Employee;
use App\Models\EmployeeAbsence;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf as PDF;
use PHPUnit\Exception;

class GeneratePDF implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    /**
     * Create a new job instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $pdf = PDF::loadView("Messages.{$this->data['type']}", $this->data);
        $pdfPath = "pdfs/{$this->data['employee_name']}/" . now()->format('d-m-Y') . '-' . uniqid() . '.pdf';
        Storage::disk('public')->put($pdfPath, $pdf->output());

        $path = Storage::disk('public')->url($pdfPath);
        //$employeeAbsence = EmployeeAbsence::where('employee_id', $this->data['employee_id'])->first();
        $employee = Employee::where('id', $this->data['employee_id'])->first();

        $employee->attachments()->create([
            'pdf' => $path,
            'message_type' => $this->data['type'],
            'attachmentable_type' => $this->data['attachmentable_type'],
            'attachmentable_id' => $this->data['attachmentable_id'],
        ]);
    }
}
