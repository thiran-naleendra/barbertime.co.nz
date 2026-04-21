<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('barbers', function (Blueprint $table) {
            $table->time('work_start_time')->default('09:00')->after('sort_order');
            $table->time('work_end_time')->default('18:00')->after('work_start_time');
        });
    }

    public function down(): void
    {
        Schema::table('barbers', function (Blueprint $table) {
            $table->dropColumn(['work_start_time', 'work_end_time']);
        });
    }
};
