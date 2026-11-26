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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
