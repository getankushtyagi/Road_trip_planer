<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StopsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('stops')->insert([
            'road_trip_id' => 1,
            'name' => 'Rest Stop',
            'description' => 'A quick rest stop along the highway.',
            'latitude' => 12.3456789,
            'longitude' => 98.7654321,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
