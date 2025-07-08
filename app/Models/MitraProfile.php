<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MitraProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'barbershop_name',
        'address',
        'city',
        'phone_number',
        'description',
        'profile_picture',
        'is_verified',
    ];

    // Relasi: Profil ini dimiliki oleh satu user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Satu profil mitra punya banyak layanan
    public function services()
    {
        return $this->hasMany(Service::class);
    }

    // Relasi: Satu profil mitra punya banyak booking
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
