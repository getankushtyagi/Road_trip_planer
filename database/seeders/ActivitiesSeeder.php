<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActivitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('activities')->insert([
            'road_trip_id' => 1,
            'name' => 'Beach Day',
            'description' => 'Enjoy a day at the beach with friends.',
            'latitude' => 12.3456789,
            'longitude' => 98.7654321,
            'start_time' => '10:00:00',
            'end_time' => '16:00:00',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
