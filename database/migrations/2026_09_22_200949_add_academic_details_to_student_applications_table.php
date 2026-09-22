<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('student_applications', function (Blueprint $table) {
            $table->string('dropped_subject')->nullable()->after('requested_level');

            $table->json('terminal_specialties')->nullable()->after('dropped_subject');

            $table->json('languages')->nullable()->after('terminal_specialties');
        });
    }

    public function down()
    {
        Schema::table('student_applications', function (Blueprint $table) {
            $table->dropColumn([
                'dropped_subject',
                'terminal_specialties',
                'languages',
            ]);
        });
    }
};
