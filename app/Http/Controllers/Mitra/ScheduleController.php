<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MitraAvailability; // <-- Import model
use Inertia\Inertia;

class ScheduleController extends Controller
{
    public function index()
    {
        $mitraProfile = Auth::user()->mitraProfile;
        $availabilities = [];
        // Siapkan data untuk 7 hari, ambil dari DB jika ada
        for ($i = 1; $i <= 7; $i++) {
            $availabilities[$i] = MitraAvailability::firstOrNew(
                ['mitra_profile_id' => $mitraProfile->id, 'day_of_week' => $i]
            );
        }

        return Inertia::render('Mitra/Schedule/Index', [
            'availabilities' => $availabilities,
        ]);
    }

    public function store(Request $request)
    {
        $mitraProfile = Auth::user()->mitraProfile;
        $scheduleData = $request->validate([
            'schedule' => 'required|array|size:7',
            'schedule.*.is_active' => 'required|boolean',
            'schedule.*.start_time' => 'nullable|date_format:H:i',
            'schedule.*.end_time' => 'nullable|date_format:H:i|after:schedule.*.start_time',
        ]);

        foreach ($scheduleData['schedule'] as $day => $data) {
            MitraAvailability::updateOrCreate(
                ['mitra_profile_id' => $mitraProfile->id, 'day_of_week' => $day + 1],
                $data
            );
        }

        return back()->with('success', 'Jadwal berhasil diperbarui.');
    }
}
