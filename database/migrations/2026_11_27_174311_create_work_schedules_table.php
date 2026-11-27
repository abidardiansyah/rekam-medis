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
        Schema::create('work_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., "Morning Shift", "Night Shift"
            $table->string('code')->unique(); // e.g., "SHIFT-MORNING"
            $table->time('start_time');
            $table->time('end_time');
            $table->string('color')->default('#3B82F6'); // Hex color for UI
            $table->text('description')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });

        // Pivot table for assigning schedules to staff (dokter/perawat)
        Schema::create('schedule_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_schedule_id')->constrained()->onDelete('cascade');
            $table->morphs('assignable'); // assignable_type (Dokter/Perawat), assignable_id
            $table->enum('day_of_week', ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu']);
            $table->string('room')->nullable();
            $table->integer('quota')->default(0);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            
            $table->unique(['work_schedule_id', 'assignable_type', 'assignable_id', 'day_of_week'], 'schedule_assignment_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedule_assignments');
        Schema::dropIfExists('work_schedules');
    }
};
