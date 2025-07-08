<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ServiceController extends Controller
{
    // Method untuk menampilkan halaman daftar layanan
    public function index()
    {
        // Ambil profil mitra yang sedang login
        $mitraProfile = Auth::user()->mitraProfile;

        // Ambil semua layanan yang dimiliki oleh profil mitra tersebut
        $services = $mitraProfile->services()->latest()->get();

        return Inertia::render('Mitra/Services/Index', [
            'services' => $services,
        ]);
    }

    // Method untuk menampilkan form tambah layanan
    public function create()
    {
        return Inertia::render('Mitra/Services/Create');
    }

    // Method untuk menyimpan layanan baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|integer|min:0',
            'duration_minutes' => 'required|integer|min:5',
        ]);

        // Hubungkan layanan dengan profil mitra yang sedang login
        Auth::user()->mitraProfile->services()->create($validated);

        return redirect()->route('mitra.services.index')->with('success', 'Layanan berhasil ditambahkan.');
    }

    // Method untuk menampilkan form edit layanan
    public function edit(Service $service)
    {
        // Pastikan mitra hanya bisa mengedit layanannya sendiri
        $this->authorize('update', $service);

        return Inertia::render('Mitra/Services/Edit', [
            'service' => $service,
        ]);
    }

    // Method untuk memperbarui layanan
    public function update(Request $request, Service $service)
    {
        // Pastikan mitra hanya bisa mengupdate layanannya sendiri
        $this->authorize('update', $service);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|integer|min:0',
            'duration_minutes' => 'required|integer|min:5',
        ]);

        $service->update($validated);

        return redirect()->route('mitra.services.index')->with('success', 'Layanan berhasil diperbarui.');
    }

    // Method untuk menghapus layanan
    public function destroy(Service $service)
    {
        // Pastikan mitra hanya bisa menghapus layanannya sendiri
        $this->authorize('delete', $service);

        $service->delete();

        return redirect()->route('mitra.services.index')->with('success', 'Layanan berhasil dihapus.');
    }
}
