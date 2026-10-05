<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParentNotificationsTable extends Migration
{
    public function up()
    {
        Schema::create('parent_notifications', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('parent_id');
            $table->unsignedInteger('student_id')->nullable();
            $table->unsignedInteger('attendance_id')->nullable();

            $table->string('type')->default('student_absence');
            $table->string('title');
            $table->text('message');

            $table->timestamp('read_at')->nullable();

            $table->timestamps();

            $table->index('parent_id');
            $table->index('student_id');
            $table->index('attendance_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('parent_notifications');
    }
}
