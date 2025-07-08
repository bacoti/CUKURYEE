<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\MitraProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class ProfileController extends Controller
{
    // Method untuk menampilkan halaman form
    public function create()
    {
        return Inertia::render('Mitra/CreateProfile');
    }

    // Method untuk menyimpan data form
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'barbershop_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'phone_number' => 'required|string|max:15',
            'description' => 'nullable|string',
        ]);

        // Tambahkan user_id dari user yang sedang login
        $validated['user_id'] = Auth::id();

        MitraProfile::create($validated);

        // Arahkan ke dashboard setelah berhasil membuat profil
        return redirect()->route('dashboard')->with('success', 'Profil barbershop berhasil dibuat!');
    }
}
