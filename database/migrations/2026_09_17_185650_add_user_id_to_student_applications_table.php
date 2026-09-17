<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // The user_id column and foreign key were already
        // created manually because the original migration
        // partially executed.
    }

    public function down()
    {
        Schema::table('student_applications', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
    }
};
