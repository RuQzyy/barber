<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barber extends Model
{
    protected $fillable = ['nama', 'foto'];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
