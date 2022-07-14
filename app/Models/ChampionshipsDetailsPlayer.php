<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChampionshipsDetailsPlayer extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'championships_detail_id',
        'player_id',
        'number',
        'type',
        'playing',
        'status',
        'observations'
    ];

    public function player(){
        return $this->belongsTo(Player::class, 'player_id')->withTrashed();
    }

    public function goals(){
        return $this->hasMany(ChampionshipsDetailsPlayersGoal::class, 'championships_details_player_id');
    }

    public function cards(){
        return $this->hasMany(ChampionshipsDetailsPlayersCard::class, 'championships_details_player_id');
    }
}
