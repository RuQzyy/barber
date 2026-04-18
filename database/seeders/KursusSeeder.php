<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kursus;

class KursusSeeder extends Seeder
{
    public function run(): void
    {
        Kursus::truncate(); // reset data biar bersih

        Kursus::insert([

            [
                'nama_kursus' => 'Paket A',
                'harga' => 1500000,
                'jumlah_pertemuan' => 6,
                'deskripsi' => "Free Class 1 Hari",
                'materi' => "Dasar Haircut\nPengenalan Alat\nTeknik Dasar Fade",
                'wa_group' => 'https://chat.whatsapp.com/REGULER_A',
                'gambar' => null,
                'is_rekomendasi' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'nama_kursus' => 'Paket B',
                'harga' => 2000000,
                'jumlah_pertemuan' => 8,
                'deskripsi' => "Bonus Mesin Cukur\nFree Class 1 Hari",
                'materi' => "Basic Haircut\nMid Fade\nLow Fade\nStyling Rambut",
                'wa_group' => 'https://chat.whatsapp.com/REGULER_B',
                'gambar' => null,
                'is_rekomendasi' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'nama_kursus' => 'Paket C',
                'harga' => 3500000,
                'jumlah_pertemuan' => 12,
                'deskripsi' => "Bonus Mesin Cukur\nKaos Peserta\nFree Class 1 Hari",
                'materi' => "Advanced Fade\nUndercut\nPompadour\nBeard Styling",
                'wa_group' => 'https://chat.whatsapp.com/REGULER_C',
                'gambar' => null,
                'is_rekomendasi' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'nama_kursus' => 'Paket D',
                'harga' => 4500000,
                'jumlah_pertemuan' => 15,
                'deskripsi' => "Mesin Cukur\nCase\nKaos\nFree Class 2 Hari",
                'materi' => "Skin Fade\nTaper Fade\nHair Tattoo\nClient Handling",
                'wa_group' => 'https://chat.whatsapp.com/REGULER_D',
                'gambar' => null,
                'is_rekomendasi' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'nama_kursus' => 'Paket Lengkap',
                'harga' => 6000000,
                'jumlah_pertemuan' => 25,
                'deskripsi' => "Full Alat Barber\nKaos\nFree Class 3 Hari",
                'materi' => "Master Barber Class\nBusiness Barber\nBranding\nCustomer Experience",
                'wa_group' => 'https://chat.whatsapp.com/REGULER_FULL',
                'gambar' => null,
                'is_rekomendasi' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}
