<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Employee extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'number', 'name', 'department', 'phone', 'email'
    ];

    public function absence()
    {
        return $this->hasMany(EmployeeAbsence::class);
    }

    public function messages()
    {
        return $this->morphMany(Messages::class, 'messageable');
    }
}
