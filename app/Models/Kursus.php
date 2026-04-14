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
        'deskripsi',
        'gambar',
        'is_rekomendasi'
    ];
}
