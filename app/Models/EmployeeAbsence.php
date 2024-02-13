<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeAbsence extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id', 'employee_number', 'status', 'is_replied'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
