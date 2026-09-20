<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddParentRegistrationFieldsToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {

            // Parent registration
            $table->date('registration_date')->nullable();
            $table->integer('number_of_children')->nullable();

            // Previous school / program
            $table->string('previous_school')->nullable();
            $table->string('studied_program')->nullable();
            $table->string('requested_level')->nullable();

            // Student information
            $table->string('student_name')->nullable();
            $table->date('student_date_of_birth')->nullable();
            $table->string('student_place_of_birth')->nullable();
            $table->text('student_address')->nullable();
            $table->string('student_status')->nullable();

            // Academic information
            $table->string('dropped_subject')->nullable();
            $table->string('terminal_specialties')->nullable();
            $table->string('languages')->nullable();

            // Educational needs
            $table->text('educational_needs')->nullable();

            // Activities
            $table->text('extracurricular_activities')->nullable();
            $table->text('interested_clubs')->nullable();

            // Additional information
            $table->string('how_did_you_hear')->nullable();
            $table->text('additional_information')->nullable();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropColumn([
                'registration_date',
                'number_of_children',
                'previous_school',
                'studied_program',
                'requested_level',
                'student_name',
                'student_date_of_birth',
                'student_place_of_birth',
                'student_address',
                'student_status',
                'dropped_subject',
                'terminal_specialties',
                'languages',
                'educational_needs',
                'extracurricular_activities',
                'interested_clubs',
                'how_did_you_hear',
                'additional_information',
            ]);
        });
    }
}
