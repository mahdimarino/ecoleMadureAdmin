<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\StudentApplication;
class StudentApplicationController extends Controller
{
    /**
     * Submit a new student application
     */
    public function store(Request $request)
    {
        $validated = $request->validate([

            // Student
            'full_name' => 'required|string|max:255',
            'first_name' => 'nullable|string|max:100',
            'last_name' => 'nullable|string|max:100',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|string|max:50',
            'nationality' => 'nullable|string|max:100',
            'place_of_birth' => 'nullable|string|max:255',

            // Optional photo
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',

            // Education
            'current_school' => 'nullable|string|max:255',
            'current_level' => 'nullable|string|max:100',
            'previous_school' => 'nullable|string|max:255',

            // Address
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',

            // Application
            'program' => 'nullable|string|max:100',
            'requested_level' => 'nullable|string|max:100',
            'academic_year' => 'nullable|string|max:50',
            'desired_start_date' => 'nullable|date',
            'academic_notes' => 'nullable|string',

            // Parent
            'parent_name' => 'nullable|string|max:255',
            'parent_relationship' => 'nullable|string|max:100',
            'parent_phone' => 'nullable|string|max:50',
            'parent_whatsapp' => 'nullable|string|max:50',
            'parent_email' => 'nullable|email|max:255',
            'parent_occupation' => 'nullable|string|max:255',
            'parent_address' => 'nullable|string',

            // Emergency
            'emergency_name' => 'nullable|string|max:255',
            'emergency_relationship' => 'nullable|string|max:100',
            'emergency_phone' => 'nullable|string|max:50',

            // Additional
            'medical_notes' => 'nullable|string',
            'additional_comments' => 'nullable|string',
            'how_did_you_hear' => 'nullable|string|max:255',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Generate application number
        |--------------------------------------------------------------------------
        */

        $lastApplication = StudentApplication::latest('id')->first();

        $nextNumber = $lastApplication
            ? $lastApplication->id + 1
            : 1;

        $applicationNumber = 'APP-' . date('Y') . '-' . str_pad(
            $nextNumber,
            4,
            '0',
            STR_PAD_LEFT
        );

        /*
        |--------------------------------------------------------------------------
        | Upload photo if provided
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('photo')) {

            $validated['photo'] = $request
                ->file('photo')
                ->store('student-applications', 'public');
        }

        /*
        |--------------------------------------------------------------------------
        | Create application
        |--------------------------------------------------------------------------
        */

        $application = StudentApplication::create([
            ...$validated,

            'application_number' => $applicationNumber,
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Votre demande d’inscription a été envoyée avec succès.',
            'application_number' => $application->application_number,
            'application_id' => $application->id,
        ], 201);
    }
}
