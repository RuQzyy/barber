<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Barber;

class BarberSeeder extends Seeder
{
    public function run()
    {
        // ❌ jangan truncate
        Barber::query()->delete();

        Barber::insert([
            [
                'nama' => 'Wahid',
                'no_hp' => '6281234567890',
                'is_mentor' => 1,
                'foto' => null,
            ],
            [
                'nama' => 'Fauzan',
                'no_hp' => '6281234567891',
                'is_mentor' => 1,
                'foto' => null,
            ],
            [
                'nama' => 'Rizky',
                'no_hp' => '6281234567892',
                'is_mentor' => 0,
                'foto' => null,
            ],
        ]);
    }
}
