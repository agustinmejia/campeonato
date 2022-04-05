<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlayersTransfer extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'user_id',
        'player_id',
        'origin',
        'destiny',
        'observations',
        'date'
    ];

    public function player(){
        return $this->belongsTo(Player::class, 'player_id');
    }

    public function origin_club(){
        return $this->belongsTo(Club::class, 'origin', 'id');
    }

    public function destiny_club(){
        return $this->belongsTo(Club::class, 'destiny', 'id');
    }
}
