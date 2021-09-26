<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Track;

class TrackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Track::factory()->count(1)->create();
        for ($i = 1; $i <= 16; $i++) {
            $track = new Track;
            $track->file_name = $i;
            $track->save();
        }
    }
}
