<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use Illuminate\Http\Request;

class PasienController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Pasien::query();
        
        if (request('search_nama')) {
            $query->where('nama', 'like', '%' . request('search_nama') . '%');
        }
        if (request('search_no_rm')) {
            $query->where('no_rm', 'like', '%' . request('search_no_rm') . '%');
        }
        if (request('search_jenis_kelamin')) {
            $query->where('jenis_kelamin', request('search_jenis_kelamin'));
        }
        if (request('search_telepon')) {
            $query->where('telepon', 'like', '%' . request('search_telepon') . '%');
        }
        if (request('search_status')) {
            $query->where('status', request('search_status'));
        }
        
        $pasiens = $query->latest()->paginate(10)->withQueryString();
        return view('pasien.index', compact('pasiens'));
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
