<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class MakeSubjectsTeacherIdNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * Using a raw statement instead of Schema::table(...)->change()
     * to avoid requiring the doctrine/dbal package.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE `subjects` MODIFY `teacher_id` INT UNSIGNED NULL');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE `subjects` MODIFY `teacher_id` INT UNSIGNED NOT NULL');
    }
}
