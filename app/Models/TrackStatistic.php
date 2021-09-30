<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Track;

class TrackStatistic extends Model
{
    use HasFactory;
    protected $table = 'track_statistics';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'preference',
        'amount_listened'
    ];

    public function track()
    {
        return $this->belongsTo(Track::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
