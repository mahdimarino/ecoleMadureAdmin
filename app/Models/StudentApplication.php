<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class StudentApplication extends Model
{
    protected $table = 'student_applications';

    protected $fillable = [
        'application_number',

        'full_name',
        'first_name',
        'last_name',
        'date_of_birth',
        'gender',
        'nationality',
        'place_of_birth',
        'photo',

        'current_school',
        'current_level',
        'previous_school',

        'address',
        'city',
        'country',

        'program',
        'requested_level',
        'academic_year',
        'desired_start_date',
        'academic_notes',

        'parent_name',
        'parent_relationship',
        'parent_phone',
        'parent_whatsapp',
        'parent_email',
        'parent_occupation',
        'parent_address',

        'emergency_name',
        'emergency_relationship',
        'emergency_phone',

        'medical_notes',
        'additional_comments',
        'how_did_you_hear',

        'status',
        'admin_notes',
        'reviewed_by',
        'reviewed_at',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'desired_start_date' => 'date',
        'reviewed_at' => 'datetime',
    ];

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
