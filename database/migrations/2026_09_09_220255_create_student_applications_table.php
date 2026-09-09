<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('student_applications', function (Blueprint $table) {

            $table->id();

            // Application
            $table->string('application_number')->unique();

            // Student information
            $table->string('full_name');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('gender')->nullable();
            $table->string('nationality')->nullable();
            $table->string('place_of_birth')->nullable();
            $table->string('photo')->nullable();

            // Previous/current education
            $table->string('current_school')->nullable();
            $table->string('current_level')->nullable();
            $table->string('previous_school')->nullable();

            // Address
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();

            // Requested program
            $table->string('program')->nullable();
            $table->string('requested_level')->nullable();
            $table->string('academic_year')->nullable();
            $table->date('desired_start_date')->nullable();

            // Academic information
            $table->text('academic_notes')->nullable();

            // Parent / guardian
            $table->string('parent_name')->nullable();
            $table->string('parent_relationship')->nullable();
            $table->string('parent_phone')->nullable();
            $table->string('parent_whatsapp')->nullable();
            $table->string('parent_email')->nullable();
            $table->string('parent_occupation')->nullable();
            $table->text('parent_address')->nullable();

            // Emergency contact
            $table->string('emergency_name')->nullable();
            $table->string('emergency_relationship')->nullable();
            $table->string('emergency_phone')->nullable();

            // Additional information
            $table->text('medical_notes')->nullable();
            $table->text('additional_comments')->nullable();
            $table->string('how_did_you_hear')->nullable();

            // Application status
            $table->string('status')->default('pending');

            // Admin review
            $table->text('admin_notes')->nullable();
            $table->unsignedInteger('reviewed_by')->nullable();
            $table->timestamp('reviewed_at')->nullable();

            $table->timestamps();

            // Reviewer is an existing user
            $table->foreign('reviewed_by')
                ->references('id')
                ->on('users')
                ->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('student_applications');
    }
};
