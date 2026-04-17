<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalBarber extends Model
{
    protected $fillable = [
        'barber_id',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'libur'
    ];

    public function barber()
    {
        return $this->belongsTo(Barber::class);
    }
}
