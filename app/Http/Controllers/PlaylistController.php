<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use App\Models\Track;
use App\Models\PlaylistTrack;
use App\Models\TrackStatistic;
use Illuminate\Http\Request;

class PlaylistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Playlist::with(['playlistTracks'])->get();
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
        // creating new playlist
        $playlist = new Playlist;

        $playlist->user_id = $request->user()->id;

        if ($request->preference == 'neutral') {
            $playlist->preference = 0;
        } else if ($request->preference == 'positive') {
            $playlist->preference = 1;
        } else if ($request->preference == 'negative') {
            $playlist->preference = -1;
        }

        $playlist->save();

        // save each track in playlist
        for ($i = 0; $i < count($request->playlistData); $i++) {
            // creating new playlist track
            $playlistTrack = new PlaylistTrack;

            $playlistTrack->playlist_id = $playlist->id;
            $playlistTrack->order = $i + 1;
            $playlistTrack->track_id = $request->playlistData[$i]['track']['id'];
            $playlistTrack->num_plays = $request->playlistData[$i]['num_plays'];

            if ($request->playlistData[$i]['placement_liked'] == 'neutral') {
                $playlistTrack->preference = 0;
            } else if ($request->playlistData[$i]['placement_liked'] == 'positive') {
                $playlistTrack->preference = 1;
            } else if ($request->playlistData[$i]['placement_liked'] == 'negative') {
                $playlistTrack->preference = -1;
            }

            $playlistTrack->save();

            // creating new track statistic
            $trackStatistic = new TrackStatistic;

            $trackStatistic->track_id = $request->playlistData[$i]['track']['id'];
            $trackStatistic->user_id = $request->user()->id;

            if ($request->playlistData[$i]['track']['liked'] == 'neutral') {
                $trackStatistic->preference = 0;
            } else if ($request->playlistData[$i]['track']['liked'] == 'positive') {
                $trackStatistic->preference = 1;
            } else if ($request->playlistData[$i]['track']['liked'] == 'negative') {
                $trackStatistic->preference = -1;
            }

            $trackStatistic->save();

            // updating current track data
            $currentTrack = Track::find($request->playlistData[$i]['track']['id']);
            $currentTrack->play_count += $request->playlistData[$i]['num_plays'];
            $currentTrack->listener_count = count(TrackStatistic::where('track_id', $request->playlistData[$i]['track']['id'])->get()->groupBy('user_id')->toArray());

            // items to modify in track now that all data was saved:
            // "rank"
            // "rating"

            $currentTrack->save();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Playlist  $playlist
     * @return \Illuminate\Http\Response
     */
    public function show(Playlist $playlist)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Playlist  $playlist
     * @return \Illuminate\Http\Response
     */
    public function edit(Playlist $playlist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Playlist  $playlist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Playlist $playlist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Playlist  $playlist
     * @return \Illuminate\Http\Response
     */
    public function destroy(Playlist $playlist)
    {
        //
    }
}
