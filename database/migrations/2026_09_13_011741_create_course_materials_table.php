<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('course_materials', function (Blueprint $table) {
            $table->increments('id');

            $table->string('title');
            $table->text('description')->nullable();

            $table->string('file_name');
            $table->string('file_path');
            $table->string('file_type')->nullable();
            $table->unsignedInteger('file_size')->nullable();

            $table->unsignedInteger('teacher_id');
            $table->unsignedInteger('class_id');

            $table->timestamps();

            $table->foreign('teacher_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('class_id')
                ->references('id')
                ->on('my_classes')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('course_materials');
    }
};
