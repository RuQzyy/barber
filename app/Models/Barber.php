<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\JadwalBarber;
use App\Models\LiburBarber;

class Barber extends Model
{
    protected $fillable = [
        'nama',
        'foto',
        'no_hp',      // 🔥 TAMBAH
        'is_mentor'   // 🔥 TAMBAH
    ];

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

    // 🔥 RELASI KE KURSUS PRIVATE
    public function kursusUsers()
    {
        return $this->hasMany(KursusUser::class, 'mentor_id');
    }
}
