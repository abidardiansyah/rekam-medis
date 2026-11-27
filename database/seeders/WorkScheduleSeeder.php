<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WorkSchedule;

class WorkScheduleSeeder extends Seeder
{
    public function run(): void
    {
        $schedules = [
            [
                'name' => 'Morning Shift',
                'code' => 'SHIFT-MORNING',
                'start_time' => '08:00:00',
                'end_time' => '14:00:00',
                'color' => '#3B82F6',
                'description' => 'Shift pagi untuk pelayanan umum',
                'status' => 'active'
            ],
            [
                'name' => 'Afternoon Shift',
                'code' => 'SHIFT-AFTERNOON',
                'start_time' => '14:00:00',
                'end_time' => '20:00:00',
                'color' => '#10B981',
                'description' => 'Shift siang untuk pelayanan lanjutan',
                'status' => 'active'
            ],
            [
                'name' => 'Night Shift',
                'code' => 'SHIFT-NIGHT',
                'start_time' => '20:00:00',
                'end_time' => '08:00:00',
                'color' => '#8B5CF6',
                'description' => 'Shift malam untuk pelayanan darurat',
                'status' => 'active'
            ]
        ];

        foreach ($schedules as $schedule) {
            WorkSchedule::create($schedule);
        }
    }
}
