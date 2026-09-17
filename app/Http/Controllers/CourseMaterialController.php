<?php

namespace App\Http\Controllers;

use App\Helpers\Qs;
use App\Models\CourseMaterial;
use App\Models\MyClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Mail\NewCourseMail;
use App\Models\StudentRecord;
use Illuminate\Support\Facades\Mail;

class CourseMaterialController extends Controller
{
    /**
     * Teacher page
     */
    public function teacherIndex()
    {
        $user = Auth::user();

        if (Qs::userIsTeamSA()) {
            $materials = CourseMaterial::with('my_class')
                ->latest()
                ->get();
        } else {
            $materials = CourseMaterial::where('teacher_id', $user->id)
                ->with('my_class')
                ->latest()
                ->get();
        }

        $classes = MyClass::orderBy('name')->get();

        return view(
            'pages.course_materials.teacher',
            compact('materials', 'classes')
        );
    }

    public function create()
    {
        $classes = MyClass::orderBy('name')->get();

        return view(
            'pages.course_materials.create',
            compact('classes')
        );
    }
    /**
     * Upload material
     */
    /**
     * Upload material
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'class_id' => 'required|exists:my_classes,id',
            'file' => [
                'required',
                'file',
                'max:20480',
                'mimes:pdf,doc,docx,ppt,pptx,jpg,jpeg,png,webp'
            ],
        ]);

        $teacher = Auth::user();

        $file = $request->file('file');

        $originalName = $file->getClientOriginalName();

        $path = $file->store(
            'course_materials/' . $teacher->id,
            'local'
        );

        // Create the course material
        $course = CourseMaterial::create([
            'title' => $request->title,
            'description' => $request->description,
            'file_name' => $originalName,
            'file_path' => $path,
            'file_type' => $file->getClientMimeType(),
            'file_size' => $file->getSize(),
            'teacher_id' => $teacher->id,
            'class_id' => $request->class_id,
        ]);

        /*
     * Get all students belonging to this class
     */
        $students = StudentRecord::with('user')
            ->where('my_class_id', $course->class_id)
            ->get();

        /*
     * Send email to every student who has an email address
     */
        foreach ($students as $student) {

            if ($student->user && !empty($student->user->email)) {

                Mail::to($student->user->email)
                    ->send(new NewCourseMail($course));
            }
        }

        return back()->with(
            'flash_success',
            'Course material uploaded successfully and students have been notified.'
        );
    }

    /**
     * Edit material page
     */
    public function edit($id)
    {
        $material = CourseMaterial::findOrFail($id);

        $classes = MyClass::orderBy('name')->get();

        return view(
            'pages.course_materials.edit',
            compact('material', 'classes')
        );
    }

    /**
     * Update material
     */
    public function update(Request $request, $id)
    {
        $material = CourseMaterial::findOrFail($id);

        $user = Auth::user();

        // Only the teacher who uploaded it, or an admin/super_admin, can update it
        if (
            $material->teacher_id != $user->id &&
            !in_array($user->user_type, ['admin', 'super_admin'])
        ) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'class_id' => 'required|exists:my_classes,id',
            'file' => [
                'nullable',
                'file',
                'max:20480',
                'mimes:pdf,doc,docx,ppt,pptx,jpg,jpeg,png,webp'
            ],
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'class_id' => $request->class_id,
        ];

        // Replace file if a new one was uploaded
        if ($request->hasFile('file')) {

            // Delete old file
            if (Storage::disk('local')->exists($material->file_path)) {
                Storage::disk('local')->delete($material->file_path);
            }

            $file = $request->file('file');

            $path = $file->store(
                'course_materials/' . $material->teacher_id,
                'local'
            );

            $data['file_name'] = $file->getClientOriginalName();
            $data['file_path'] = $path;
            $data['file_type'] = $file->getClientMimeType();
            $data['file_size'] = $file->getSize();
        }

        $material->update($data);

        return redirect()
            ->route('teacher.course_materials')
            ->with(
                'flash_success',
                'Course material updated successfully.'
            );
    }

    /**
     * Delete material
     */
    public function destroy($id)
    {
        $material = CourseMaterial::findOrFail($id);

        $user = Auth::user();

        if (
            $material->teacher_id != $user->id &&
            !in_array($user->user_type, ['admin', 'super_admin'])
        ) {
            abort(403);
        }

        if (Storage::disk('local')->exists($material->file_path)) {
            Storage::disk('local')->delete($material->file_path);
        }

        $material->delete();

        return back()->with(
            'flash_success',
            'Course material deleted successfully.'
        );
    }

    /**
     * Materials for students
     */
    public function studentIndex()
    {
        $user = Auth::user();

        $student = $user->student_record;

        if (!$student) {
            $materials = collect();
        } else {
            $materials = CourseMaterial::where(
                'class_id',
                $student->my_class_id
            )
                ->with(['teacher', 'my_class'])
                ->latest()
                ->get();
        }

        return view(
            'pages.course_materials.index',
            compact('materials')
        );
    }

    /**
     * Materials for parents
     */
    public function parentIndex()
    {
        $parent = Auth::user();

        $students = \App\Models\StudentRecord::where(
            'my_parent_id',
            $parent->id
        )->get();

        $classIds = $students
            ->pluck('my_class_id')
            ->filter()
            ->unique();

        $materials = CourseMaterial::whereIn(
            'class_id',
            $classIds
        )
            ->with(['teacher', 'my_class'])
            ->latest()
            ->get();

        return view(
            'pages.course_materials.index',
            compact('materials')
        );
    }

    /**
     * Download material
     */
    public function download($id)
    {
        $material = CourseMaterial::findOrFail($id);

        $user = Auth::user();

        /*
         * Teacher who uploaded the file
         */
        if (
            $user->user_type === 'teacher' &&
            $material->teacher_id == $user->id
        ) {
            return $this->sendFile($material);
        }

        /*
         * Student
         */
        if ($user->user_type === 'student') {

            $student = $user->student_record;

            if (
                !$student ||
                $student->my_class_id != $material->class_id
            ) {
                abort(403);
            }

            return $this->sendFile($material);
        }

        /*
         * Parent
         */
        if ($user->user_type === 'parent') {

            $child = \App\Models\StudentRecord::where(
                'my_parent_id',
                $user->id
            )
                ->where(
                    'my_class_id',
                    $material->class_id
                )
                ->first();

            if (!$child) {
                abort(403);
            }

            return $this->sendFile($material);
        }
        if (in_array($user->user_type, ['admin', 'super_admin'])) {
            return $this->sendFile($material);
        }

        abort(403);
    }

    /**
     * Send file
     */
    private function sendFile(CourseMaterial $material)
    {
        if (!Storage::disk('local')->exists($material->file_path)) {
            abort(404, 'File not found.');
        }

        return Storage::disk('local')->download(
            $material->file_path,
            $material->file_name
        );
    }
}
