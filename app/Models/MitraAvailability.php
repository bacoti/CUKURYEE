<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MitraAvailability extends Model
{
    protected $fillable = ['mitra_profile_id', 'day_of_week', 'start_time', 'end_time', 'is_active'];
}
