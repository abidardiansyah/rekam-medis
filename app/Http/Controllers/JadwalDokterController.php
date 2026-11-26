<?php

namespace App\Http\Controllers;

use App\Models\JadwalDokter;
use App\Models\Dokter;
use Illuminate\Http\Request;

class JadwalDokterController extends Controller
{
    public function index()
    {
        $query = JadwalDokter::with('dokter');
        
        if (request('search_dokter')) {
            $query->whereHas('dokter', function($q) {
                $q->where('nama', 'like', '%' . request('search_dokter') . '%');
            });
        }
        
        if (request('search_hari')) {
            $query->where('hari', 'like', '%' . request('search_hari') . '%');
        }
        
        if (request('search_ruangan')) {
            $query->where('ruangan', 'like', '%' . request('search_ruangan') . '%');
        }
        
        if (request('search_status')) {
            $query->where('status', request('search_status'));
        }
        
        $jadwals = $query->latest()->paginate(10)->withQueryString();
        
        return view('jadwal-dokter.index', compact('jadwals'));
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
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
