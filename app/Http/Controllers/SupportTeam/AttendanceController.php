<?php

namespace App\Http\Controllers\SupportTeam;

use App\Http\Controllers\Controller;
use App\Mail\StudentAbsenceMail;
use App\Models\ParentNotification;
use App\Models\StudentAttendance;
use App\Models\StudentRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class AttendanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('teamSAT');
    }

    /**
     * Show all students.
     */
    public function index(Request $request)
    {
        $date = $request->input(
            'date',
            now()->toDateString()
        );

        $students = StudentRecord::where('grad', 0)
            ->with([
                'user',
                'my_class',
                'section',
                'my_parent'
            ])
            ->orderBy('my_class_id')
            ->get();

        $attendance = StudentAttendance::whereDate('date', $date)
            ->get()
            ->keyBy('student_id');

        return view(
            'pages.support_team.attendance.index',
            compact(
                'students',
                'date',
                'attendance'
            )
        );
    }

    /**
     * Mark student absent.
     */
    public function markAbsent(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|integer|exists:student_records,id',
            'date' => 'required|date',
            'note' => 'nullable|string|max:2000',
        ]);

        $student = StudentRecord::with([
            'user',
            'my_parent'
        ])
            ->where('grad', 0)
            ->findOrFail($validated['student_id']);

        /*
         * Make sure the student has a parent.
         */
        if (!$student->my_parent_id || !$student->my_parent) {
            return back()
                ->withInput()
                ->with(
                    'pop_error',
                    'This student does not have a parent account linked.'
                );
        }

        $attendance = DB::transaction(function () use (
            $validated,
            $student
        ) {

            /*
             * Create/update attendance.
             *
             * Because student_id + date is unique,
             * we don't create duplicate attendance records.
             */
            $attendance = StudentAttendance::updateOrCreate(
                [
                    'student_id' => $student->id,
                    'date' => $validated['date'],
                ],
                [
                    'status' => 'absent',
                    'note' => $validated['note'] ?? null,
                    'marked_by' => Auth::id(),
                ]
            );

            /*
             * Create notification for parent.
             */
            ParentNotification::create([
                'parent_id' => $student->my_parent_id,
                'student_id' => $student->id,
                'attendance_id' => $attendance->id,
                'type' => 'student_absence',
                'title' => 'Student absence',
                'message' =>
                $student->user->name .
                    ' was marked absent on ' .
                    $attendance->date->format('d/m/Y') .
                    (
                        $attendance->note
                        ? '. Note: ' . $attendance->note
                        : '.'
                    ),
            ]);

            return $attendance->load([
                'student.user'
            ]);
        });

        /*
         * Send email to parent.
         */
        if (!empty($student->my_parent->email)) {

            Mail::to($student->my_parent->email)
                ->send(
                    new StudentAbsenceMail($attendance)
                );
        }

        return redirect()
            ->route(
                'attendance.index',
                [
                    'date' => $validated['date']
                ]
            )
            ->with(
                'flash_success',
                $student->user->name .
                    ' was marked absent successfully.'
            );
    }
}
