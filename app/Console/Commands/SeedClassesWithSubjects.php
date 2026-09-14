<?php

namespace App\Console\Commands;

use App\Models\MyClass;
use App\Services\ClassSubjectSeeder;
use Illuminate\Console\Command;

class SeedClassesWithSubjects extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'classes:seed-subjects';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create the standard classes and give each one its full subject list from config/class_subjects.php';

    /**
     * The classes to create, in this order. Each one must have a
     * matching entry in config/class_subjects.php or it will be
     * created with no subjects.
     *
     * @var array
     */
    protected $classNames = [
        'Cinquième',
        'Première',
        'Quatrième',
        'Seconde',
        'Sixième',
        'Terminale',
        'Terminale melissa',
        'Terminale STMG',
        'Troisième',
    ];

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        foreach ($this->classNames as $name) {
            $class = MyClass::firstOrCreate(['name' => $name]);

            // firstOrCreate already triggers MyClassObserver::created()
            // for brand-new classes, which seeds the subjects. Calling
            // seed() again here is what makes this idempotent - if the
            // class already existed (e.g. created before this command
            // ran, or missing a subject added to the config later),
            // this fills in whatever's missing without touching
            // subjects that are already there.
            $created = ClassSubjectSeeder::seed($class);

            $this->info("{$name}: {$created} subject(s) created.");
        }

        return 0;
    }
}
