<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeTimeSlotsFullNullable extends Migration
{
    public function up()
    {
        Schema::table('time_slots', function (Blueprint $table) {
            $table->string('full')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('time_slots', function (Blueprint $table) {
            $table->string('full')->nullable(false)->change();
        });
    }
}
