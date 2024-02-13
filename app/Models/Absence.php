<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absence extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function teacher(){
        return $this->belongsTo(Teacher::class , 'teacher_id');
    }
    public function attendance(){
        return $this->belongsTo(Attendance::class , 'teacher_id');
    }
}
