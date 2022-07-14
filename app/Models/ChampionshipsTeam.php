<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChampionshipsTeam extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'championships_category_id',
        'team_id'
    ];

    public function team(){
        return $this->belongsTo(Team::class)->withTrashed();
    }
}
