<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HobbySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hobbies = [
            ['hobbyName' => 'Reading'],
            ['hobbyName' => 'Traveling'],
            ['hobbyName' => 'Music'],
            ['hobbyName' => 'Sports'],
            ['hobbyName' => 'Painting'],
            ['hobbyName' => 'Writing'],
            ['hobbyName' => 'Gaming'],
        ];

        // Insert hobbies into the database
        DB::table('hobbies')->insert($hobbies);
    }
}
