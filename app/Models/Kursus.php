<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kursus extends Model
{
    protected $table = 'kursus';

    protected $fillable = [
        'nama_kursus',
        'harga',
        'jumlah_pertemuan',
        'materi',
        'wa_instruktur',
        'wa_group',
        'deskripsi',
        'gambar'
    ];

    public function kursusUsers()
    {
        return $this->hasMany(KursusUser::class);
    }
}
