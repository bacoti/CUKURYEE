<?php

namespace App\Http\Controllers;

use App\Models\MitraProfile;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BarbershopController extends Controller
{
    /**
     * Menampilkan daftar semua barbershop yang sudah terverifikasi.
     */
    public function index(Request $request) // Tambahkan Request $request
    {
        $query = MitraProfile::where('is_verified', true);

        // Filter berdasarkan pencarian nama
        if ($request->has('search')) {
            $query->where('barbershop_name', 'like', '%' . $request->search . '%');
        }

        // Filter berdasarkan kota
        if ($request->has('city') && $request->city !== '') {
            $query->where('city', $request->city);
        }

        $barbershops = $query->latest()->get();

        // Ambil semua kota unik untuk filter dropdown
        $cities = MitraProfile::where('is_verified', true)->select('city')->distinct()->pluck('city');

        return Inertia::render('Barbershop/Index', [
            'barbershops' => $barbershops,
            'cities' => $cities, // Kirim daftar kota
            'filters' => $request->only(['search', 'city']) // Kirim parameter filter
        ]);
    }

    /**
     * Menampilkan detail satu barbershop beserta layanannya.
     */
    public function show(MitraProfile $barbershop)
    {
        // Pastikan hanya profil yang terverifikasi yang bisa diakses
        if (!$barbershop->is_verified) {
            abort(404);
        }

        return Inertia::render('Barbershop/Show', [
            'barbershop' => $barbershop->load('services'), // Eager load services
        ]);
    }
}
