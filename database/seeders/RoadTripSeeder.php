<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoadTripSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('road_trips')->insert([
            'user_id' => 1,
            'title' => 'Summer Road Trip',
            'starting_point' => 'Delhi, India',
            'destination_point' => 'Mananli, India',
            'start_date' => '2023-06-01',
            'end_date' => '2023-06-10',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
