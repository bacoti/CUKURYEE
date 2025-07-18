<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Service;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class BookingController extends Controller
{
    /**
     * Menampilkan riwayat booking milik user yang sedang login.
     */
    public function index()
    {
        $bookings = \App\Models\Booking::where('customer_id', Auth::id())
            ->with(['service', 'mitraProfile']) // Eager load relasi
            ->latest('booking_time')
            ->get();

        return Inertia::render('Booking/Index', [
            'bookings' => $bookings,
        ]);
    }

    /**
     * Menampilkan halaman form untuk membuat booking baru.
     */
    public function create(Service $service)
    {
        // Kirim data service dan barbershop-nya ke halaman form
        return Inertia::render('Booking/Create', [
            'service' => $service->load('mitraProfile.user'),
        ]);
    }

    /**
     * Menyimpan data booking baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'booking_date' => 'required|date',
            'booking_time' => 'required',
        ]);

        $service = Service::findOrFail($validated['service_id']);
        $mitraProfile = $service->mitraProfile;

        // Gabungkan tanggal dan waktu menjadi satu timestamp
        $bookingTime = Carbon::parse($validated['booking_date'] . ' ' . $validated['booking_time']);

        // Buat record booking baru
        $mitraProfile->bookings()->create([
            'customer_id'       => Auth::id(),
            'service_id'        => $service->id,
            'booking_time'      => $bookingTime,
            'total_price'       => $service->price,
            'status'            => 'pending', // Status awal
        ]);

        return redirect()->route('my-bookings.index')->with('success', 'Booking berhasil dibuat!');
    }

    public function cancel(Booking $booking)
    {
        // Otorisasi: Pastikan hanya pemilik booking yang bisa membatalkan.
        if ($booking->customer_id !== Auth::id()) {
            abort(403, 'AKSI TIDAK DIIZINKAN.');
        }

        // Logika: Hanya booking yang statusnya 'pending' atau 'confirmed' yang bisa dibatalkan.
        if (!in_array($booking->status, ['pending', 'confirmed'])) {
            return back()->with('error', 'Booking yang sudah selesai atau dibatalkan tidak bisa diubah.');
        }

        $booking->update(['status' => 'cancelled']);

        return back()->with('success', 'Booking berhasil dibatalkan.');
    }

    public function getAvailability(Request $request, Service $service)
    {
        $request->validate(['date' => 'required|date']);
        $date = Carbon::parse($request->date);
        $dayOfWeek = $date->dayOfWeekIso; // 1 = Senin, ..., 7 = Minggu

        $mitraProfile = $service->mitraProfile;

        // 1. Cek jadwal kerja mitra
        $availability = \App\Models\MitraAvailability::where('mitra_profile_id', $mitraProfile->id)
            ->where('day_of_week', $dayOfWeek)
            ->where('is_active', true)
            ->first();

        // --- PERBAIKAN DI SINI ---
        // Pastikan jadwal ada DAN jam buka/tutup tidak kosong
        if (!$availability || !$availability->start_time || !$availability->end_time) {
            return response()->json([]); // Jika tidak lengkap, kembalikan array kosong
        }

        // 2. Ambil semua booking yang sudah ada di hari itu
        $existingBookings = \App\Models\Booking::where('mitra_profile_id', $mitraProfile->id)
            ->whereDate('booking_time', $date->toDateString())
            ->where('status', '!=', 'cancelled')
            ->get();

        // 3. Buat semua kemungkinan slot waktu
        $serviceDuration = $service->duration_minutes;
        $period = new CarbonPeriod(
            $date->copy()->setTimeFromTimeString($availability->start_time),
            $serviceDuration . ' minutes',
            $date->copy()->setTimeFromTimeString($availability->end_time)->subMinutes($serviceDuration)
        );

        $availableSlots = [];
        foreach ($period as $slot) {
            // Jangan tampilkan slot di masa lalu untuk hari ini
            if ($slot->isPast()) {
                continue;
            }

            $isBooked = false;
            // 4. Cek apakah slot ini sudah di-booking
            foreach ($existingBookings as $booking) {
                $bookingStart = Carbon::parse($booking->booking_time);
                $bookingEnd = $bookingStart->copy()->addMinutes($booking->service->duration_minutes);
                // Cek apakah slot baru tumpang tindih dengan booking yang ada
                if ($slot->between($bookingStart, $bookingEnd->subMinute())) {
                    $isBooked = true;
                    break;
                }
            }

            if (!$isBooked) {
                $availableSlots[] = $slot->format('H:i');
            }
        }

        return response()->json($availableSlots);
    }
}
