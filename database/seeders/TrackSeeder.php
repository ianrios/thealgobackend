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

        // $songLengths = [
        //     39778,
        //     42872,
        //     39111,
        //     33153,
        //     34305,
        //     40556,
        //     39559,
        //     42451,
        //     37662,
        //     45667,
        //     44555,
        //     48004,
        //     45163,
        //     45695,
        //     43243,
        //     50109
        // ];
        // Track::factory()->count(1)->create();
        // for ($i = 1; $i <= count($songLengths); $i++) {
        for ($i = 1; $i <= 16; $i++) {
            $track = new Track;
            $file_short = $i;
            if ($i < 10) {
                $file_short = '0' . $i;
            }
            $track->file_name = 'T00' . $file_short . '.wav';
            // $track->song_length = $songLengths[$i - 1];
            $track->rank = $i;
            $track->listener_count = 0;
            $track->rating = 0;
            $track->play_count = 0;
            $track->save();
        }
    }
}
