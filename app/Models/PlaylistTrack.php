<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Track;
use App\Models\Playlist;

class PlaylistTrack extends Model
{
    use HasFactory;
    protected $table = 'playlist_tracks';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order', 'preference', 'num_plays'
    ];

    public function playlist()
    {
        return $this->belongsTo(Playlist::class);
    }
    public function track()
    {
        return $this->belongsTo(Track::class);
    }
}
