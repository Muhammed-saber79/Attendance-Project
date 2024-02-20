<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'type', 'messageable_type', 'messageable_id'];

    public function messageable()
    {
        return $this->morphTo();
    }
}
