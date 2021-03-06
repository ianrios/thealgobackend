<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TrackStatistic;
use App\Models\PlaylistTrack;

class Track extends Model
{
    use HasFactory;
    protected $table = 'tracks';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'file_name',
        'song_length',
        'rank',
        'listener_count',
        'rating',
        'play_count',
        'interactions',
    ];

    public function playlistTracks()
    {
        return $this->hasMany(PlaylistTrack::class);
    }
    public function trackStatistics()
    {
        return $this->hasMany(TrackStatistic::class);
    }
}
