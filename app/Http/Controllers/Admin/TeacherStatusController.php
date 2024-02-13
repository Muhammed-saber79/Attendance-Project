<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absence;
use Illuminate\Http\Request;

class TeacherStatusController extends Controller
{
    public function absense(){
        $absenses = Absence::where('status','absense')->with('teacher','attendance')->get();
        return view('Admin.teachers_status.absense',compact('absenses'));
    }

    public function delay(){
        $delays = Absence::where('status','delay')->with('teacher','attendance')->get();
        return view('Admin.teachers_status.delay',compact('delays'));
    }
}
