<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LayananItem extends Model
{
   protected $fillable = [
    'layanan_id',
    'nama',
    'value'
];
    public function layanan()
    {
        return $this->belongsTo(Layanan::class);
    }

    public function getValueFormattedAttribute()
{
    if (!is_numeric($this->value)) {
        return $this->value; // untuk "Ya", "Included", dll
    }

    return 'Rp ' . number_format($this->value, 0, ',', '.');
}
}
