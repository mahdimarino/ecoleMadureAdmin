<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\MyClass;
use App\Models\Subject;
use App\Models\TimeSlot;
use App\Models\TimeTable;
use App\Models\TimeTableRecord;
use App\Helpers\Qs;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class SeedSchoolTimetable extends Command
{
    protected $signature = 'school:timetable-seed
                            {--fresh : Delete existing normal timetable first}';

    protected $description = 'Insert the school timetable into the existing timetable system';


    public function handle()
    {
        /*
        |--------------------------------------------------------------------------
        | TIMETABLE DATA
        |--------------------------------------------------------------------------
        */

        $data = [

            'Cinquième' => [

                ['Sunday', '09:00', '10:00', 'Anglais'],
                ['Monday', '09:00', '10:00', 'Français'],
                ['Tuesday', '09:00', '10:00', 'Physique'],
                ['Wednesday', '09:00', '10:00', 'SVT'],
                ['Thursday', '09:00', '10:00', 'Anglais'],

                ['Sunday', '10:00', '11:00', 'Anglais'],
                ['Monday', '10:00', '11:00', 'Français'],
                ['Tuesday', '10:00', '11:00', 'Français'],
                ['Wednesday', '10:00', '11:00', 'SVT'],
                ['Thursday', '10:00', '11:00', 'Maths'],

                ['Sunday', '11:00', '12:00', 'Français'],
                ['Monday', '11:00', '12:00', 'Histoire géo'],
                ['Tuesday', '11:00', '12:00', 'Français'],
                ['Wednesday', '11:00', '12:00', 'Maths'],
                ['Thursday', '11:00', '12:00', 'Maths'],

                ['Sunday', '13:00', '14:00', 'Maths'],
                ['Monday', '13:00', '14:00', 'Art plastique'],
                ['Tuesday', '13:00', '14:00', 'Atelier'],
                ['Wednesday', '13:00', '14:00', 'Espagnol'],

                ['Sunday', '14:00', '15:00', 'Maths'],
                ['Monday', '14:00', '15:00', 'Histoire géo'],
                ['Tuesday', '14:00', '15:00', 'EPS'],
                ['Wednesday', '14:00', '15:00', 'Espagnol'],

                ['Sunday', '15:00', '16:00', 'Physique'],
                ['Monday', '15:00', '16:00', 'Arabe'],
                ['Tuesday', '15:00', '16:00', 'EPS'],
                ['Wednesday', '15:00', '16:00', 'Islamique'],
            ],


            'Quatrième' => [

                ['Sunday', '09:00', '10:00', 'Français'],
                ['Monday', '09:00', '10:00', 'SVT'],
                ['Tuesday', '09:00', '10:00', 'Français'],
                ['Wednesday', '09:00', '10:00', 'Histoire géo'],
                ['Thursday', '09:00', '10:00', 'Espagnol'],

                ['Sunday', '10:00', '11:00', 'Français'],
                ['Monday', '10:00', '11:00', 'SVT'],
                ['Tuesday', '10:00', '11:00', 'Maths'],
                ['Wednesday', '10:00', '11:00', 'Histoire géo'],
                ['Thursday', '10:00', '11:00', 'Espagnol'],

                ['Sunday', '11:00', '12:00', 'Art plastique'],
                ['Monday', '11:00', '12:00', 'Français'],
                ['Tuesday', '11:00', '12:00', 'Maths'],
                ['Wednesday', '11:00', '12:00', 'Français'],
                ['Thursday', '11:00', '12:00', 'Anglais'],

                ['Sunday', '13:00', '14:00', 'Anglais'],
                ['Monday', '13:00', '14:00', 'Maths'],
                ['Tuesday', '13:00', '14:00', 'Maths'],
                ['Wednesday', '13:00', '14:00', 'Maths'],

                ['Sunday', '14:00', '15:00', 'Anglais'],
                ['Monday', '14:00', '15:00', 'Islamique'],
                ['Tuesday', '14:00', '15:00', 'EPS'],
                ['Wednesday', '14:00', '15:00', 'Physique'],

                ['Sunday', '15:00', '16:00', 'Arabe'],
                ['Monday', '15:00', '16:00', 'Atelier'],
                ['Tuesday', '15:00', '16:00', 'EPS'],
                ['Wednesday', '15:00', '16:00', 'Physique'],
            ],


            'Troisième' => [

                ['Sunday', '09:00', '10:00', 'Maths'],
                ['Monday', '09:00', '10:00', 'SVT'],
                ['Tuesday', '09:00', '10:00', 'Anglais'],
                ['Wednesday', '09:00', '10:00', 'Français'],
                ['Thursday', '09:00', '10:00', 'SVT'],

                ['Sunday', '10:00', '11:00', 'Maths'],
                ['Monday', '10:00', '11:00', 'Histoire géo'],
                ['Tuesday', '10:00', '11:00', 'Anglais'],
                ['Wednesday', '10:00', '11:00', 'Français'],
                ['Thursday', '10:00', '11:00', 'Français'],

                ['Sunday', '11:00', '12:00', 'Français'],
                ['Monday', '11:00', '12:00', 'Atelier'],
                ['Tuesday', '11:00', '12:00', 'Espagnol'],
                ['Wednesday', '11:00', '12:00', 'EPS'],
                ['Thursday', '11:00', '12:00', 'Français'],

                ['Sunday', '13:00', '14:00', 'Histoire géo'],
                ['Monday', '13:00', '14:00', 'Anglais'],
                ['Tuesday', '13:00', '14:00', 'EPS'],
                ['Wednesday', '13:00', '14:00', 'Atelier'],

                ['Sunday', '14:00', '15:00', 'Maths'],
                ['Monday', '14:00', '15:00', 'Physique'],
                ['Tuesday', '14:00', '15:00', 'Maths'],
                ['Wednesday', '14:00', '15:00', 'Arabe'],

                ['Sunday', '15:00', '16:00', 'Art plastique'],
                ['Monday', '15:00', '16:00', 'Physique'],
                ['Tuesday', '15:00', '16:00', 'Maths'],
                ['Wednesday', '15:00', '16:00', 'Espagnol'],
            ],


            'Seconde' => [

                ['Sunday', '09:00', '10:00', 'SVT'],
                ['Monday', '09:00', '10:00', 'Physique'],
                ['Tuesday', '09:00', '10:00', 'Maths'],
                ['Wednesday', '09:00', '10:00', 'Maths'],
                ['Thursday', '09:00', '10:00', 'Maths'],

                ['Sunday', '10:00', '11:00', 'SVT'],
                ['Monday', '10:00', '11:00', 'Français'],
                ['Tuesday', '10:00', '11:00', 'SES'],
                ['Wednesday', '10:00', '11:00', 'Maths'],
                ['Thursday', '10:00', '11:00', 'Maths'],

                ['Sunday', '11:00', '12:00', 'Anglais'],
                ['Monday', '11:00', '12:00', 'Art plastique'],
                ['Tuesday', '11:00', '12:00', 'Atelier'],
                ['Wednesday', '11:00', '12:00', 'Français'],
                ['Thursday', '11:00', '12:00', 'Espagnol'],

                ['Sunday', '13:00', '14:00', 'Français'],
                ['Monday', '13:00', '14:00', 'Arabe'],
                ['Tuesday', '13:00', '14:00', 'Espagnol'],
                ['Wednesday', '13:00', '14:00', 'Français'],
                ['Thursday', '13:00', '14:00', 'Anglais'],

                ['Sunday', '14:00', '15:00', 'Islamique'],
                ['Monday', '14:00', '15:00', 'EPS'],
                ['Tuesday', '14:00', '15:00', 'Histoire géo'],
                ['Wednesday', '14:00', '15:00', 'Physique'],

                ['Sunday', '15:00', '16:00', 'Anglais'],
                ['Monday', '15:00', '16:00', 'EPS'],
                ['Tuesday', '15:00', '16:00', 'Histoire géo'],
                ['Wednesday', '15:00', '16:00', 'Physique'],
            ],


            'Première' => [

                ['Sunday', '09:00', '10:00', 'Français'],
                ['Monday', '09:00', '10:00', 'Histoire géo'],
                ['Tuesday', '09:00', '10:00', 'SES'],
                ['Wednesday', '09:00', '10:00', 'Français'],

                ['Sunday', '10:00', '11:00', 'Français'],
                ['Monday', '10:00', '11:00', 'MA : SVT PHYSIQUE'],
                ['Tuesday', '10:00', '11:00', 'Maths'],
                ['Wednesday', '10:00', '11:00', 'ES'],
                ['Thursday', '10:00', '11:00', 'SES'],
                ['Saturday', '10:00', '11:00', 'Français'],

                ['Sunday', '11:00', '12:00', 'Anglais'],
                ['Monday', '11:00', '12:00', 'MA : SVT PHYSIQUE'],
                ['Tuesday', '11:00', '12:00', 'Maths'],
                ['Wednesday', '11:00', '12:00', 'Histoire géo'],
                ['Thursday', '11:00', '12:00', 'SES'],

                ['Tuesday', '12:00', '13:00', 'ES'],

                ['Sunday', '13:00', '14:00', 'MA : SVT PHYSIQUE'],
                ['Monday', '13:00', '14:00', 'MA : SVT PHYSIQUE'],
                ['Tuesday', '13:00', '14:00', 'Anglais'],
                ['Wednesday', '13:00', '14:00', 'Anglais'],
                ['Thursday', '13:00', '14:00', 'Maths'],

                ['Sunday', '14:00', '15:00', 'Histoire géo'],
                ['Monday', '14:00', '15:00', 'EPS'],
                ['Tuesday', '14:00', '15:00', 'Français'],
                ['Wednesday', '14:00', '15:00', 'Maths'],

                ['Sunday', '15:00', '16:00', 'EPS'],
                ['Monday', '15:00', '16:00', 'Français'],
                ['Tuesday', '15:00', '16:00', 'Arabe'],
            ],


            'Terminale' => [

                ['Sunday', '09:00', '10:00', 'Spé'],
                ['Monday', '09:00', '10:00', 'Histoire géo'],
                ['Tuesday', '09:00', '10:00', 'Spé'],
                ['Wednesday', '09:00', '10:00', 'ES'],
                ['Saturday', '09:00', '10:00', 'Français'],

                ['Sunday', '10:00', '11:00', 'Spé'],
                ['Monday', '10:00', '11:00', 'MA : SVT PHYSIQUE'],
                ['Tuesday', '10:00', '11:00', 'Spé'],
                ['Wednesday', '10:00', '11:00', 'Maths'],
                ['Thursday', '10:00', '11:00', 'Maths'],
                ['Saturday', '10:00', '11:00', 'Français'],

                ['Sunday', '11:00', '12:00', 'Spé'],
                ['Monday', '11:00', '12:00', 'MA : SVT PHYSIQUE'],
                ['Tuesday', '11:00', '12:00', 'Spé'],
                ['Wednesday', '11:00', '12:00', 'Maths'],
                ['Thursday', '11:00', '12:00', 'Maths'],
                ['Saturday', '11:00', '12:00', 'Anglais'],

                ['Thursday', '12:00', '13:00', 'Anglais'],

                ['Sunday', '13:00', '14:00', 'Maths'],
                ['Monday', '13:00', '14:00', 'MA : SVT PHYSIQUE'],
                ['Tuesday', '13:00', '14:00', 'ES'],
                ['Wednesday', '13:00', '14:00', 'Histoire géo'],
                ['Thursday', '13:00', '14:00', 'Arabe'],

                ['Sunday', '14:00', '15:00', 'Maths'],
                ['Monday', '14:00', '15:00', 'EPS'],
                ['Tuesday', '14:00', '15:00', 'Philo'],
                ['Wednesday', '14:00', '15:00', 'Français'],
                ['Thursday', '14:00', '15:00', 'Philo'],

                ['Sunday', '15:00', '16:00', 'Histoire géo'],
                ['Monday', '15:00', '16:00', 'EPS'],
                ['Tuesday', '15:00', '16:00', 'Philo'],
                ['Wednesday', '15:00', '16:00', 'Français'],
                ['Thursday', '15:00', '16:00', 'Philo'],
            ],


            'Sixième' => [

                ['Sunday', '09:00', '10:00', 'Histoire géo'],
                ['Monday', '09:00', '10:00', 'Maths'],
                ['Tuesday', '09:00', '10:00', 'Espagnol'],
                ['Wednesday', '09:00', '10:00', 'Maths'],
                ['Thursday', '09:00', '10:00', 'Atelier'],

                ['Sunday', '10:00', '11:00', 'Histoire géo'],
                ['Monday', '10:00', '11:00', 'Maths'],
                ['Tuesday', '10:00', '11:00', 'Espagnol'],
                ['Wednesday', '10:00', '11:00', 'Maths'],
                ['Thursday', '10:00', '11:00', 'Anglais'],

                ['Sunday', '11:00', '12:00', 'Physique'],
                ['Monday', '11:00', '12:00', 'Anglais'],
                ['Tuesday', '11:00', '12:00', 'Anglais'],
                ['Wednesday', '11:00', '12:00', 'SVT'],
                ['Thursday', '11:00', '12:00', 'Physique'],

                ['Sunday', '13:00', '14:00', 'Français'],
                ['Monday', '13:00', '14:00', 'Français'],
                ['Tuesday', '13:00', '14:00', 'Français'],
                ['Wednesday', '13:00', '14:00', 'Arabe'],

                ['Sunday', '14:00', '15:00', 'Français'],
                ['Monday', '14:00', '15:00', 'Français'],
                ['Tuesday', '14:00', '15:00', 'EPS'],
                ['Wednesday', '14:00', '15:00', 'Islamique'],

                ['Sunday', '15:00', '16:00', 'Maths'],
                ['Monday', '15:00', '16:00', 'SVT'],
                ['Tuesday', '15:00', '16:00', 'EPS'],
                ['Wednesday', '15:00', '16:00', 'Art plastique'],
            ],


            'Terminale STMG' => [

                ['Sunday', '09:00', '10:00', 'Mercatique'],
                ['Monday', '09:00', '10:00', 'Management'],
                ['Tuesday', '09:00', '10:00', 'Séance de gestion et numérique'],

                ['Sunday', '10:00', '11:00', 'Mercatique'],
                ['Monday', '10:00', '11:00', 'Mercatique'],
                ['Tuesday', '10:00', '11:00', 'Maths'],

                ['Sunday', '11:00', '12:00', 'Management'],
                ['Monday', '11:00', '12:00', 'Séance de gestion et numérique'],
                ['Tuesday', '11:00', '12:00', 'Mercatique'],
                ['Wednesday', '11:00', '12:00', 'Maths'],
                ['Thursday', '11:00', '12:00', 'Anglais'],

                ['Tuesday', '12:00', '13:00', 'Droit et économique'],
                ['Saturday', '12:00', '13:00', 'Anglais'],

                ['Sunday', '13:00', '14:00', 'Droit et économique'],
                ['Monday', '13:00', '14:00', 'Droit et économique'],
                ['Tuesday', '13:00', '14:00', 'Histoire géo'],
                ['Wednesday', '13:00', '14:00', 'Arabe'],

                ['Sunday', '14:00', '15:00', 'Droit et économique'],
                ['Monday', '14:00', '15:00', 'EPS'],
                ['Tuesday', '14:00', '15:00', 'Philo'],
                ['Wednesday', '14:00', '15:00', 'Management'],
                ['Thursday', '14:00', '15:00', 'Philo'],

                ['Sunday', '15:00', '16:00', 'Histoire géo'],
                ['Monday', '15:00', '16:00', 'EPS'],
                ['Tuesday', '15:00', '16:00', 'Philo'],
                ['Wednesday', '15:00', '16:00', 'Management'],
                ['Thursday', '15:00', '16:00', 'Philo'],
            ],


            'Terminale melissa' => [

                ['Sunday', '09:00', '10:00', 'Spé'],
                ['Monday', '09:00', '10:00', 'Spé'],
                ['Tuesday', '09:00', '10:00', 'ES'],
                ['Wednesday', '09:00', '10:00', 'Français'],

                ['Sunday', '10:00', '11:00', 'Spé'],
                ['Monday', '10:00', '11:00', 'Spé'],
                ['Tuesday', '10:00', '11:00', 'Spé Anglais'],
                ['Wednesday', '10:00', '11:00', 'Maths'],
                ['Thursday', '10:00', '11:00', 'Français'],

                ['Sunday', '11:00', '12:00', 'Spé'],
                ['Monday', '11:00', '12:00', 'Spé'],
                ['Tuesday', '11:00', '12:00', 'Spé Anglais'],
                ['Wednesday', '11:00', '12:00', 'Maths'],
                ['Thursday', '11:00', '12:00', 'Anglais'],

                ['Thursday', '12:00', '13:00', 'Anglais'],

                ['Sunday', '13:00', '14:00', 'Spé'],
                ['Monday', '13:00', '14:00', 'Anglais'],
                ['Tuesday', '13:00', '14:00', 'ES'],
                ['Wednesday', '13:00', '14:00', 'Histoire géo'],
                ['Thursday', '13:00', '14:00', 'Arabe'],
                ['Saturday', '13:00', '14:00', 'Géopolitique'],

                ['Sunday', '14:00', '15:00', 'Spé'],
                ['Monday', '14:00', '15:00', 'Anglais'],
                ['Tuesday', '14:00', '15:00', 'EPS'],
                ['Wednesday', '14:00', '15:00', 'Français'],
                ['Thursday', '14:00', '15:00', 'Français'],
                ['Saturday', '14:00', '15:00', 'Géopolitique'],

                ['Sunday', '15:00', '16:00', 'Histoire géo'],
                ['Monday', '15:00', '16:00', 'EPS'],
                ['Tuesday', '15:00', '16:00', 'Français'],
                ['Wednesday', '15:00', '16:00', 'Français'],
                ['Thursday', '15:00', '16:00', 'Philo'],
            ],
        ];


        /*
        |--------------------------------------------------------------------------
        | INSERT
        |--------------------------------------------------------------------------
        */

        foreach ($data as $className => $rows) {

            $class = MyClass::whereRaw(
                'LOWER(name) = ?',
                [mb_strtolower($className)]
            )->first();

            if (!$class) {

                $this->warn(
                    "Class not found: {$className}"
                );

                continue;
            }


            $this->info(
                "Processing: {$class->name}"
            );


            /*
             * Timetable record
             */
            $record = TimeTableRecord::firstOrCreate(
                [
                    'my_class_id' => $class->id,
                    'exam_id' => null,
                    'year' => Qs::getCurrentSession(),
                ],
                [
                    'name' => 'Normal Timetable - ' . $class->name,
                ]
            );


            /*
             * Fresh
             */
            if ($this->option('fresh')) {

                TimeTable::where('ttr_id', $record->id)->delete();

                TimeSlot::where('ttr_id', $record->id)->delete();
            }


            foreach ($rows as $item) {

                [$day, $fromTime, $toTime, $subjectName] = $item;


                /*
                 * Subject
                 */
                $subject = Subject::firstOrCreate(
                    [
                        'my_class_id' => $class->id,
                        'name' => $subjectName,
                    ],
                    [
                        'slug' => Str::slug($subjectName),
                    ]
                );


                /*
                 * Time
                 */
                $from = Carbon::createFromFormat(
                    'H:i',
                    $fromTime
                );

                $to = Carbon::createFromFormat(
                    'H:i',
                    $toTime
                );


                /*
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


                /*
                 * Timetable row
                 */
                TimeTable::updateOrCreate(
                    [
                        'ttr_id' => $record->id,
                        'ts_id' => $slot->id,
                        'day' => $day,
                    ],
                    [
                        'subject_id' => $subject->id,
                        'exam_date' => null,
                        'timestamp_from' => $from->timestamp,
                        'timestamp_to' => $to->timestamp,
                    ]
                );
            }
        }


        $this->info('');
        $this->info('Timetable inserted successfully.');

        return Command::SUCCESS;
    }
}
