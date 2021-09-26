<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\PlaylistTrack;

class Playlist extends Model
{
    use HasFactory;
    protected $table = 'playlists';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'preference'
    ];

    public function playlistTracks()
    {
        return $this->hasMany(PlaylistTrack::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
