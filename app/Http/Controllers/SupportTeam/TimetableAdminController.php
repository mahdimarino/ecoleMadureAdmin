<?php

namespace App\Http\Controllers\SupportTeam;

use App\Http\Controllers\Controller;
use App\Models\MyClass;
use App\Models\Subject;
use App\Models\StudentRecord;
use App\Models\TimeSlot;
use App\Models\TimeTable;
use App\Models\TimeTableRecord;
use App\Helpers\Qs;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TimetableAdminController extends Controller
{
    /**
     * ADMIN TIMETABLE
     */
    public function index(Request $request)
    {
        $classes = MyClass::orderBy('name')->get();

        $selectedClassId = $request->get('class_id');

        $record = null;
        $rows = collect();
        $subjects = collect();

        if ($selectedClassId) {

            $record = TimeTableRecord::where('my_class_id', $selectedClassId)
                ->whereNull('exam_id')
                ->where('year', Qs::getCurrentSession())
                ->first();

            $subjects = Subject::where('my_class_id', $selectedClassId)
                ->orderBy('name')
                ->get();

            if ($record) {
                $rows = TimeTable::with(['subject', 'time_slot'])
                    ->where('ttr_id', $record->id)
                    ->get()
                    ->sortBy(function ($row) {

                        $days = [
                            'Sunday'    => 1,
                            'Monday'    => 2,
                            'Tuesday'   => 3,
                            'Wednesday' => 4,
                            'Thursday'  => 5,
                            'Friday'    => 6,
                            'Saturday'  => 7,
                        ];

                        $day = $days[$row->day] ?? 99;

                        $time = $row->time_slot
                            ? $row->time_slot->timestamp_from
                            : 0;

                        return ($day * 100000) + $time;
                    });
            }
        }

        return view(
            'pages.support_team.timetables.admin',
            compact(
                'classes',
                'selectedClassId',
                'record',
                'rows',
                'subjects'
            )
        );
    }


    /**
     * ADD TIMETABLE ROW
     */
    public function store(Request $request)
    {
        $request->validate([
            'class_id'     => 'required|integer|exists:my_classes,id',
            'day'          => 'required|in:Sunday,Monday,Tuesday,Wednesday,Thursday,Friday,Saturday',
            'time_from'    => 'required|date_format:H:i',
            'time_to'      => 'required|date_format:H:i',
            'subject_id'  => 'nullable|integer|exists:subjects,id',
            'new_subject' => 'nullable|string|max:255',
        ]);

        if (!$request->subject_id && !$request->new_subject) {
            return back()
                ->withInput()
                ->with('flash_danger', 'Please select or enter a subject.');
        }

        /**
         * Find or create timetable record
         */
        $record = TimeTableRecord::firstOrCreate(
            [
                'my_class_id' => $request->class_id,
                'exam_id'     => null,
                'year'        => Qs::getCurrentSession(),
            ],
            [
                'name' => 'Normal Timetable - ' . Qs::getCurrentSession(),
            ]
        );


        /**
         * SUBJECT
         */
        if ($request->new_subject) {

            $subject = Subject::firstOrCreate(
                [
                    'my_class_id' => $request->class_id,
                    'name'        => $request->new_subject,
                ],
                [
                    'slug' => Str::slug($request->new_subject),
                ]
            );

            $subjectId = $subject->id;
        } else {

            $subject = Subject::where('id', $request->subject_id)
                ->where('my_class_id', $request->class_id)
                ->first();

            if (!$subject) {
                return back()
                    ->withInput()
                    ->with('flash_danger', 'The selected subject does not belong to this class.');
            }

            $subjectId = $subject->id;
        }


        /**
         * Convert time
         */
        $from = Carbon::createFromFormat('H:i', $request->time_from);
        $to   = Carbon::createFromFormat('H:i', $request->time_to);

        if ($to->lessThanOrEqualTo($from)) {
            return back()
                ->withInput()
                ->with('flash_danger', 'End time must be after start time.');
        }


        /**
         * Find or create TimeSlot
         */
        $slot = TimeSlot::firstOrCreate(
            [
                'ttr_id'        => $record->id,
                'timestamp_from' => $from->timestamp,
                'timestamp_to'  => $to->timestamp,
            ],
            [
                'hour_from' => $from->format('g'),
                'min_from'  => $from->format('i'),
                'meridian_from' => $from->format('A'),

                'hour_to' => $to->format('g'),
                'min_to'  => $to->format('i'),
                'meridian_to' => $to->format('A'),

                'time_from' => $from->format('g:i A'),
                'time_to'   => $to->format('g:i A'),
            ]
        );


        /**
         * One subject per class/day/time
         */
        TimeTable::updateOrCreate(
            [
                'ttr_id' => $record->id,
                'ts_id'  => $slot->id,
                'day'    => $request->day,
            ],
            [
                'subject_id' => $subjectId,
                'exam_date'  => now()->toDateString(),
                'timestamp_from' => $from->timestamp,
                'timestamp_to'   => $to->timestamp,
            ]
        );

        return redirect()
            ->route('admin-timetable.index', [
                'class_id' => $request->class_id
            ])
            ->with('flash_success', 'Timetable row added successfully.');
    }


    /**
     * UPDATE ROW
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'day'          => 'required|in:Sunday,Monday,Tuesday,Wednesday,Thursday,Friday,Saturday',
            'time_from'    => 'required|date_format:H:i',
            'time_to'      => 'required|date_format:H:i',
            'subject_id'  => 'nullable|integer|exists:subjects,id',
            'new_subject' => 'nullable|string|max:255',
        ]);

        $row = TimeTable::with('time_slot')->findOrFail($id);

        $record = TimeTableRecord::findOrFail($row->ttr_id);

        if ($record->exam_id !== null) {
            abort(403);
        }


        /**
         * Subject
         */
        if ($request->new_subject) {

            $subject = Subject::firstOrCreate(
                [
                    'my_class_id' => $record->my_class_id,
                    'name'        => $request->new_subject,
                ],
                [
                    'slug' => Str::slug($request->new_subject),
                ]
            );

            $subjectId = $subject->id;
        } else {

            $subject = Subject::where('id', $request->subject_id)
                ->where('my_class_id', $record->my_class_id)
                ->first();

            if (!$subject) {
                return back()->with(
                    'flash_danger',
                    'The selected subject does not belong to this class.'
                );
            }

            $subjectId = $subject->id;
        }


        /**
         * Time
         */
        $from = Carbon::createFromFormat('H:i', $request->time_from);
        $to   = Carbon::createFromFormat('H:i', $request->time_to);

        if ($to->lessThanOrEqualTo($from)) {
            return back()->with(
                'flash_danger',
                'End time must be after start time.'
            );
        }


        /**
         * Time slot
         */
        $slot = TimeSlot::firstOrCreate(
            [
                'ttr_id' => $record->id,
                'timestamp_from' => $from->timestamp,
                'timestamp_to' => $to->timestamp,
            ],
            [
                'hour_from' => $from->format('g'),
                'min_from' => $from->format('i'),
                'meridian_from' => $from->format('A'),

                'hour_to' => $to->format('g'),
                'min_to' => $to->format('i'),
                'meridian_to' => $to->format('A'),

                'time_from' => $from->format('g:i A'),
                'time_to' => $to->format('g:i A'),
            ]
        );


        $row->update([
            'ts_id' => $slot->id,
            'day' => $request->day,
            'subject_id' => $subjectId,
            'timestamp_from' => $from->timestamp,
            'timestamp_to' => $to->timestamp,
        ]);

        return back()->with(
            'flash_success',
            'Timetable row updated successfully.'
        );
    }


    /**
     * DELETE
     */
    public function destroy($id)
    {
        $row = TimeTable::findOrFail($id);

        $record = TimeTableRecord::findOrFail($row->ttr_id);

        if ($record->exam_id !== null) {
            abort(403);
        }

        $row->delete();

        return back()->with(
            'flash_success',
            'Timetable row deleted successfully.'
        );
    }


    /**
     * STUDENT / PARENT TIMETABLE
     */
    public function myTimetable(Request $request)
    {
        $user = Auth::user();

        $classIds = collect();

        /**
         * STUDENT
         */
        if (Qs::userIsStudent()) {

            $student = Qs::findStudentRecord($user->id);

            if ($student) {
                $classIds->push($student->my_class_id);
            }
        }

        /**
         * PARENT
         */
        elseif (Qs::userIsParent()) {

            $classIds = StudentRecord::where(
                'my_parent_id',
                $user->id
            )
                ->pluck('my_class_id')
                ->unique();
        }


        $classes = MyClass::whereIn('id', $classIds)
            ->orderBy('name')
            ->get();

        $selectedClassId = $request->get(
            'class_id',
            $classes->first()->id ?? null
        );

        if (!$classIds->contains((int) $selectedClassId)) {
            $selectedClassId = $classIds->first();
        }

        $record = null;
        $rows = collect();

        if ($selectedClassId) {

            $record = TimeTableRecord::where(
                'my_class_id',
                $selectedClassId
            )
                ->whereNull('exam_id')
                ->where('year', Qs::getCurrentSession())
                ->first();

            if ($record) {
                $rows = TimeTable::with([
                    'subject',
                    'time_slot'
                ])
                    ->where('ttr_id', $record->id)
                    ->get();
            }
        }

        return view(
            'pages.support_team.timetables.my_timetable',
            compact(
                'classes',
                'selectedClassId',
                'rows'
            )
        );
    }
}
