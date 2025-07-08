<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\MitraProfile; // <-- Tambahkan ini

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'mitra' && !$user->mitraProfile) {
            return redirect()->route('mitra.profile.create');
        }

        $barbershops = [];
        // Jika yang login customer, ambil data barbershop
        if ($user->role === 'customer') {
            $barbershops = MitraProfile::where('is_verified', true)->latest()->get();
        }

        return Inertia::render('Dashboard', [
            'barbershops' => $barbershops, // Kirim data ke frontend
        ]);
    }
}
