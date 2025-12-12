<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DifficultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $difficulties = [
            ['name' => 'baixa', 'effort_points' => 1],
            ['name' => 'media', 'effort_points' => 4],
            ['name' => 'alta', 'effort_points' => 12],
        ];

        DB::table('difficulties')->insert($difficulties);
    }
}
