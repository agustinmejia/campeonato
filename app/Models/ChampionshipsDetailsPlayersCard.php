<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChampionshipsDetailsPlayersCard extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'championships_details_player_id',
        'type',
        'time',
        'accumulated',
        'observations'
    ];
}
