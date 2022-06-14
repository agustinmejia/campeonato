<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Models
use App\Models\Club;

class TeamsController extends Controller
{
    public function teams($id)
    {
        $club = Club::with('teams.category')->where('id', $id)->first();
        return response()->json($club);
    }
}
