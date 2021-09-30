<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use App\Models\Track;
use App\Models\PlaylistTrack;
use App\Models\TrackStatistic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

            $playlistTrackData = $request->playlistData[$i];

            // creating new playlist track even if we listened or not, since this tracks placement
            $playlistTrack = new PlaylistTrack;

            $playlistTrack->playlist_id = $playlist->id;
            $playlistTrack->order = $i + 1;
            $playlistTrack->track_id = $playlistTrackData['track']['id'];
            $playlistTrack->play_count = $playlistTrackData['play_count'];
            $playlistTrack->preference = $playlistTrackData['placement_liked'];
            // $playlistTrack->rating = $playlistTrackData['rating'];

            $playlistTrack->save();

            $track = $playlistTrackData['track'];

            $trackStatistic = TrackStatistic::updateOrCreate(
                ['user_id' => $request->user()->id, 'track_id' => $track['id']],
                ['preference' => $playlistTrackData['preference']]
            );

            $trackStatistic->amount_listened += $playlistTrackData['play_count'];

            $trackStatistic->save();
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
