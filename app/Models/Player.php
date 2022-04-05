<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Player extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'first_name',
        'last_name',
        'ci',
        'gender',
        'birthday',
        'origin',
        'image',
        'status'
    ];

    public function teams(){
        return $this->hasMany(TeamPlayer::class);
    }

    public function transfers(){
        return $this->hasMany(PlayersTransfer::class);
    }
}
