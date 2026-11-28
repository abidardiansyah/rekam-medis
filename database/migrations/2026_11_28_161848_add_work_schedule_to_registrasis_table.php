<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('registrasis', function (Blueprint $table) {
            $table->foreignId('work_schedule_id')->nullable()->after('dokter_id')->constrained('work_schedules')->onDelete('set null');
            $table->foreignId('schedule_assignment_id')->nullable()->after('work_schedule_id')->constrained('schedule_assignments')->onDelete('set null');
            $table->string('no_antrean', 10)->nullable()->after('no_registrasi');
        });
    }

    public function down(): void
    {
        Schema::table('registrasis', function (Blueprint $table) {
            $table->dropForeign(['work_schedule_id']);
            $table->dropForeign(['schedule_assignment_id']);
            $table->dropColumn(['work_schedule_id', 'schedule_assignment_id', 'no_antrean']);
        });
    }
};
