<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Galeri;

class GaleriSeeder extends Seeder
{
    public function run(): void
    {
        Galeri::insert([

            [
                'judul' => 'Hasil Cukur Premium',
                'deskripsi' => 'Model haircut modern dengan teknik fade rapi dan presisi.',
                'gambar' => 'galeri/hasil1.jpeg',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'judul' => 'Kegiatan Kursus Barber',
                'deskripsi' => 'Suasana belajar peserta saat praktik langsung bersama mentor.',
                'gambar' => 'galeri/kursus2.jpeg',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'judul' => 'Interior Barbershop',
                'deskripsi' => 'Ruangan nyaman dengan AC dan fasilitas lengkap.',
                'gambar' => 'galeri/suasana.jpeg',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'judul' => 'Hasil Styling Rambut',
                'deskripsi' => 'Finishing styling dengan pomade agar tampil maksimal.',
                'gambar' => 'galeri/hasil4.jpeg',
                'created_at' => now(),
                'updated_at' => now(),
            ],

           
        ]);
    }
}
