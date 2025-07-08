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
    public function index()
    {
        $barbershops = MitraProfile::where('is_verified', true)
            ->latest()
            ->get();

        return Inertia::render('Barbershop/Index', [
            'barbershops' => $barbershops,
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
