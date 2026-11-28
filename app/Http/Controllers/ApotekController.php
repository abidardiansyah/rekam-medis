<?php

namespace App\Http\Controllers;

use App\Models\Apotek;
use Illuminate\Http\Request;

class ApotekController extends Controller
{
    public function index()
    {
        $query = Apotek::query();
        
        if (request('search_nama_obat')) {
            $query->where('nama_obat', 'like', '%' . request('search_nama_obat') . '%');
        }
        if (request('search_kode_obat')) {
            $query->where('kode_obat', 'like', '%' . request('search_kode_obat') . '%');
        }
        if (request('search_kategori')) {
            $query->where('kategori', 'like', '%' . request('search_kategori') . '%');
        }
        if (request('search_status')) {
            $query->where('status', request('search_status'));
        }
        
        $apoteks = $query->latest()->paginate(10)->withQueryString();
        return view('apotek.index', compact('apoteks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_obat' => 'required|string|unique:apoteks,kode_obat',
            'nama_obat' => 'required|string',
            'kategori' => 'required|string',
            'satuan' => 'required|string',
            'tanggal_kadaluarsa' => 'nullable|date',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:tersedia,habis,kadaluarsa',
        ]);

        Apotek::create($validated);

        return redirect()->route('apotek.index')->with('success', 'Data obat berhasil ditambahkan');
    }

    public function update(Request $request, Apotek $apotek)
    {
        $validated = $request->validate([
            'kode_obat' => 'required|string|unique:apoteks,kode_obat,' . $apotek->id,
            'nama_obat' => 'required|string',
            'kategori' => 'required|string',
            'satuan' => 'required|string',
            'tanggal_kadaluarsa' => 'nullable|date',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:tersedia,habis,kadaluarsa'
        ]);

        $apotek->update($validated);

        return redirect()->route('apotek.index')->with('success', 'Data obat berhasil diupdate');
    }

    public function destroy(Apotek $apotek)
    {
        $apotek->delete();
        return redirect()->route('apotek.index')->with('success', 'Data obat berhasil dihapus');
    }
}
