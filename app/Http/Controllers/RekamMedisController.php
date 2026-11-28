<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pasien;
use App\Models\RekamMedis;
use App\Models\Dokter;
use App\Http\Requests\StoreRekamMedisRequest;
use App\Http\Requests\UpdateRekamMedisRequest;
use Carbon\Carbon;

class RekamMedisController extends Controller
{
    public function index()
    {
        return view('rekam-medis.index');
    }

    public function searchPasien(Request $request)
    {
        $query = $request->get('q');
        
        $pasiens = Pasien::where('nama', 'like', "%{$query}%")
            ->orWhere('no_rm', 'like', "%{$query}%")
            ->limit(10)
            ->get()
            ->map(function($pasien) {
                $umur = Carbon::parse($pasien->tanggal_lahir)->age;
                return [
                    'id' => $pasien->id,
                    'no_rm' => $pasien->no_rm,
                    'nama' => $pasien->nama,
                    'tanggal_lahir' => $pasien->tanggal_lahir,
                    'jenis_kelamin' => $pasien->jenis_kelamin,
                    'umur' => $umur,
                    'label' => $pasien->nama,
                    'sublabel' => "{$pasien->no_rm} • {$umur} years • {$pasien->jenis_kelamin}"
                ];
            });

        return response()->json($pasiens);
    }

    public function getPasienDetail($id)
    {
        $pasien = Pasien::findOrFail($id);
        $umur = Carbon::parse($pasien->tanggal_lahir)->age;
        
        $rekamMedis = RekamMedis::where('pasien_id', $id)
            ->with('dokter')
            ->orderBy('tanggal_kunjungan', 'desc')
            ->get();

        return response()->json([
            'pasien' => [
                'id' => $pasien->id,
                'no_rm' => $pasien->no_rm,
                'nama' => $pasien->nama,
                'tanggal_lahir' => $pasien->tanggal_lahir,
                'umur' => $umur,
                'jenis_kelamin' => $pasien->jenis_kelamin,
                'alamat' => $pasien->alamat,
                'no_hp' => $pasien->telepon,
                'telepon' => $pasien->telepon,
                'email' => $pasien->email,
                'golongan_darah' => $pasien->golongan_darah,
                'status' => $pasien->status,
                'total_kunjungan' => $rekamMedis->count()
            ],
            'records' => $rekamMedis
        ]);
    }

    public function show($id)
    {
        $rekamMedis = RekamMedis::with(['pasien', 'dokter'])->findOrFail($id);
        
        // Calculate age
        $umur = Carbon::parse($rekamMedis->pasien->tanggal_lahir)->age;
        
        // Parse resep_obat if it's JSON string
        if (is_string($rekamMedis->resep_obat)) {
            $rekamMedis->resep_obat = json_decode($rekamMedis->resep_obat, true);
        }
        
        // Format response with consistent field names
        return response()->json([
            'id' => $rekamMedis->id,
            'nomor_rekam' => $rekamMedis->record_number,
            'tanggal_kunjungan' => $rekamMedis->tanggal_kunjungan,
            'keluhan_utama' => $rekamMedis->keluhan_utama,
            'tekanan_darah' => $rekamMedis->tekanan_darah,
            'suhu' => (float) $rekamMedis->suhu_badan,
            'nadi' => $rekamMedis->nadi,
            'pernapasan' => $rekamMedis->pernapasan,
            'berat_badan' => $rekamMedis->berat_badan,
            'tinggi_badan' => $rekamMedis->tinggi_badan,
            'bmi' => $rekamMedis->bmi,
            'saturasi_oksigen' => $rekamMedis->saturasi_oksigen,
            'diagnosa' => $rekamMedis->diagnosa,
            'diagnosa_code' => $rekamMedis->diagnosa_code,
            'rencana_tindakan' => $rekamMedis->rencana_tindakan,
            'resep_obat' => $rekamMedis->resep_obat,
            'hasil_lab' => $rekamMedis->hasil_lab,
            'catatan_dokter' => $rekamMedis->catatan_dokter,
            'status' => $rekamMedis->status,
            'pasien' => [
                'id' => $rekamMedis->pasien->id,
                'nama' => $rekamMedis->pasien->nama,
                'no_rm' => $rekamMedis->pasien->no_rm,
                'umur' => $umur,
                'jenis_kelamin' => $rekamMedis->pasien->jenis_kelamin,
            ],
            'dokter' => [
                'id' => $rekamMedis->dokter->id,
                'nama' => $rekamMedis->dokter->nama,
                'spesialisasi' => $rekamMedis->dokter->spesialisasi,
            ]
        ]);
    }

    public function store(StoreRekamMedisRequest $request)
    {
        $data = $request->validated();
        
        // Generate record number
        $lastRecord = RekamMedis::latest('id')->first();
        $nextNumber = $lastRecord ? intval(substr($lastRecord->record_number, 3)) + 1 : 1;
        $data['record_number'] = 'RM-' . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);
        
        // Calculate BMI if height and weight provided
        if (!empty($data['berat_badan']) && !empty($data['tinggi_badan'])) {
            $tinggiMeter = $data['tinggi_badan'] / 100;
            $data['bmi'] = round($data['berat_badan'] / ($tinggiMeter * $tinggiMeter), 1);
        }
        
        $rekamMedis = RekamMedis::create($data);
        
        return response()->json([
            'success' => true,
            'message' => 'Rekam medis berhasil ditambahkan',
            'data' => $rekamMedis->load(['pasien', 'dokter'])
        ]);
    }

    public function getDokters()
    {
        $dokters = Dokter::where('status', 'aktif')->get(['id', 'nama', 'spesialisasi']);
        return response()->json($dokters);
    }

    public function update(UpdateRekamMedisRequest $request, $id)
    {
        $rekamMedis = RekamMedis::findOrFail($id);
        $data = $request->validated();
        
        // Calculate BMI if height and weight provided
        if (!empty($data['berat_badan']) && !empty($data['tinggi_badan'])) {
            $tinggiMeter = $data['tinggi_badan'] / 100;
            $data['bmi'] = round($data['berat_badan'] / ($tinggiMeter * $tinggiMeter), 1);
        }
        
        $rekamMedis->update($data);
        
        return response()->json([
            'success' => true,
            'message' => 'Rekam medis berhasil diperbarui',
            'data' => $rekamMedis->load(['pasien', 'dokter'])
        ]);
    }

    public function destroy($id)
    {
        $rekamMedis = RekamMedis::findOrFail($id);
        $rekamMedis->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Rekam medis berhasil dihapus'
        ]);
    }
}
