<?php

namespace App\Imports;

use App\Models\Teacher;
use App\Models\Attendance;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Queue;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;

class DataImport implements ToModel
{
    /**
     * @param Collection $collection
     */
    public function model(array $row)
    {
        static $firstRowSkipped = false;

        // Skip the first row (header)
        if (!$firstRowSkipped) {
            $firstRowSkipped = true;
            return null;
        }
        if (! Teacher::where('number', $row[18])->first()) {
            // Create Teacher model
            $teacher = new Teacher([
                'name' => $row[19],
                'number' => $row[18],
                'department' => $row[3],
                // Add other columns for Teachers as needed
            ]);
            $teacher->save();

        }

        // Queue::push(new \App\Jobs\TruncateAttendanceTable());
        // Create Attendance model
        $attendance = new Attendance([
            'teacher_name' => $row[19],
            'teacher_number' => $row[18],
            'department' => $row[3],
            'building' => $row[13],
            'room' => $row[14],
            'day' => $row[10],
            'lecture_time' => $row[11],
            'subject_name' => $row[5],
            'lecture_number' => $row[6],

            // Add other columns for Attendances as needed
        ]);

        // Save models to the respective tables
        $attendance->save();

        // You may return any of the models or null as needed
        return $attendance;
    }
}
