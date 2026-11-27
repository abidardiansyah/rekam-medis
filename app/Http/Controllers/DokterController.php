<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use Illuminate\Http\Request;

class DokterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Dokter::query();
        
        if (request('search_nama')) {
            $query->where('nama', 'like', '%' . request('search_nama') . '%');
        }
        if (request('search_spesialisasi')) {
            $query->where('spesialisasi', 'like', '%' . request('search_spesialisasi') . '%');
        }
        if (request('search_no_sip')) {
            $query->where('no_sip', 'like', '%' . request('search_no_sip') . '%');
        }
        if (request('search_telepon')) {
            $query->where('telepon', 'like', '%' . request('search_telepon') . '%');
        }
        if (request('search_status')) {
            $query->where('status', request('search_status'));
        }
        
        $dokters = $query->latest()->paginate(10)->withQueryString();
        return view('dokter.index', compact('dokters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'spesialisasi' => 'required|string|max:255',
            'no_sip' => 'required|string|unique:dokters,no_sip',
            'telepon' => 'required|string|max:20',
            'email' => 'required|email|unique:dokters,email',
            'alamat' => 'nullable|string',
            'foto' => 'nullable|image|max:2048',
            'status' => 'required|in:aktif,nonaktif'
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('dokter', 'public');
        }

        Dokter::create($validated);

        return redirect()->route('dokter.index')->with('success', 'Data dokter berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Dokter $dokter)
    {
        return view('dokter.show', compact('dokter'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dokter $dokter)
    {
        return view('dokter.edit', compact('dokter'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dokter $dokter)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'spesialisasi' => 'required|string|max:255',
            'no_sip' => 'required|string|unique:dokters,no_sip,' . $dokter->id,
            'telepon' => 'required|string|max:20',
            'email' => 'required|email|unique:dokters,email,' . $dokter->id,
            'alamat' => 'nullable|string',
            'foto' => 'nullable|image|max:2048',
            'status' => 'required|in:aktif,nonaktif'
        ]);

        if ($request->hasFile('foto')) {
            if ($dokter->foto) {
                \Storage::disk('public')->delete($dokter->foto);
            }
            $validated['foto'] = $request->file('foto')->store('dokter', 'public');
        }

        $dokter->update($validated);

        return redirect()->route('dokter.index')->with('success', 'Data dokter berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dokter $dokter)
    {
        if ($dokter->foto) {
            \Storage::disk('public')->delete($dokter->foto);
        }
        
        $dokter->delete();
        
        return redirect()->route('dokter.index')->with('success', 'Data dokter berhasil dihapus');
    }
}
