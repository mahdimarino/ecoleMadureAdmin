<?php

namespace App\Http\Controllers\SupportTeam;

use App\Helpers\Qs;
use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\MyClass;
use App\Models\Subject;
use App\Models\TimeSlot;
use App\Models\TimeTable;
use App\Models\TimeTableRecord;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CalendarController extends Controller
{
    /**
     * Calendar events
     */
    public function events(Request $request)
    {
        $user = Auth::user();

        $start = Carbon::parse($request->start)->startOfDay();
        $end   = Carbon::parse($request->end)->endOfDay();

        $query = TimeTable::with([
            'subject',
            'time_slot',
            'tt_record.my_class',
            'tt_record.exam'
        ]);

        /*
        |--------------------------------------------------------------------------
        | PERMISSIONS
        |--------------------------------------------------------------------------
        */

        // Teacher = only subjects/classes assigned to teacher
        if ($user->user_type === 'teacher') {

            $query->whereHas('subject', function ($q) use ($user) {
                $q->where('teacher_id', $user->id);
            });
        }

        // Student = only his/her class
        elseif ($user->user_type === 'student') {

            $student = Qs::findStudentRecord($user->id);

            if (!$student) {
                return response()->json([]);
            }

            $query->whereHas('tt_record', function ($q) use ($student) {
                $q->where('my_class_id', $student->my_class_id);
            });
        }

        // admin / super_admin = everything

        $rows = $query->get();

        $events = [];

        foreach ($rows as $row) {

            if (!$row->time_slot) {
                continue;
            }

            $className = optional($row->tt_record->my_class)->name ?? 'Class';
            $subjectName = optional($row->subject)->name ?? 'Subject';

            /*
            |--------------------------------------------------------------------------
            | EXAM
            |--------------------------------------------------------------------------
            */

            if ($row->exam_date) {

                $date = Carbon::parse($row->exam_date);

                if (
                    $date->lt($start->copy()->startOfDay()) ||
                    $date->gt($end->copy()->startOfDay())
                ) {
                    continue;
                }

                $eventStart = Carbon::parse(
                    $date->format('Y-m-d') . ' ' . $row->time_slot->time_from
                );

                $eventEnd = Carbon::parse(
                    $date->format('Y-m-d') . ' ' . $row->time_slot->time_to
                );

                $examName = optional($row->tt_record->exam)->name ?? 'Exam';

                $events[] = [
                    'id' => 'exam-' . $row->id,
                    'title' => 'EXAM - ' . $subjectName . ' (' . $className . ')',
                    'start' => $eventStart->format('Y-m-d H:i:s'),
                    'end' => $eventEnd->format('Y-m-d H:i:s'),
                    'color' => '#ef5350',
                    'editable' => false,

                    'extendedProps' => [
                        'row_id' => $row->id,
                        'type' => 'exam',
                        'date' => $date->format('Y-m-d'),
                        'class_id' => $row->tt_record->my_class_id,
                        'class_name' => $className,
                        'subject_id' => $row->subject_id,
                        'subject_name' => $subjectName,
                        'exam_id' => $row->tt_record->exam_id,
                        'exam_name' => $examName,
                    ],
                ];

                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | NORMAL WEEKLY SCHEDULE
            |--------------------------------------------------------------------------
            */

            if ($row->day) {

                $current = $start->copy()->startOfDay();

                while ($current->lte($end)) {

                    if ($current->format('l') === $row->day) {

                        $eventStart = Carbon::parse(
                            $current->format('Y-m-d') . ' ' . $row->time_slot->time_from
                        );

                        $eventEnd = Carbon::parse(
                            $current->format('Y-m-d') . ' ' . $row->time_slot->time_to
                        );

                        $events[] = [
                            'id' => 'schedule-' . $row->id . '-' . $current->format('Y-m-d'),

                            'title' => $subjectName . ' - ' . $className,

                            'start' => $eventStart->format('Y-m-d H:i:s'),
                            'end' => $eventEnd->format('Y-m-d H:i:s'),

                            'color' => '#42a5f5',

                            'editable' => false,

                            'extendedProps' => [
                                'row_id' => $row->id,
                                'type' => 'schedule',
                                'date' => $current->format('Y-m-d'),
                                'class_id' => $row->tt_record->my_class_id,
                                'class_name' => $className,
                                'subject_id' => $row->subject_id,
                                'subject_name' => $subjectName,
                                'exam_id' => null,
                                'exam_name' => null,
                            ],
                        ];
                    }

                    $current->addDay();
                }
            }
        }

        return response()->json($events);
    }


    /**
     * Store calendar event
     */
    public function store(Request $request)
    {
        $request->validate([
            'type'       => 'required|in:schedule,exam',
            'class_id'   => 'required|exists:my_classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'date'       => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time'   => 'required|date_format:H:i|after:start_time',
            'exam_id'    => 'nullable|exists:exams,id',
        ]);

        $this->checkCreatePermission(
            $request->class_id,
            $request->subject_id
        );

        if ($request->type === 'exam' && !$request->exam_id) {
            return response()->json([
                'ok' => false,
                'msg' => 'Please select an exam.'
            ], 422);
        }

        $year = Qs::getCurrentSession();

        DB::transaction(function () use ($request, $year) {

            /*
            |--------------------------------------------------------------------------
            | FIND / CREATE TIMETABLE RECORD
            |--------------------------------------------------------------------------
            */

            if ($request->type === 'exam') {

                $ttr = TimeTableRecord::where('my_class_id', $request->class_id)
                    ->where('exam_id', $request->exam_id)
                    ->where('year', $year)
                    ->first();

                if (!$ttr) {

                    $class = MyClass::findOrFail($request->class_id);
                    $exam  = Exam::findOrFail($request->exam_id);

                    $ttr = TimeTableRecord::create([
                        'name' => $class->name . ' - ' . $exam->name,
                        'my_class_id' => $request->class_id,
                        'exam_id' => $request->exam_id,
                        'year' => $year,
                    ]);
                }
            } else {

                $ttr = TimeTableRecord::where('my_class_id', $request->class_id)
                    ->whereNull('exam_id')
                    ->where('year', $year)
                    ->first();

                if (!$ttr) {

                    $class = MyClass::findOrFail($request->class_id);

                    $ttr = TimeTableRecord::create([
                        'name' => $class->name . ' - Class Schedule',
                        'my_class_id' => $request->class_id,
                        'exam_id' => null,
                        'year' => $year,
                    ]);
                }
            }

            /*
            |--------------------------------------------------------------------------
            | TIME SLOT
            |--------------------------------------------------------------------------
            */

            $from = Carbon::createFromFormat('H:i', $request->start_time);
            $to   = Carbon::createFromFormat('H:i', $request->end_time);

            $timeFrom = $from->format('g:i A');
            $timeTo   = $to->format('g:i A');

            $slot = TimeSlot::where('ttr_id', $ttr->id)
                ->where('time_from', $timeFrom)
                ->where('time_to', $timeTo)
                ->first();

            if (!$slot) {

                $slot = TimeSlot::create([
                    'ttr_id' => $ttr->id,

                    'hour_from' => $from->format('g'),
                    'min_from' => $from->format('i'),
                    'meridian_from' => $from->format('A'),

                    'hour_to' => $to->format('g'),
                    'min_to' => $to->format('i'),
                    'meridian_to' => $to->format('A'),

                    'time_from' => $timeFrom,
                    'time_to' => $timeTo,

                    'timestamp_from' => $from->timestamp,
                    'timestamp_to' => $to->timestamp,

                    'full' => $timeFrom . ' - ' . $timeTo,
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | TIME TABLE ROW
            |--------------------------------------------------------------------------
            */

            $date = Carbon::parse($request->date);

            TimeTable::create([
                'ttr_id' => $ttr->id,
                'ts_id' => $slot->id,
                'subject_id' => $request->subject_id,

                'exam_date' => $request->type === 'exam'
                    ? $date->format('Y-m-d')
                    : null,

                'day' => $request->type === 'schedule'
                    ? $date->format('l')
                    : null,

                'timestamp_from' => strtotime(
                    $date->format('Y-m-d') . ' ' . $timeFrom
                ),

                'timestamp_to' => strtotime(
                    $date->format('Y-m-d') . ' ' . $timeTo
                ),
            ]);
        });

        return response()->json([
            'ok' => true,
            'msg' => 'Calendar event added successfully.'
        ]);
    }


    /**
     * Update event
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'date'       => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time'   => 'required|date_format:H:i|after:start_time',
            'subject_id' => 'required|exists:subjects,id',
            'type'       => 'required|in:schedule,exam',
        ]);

        $row = TimeTable::with([
            'tt_record',
            'subject'
        ])->find($id);

        if (!$row) {
            return response()->json([
                'ok' => false,
                'msg' => 'Timetable record not found. ID: ' . $id,
            ], 404);
        }

        $this->checkEventPermission($row);

        $this->checkCreatePermission(
            $row->tt_record->my_class_id,
            $request->subject_id
        );

        $from = Carbon::createFromFormat('H:i', $request->start_time);
        $to   = Carbon::createFromFormat('H:i', $request->end_time);

        $timeFrom = $from->format('g:i A');
        $timeTo   = $to->format('g:i A');

        $slot = TimeSlot::where('ttr_id', $row->ttr_id)
            ->where('time_from', $timeFrom)
            ->where('time_to', $timeTo)
            ->first();

        if (!$slot) {

            $slot = TimeSlot::create([
                'ttr_id' => $row->ttr_id,

                'hour_from' => $from->format('g'),
                'min_from' => $from->format('i'),
                'meridian_from' => $from->format('A'),

                'hour_to' => $to->format('g'),
                'min_to' => $to->format('i'),
                'meridian_to' => $to->format('A'),

                'time_from' => $timeFrom,
                'time_to' => $timeTo,

                'timestamp_from' => $from->timestamp,
                'timestamp_to' => $to->timestamp,

                'full' => $timeFrom . ' - ' . $timeTo,
            ]);
        }

        $date = Carbon::parse($request->date);

        $row->update([
            'ts_id' => $slot->id,
            'subject_id' => $request->subject_id,

            'exam_date' => $request->type === 'exam'
                ? $date->format('Y-m-d')
                : null,

            'day' => $request->type === 'schedule'
                ? $date->format('l')
                : null,

            'timestamp_from' => strtotime(
                $date->format('Y-m-d') . ' ' . $timeFrom
            ),

            'timestamp_to' => strtotime(
                $date->format('Y-m-d') . ' ' . $timeTo
            ),
        ]);

        return response()->json([
            'ok' => true,
            'msg' => 'Calendar event updated successfully.'
        ]);
    }


    /**
     * Delete event
     */
    public function destroy($id)
    {
        $row = TimeTable::with([
            'tt_record',
            'subject'
        ])->findOrFail($id);

        $this->checkEventPermission($row);

        $row->delete();

        return response()->json([
            'ok' => true,
            'msg' => 'Calendar event deleted successfully.'
        ]);
    }


    /**
     * Permission for creating events
     */
    private function checkCreatePermission($classId, $subjectId)
    {
        $user = Auth::user();

        if (in_array($user->user_type, ['admin', 'super_admin'])) {
            return true;
        }

        if ($user->user_type === 'teacher') {

            $subject = Subject::findOrFail($subjectId);

            if (
                (int) $subject->teacher_id !== (int) $user->id ||
                (int) $subject->my_class_id !== (int) $classId
            ) {
                abort(403, 'You can only manage your own classes.');
            }

            return true;
        }

        abort(403);
    }


    /**
     * Permission for editing/deleting an existing event
     */
    private function checkEventPermission($row)
    {
        $user = Auth::user();

        if (in_array($user->user_type, ['admin', 'super_admin'])) {
            return true;
        }

        if (
            $user->user_type === 'teacher' &&
            $row->subject &&
            (int) $row->subject->teacher_id === (int) $user->id
        ) {
            return true;
        }

        abort(403);
    }
}
