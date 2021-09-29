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
        $playlist->preference = $request->preference;

        $playlist->save();

        // save each track in playlist
        for ($i = 0; $i < count($request->playlistData); $i++) {
            // creating new playlist track
            $playlistTrack = new PlaylistTrack;

            $playlistTrack->playlist_id = $playlist->id;
            $playlistTrack->order = $i + 1;
            $playlistTrack->track_id = $request->playlistData[$i]['track']['id'];
            $playlistTrack->play_count = $request->playlistData[$i]['play_count'];
            $playlistTrack->preference = $request->playlistData[$i]['placement_liked'];

            $playlistTrack->save();

            // creating new track statistic
            $trackStatistic = new TrackStatistic;

            $trackStatistic->track_id = $request->playlistData[$i]['track']['id'];
            $trackStatistic->user_id = $request->user()->id;
            $trackStatistic->preference = $request->playlistData[$i]['track']['preference'];

            $trackStatistic->save();

            // updating current track data
            $currentTrack = Track::find($request->playlistData[$i]['track']['id']);
            $currentTrack->play_count += $request->playlistData[$i]['play_count'];

            $currentTrackStatistics = TrackStatistic::where('track_id', $currentTrack->id)->get();
            $groupedStats = $currentTrackStatistics->groupBy('user_id')->toArray();
            $listenerCount = count($groupedStats);

            $currentTrack->listener_count = $listenerCount;

            // items to modify in track now that all data was saved:
                // TODO: look at playlist data and rank items based on popularity, retention time, order, listener_count, and more
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
