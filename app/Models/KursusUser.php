<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KursusUser extends Model
{
    protected $table = 'kursus_users';

    protected $fillable = [
        'user_id',
        'kursus_id',
        'tipe_kelas',      // 🔥 TAMBAH
        'mentor_id',       // 🔥 TAMBAH
        'payment_status',
        'midtrans_order_id',
        'snap_token',
        'paid_at',
        'nama_peserta',
        'no_hp'
    ];

    public function kursus()
    {
        return $this->belongsTo(Kursus::class);
    }

    // 🔥 RELASI KE USER
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 🔥 RELASI KE MENTOR (BARBER)
    public function mentor()
    {
        return $this->belongsTo(Barber::class, 'mentor_id');
    }
}
