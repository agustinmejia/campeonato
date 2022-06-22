<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

// Models
use App\Models\Championship;
use App\Models\ChampionshipTeam;
use App\Models\ChampionshipDetail;
use App\Models\ChampionshipDetailsPlayer;
use App\Models\ChampionshipDetailsPlayersGoal;
use App\Models\ChampionshipDetailsPlayersCard;

class ChampionshipsController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('championships.browse');
    }

    public function list($search = null){
        $paginate = request('paginate') ?? 10;
        $data = Championship::where(function($query) use ($search){
                    if($search){
                        $query->OrwhereHas('category', function($query) use($search){
                            $query->whereRaw("name like '%$search%'");
                        })
                        ->OrWhereRaw($search ? "name like '%$search%'" : 1)
                        ->OrWhereRaw($search ? "year like '%$search%'" : 1)
                        ->OrWhereRaw($search ? "status like '%$search%'" : 1);
                    }
                })->where('deleted_at', NULL)->paginate($paginate);
        // dd($data);
        return view('championships.list', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('championships.edit-add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            $championship = Championship::create([
                'category_id' => $request->category_id,
                'name' => $request->name,
                'start' => $request->start,
                'finish' => $request->finish,
                'year' => date('Y', strtotime($request->start)) == date('Y', strtotime($request->finish)) ? date('Y', strtotime($request->start)) : date('Y', strtotime($request->start)).'-'.date('Y', strtotime($request->finish))
            ]);

            // Registrar lista de equipos del campeonato
            $teams = array_unique(array_merge($request->local_id,$request->visitor_id), SORT_REGULAR);
            foreach ($teams as $team) {
                ChampionshipTeam::create([
                    'championship_id' => $championship->id,
                    'team_id' => $team
                ]);
            }

            // Registrar encuentros
            for ($i = 0; $i < count($request->local_id); $i++) {
                ChampionshipDetail::create([
                    'championship_id' => $championship->id,
                    'local_id' => $request->local_id[$i],
                    'visitor_id' => $request->visitor_id[$i],
                    'title' => $request->title[$i],
                    'datetime' => $request->datetime[$i]
                ]);
            }

            DB::commit();
            return redirect()->route('championships.index')->with(['message' => 'Campeonato registrado exitosamente', 'alert-type' => 'success']);

        } catch (\Throwable $th) {
            DB::rollback();
            // dd($th);
            return redirect()->route('championships.index')->with(['message' => 'Ocurrió un error', 'alert-type' => 'error']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $championship = Championship::with(['details.local.team_players.player', 'details.visitor.team_players.player'])->find($id);
        return view('championships.read', compact('championship'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            Championship::where('id', $id)->delete();
            ChampionshipTeam::where('championship_id', $id)->delete();
            ChampionshipDetail::where('championship_id', $id)->delete();
            DB::commit();
            return redirect()->route('championships.index')->with(['message' => 'Campeonato registrado exitosamente', 'alert-type' => 'success']);
        } catch (\Throwable $th) {
            DB::rollback();
            // dd($th);
            return redirect()->route('championships.index')->with(['message' => 'Ocurrió un error', 'alert-type' => 'error']);
        }
    }

    // =================================================

    public function details_enable($id, Request $request){
        // dd($request->all());
        DB::beginTransaction();
        try {
            if($request->local_id){
                for ($i=0; $i < count($request->local_id); $i++) { 
                    ChampionshipDetailsPlayer::create([
                        'championship_detail_id' => $request->championship_detail_id,
                        'player_id' => $request->local_id[$i],
                        'type' => $request->local_type[$i],
                        'playing' => $request->local_type[$i] == 'titular' ? 1 : 0,
                        'number' => $request->local_number[$i],
                    ]);
                }
            }

            if($request->visitor_id){
                for ($i=0; $i < count($request->visitor_id); $i++) { 
                    ChampionshipDetailsPlayer::create([
                        'championship_detail_id' => $request->championship_detail_id,
                        'player_id' => $request->visitor_id[$i],
                        'type' => $request->visitor_type[$i],
                        'playing' => $request->visitor_type[$i] == 'titular' ? 1 : 0,
                        'number' => $request->visitor_number[$i],
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('championships.show', ['championship' => $id])->with(['message' => 'Encuantro habilitado exitosamente', 'alert-type' => 'success']);
        } catch (\Throwable $th) {
            DB::rollback();
            // dd($th);
            return redirect()->route('championships.show', ['championship' => $id])->with(['message' => 'Ocurrió un error', 'alert-type' => 'error']);
        }
    }
    
    public function game($id){
        $game = ChampionshipDetail::with(['local.team_players.player', 'visitor.team_players.player', 'players.player.teams', 'players.goals', 'players.cards'])->find($id);
        return view('championships.game', compact('game'));
    }

    public function game_goal($id, Request $request){
        try {
            ChampionshipDetailsPlayersGoal::create([
                'championship_details_player_id' => $request->championship_details_player_id,
                'type' => $request->type,
                'time' => $request->time
            ]);
            return redirect()->route('championships.game', ['id' => $id])->with(['message' => 'Gol registrado', 'alert-type' => 'success']);
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('championships.game', ['id' => $id])->with(['message' => 'Ocurrió un error', 'alert-type' => 'error']);
        }
    }

    public function game_card($id, Request $request){
        try {

            // Buscar si ya tiene una tarjeta amarilla
            if($request->type){
                $card = ChampionshipDetailsPlayersCard::where('championship_details_player_id', $request->championship_details_player_id)
                        ->where('type', 'yellow')->where('deleted_at', NULL)->first();
            }

            // Guardar tarjeta
            ChampionshipDetailsPlayersCard::create([
                'championship_details_player_id' => $request->championship_details_player_id,
                'type' => $request->type,
                'time' => $request->time,
                'observations' => $request->observations
            ]);

            // Si ya tenía tarjeta amarilla se agrega una tarjeta roja
            if($card){
                ChampionshipDetailsPlayersCard::create([
                    'championship_details_player_id' => $request->championship_details_player_id,
                    'type' => 'red',
                    'time' => $request->time,
                    'observations' => $request->observations
                ]);
            }

            // Si la tarjeta es roja o acumula 2 amaillas
            if($card || $request->type == 'red'){
                $player = ChampionshipDetailsPlayer::find($request->championship_details_player_id);
                $player->playing = 0;
                $player->status = 'inactivo';
                $player->save();
            }


            return redirect()->route('championships.game', ['id' => $id])->with(['message' => 'Tarjeta registrada', 'alert-type' => 'success']);
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('championships.game', ['id' => $id])->with(['message' => 'Ocurrió un error', 'alert-type' => 'error']);
        }
    }

    public function game_change($id, Request $request){
        try {
            $player_in = ChampionshipDetailsPlayer::where('championship_detail_id', $id)
                        ->where('player_id', $request->player_id)
                        ->where('deleted_at', null)->first();
            $player_in->playing = 1;
            $player_in->save();

            $player_out = ChampionshipDetailsPlayer::find($request->championship_details_player_id);
            $player_out->playing = 0;
            $player_out->status = 'inactivo';
            $player_out->save();

            return redirect()->route('championships.game', ['id' => $id])->with(['message' => 'Cambio registrado', 'alert-type' => 'success']);
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('championships.game', ['id' => $id])->with(['message' => 'Ocurrió un error', 'alert-type' => 'error']);
        }
    }

    public function game_finish($id, Request $request){
        try {
            ChampionshipDetail::where('id', $id)->update([
                'winner_id' => $request->win_type == 'normal' ? $request->winner_id : $request->winner_id_alt,
                'win_type' => $request->win_type,
                'status' => 'finalizado',
                'observations' => $request->observations
            ]);
            return redirect()->route('championships.game', ['id' => $id])->with(['message' => 'Partido finalizado', 'alert-type' => 'success']);
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('championships.game', ['id' => $id])->with(['message' => 'Ocurrió un error', 'alert-type' => 'error']);
        }
    }
}
