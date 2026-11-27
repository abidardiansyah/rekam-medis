<?php

namespace App\Http\Controllers;

use App\Models\Registrasi;
use App\Models\Dokter;
use App\Models\WorkSchedule;
use Illuminate\Http\Request;

class AntreanV2Controller extends Controller
{
    public function index(Request $request)
    {
        $date = $request->input('date', date('Y-m-d'));
        
        $antreans = Registrasi::with(['pasien', 'dokter'])
            ->whereDate('tanggal_kunjungan', $date)
            ->orderBy('jam_kunjungan')
            ->get();
        
        $hariMapping = [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu'
        ];
        
        $hariIni = $hariMapping[date('l', strtotime($date))];
        
        $shifts = WorkSchedule::where('status', 'active')
            ->orderBy('start_time')
            ->get()
            ->map(function($schedule) {
                return [
                    'id' => $schedule->id,
                    'name' => $schedule->name,
                    'start_time' => substr($schedule->start_time, 0, 5),
                    'end_time' => substr($schedule->end_time, 0, 5),
                    'color' => $schedule->color
                ];
            })
            ->toArray();
        
        $doktersByShift = [];
        foreach ($shifts as $shift) {
            $doktersByShift[$shift['id']] = Dokter::whereHas('scheduleAssignments', function($query) use ($hariIni, $shift) {
                    $query->where('work_schedule_id', $shift['id'])
                          ->where('day_of_week', $hariIni)
                          ->where('status', 'active');
                })
                ->where('status', 'aktif')
                ->orderBy('nama')
                ->get();
        }
        
        if ($request->wantsJson()) {
            return response()->json([
                'antreans' => $antreans,
                'shifts' => $shifts,
                'doktersByShift' => $doktersByShift
            ]);
        }
        
        return view('antrean.v2', compact('antreans', 'shifts', 'doktersByShift'));
    }
}
