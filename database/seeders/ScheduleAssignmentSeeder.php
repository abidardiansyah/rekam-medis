<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ScheduleAssignment;
use App\Models\WorkSchedule;
use App\Models\Dokter;
use App\Models\Perawat;

class ScheduleAssignmentSeeder extends Seeder
{
    public function run(): void
    {
        $schedules = WorkSchedule::all();
        $dokters = Dokter::where('status', 'aktif')->get();
        $perawats = Perawat::where('status', 'aktif')->get();
        
        if ($schedules->isEmpty() || $dokters->isEmpty()) {
            return;
        }

        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        $rooms = ['Ruang 101', 'Ruang 102', 'Ruang 103', 'Ruang 201', 'Ruang 202'];

        // Assign dokter ke shifts
        foreach ($schedules as $schedule) {
            // Assign 3-4 dokter per shift
            $assignedDokters = $dokters->random(min(4, $dokters->count()));
            
            foreach ($assignedDokters as $dokter) {
                // Random 3-5 hari per dokter
                $assignedDays = collect($days)->random(rand(3, 5));
                
                foreach ($assignedDays as $day) {
                    ScheduleAssignment::create([
                        'work_schedule_id' => $schedule->id,
                        'assignable_type' => Dokter::class,
                        'assignable_id' => $dokter->id,
                        'day_of_week' => $day,
                        'room' => $rooms[array_rand($rooms)],
                        'status' => 'active'
                    ]);
                }
            }
        }

        // Assign perawat ke shifts
        if ($perawats->isNotEmpty()) {
            foreach ($schedules as $schedule) {
                $assignedPerawats = $perawats->random(min(3, $perawats->count()));
                
                foreach ($assignedPerawats as $perawat) {
                    $assignedDays = collect($days)->random(rand(4, 6));
                    
                    foreach ($assignedDays as $day) {
                        ScheduleAssignment::create([
                            'work_schedule_id' => $schedule->id,
                            'assignable_type' => Perawat::class,
                            'assignable_id' => $perawat->id,
                            'day_of_week' => $day,
                            'room' => $rooms[array_rand($rooms)],
                            'status' => 'active'
                        ]);
                    }
                }
            }
        }
    }
}
