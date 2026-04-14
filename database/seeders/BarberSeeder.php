<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Barber;

class BarberSeeder extends Seeder
{
    public function run()
    {
        Barber::insert([
            ['nama' => 'Wahid'],
            ['nama' => 'Fauzan'],
            ['nama' => 'Rizky'],
        ]);
    }
}
