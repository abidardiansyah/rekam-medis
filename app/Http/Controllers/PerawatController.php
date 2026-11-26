<?php

namespace App\Http\Controllers;

use App\Models\Perawat;
use Illuminate\Http\Request;

class PerawatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Perawat::query();
        
        if (request('search_nama')) {
            $query->where('nama', 'like', '%' . request('search_nama') . '%');
        }
        if (request('search_no_str')) {
            $query->where('no_str', 'like', '%' . request('search_no_str') . '%');
        }
        if (request('search_telepon')) {
            $query->where('telepon', 'like', '%' . request('search_telepon') . '%');
        }
        if (request('search_email')) {
            $query->where('email', 'like', '%' . request('search_email') . '%');
        }
        if (request('search_status')) {
            $query->where('status', request('search_status'));
        }
        
        $perawats = $query->latest()->paginate(10)->withQueryString();
        return view('perawat.index', compact('perawats'));
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
