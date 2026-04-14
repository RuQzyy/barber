<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Layanan;
use App\Models\LayananItem;

class LayananSeeder extends Seeder
{
    public function run(): void
    {
        // ================= BARBERSHOP =================
        $barber = Layanan::create([
            'kategori' => 'barbershop',
            'judul' => 'Barbershop'
        ]);

        LayananItem::insert([
            ['layanan_id' => $barber->id, 'nama' => 'Potong Anak', 'value' => '60000'],
            ['layanan_id' => $barber->id, 'nama' => 'Potong Dewasa', 'value' => '70000'],
            ['layanan_id' => $barber->id, 'nama' => 'Full Service', 'value' => '85000'],
            ['layanan_id' => $barber->id, 'nama' => 'Gratis Keramas + Vitamin', 'value' => 'Included'],
        ]);

        // ================= KURSUS =================
        $kursus = Layanan::create([
            'kategori' => 'kursus',
            'judul' => 'Kursus Barber'
        ]);

        LayananItem::insert([
            ['layanan_id' => $kursus->id, 'nama' => 'Paket A - E', 'value' => 'Tersedia'],
            ['layanan_id' => $kursus->id, 'nama' => 'Privat / Reguler', 'value' => 'Fleksibel'],
            ['layanan_id' => $kursus->id, 'nama' => 'Praktik Langsung', 'value' => 'Ya'],
            ['layanan_id' => $kursus->id, 'nama' => 'Garansi Sampai Bisa', 'value' => 'Ya'],
            ['layanan_id' => $kursus->id, 'nama' => 'Sertifikat', 'value' => 'Ada'],
        ]);

        // ================= FASILITAS =================
        $fasilitas = Layanan::create([
            'kategori' => 'fasilitas',
            'judul' => 'Fasilitas'
        ]);

        LayananItem::insert([
            ['layanan_id' => $fasilitas->id, 'nama' => 'Jadwal Fleksibel', 'value' => 'Ya'],
            ['layanan_id' => $fasilitas->id, 'nama' => 'Ruangan AC & Wifi', 'value' => 'Nyaman'],
            ['layanan_id' => $fasilitas->id, 'nama' => 'Mesin Clipper', 'value' => 'Dapat'],
            ['layanan_id' => $fasilitas->id, 'nama' => 'Konsultasi Seumur Hidup', 'value' => 'Ya'],
            ['layanan_id' => $fasilitas->id, 'nama' => 'Pembukuan & Gaji Barber', 'value' => 'Diajarkan'],
        ]);
    }
}
