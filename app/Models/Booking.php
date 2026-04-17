<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
    'user_id',
    'barber_id',
    'layanan_item_id',
    'tanggal',
    'jam',
    'nomor_antrian',
    'status',
    'payment_status',
    'midtrans_order_id',
    'snap_token',
     'qr_code'
];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function barber()
    {
        return $this->belongsTo(Barber::class);
    }

    public function layanan()
    {
        return $this->belongsTo(LayananItem::class, 'layanan_item_id');
    }

    public function layananItem()
{
    return $this->belongsTo(\App\Models\LayananItem::class, 'layanan_item_id');
}
}
