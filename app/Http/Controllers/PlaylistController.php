<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use App\Models\PlaylistTrack;
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

        for ($i = 0; $i < count($request->playlistData); $i++) {
            $playlistTrack = new PlaylistTrack;

            $playlistTrack->playlist_id = $playlist->id;
            $playlistTrack->order = $i;
            $playlistTrack->track_id = $request->playlistData[$i]['track']['id'];
            $playlistTrack->preference = $request->playlistData[$i]['placement_liked'];
            $playlistTrack->num_plays = $request->playlistData[$i]['num_plays'];

            $playlistTrack->save();
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
