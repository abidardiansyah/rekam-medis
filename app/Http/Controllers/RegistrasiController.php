<?php

namespace App\Http\Controllers;

use App\Models\Registrasi;
use App\Models\Pasien;
use App\Models\Dokter;
use Illuminate\Http\Request;

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

    public function store(Request $request)
    {
        $request->validate([
            'pasien_id' => 'required|exists:pasiens,id',
            'dokter_id' => 'required|exists:dokters,id',
            'tanggal_kunjungan' => 'required|date',
            'jam_kunjungan' => 'required',
            'jenis_kunjungan' => 'required|in:baru,kontrol'
        ]);
        
        // Generate no_registrasi
        $tanggal = date('Ymd', strtotime($request->tanggal_kunjungan));
        $lastReg = Registrasi::whereDate('tanggal_kunjungan', $request->tanggal_kunjungan)
            ->orderBy('id', 'desc')
            ->first();
        
        $urutan = $lastReg ? intval(substr($lastReg->no_registrasi, -4)) + 1 : 1;
        $noRegistrasi = 'REG-' . $tanggal . '-' . str_pad($urutan, 4, '0', STR_PAD_LEFT);
        
        Registrasi::create([
            'no_registrasi' => $noRegistrasi,
            'pasien_id' => $request->pasien_id,
            'dokter_id' => $request->dokter_id,
            'jadwal_dokter_id' => $request->jadwal_dokter_id,
            'tanggal_kunjungan' => $request->tanggal_kunjungan,
            'jam_kunjungan' => $request->jam_kunjungan,
            'keluhan' => $request->keluhan,
            'jenis_kunjungan' => $request->jenis_kunjungan,
            'status' => 'menunggu'
        ]);
        
        return redirect()->route('registrasi.index')->with('success', 'Registrasi berhasil ditambahkan');
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
