<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Teacher extends Model implements HasMedia
{
    use HasFactory , InteractsWithMedia;
    protected $guarded =[];

    public function messages()
    {
        return $this->morphMany(Messages::class, 'messageable');
    }

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachmentable');
    }
}
