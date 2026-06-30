<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('location.index', [
            'title' => 'Lokasi Rak',
            'locations' => Location::withCount('bookCopies')->latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('location.create', [
            'title' => 'Tambah Lokasi Rak',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'floor' => 'nullable|max:50',
            'aisle' => 'nullable|max:50',
            'shelf_number' => 'nullable|max:50',
        ]);

        \Illuminate\Support\Facades\DB::beginTransaction();
        try {
            Location::create($validate);
            \Illuminate\Support\Facades\DB::commit();
            return to_route('location.index')->withSuccess('Lokasi berhasil ditambahkan');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return to_route('location.create')->withError('Gagal menambahkan lokasi: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Location $location)
    {
        return view('location.show', [
            'title' => 'Detail Lokasi',
            'location' => $location->load('bookCopies.book'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Location $location)
    {
        return view('location.edit', [
            'title' => 'Edit Lokasi Rak',
            'location' => $location,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Location $location)
    {
        $validate = $request->validate([
            'floor' => 'nullable|max:50',
            'aisle' => 'nullable|max:50',
            'shelf_number' => 'nullable|max:50',
        ]);

        \Illuminate\Support\Facades\DB::beginTransaction();
        try {
            $location->update($validate);
            \Illuminate\Support\Facades\DB::commit();
            return to_route('location.index')->withSuccess('Lokasi berhasil diubah');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return to_route('location.edit', $location)->withError('Gagal mengubah lokasi: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Location $location)
    {
        \Illuminate\Support\Facades\DB::beginTransaction();
        try {
            $location->delete();
            \Illuminate\Support\Facades\DB::commit();
            return to_route('location.index')->withSuccess('Lokasi berhasil dihapus');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return to_route('location.index')->withError('Gagal menghapus lokasi: ' . $e->getMessage());
        }
    }
}
