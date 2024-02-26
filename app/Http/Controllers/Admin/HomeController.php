<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absence;
use App\Models\EmployeeAbsence;
use App\Models\Teacher;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $usersData = [];
        $ordersData = [];

        for ($i = 4; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i)->format('F'); // Get month name
            $usersData['labels'][] = $month;

            // Fetch user count for the current month
            $usersData['data'][] = Absence::whereMonth('created_at', Carbon::parse($month)->month)
                ->count();
        }

        for ($i = 4; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i)->format('F'); // Get month name
            $usersData['labels'][] = $month;

            // Fetch user count for the current month
            $usersData['data'][] = EmployeeAbsence::whereMonth('created_at', Carbon::parse($month)->month)
                ->count();
        }

        return view('Admin.index', compact('usersData', 'ordersData'));
    }

    public function teachers()
    {
        $lastMonth = Carbon::now()->subMonth();
        $absent = Absence::where('created_at', '>=', $lastMonth)->where('status', 'absence')->count();
        $late = Absence::where('created_at', '>=', $lastMonth)->where('status', 'late')->count();
        $attend = Absence::where('created_at', '>=', $lastMonth)->where('status', 'attend')->count();
        $labels = ['غياب', 'تاخير', 'حضور'];

        $teachersAbsenceData = [
            'labels' => $labels,
            'values' => [$absent, $late, $attend],
            'colors' => ['red', 'green', 'blue']
        ];
        return response()->json($teachersAbsenceData);
    }

    public function employees()
    {
        // Get the start and end of the last month
        $startOfMonth = Carbon::now()->subMonth()->startOfMonth();
        $endOfMonth = Carbon::now()->subMonth()->endOfMonth();

        // Initialize arrays to hold data for each status
        $absencesData = [];
        $tardinessData = [];
        $attendancesData = [];

        // Get an array of dates for each day of the last month
        $dates = [];
        for ($date = $startOfMonth; $date <= $endOfMonth; $date->addDay()) {
            $dates[] = $date->format('Y-m-d');
        }

        // Loop through each day of the last month
        foreach ($dates as $date) {
            // Get the count of absences, tardiness, and attendances for each day
            $absencesCount = EmployeeAbsence::whereDate('created_at', $date)
                ->where('status', 'absence')
                ->count();

            $tardinessCount = EmployeeAbsence::whereDate('created_at', $date)
                ->where('status', 'late')
                ->count();

            $attendancesCount = EmployeeAbsence::whereDate('created_at', $date)
                ->where('status', 'attend')
                ->count();

            // Push the counts into respective arrays
            $absencesData[] = $absencesCount;
            $tardinessData[] = $tardinessCount;
            $attendancesData[] = $attendancesCount;
        }

        // Return data as JSON response
        return response()->json([
            'labels' => $dates,
            'datasets' => [
                [
                    'label' => 'Absences',
                    'data' => $absencesData,
                    'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                    'borderColor' => 'rgba(255, 99, 132, 1)',
                    'borderWidth' => 1,
                ],
                [
                    'label' => 'Tardiness',
                    'data' => $tardinessData,
                    'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                    'borderColor' => 'rgba(54, 162, 235, 1)',
                    'borderWidth' => 1,
                ],
                [
                    'label' => 'Attendances',
                    'data' => $attendancesData,
                    'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                    'borderColor' => 'rgba(75, 192, 192, 1)',
                    'borderWidth' => 1,
                ],
            ],
        ]);
    }
}
