<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\JadwalBarber;
use App\Models\LiburBarber;

class Barber extends Model
{
    protected $fillable = ['nama', 'foto'];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function jadwal()
{
    return $this->hasMany(JadwalBarber::class);
}

public function libur()
{
    return $this->hasMany(LiburBarber::class);
}
}
