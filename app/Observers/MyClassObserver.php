<?php

namespace App\Observers;

use App\Models\MyClass;
use App\Services\ClassSubjectSeeder;

class MyClassObserver
{
    /**
     * Handle the MyClass "created" event.
     *
     * Whenever a new class is created (via this command, the admin
     * UI, tinker, wherever), give it its full subject list if we
     * have one on file for a class with that name.
     *
     * @param  MyClass  $myClass
     * @return void
     */
    public function created(MyClass $myClass)
    {
        ClassSubjectSeeder::seed($myClass);
    }
}

