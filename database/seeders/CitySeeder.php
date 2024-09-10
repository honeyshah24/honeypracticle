<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            ['cityName' => 'Amd', 'stateId' => 3], 
            ['cityName' => 'Gn', 'stateId' => 3], 
            ['cityName' => 'vadodara', 'stateId' => 3],
            ['cityName' => 'Modasa', 'stateId' => 3],
            ['cityName' => 'Jaipur', 'stateId' => 4],
            ['cityName' => 'Jodhpur', 'stateId' => 4],
        ];

        // Insert cities into the database
        DB::table('cities')->insert($cities);
    }
}
