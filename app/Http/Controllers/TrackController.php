<?php

namespace App\Http\Controllers;

use App\Models\Track;
use App\Models\TrackStatistic;
use Illuminate\Http\Request;

class TrackController extends Controller
{

    public function knapsack($ratings, $playCounts, $listenerCounts)
    {
        // TODO: test to make sure its preference first, then play count then listener count
        $weights = [];
        for ($i = 0; $i < count($ratings); $i++) {

            $sum = $ratings[$i]['rating'] + $playCounts[$i]['play_count'] + $listenerCounts[$i]['listener_count'];


            array_push($weights, [
                'sum' => $sum,
                'ratingWeight' => [$ratings[$i]['id'], $ratings[$i]['rating']],
                'playCountWeight' => [$playCounts[$i]['id'], $playCounts[$i]['play_count']],
                'listenerCountWeight' => [$listenerCounts[$i]['id'], $listenerCounts[$i]['listener_count']],
            ]);
        }

        $finalRank = [];

        foreach ($weights as $index => $weight) {
            if ($weight['ratingWeight'][1] >= $weight['playCountWeight'][1]) {
                if (!in_array($weight['ratingWeight'][0], $finalRank)) {
                    array_push($finalRank, $weight['ratingWeight'][0]);
                    continue;
                }
            }
            if ($weight['playCountWeight'][1] >= $weight['listenerCountWeight'][1]) {
                if (!in_array($weight['playCountWeight'][0], $finalRank)) {
                    array_push($finalRank, $weight['playCountWeight'][0]);
                    continue;
                }
            }
            if (!in_array($weight['listenerCountWeight'][0], $finalRank)) {
                array_push($finalRank, $weight['listenerCountWeight'][0]);
            } else if (!in_array($weight['playCountWeight'][0], $finalRank)) {
                array_push($finalRank, $weight['playCountWeight'][0]);
            } else if (!in_array($weight['ratingWeight'][0], $finalRank)) {
                array_push($finalRank, $weight['ratingWeight'][0]);
            }
        }
        // dd($finalRank);
        if (count($finalRank) < 16) {
            // add missing indexes in order that they should appear
            for ($i = 1; $i <= 16; $i++) {
                if (!in_array($i, $finalRank)) {
                    array_push($finalRank, $i);
                }
            }
        }
        // dd($finalRank);

        return $finalRank;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tracks = Track::all();

        $ratings = $tracks->sortBy([['rating', 'desc']]); // 1
        $playCounts = $tracks->sortBy([['play_count', 'desc']]); // 2
        $listenerCounts = $tracks->sortBy([['listener_count', 'desc']]); // 3
        $finalRank = $this->knapsack($ratings, $playCounts, $listenerCounts);

        $trackStatistics = TrackStatistic::all()->groupBy('track_id')->toArray();

        foreach ($trackStatistics as $index => $trackStatistic) {
            $listener_count = 0;
            $play_count = 0;
            $preference = 0;
            $rating = 0;
            $interactions = 0;

            $rank = array_search($index, $finalRank);

            for ($j = 0; $j < count($trackStatistic); $j++) {
                $preference += $trackStatistic[$j]['preference'];
                $rating += $trackStatistic[$j]['preference'];
                $play_count += $trackStatistic[$j]['amount_listened'];
                if ($trackStatistic[$j]['preference'] != 0) {
                    $interactions++;
                }
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
            $tracks[$index - 1]['interactions'] = $interactions;
            $tracks[$index - 1]['rank'] = $rank;
            // $tracks[$index - 1]->track = $track;

            // update track object in DB
            $track = Track::find($tracks[$index - 1]['id']);

            $track->rating = $rating;
            $track->listener_count = $listener_count;
            $track->play_count = (float)number_format($play_count, 1, '.', "");
            $track->rank = $rank;
            $track->interactions = $interactions;
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
