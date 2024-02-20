<?php

namespace App\Jobs;

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
        $viewPath = resource_path("views/Messages/{$this->data['type']}.blade.php");
        $pdf = PDF::loadView($viewPath, $this->data);//. $this->data['type'] .'test');
        $pdfPath = 'pdfs/' . uniqid() . '.pdf';
        Storage::disk('public')->put($pdfPath, $pdf->output());

        $path = Storage::disk('public')->url($pdfPath);
        EmployeeAbsence::where('employee_id', $this->data['employee_id'])->update([
            'pdf' => $path,
        ]);
    }
}
