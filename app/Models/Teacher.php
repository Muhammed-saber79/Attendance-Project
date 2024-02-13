<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;
    protected $guarded =[];

    public function messages()
    {
        return $this->morphMany(Messages::class, 'messageable');
    }
}
