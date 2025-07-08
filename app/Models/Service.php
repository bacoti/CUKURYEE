<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'mitra_profile_id',
        'name',
        'description',
        'price',
        'duration_minutes',
    ];

    // Relasi: Layanan ini dimiliki oleh satu profil mitra
    public function mitraProfile()
    {
        return $this->belongsTo(MitraProfile::class);
    }
}
