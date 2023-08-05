<?php

namespace Database\Seeders;

use App\Models\Day;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dayName = [
            ["name" => "Senin"],
            ["name" => "Selasa"],
            ["name" => "Rabu"],
            ["name" => "Kamis"],
            ["name" => "Jumat"],
            ["name" => "Sabtu"],
            ["name" => "Minggu"],
        ];

        Day::insert($dayName);
    }
}
