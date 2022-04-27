<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Delegate extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];

    public function club(){
        return $this->belongsTo(Club::class);
    }
}
