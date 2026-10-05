<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentAttendancesTable extends Migration
{
    public function up()
    {
        Schema::create('student_attendances', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('student_id');
            $table->date('date');
            $table->string('status')->default('absent');
            $table->text('note')->nullable();
            $table->unsignedInteger('marked_by')->nullable();
            $table->timestamps();

            $table->unique(['student_id', 'date']);
            $table->index('marked_by');
        });
    }

    public function down()
    {
        Schema::dropIfExists('student_attendances');
    }
}
