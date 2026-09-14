<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('time_table_records', function (Blueprint $table) {
            $table->string('exam_name')->nullable()->after('exam_id');
        });
    }

    public function down(): void
    {
        Schema::table('time_table_records', function (Blueprint $table) {
            $table->dropColumn('exam_name');
        });
    }
};
