<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $states = [
            ['stateName' => 'Gujarat'],
            ['stateName' => 'RJ'],
        ];

        // Insert states into the database
        DB::table('states')->insert($states);
    }
}
