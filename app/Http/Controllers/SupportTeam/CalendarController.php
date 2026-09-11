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
use App\Models\StudentRecord;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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

        // Requested class filter (from the "Classe" selector above the calendar)
        $class_id = $request->class_id;

        /*
        |--------------------------------------------------------------------------
        | PERMISSIONS
        |--------------------------------------------------------------------------
        */

        // Teacher = only subjects/classes assigned to teacher
        if ($user->user_type === 'teacher') {

            $allowed_class_ids = Subject::where('teacher_id', $user->id)
                ->pluck('my_class_id')
                ->unique();

            $query->whereHas('subject', function ($q) use ($user) {
                $q->where('teacher_id', $user->id);
            });

            if ($class_id && $allowed_class_ids->contains((int) $class_id)) {
                $query->whereHas('tt_record', function ($q) use ($class_id) {
                    $q->where('my_class_id', $class_id);
                });
            }
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

        // Parent = only classes his/her children are in
        elseif ($user->user_type === 'parent') {

            $children_class_ids = StudentRecord::where('my_parent_id', $user->id)
                ->pluck('my_class_id')
                ->filter()
                ->unique();

            if ($children_class_ids->isEmpty()) {
                return response()->json([]);
            }

            if ($class_id && $children_class_ids->contains((int) $class_id)) {
                $query->whereHas('tt_record', function ($q) use ($class_id) {
                    $q->where('my_class_id', $class_id);
                });
            } else {
                $query->whereHas('tt_record', function ($q) use ($children_class_ids) {
                    $q->whereIn('my_class_id', $children_class_ids);
                });
            }
        }

        // admin / super_admin = everything, optionally narrowed to one class
        elseif ($class_id) {

            $query->whereHas('tt_record', function ($q) use ($class_id) {
                $q->where('my_class_id', $class_id);
            });
        }

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
    public function update(Request $request, $event_id)
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
        ])->find($event_id);

        if (!$row) {
            return response()->json([
                'ok' => false,
                'msg' => 'Timetable record not found. ID: ' . $event_id,
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
    public function destroy($event_id)
    {
        $row = TimeTable::with([
            'tt_record',
            'subject'
        ])->findOrFail($event_id);

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


    /*
    |--------------------------------------------------------------------------
    | IMPORT SCHEDULE (bulk, per class)
    |--------------------------------------------------------------------------
    */

    /**
     * Classes the current user (teacher/admin) is allowed to import a
     * schedule for.
     */
    private function importableClasses()
    {
        $user = Auth::user();

        if (in_array($user->user_type, ['admin', 'super_admin'])) {
            return MyClass::orderBy('name')->get();
        }

        if ($user->user_type === 'teacher') {
            return Subject::where('teacher_id', $user->id)
                ->with('my_class')
                ->get()
                ->pluck('my_class')
                ->filter()
                ->unique('id')
                ->sortBy('name')
                ->values();
        }

        abort(403);
    }

    /**
     * Step 1 (choose class) + Step 2 (template + upload) page.
     */
    public function importForm(Request $request)
    {
        $classes = $this->importableClasses();

        $d['classes'] = $classes;
        $d['selected_class'] = null;
        $d['subjects'] = collect();

        if ($request->filled('class_id')) {
            $classId = (int) $request->class_id;

            if (!$classes->pluck('id')->contains($classId)) {
                abort(403, 'You can only import a schedule for your own classes.');
            }

            $user = Auth::user();
            $d['selected_class'] = MyClass::findOrFail($classId);

            $subjectsQuery = Subject::where('my_class_id', $classId);
            if ($user->user_type === 'teacher') {
                $subjectsQuery->where('teacher_id', $user->id);
            }
            $d['subjects'] = $subjectsQuery->orderBy('name')->get();
        }

        return view('pages.support_team.timetables.import', $d);
    }

    /**
     * Downloadable starter CSV for the chosen class.
     */
    public function importTemplate(Request $request)
    {
        $request->validate(['class_id' => 'required|exists:my_classes,id']);

        $classes = $this->importableClasses();
        $classId = (int) $request->class_id;

        if (!$classes->pluck('id')->contains($classId)) {
            abort(403, 'You can only import a schedule for your own classes.');
        }

        $user = Auth::user();
        $class = MyClass::findOrFail($classId);

        $subjectsQuery = Subject::where('my_class_id', $classId);
        if ($user->user_type === 'teacher') {
            $subjectsQuery->where('teacher_id', $user->id);
        }
        $subjects = $subjectsQuery->pluck('name');

        $filename = 'schedule_template_' . Str::slug($class->name) . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($subjects) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['day', 'start_time', 'end_time', 'subject']);
            fputcsv($out, ['Monday', '08:00', '09:00', $subjects->first() ?? 'Math']);
            fputcsv($out, ['# valid days: Monday Tuesday Wednesday Thursday Friday Saturday Sunday']);
            fputcsv($out, ['# times use 24h format HH:MM']);
            fputcsv($out, ['# subjects available for this class: ' . $subjects->implode(', ')]);
            fclose($out);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Bulk-import a weekly schedule (CSV) for one class. Each valid row
     * becomes one recurring weekly TimeTable slot (same storage/display
     * mechanism as a single manually-added "Emploi du temps" event).
     */
    public function import(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:my_classes,id',
            'csv_file' => 'required|file|mimes:csv,txt|max:2048',
        ]);

        $classes = $this->importableClasses();
        $classId = (int) $request->class_id;

        if (!$classes->pluck('id')->contains($classId)) {
            abort(403, 'You can only import a schedule for your own classes.');
        }

        $user = Auth::user();
        $class = MyClass::findOrFail($classId);

        $subjectsByName = Subject::where('my_class_id', $classId)
            ->when($user->user_type === 'teacher', function ($q) use ($user) {
                $q->where('teacher_id', $user->id);
            })
            ->get()
            ->keyBy(function ($s) {
                return Str::lower(trim($s->name));
            });

        $validDays = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        $year = Qs::getCurrentSession();

        $handle = fopen($request->file('csv_file')->getRealPath(), 'r');
        fgetcsv($handle); // skip header row

        $created = 0;
        $skipped = [];
        $rowNum = 1;

        DB::beginTransaction();

        try {
            $ttr = TimeTableRecord::where('my_class_id', $classId)
                ->whereNull('exam_id')
                ->where('year', $year)
                ->first();

            if (!$ttr) {
                $ttr = TimeTableRecord::create([
                    'name' => $class->name . ' - Class Schedule',
                    'my_class_id' => $classId,
                    'exam_id' => null,
                    'year' => $year,
                ]);
            }

            while (($row = fgetcsv($handle)) !== false) {
                $rowNum++;

                if (!isset($row[0]) || trim($row[0]) === '' || Str::startsWith(trim($row[0]), '#')) {
                    continue;
                }

                [$day, $startTime, $endTime, $subjectName] = array_pad($row, 4, null);
                $day = ucfirst(strtolower(trim($day ?? '')));
                $subjectKey = Str::lower(trim($subjectName ?? ''));

                if (!in_array($day, $validDays)) {
                    $skipped[] = "Row {$rowNum}: invalid day \"{$day}\"";
                    continue;
                }

                if (
                    !preg_match('/^\d{1,2}:\d{2}$/', trim($startTime ?? '')) ||
                    !preg_match('/^\d{1,2}:\d{2}$/', trim($endTime ?? ''))
                ) {
                    $skipped[] = "Row {$rowNum}: invalid time format (use HH:MM)";
                    continue;
                }

                if (!$subjectsByName->has($subjectKey)) {
                    $skipped[] = "Row {$rowNum}: subject \"{$subjectName}\" not found for this class"
                        . ($user->user_type === 'teacher' ? ' (or not taught by you)' : '');
                    continue;
                }

                try {
                    $from = Carbon::createFromFormat('H:i', trim($startTime));
                    $to = Carbon::createFromFormat('H:i', trim($endTime));
                } catch (\Exception $e) {
                    $skipped[] = "Row {$rowNum}: could not parse times";
                    continue;
                }

                if ($to->lte($from)) {
                    $skipped[] = "Row {$rowNum}: end_time must be after start_time";
                    continue;
                }

                $subject = $subjectsByName->get($subjectKey);
                $timeFrom = $from->format('g:i A');
                $timeTo = $to->format('g:i A');

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

                $exists = TimeTable::where('ttr_id', $ttr->id)
                    ->where('ts_id', $slot->id)
                    ->where('day', $day)
                    ->exists();

                if ($exists) {
                    $skipped[] = "Row {$rowNum}: {$day} {$timeFrom}-{$timeTo} already exists, skipped";
                    continue;
                }

                TimeTable::create([
                    'ttr_id' => $ttr->id,
                    'ts_id' => $slot->id,
                    'subject_id' => $subject->id,
                    'exam_date' => null,
                    'day' => $day,
                    'timestamp_from' => strtotime(now()->format('Y-m-d') . ' ' . $timeFrom),
                    'timestamp_to' => strtotime(now()->format('Y-m-d') . ' ' . $timeTo),
                ]);

                $created++;
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            fclose($handle);
            return back()->with('flash_danger', 'Import failed: ' . $e->getMessage());
        }

        fclose($handle);

        $msg = "{$created} schedule slot(s) imported successfully.";
        if (count($skipped)) {
            $msg .= ' ' . count($skipped) . ' row(s) skipped — see details below.';
        }

        return back()
            ->with($created ? 'flash_success' : 'flash_danger', $msg)
            ->with('import_skipped', $skipped)
            ->with('class_id', $classId);
    }
}
