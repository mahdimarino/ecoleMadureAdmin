<?php

namespace App\Http\Controllers\SupportTeam;

use App\Http\Controllers\Controller;
use App\Models\StudentApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StudentApplicationController extends Controller
{
    /**
     * Show the public student registration form.
     */
    public function create()
    {
        return view('auth.studentregistration');
    }

    /**
     * Handle the public student registration submission.
     * Creates a pending StudentApplication for the admin to review/approve.
     */
    public function storePublic(Request $request)
    {
        $validated = $request->validate([

            // Student
            'full_name' => 'required|string|max:255',
            'first_name' => 'nullable|string|max:100',
            'last_name' => 'nullable|string|max:100',
            'date_of_birth' => 'required|date',
            'gender' => 'required|string|max:50',
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
            'program' => 'required|string|max:100',
            'requested_level' => 'required|string|max:100',
            'academic_year' => 'nullable|string|max:50',
            'desired_start_date' => 'nullable|date',
            'academic_notes' => 'nullable|string',

            // Parent / guardian
            'parent_name' => 'required|string|max:255',
            'parent_relationship' => 'nullable|string|max:100',
            'parent_phone' => 'required|string|max:50',
            'parent_whatsapp' => 'nullable|string|max:50',
            'parent_email' => 'required|email|max:255',
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

        // Upload photo if provided
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request
                ->file('photo')
                ->store('student-applications', 'public');
        }

        $application = StudentApplication::create([
            ...$validated,
            'application_number' => $this->generateApplicationNumber(),
            'status' => 'pending',
        ]);

        return redirect()
            ->route('studentregistration')
            ->with(
                'success',
                'Votre dossier d\'inscription a été envoyé avec succès (N° '
                    . $application->application_number
                    . '). Il sera examiné par l\'administration.'
            );
    }

    /**
     * Generate a unique, sequential application number (APP-YYYY-0001).
     */
    protected function generateApplicationNumber()
    {
        $lastApplication = StudentApplication::latest('id')->first();

        $nextNumber = $lastApplication
            ? $lastApplication->id + 1
            : 1;

        return 'APP-' . date('Y') . '-' . str_pad(
            $nextNumber,
            4,
            '0',
            STR_PAD_LEFT
        );
    }

    /**
     * Display all student applications.
     */
    public function index(Request $request)
    {
        $query = StudentApplication::query();

        // Search
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('application_number', 'like', '%' . $search . '%')
                    ->orWhere('full_name', 'like', '%' . $search . '%')
                    ->orWhere('parent_name', 'like', '%' . $search . '%')
                    ->orWhere('parent_email', 'like', '%' . $search . '%')
                    ->orWhere('parent_phone', 'like', '%' . $search . '%');
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Program filter
        if ($request->filled('program')) {
            $query->where('program', $request->program);
        }

        // Level filter
        if ($request->filled('requested_level')) {
            $query->where('requested_level', $request->requested_level);
        }

        $applications = $query
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->appends($request->all());

        $programs = StudentApplication::whereNotNull('program')
            ->where('program', '!=', '')
            ->distinct()
            ->orderBy('program')
            ->pluck('program');

        $levels = StudentApplication::whereNotNull('requested_level')
            ->where('requested_level', '!=', '')
            ->distinct()
            ->orderBy('requested_level')
            ->pluck('requested_level');

        return view(
            'pages.admin.student-applications.index',
            compact(
                'applications',
                'programs',
                'levels'
            )
        );
    }

    /**
     * Edit application.
     */
    public function edit(Request $request)
    {
        $path = $request->path();

        // student-applications/1/edit
        $parts = explode('/', $path);

        $id = $parts[count($parts) - 2];

        $application = StudentApplication::findOrFail($id);

        return view('pages.admin.student-applications.edit', [
            'application' => $application
        ]);
    }

    /**
     * Update application.
     */
    public function update(Request $request, $id)
    {
        $application = StudentApplication::findOrFail($id);

        $request->validate([
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $application->full_name = $request->full_name;
        $application->first_name = $request->first_name;
        $application->last_name = $request->last_name;
        $application->date_of_birth = $request->date_of_birth;
        $application->gender = $request->gender;
        $application->nationality = $request->nationality;
        $application->place_of_birth = $request->place_of_birth;

        $application->program = $request->program;
        $application->requested_level = $request->requested_level;
        $application->academic_year = $request->academic_year;
        $application->current_school = $request->current_school;
        $application->current_level = $request->current_level;
        $application->previous_school = $request->previous_school;
        $application->desired_start_date = $request->desired_start_date;
        $application->academic_notes = $request->academic_notes;

        $application->parent_name = $request->parent_name;
        $application->parent_relationship = $request->parent_relationship;
        $application->parent_phone = $request->parent_phone;
        $application->parent_whatsapp = $request->parent_whatsapp;
        $application->parent_email = $request->parent_email;
        $application->parent_occupation = $request->parent_occupation;
        $application->parent_address = $request->parent_address;

        $application->emergency_name = $request->emergency_name;
        $application->emergency_relationship = $request->emergency_relationship;
        $application->emergency_phone = $request->emergency_phone;

        $application->address = $request->address;
        $application->city = $request->city;
        $application->country = $request->country;

        $application->medical_notes = $request->medical_notes;
        $application->how_did_you_hear = $request->how_did_you_hear;
        $application->additional_comments = $request->additional_comments;

        // Replace photo
        if ($request->hasFile('photo')) {

            // Delete old photo
            if ($application->photo) {
                Storage::disk('public')->delete($application->photo);
            }

            // Save new photo
            $application->photo = $request->file('photo')
                ->store('student-applications', 'public');
        }

        $application->save();

        return redirect()
            ->route('student-applications.show', $application->id)
            ->with('success', 'Application updated successfully.');
    }

    /**
     * Display one application.
     */
    public function show(Request $request)
    {
        $id = basename($request->path());

        $application = StudentApplication::find($id);

        if (!$application) {
            abort(404);
        }

        return view('pages.admin.student-applications.show', [
            'application' => $application
        ]);
    }

    /**
     * Change application status.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,reviewing,accepted,rejected',
            'admin_notes' => 'nullable|string',
        ]);

        $application = StudentApplication::findOrFail($id);

        $application->status = $request->status;
        $application->admin_notes = $request->admin_notes;

        if (in_array($request->status, ['accepted', 'rejected'])) {
            $application->reviewed_by = Auth::id();
            $application->reviewed_at = now();
        }

        $application->save();

        return redirect()
            ->back()
            ->with('success', 'Application status updated successfully.');
    }

    /**
     * Delete an application.
     */
    public function destroy($id)
    {
        $application = StudentApplication::findOrFail($id);

        // Delete photo if one exists
        if ($application->photo) {
            Storage::disk('public')->delete($application->photo);
        }

        $application->delete();

        return redirect()
            ->route('student-applications.index')
            ->with('success', 'Application deleted successfully.');
    }
    public function approve($id)
    {
        $application = StudentApplication::findOrFail($id);

        $application->status = 'accepted';
        $application->save();

        return back()->with(
            'success',
            'Student approved successfully.'
        );
    }
}
