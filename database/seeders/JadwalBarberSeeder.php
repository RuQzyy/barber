<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Barber;
use App\Models\JadwalBarber;

class JadwalBarberSeeder extends Seeder
{
    public function run()
    {
        $barbers = Barber::all();

        $hariKerja = ['senin','selasa','rabu','kamis','jumat','sabtu','minggu'];

        foreach ($barbers as $barber) {

            foreach ($hariKerja as $hari) {

                // 🔥 SET JAM BERDASARKAN HARI
                if ($hari == 'minggu') {
                    $jamMulai = '08:30';
                } else {
                    $jamMulai = '08:00';
                }

                JadwalBarber::updateOrCreate(
                    [
                        'barber_id' => $barber->id,
                        'hari' => $hari
                    ],
                    [
                        'jam_mulai' => $jamMulai,
                        'jam_selesai' => '22:00',
                        'libur' => false
                    ]
                );
            }
        }
    }
}
