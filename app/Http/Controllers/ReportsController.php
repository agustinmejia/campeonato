<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Models
use App\Models\TeamPlayer;

class ReportsController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    
    public function players_index(){
        return view('reports.players-index');
    }

    public function players_list(Request $request){
        $players = TeamPlayer::whereRaw($request->team_id ? 'team_id = '.$request->team_id : 1)
                    ->whereHas('player', function($q){
                        $q->where('deleted_at', NULL);
                    })
                    ->where('deleted_at', NULL)->get();
        // dd($players);
        return view('reports.players-list', compact('players'));
    }
}
