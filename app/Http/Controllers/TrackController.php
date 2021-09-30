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
        $trackStatistics = TrackStatistic::all()->groupBy('track_id')->toArray();

        foreach ($trackStatistics as $index => $trackStatistic) {
            $listener_count = 0;
            $play_count = 0;
            $preference = 0;
            $rating = 0;
            $rank = 0;
            for ($j = 0; $j < count($trackStatistic); $j++) {
                $preference += $trackStatistic[$j]['preference'];
                $rating += $trackStatistic[$j]['preference'];
                $play_count += $trackStatistic[$j]['amount_listened'];
                if ($trackStatistic[$j]['amount_listened'] > 0) {
                    $listener_count++;
                }
            }

            // TODO: create rank on get

            // TODO: look at playlist data and rank items based on popularity, retention time, order, listener_count, and more
            // "rank"
            // if tie, use track->id for rank
            // Rank should be a float number from 0 to 100 - must be unique


            // TODO: reate popularity based on relation to each track, number 0 to 100


            $track = [
                'id' => $tracks[$index - 1]['id'],
                'file_name' => $tracks[$index - 1]['file_name'],
                'song_length' => $tracks[$index - 1]['song_length'],
            ];
            $tracks[$index - 1]['rating'] = $rating;
            $tracks[$index - 1]['listener_count'] = $listener_count;
            $tracks[$index - 1]['play_count'] = $play_count;
            $tracks[$index - 1]['preference'] = $preference;
            $tracks[$index - 1]['rank'] = $rank;
            $tracks[$index - 1]->track = $track;

            // update track object in DB
            $track = Track::find($tracks[$index - 1]['id']);

            $track->rating = $rating;
            $track->listener_count = $listener_count;
            $track->play_count = $play_count;
            $track->rank = $rank;

            $track->save();
        }
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
