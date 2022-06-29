<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Barryvdh\DomPDF\Facade\Pdf;

// Models
use App\Models\Team;
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
        $team = $request->team_id ? Team::find($request->team_id) : null;
        $players = TeamPlayer::whereRaw($request->team_id ? 'team_id = '.$request->team_id : 1)
                    ->whereHas('player', function($q){
                        $q->where('deleted_at', NULL);
                    })
                    ->where('deleted_at', NULL)->get();
        if($request->export){
            // return view('reports.players-pdf', compact('players', 'team'));
            $pdf = PDF::loadView('reports.players-pdf', ['players' => $players, 'team' => $team]);
            return $pdf->setPaper('a4', 'landscape')->stream();
        }
        return view('reports.players-list', compact('players'));
    }
}
