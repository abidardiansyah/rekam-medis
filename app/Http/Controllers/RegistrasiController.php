<?php

namespace App\Http\Controllers;

use App\Models\Registrasi;
use App\Models\Pasien;
use App\Models\Dokter;
use App\Models\WorkSchedule;
use App\Models\ScheduleAssignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegistrasiController extends Controller
{
    public function index()
    {
        $query = Registrasi::with(['pasien', 'dokter', 'jadwalDokter']);
        
        if (request('search_no_registrasi')) {
            $query->where('no_registrasi', 'like', '%' . request('search_no_registrasi') . '%');
        }
        
        if (request('search_pasien')) {
            $query->whereHas('pasien', function($q) {
                $q->where('nama', 'like', '%' . request('search_pasien') . '%');
            });
        }
        
        if (request('search_dokter')) {
            $query->whereHas('dokter', function($q) {
                $q->where('nama', 'like', '%' . request('search_dokter') . '%');
            });
        }
        
        if (request('search_tanggal')) {
            $query->where('tanggal_kunjungan', request('search_tanggal'));
        }
        
        if (request('search_status')) {
            $query->where('status', request('search_status'));
        }
        
        $registrasis = $query->latest()->paginate(10)->withQueryString();
        
        return view('registrasi.index', compact('registrasis'));
    }

    public function create()
    {
        $pasiens = Pasien::where('status', 'aktif')->orderBy('nama')->get();
        $dokters = Dokter::where('status', 'aktif')->orderBy('nama')->get();
        
        return view('registrasi.create', compact('pasiens', 'dokters'));
    }

    public function getAvailableDoctors(Request $request)
    {
        $tanggal = $request->input('tanggal');
        
        if (!$tanggal) {
            return response()->json(['error' => 'Tanggal required'], 400);
        }
        
        $hariMapping = [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu'
        ];
        
        $hari = $hariMapping[date('l', strtotime($tanggal))];
        
        $shifts = WorkSchedule::where('status', 'active')
            ->orderBy('start_time')
            ->get();
        
        $result = [];
        
        foreach ($shifts as $shift) {
            $dokters = Dokter::whereHas('scheduleAssignments', function($query) use ($hari, $shift) {
                    $query->where('work_schedule_id', $shift->id)
                          ->where('day_of_week', $hari)
                          ->where('status', 'active');
                })
                ->where('status', 'aktif')
                ->with(['scheduleAssignments' => function($query) use ($hari, $shift) {
                    $query->where('work_schedule_id', $shift->id)
                          ->where('day_of_week', $hari)
                          ->where('status', 'active');
                }])
                ->orderBy('nama')
                ->get();
            
            if ($dokters->count() > 0) {
                $result[] = [
                    'shift' => [
                        'id' => $shift->id,
                        'name' => $shift->name,
                        'start_time' => substr($shift->start_time, 0, 5),
                        'end_time' => substr($shift->end_time, 0, 5),
                        'color' => $shift->color
                    ],
                    'dokters' => $dokters->map(function($dokter) {
                        $assignment = $dokter->scheduleAssignments->first();
                        return [
                            'id' => $dokter->id,
                            'nama' => $dokter->nama,
                            'spesialisasi' => $dokter->spesialisasi,
                            'assignment_id' => $assignment->id,
                            'room' => $assignment->room
                        ];
                    })
                ];
            }
        }
        
        return response()->json($result);
    }

    public function getBookedSlots(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'dokter_id' => 'required|exists:dokters,id',
            'work_schedule_id' => 'required|exists:work_schedules,id'
        ]);
        
        $bookedSlots = Registrasi::where('tanggal_kunjungan', $request->tanggal)
            ->where('dokter_id', $request->dokter_id)
            ->where('work_schedule_id', $request->work_schedule_id)
            ->whereIn('status', ['menunggu', 'dipanggil'])
            ->whereNotNull('jam_mulai')
            ->whereNotNull('jam_selesai')
            ->orderBy('jam_mulai')
            ->get(['jam_mulai', 'jam_selesai'])
            ->map(function($booking) {
                return [
                    'start' => substr($booking->jam_mulai, 0, 5),
                    'end' => substr($booking->jam_selesai, 0, 5)
                ];
            });
        
        $workSchedule = WorkSchedule::findOrFail($request->work_schedule_id);
        
        return response()->json([
            'booked_slots' => $bookedSlots,
            'shift_start' => substr($workSchedule->start_time, 0, 5),
            'shift_end' => substr($workSchedule->end_time, 0, 5)
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'pasien_id' => 'required|exists:pasiens,id',
            'dokter_id' => 'required|exists:dokters,id',
            'work_schedule_id' => 'required|exists:work_schedules,id',
            'schedule_assignment_id' => 'required|exists:schedule_assignments,id',
            'tanggal_kunjungan' => 'required|date',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'jenis_kunjungan' => 'required|in:baru,kontrol'
        ]);
        
        DB::beginTransaction();
        
        try {
            // Check for booking conflicts
            $conflict = Registrasi::where('tanggal_kunjungan', $request->tanggal_kunjungan)
                ->where('dokter_id', $request->dokter_id)
                ->where('work_schedule_id', $request->work_schedule_id)
                ->whereIn('status', ['menunggu', 'dipanggil'])
                ->where(function($query) use ($request) {
                    $query->where(function($q) use ($request) {
                        // New booking starts during existing booking
                        $q->where('jam_mulai', '<=', $request->jam_mulai)
                          ->where('jam_selesai', '>', $request->jam_mulai);
                    })->orWhere(function($q) use ($request) {
                        // New booking ends during existing booking
                        $q->where('jam_mulai', '<', $request->jam_selesai)
                          ->where('jam_selesai', '>=', $request->jam_selesai);
                    })->orWhere(function($q) use ($request) {
                        // New booking completely covers existing booking
                        $q->where('jam_mulai', '>=', $request->jam_mulai)
                          ->where('jam_selesai', '<=', $request->jam_selesai);
                    });
                })
                ->exists();
            
            if ($conflict) {
                DB::rollBack();
                return redirect()->back()->withInput()->with('error', 'Waktu yang dipilih bertabrakan dengan booking lain. Silakan pilih waktu yang berbeda.');
            }
            
            // Validate against shift time
            $workSchedule = WorkSchedule::findOrFail($request->work_schedule_id);
            $shiftStart = strtotime($workSchedule->start_time);
            $shiftEnd = strtotime($workSchedule->end_time);
            $bookingStart = strtotime($request->jam_mulai);
            $bookingEnd = strtotime($request->jam_selesai);
            
            if ($bookingStart < $shiftStart || $bookingEnd > $shiftEnd) {
                DB::rollBack();
                return redirect()->back()->withInput()->with('error', 'Waktu booking harus berada dalam jam shift dokter.');
            }
            
            // Generate no_registrasi
            $tanggal = date('Ymd', strtotime($request->tanggal_kunjungan));
            $lastReg = Registrasi::whereDate('tanggal_kunjungan', $request->tanggal_kunjungan)
                ->orderBy('id', 'desc')
                ->first();
            
            $urutan = $lastReg ? intval(substr($lastReg->no_registrasi, -4)) + 1 : 1;
            $noRegistrasi = 'REG-' . $tanggal . '-' . str_pad($urutan, 4, '0', STR_PAD_LEFT);
            
            // Generate no_antrean based on shift
            $shiftPrefix = [
                1 => 'A', // Morning
                2 => 'B', // Afternoon
                3 => 'C'  // Night
            ];
            
            $prefix = $shiftPrefix[$request->work_schedule_id] ?? 'X';
            $lastAntrean = Registrasi::where('tanggal_kunjungan', $request->tanggal_kunjungan)
                ->where('work_schedule_id', $request->work_schedule_id)
                ->whereNotNull('no_antrean')
                ->orderBy('id', 'desc')
                ->first();
            
            $nomorUrut = $lastAntrean ? intval(substr($lastAntrean->no_antrean, 1)) + 1 : 1;
            $noAntrean = $prefix . str_pad($nomorUrut, 3, '0', STR_PAD_LEFT);
            
            // Create registrasi
            Registrasi::create([
                'no_registrasi' => $noRegistrasi,
                'no_antrean' => $noAntrean,
                'pasien_id' => $request->pasien_id,
                'dokter_id' => $request->dokter_id,
                'work_schedule_id' => $request->work_schedule_id,
                'schedule_assignment_id' => $request->schedule_assignment_id,
                'tanggal_kunjungan' => $request->tanggal_kunjungan,
                'jam_kunjungan' => $request->jam_mulai,
                'jam_mulai' => $request->jam_mulai,
                'jam_selesai' => $request->jam_selesai,
                'keluhan' => $request->keluhan,
                'jenis_kunjungan' => $request->jenis_kunjungan,
                'status' => 'menunggu'
            ]);
            
            DB::commit();
            
            return redirect()->route('registrasi.index')->with('success', "Registrasi berhasil! Nomor Antrean: $noAntrean | Waktu: {$request->jam_mulai} - {$request->jam_selesai}");
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan registrasi: ' . $e->getMessage());
        }
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
