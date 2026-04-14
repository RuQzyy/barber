<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    protected $fillable = [
        'kategori',
        'judul',
        'gambar'
    ];

    public function items()
    {
        return $this->hasMany(LayananItem::class);
    }
}
