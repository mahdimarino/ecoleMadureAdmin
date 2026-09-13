<?php

namespace App\Models;

use App\User;
use Eloquent;

class CourseMaterial extends Eloquent
{
    protected $fillable = [
        'title',
        'description',
        'file_name',
        'file_path',
        'file_type',
        'file_size',
        'teacher_id',
        'class_id',
    ];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function my_class()
    {
        return $this->belongsTo(MyClass::class, 'class_id');
    }
}
