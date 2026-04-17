<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LiburBarber extends Model
{
    protected $fillable = [
        'barber_id',
        'tanggal',
        'keterangan'
    ];

    public function barber()
    {
        return $this->belongsTo(Barber::class);
    }
}
