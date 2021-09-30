<?php

namespace App\Http\Controllers;

use App\Models\Track;
use App\Models\TrackStatistic;
use Illuminate\Http\Request;

class TrackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tracks = Track::all();
        // $rankedTracks = $tracks->sortBy([
        //     //     // ['listener_count', 'desc'],
        //     //     // ['rating', 'desc'],
        //     ['play_count', 'desc'],
        //     //     // ['id', 'asc'],
        // ])->toArray();
        // // dd($rankedTracks);

        // TODO: test to make sure its preference first, then play count then listener count

        $rankedTracks = $tracks->sortBy([
            ['preference', 'desc'],
            ['play_count', 'desc'],
            ['listener_count', 'desc'],
        ])->toArray();
        // dd($rankedTracks);

        $ranking = [];
        for ($i = 0; $i < count($tracks); $i++) {
            array_push($ranking, $rankedTracks[$i]['id']);
        }
        // dd($ranking);


        $trackStatistics = TrackStatistic::all()->groupBy('track_id')->toArray();

        foreach ($trackStatistics as $index => $trackStatistic) {
            $listener_count = 0;
            $play_count = 0;
            $preference = 0;
            $rating = 0;
            $rank = $ranking[$index - 1];
            // echo $rank.', ';
            for ($j = 0; $j < count($trackStatistic); $j++) {
                $preference += $trackStatistic[$j]['preference'];
                $rating += $trackStatistic[$j]['preference'];
                $play_count += $trackStatistic[$j]['amount_listened'];
                if ($trackStatistic[$j]['amount_listened'] > 0) {
                    $listener_count++;
                }
            }

            // TODO: reate popularity based on relation to each track, number 0 to 100


            $track = [
                'id' => $tracks[$index - 1]['id'],
                'file_name' => $tracks[$index - 1]['file_name'],
                'song_length' => $tracks[$index - 1]['song_length'],
            ];
            $tracks[$index - 1]['rating'] = $rating;
            $tracks[$index - 1]['listener_count'] = $listener_count;
            $tracks[$index - 1]['play_count'] = (float)number_format($play_count, 1, '.', "");
            $tracks[$index - 1]['preference'] = $preference;
            $tracks[$index - 1]['rank'] = $rank;
            $tracks[$index - 1]->track = $track;

            // update track object in DB
            $track = Track::find($tracks[$index - 1]['id']);

            $track->rating = $rating;
            $track->listener_count = $listener_count;
            $track->play_count = (float)number_format($play_count, 1, '.', "");
            $track->rank = $rank;
            $track->save();
        }

        // $sortedTracks = $tracks->sortBy('rank');

        // return $sortedTracks;
        return $tracks;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Track  $track
     * @return \Illuminate\Http\Response
     */
    public function show(Track $track)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Track  $track
     * @return \Illuminate\Http\Response
     */
    public function edit(Track $track)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Track  $track
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Track $track)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Track  $track
     * @return \Illuminate\Http\Response
     */
    public function destroy(Track $track)
    {
        //
    }
}
