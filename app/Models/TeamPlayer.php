<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamPlayer extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_id',
        'player_id',
        'number',
        'status'
    ];

    public function team(){
        return $this->belongsTo(Team::class);
    }
}
