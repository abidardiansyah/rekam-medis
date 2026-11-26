<?php

namespace App\Http\Controllers;

use App\Models\Registrasi;
use App\Models\Dokter;
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
        
        $shifts = [
            [
                'id' => 1,
                'name' => 'Shift 1 Morning',
                'start_time' => '08:00',
                'end_time' => '13:00',
                'color' => '#3b82f6'
            ],
            [
                'id' => 2,
                'name' => 'Shift 2 Afternoon',
                'start_time' => '13:00',
                'end_time' => '19:00',
                'color' => '#10b981'
            ]
        ];
        
        $doktersByShift = [];
        foreach ($shifts as $shift) {
            $doktersByShift[$shift['id']] = Dokter::whereHas('jadwalDokters', function($query) use ($hariIni, $shift) {
                    $query->where('hari', $hariIni)
                          ->where('status', 'aktif')
                          ->where('jam_mulai', '>=', $shift['start_time'])
                          ->where('jam_mulai', '<', $shift['end_time']);
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
