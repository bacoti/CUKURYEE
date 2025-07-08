<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MitraProfile;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MitraManagementController extends Controller
{
    /**
     * Menampilkan daftar semua profil mitra untuk manajemen.
     */
    public function index()
    {
        $mitra = MitraProfile::with('user') // Ambil juga data user pemiliknya
            ->orderBy('is_verified', 'asc') // Tampilkan yang belum diverifikasi di atas
            ->latest()
            ->get();

        return Inertia::render('Admin/Mitra/Index', [
            'mitra' => $mitra,
        ]);
    }

    /**
     * Memverifikasi (menyetujui) profil mitra.
     */
    public function verify(MitraProfile $mitraProfile)
    {
        $mitraProfile->update(['is_verified' => true]);

        return back()->with('success', 'Mitra berhasil diverifikasi.');
    }

    /**
     * Menolak dan menghapus profil mitra.
     */
    public function destroy(MitraProfile $mitraProfile)
    {
        // Hapus juga user yang terkait agar tidak menjadi data sampah
        $mitraProfile->user()->delete();
        $mitraProfile->delete();

        return back()->with('success', 'Mitra berhasil ditolak dan dihapus.');
    }
}
