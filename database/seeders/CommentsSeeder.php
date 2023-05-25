<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('comments')->insert([
            'road_trip_id' => 1,
            'user_id' => 1,
            'body' => 'Sounds like a fun road trip!',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
