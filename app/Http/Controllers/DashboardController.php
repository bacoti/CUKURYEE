<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\MitraProfile; // <-- Tambahkan ini

class DashboardController extends Controller
{
    public function index(Request $request) // Tambahkan Request $request
    {
        $user = Auth::user();

        if ($user->role === 'mitra' && !$user->mitraProfile) {
            return redirect()->route('mitra.profile.create');
        }

        $barbershops = [];
        $cities = [];
        // Jika yang login customer, ambil data barbershop
        if ($user->role === 'customer') {
            // Ambil query builder untuk barbershop yang sudah diverifikasi
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
        }

        return Inertia::render('Dashboard', [
            'barbershops' => $barbershops, // Kirim data hasil filter ke frontend
            'cities' => $cities, // Kirim daftar kota
            'filters' => $request->only(['search', 'city']) // Kirim parameter filter agar tetap di form
        ]);
    }
}
