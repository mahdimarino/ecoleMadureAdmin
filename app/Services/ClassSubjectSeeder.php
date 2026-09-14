<?php

namespace App\Services;

use App\Models\MyClass;
use App\Models\Subject;
use Illuminate\Support\Str;

class ClassSubjectSeeder
{
    /**
     * Create any missing Subject rows for the given class, based on
     * config/class_subjects.php. Safe to call repeatedly - subjects
     * that already exist (matched by name) are left untouched, so
     * this never overwrites a subject's assigned teacher.
     *
     * Classes whose name isn't a key in the config are skipped -
     * we don't have a known curriculum to apply to them.
     *
     * @param  MyClass  $class
     * @return int  number of subjects created
     */
    public static function seed(MyClass $class): int
    {
        $subjectNames = config('class_subjects.' . $class->name);

        if (empty($subjectNames)) {
            return 0;
        }

        $created = 0;

        foreach ($subjectNames as $name) {
            $subject = Subject::firstOrNew([
                'my_class_id' => $class->id,
                'name' => $name,
            ]);

            if (!$subject->exists) {
                $subject->slug = Str::slug($name);
                $subject->teacher_id = null;
                $subject->save();
                $created++;
            }
        }

        return $created;
    }
}
