<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\MyClass;
use App\Models\Section;

class CreateSections extends Command
{
    protected $signature = 'sections:create';

    protected $description = 'Create sections 1 to 10 for every existing class';

    public function handle()
    {
        $classes = MyClass::all();

        if ($classes->isEmpty()) {
            $this->warn('No classes found.');
            return Command::SUCCESS;
        }

        foreach ($classes as $class) {

            for ($i = 1; $i <= 10; $i++) {

                Section::firstOrCreate(
                    [
                        'name' => (string) $i,
                        'my_class_id' => $class->id,
                    ],
                    [
                        'active' => 1,
                        'teacher_id' => null,
                    ]
                );
            }

            $this->info(
                "Created sections 1-10 for class: {$class->name} (ID: {$class->id})"
            );
        }

        $this->info('All sections have been created successfully.');

        return Command::SUCCESS;
    }
}
