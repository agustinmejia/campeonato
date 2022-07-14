<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChampionshipsCategory extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'championship_id',
        'category_id',
        'user_id',
        'status'
    ];

    public function championship(){
        return $this->belongsTo(Championship::class, 'championship_id');
    }

    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function teams(){
        return $this->hasMany(ChampionshipsTeam::class);
    }

    public function details(){
        return $this->hasMany(ChampionshipsDetail::class);
    }
}
