<?php

namespace App\Http\Controllers;

use App\Models\Registrasi;
use Illuminate\Http\Request;

class AntreanController extends Controller
{
    public function index()
    {
        $antreans = Registrasi::with(['pasien', 'dokter'])
            ->whereDate('tanggal_kunjungan', date('Y-m-d'))
            ->whereIn('status', ['menunggu', 'dipanggil'])
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
        
        $hariIni = $hariMapping[date('l')];
        
        $dokters = \App\Models\Dokter::whereHas('jadwalDokters', function($query) use ($hariIni) {
                $query->where('hari', $hariIni)
                      ->where('status', 'aktif');
            })
            ->where('status', 'aktif')
            ->orderBy('nama')
            ->get();
        
        return view('antrean.index', compact('antreans', 'dokters'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
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
        $registrasi = Registrasi::findOrFail($id);
        $registrasi->update([
            'status' => $request->status
        ]);
        
        return redirect()->route('antrean.index')->with('success', 'Status antrean berhasil diupdate');
    }

    public function destroy(string $id)
    {
        //
    }
}
