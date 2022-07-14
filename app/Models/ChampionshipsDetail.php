<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChampionshipsDetail extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'championships_category_id',
        'local_id',
        'visitor_id',
        'title',
        'datetime',
        'location',
        'winner_id',
        'win_type',
        'status',
        'observations'
    ];

    public function local(){
        return $this->belongsTo(Team::class, 'local_id');
    }

    public function visitor(){
        return $this->belongsTo(Team::class, 'visitor_id');
    }

    public function players(){
        return $this->hasMany(ChampionshipsDetailsPlayer::class);
    }

    public function winner(){
        return $this->belongsTo(Team::class, 'winner_id');
    }
}
