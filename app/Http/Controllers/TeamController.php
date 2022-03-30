<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Models
use App\Models\Club;

class TeamController extends Controller
{
    public function teams($id)
    {
        $club = Club::find($id);
        $teams = $club->teams;
        return response()->json($teams);
    }
}
