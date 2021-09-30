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
        // $trackStatistics = TrackStatistic::where('user_id', $request->user()->id)->get();



        for ($i = 0; $i < count($tracks); $i++) {
            // TODO: get all track statistics here too
            $trackStatistics = TrackStatistic::where('track_id', $tracks[$i]->id)->get();
            $groupedByUsers = $trackStatistics->groupBy('user_id')->toArray();
            dd($groupedByUsers);
            // $preference = 0;

            // if ($trackStatistic) {
            //     $preference = $trackStatistic->preference;
            // }


            // TODO: create rank on get

            // TODO: look at playlist data and rank items based on popularity, retention time, order, listener_count, and more
            // "rank"
            // Rank should be a float number from 0 to 100


            $track = [
                'id' => $tracks[$i]['id'],
                'file_name' => $tracks[$i]['file_name'],
                'song_length' => $tracks[$i]['song_length'],
                // 'preference' => $preference
            ];

            $tracks[$i]->track = $track;
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
