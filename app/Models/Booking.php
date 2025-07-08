<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'mitra_profile_id',
        'service_id',
        'booking_time',
        'total_price',
        'status',
    ];

    // Relasi: Booking ini milik satu customer
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    // Relasi: Booking ini untuk satu barbershop/mitra
    public function mitraProfile()
    {
        return $this->belongsTo(MitraProfile::class);
    }

    // Relasi: Booking ini untuk satu layanan spesifik
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
