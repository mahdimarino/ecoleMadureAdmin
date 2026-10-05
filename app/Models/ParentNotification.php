<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class ParentNotification extends Model
{
    protected $fillable = [
        'parent_id',
        'student_id',
        'attendance_id',
        'type',
        'title',
        'message',
        'read_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    public function student()
    {
        return $this->belongsTo(StudentRecord::class, 'student_id');
    }

    public function attendance()
    {
        return $this->belongsTo(StudentAttendance::class, 'attendance_id');
    }
}
