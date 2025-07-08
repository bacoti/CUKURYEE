<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class BookingController extends Controller
{
    /**
     * Menampilkan daftar booking yang masuk untuk mitra.
     */
    public function index()
    {
        $mitraProfileId = Auth::user()->mitraProfile->id;

        $bookings = Booking::where('mitra_profile_id', $mitraProfileId)
            ->with(['customer', 'service']) // Eager load relasi customer dan service
            ->latest('booking_time')
            ->get();

        return Inertia::render('Mitra/Bookings/Index', [
            'bookings' => $bookings,
        ]);
    }

    /**
     * Memperbarui status sebuah booking.
     */
    public function updateStatus(Request $request, Booking $booking)
    {
        // Otorisasi: Pastikan booking ini milik mitra yang sedang login
        if ($booking->mitra_profile_id !== Auth::user()->mitraProfile->id) {
            abort(403);
        }

        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled',
        ]);

        $booking->update(['status' => $validated['status']]);

        return back()->with('success', 'Status booking berhasil diperbarui.');
    }
}
