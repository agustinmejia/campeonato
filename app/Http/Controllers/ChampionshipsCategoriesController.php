<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

// Models
use App\Models\Player;
use App\Models\TeamPlayer;
use App\Models\Championship;
use App\Models\ChampionshipsCategory;
use App\Models\ChampionshipsTeam;
use App\Models\ChampionshipsDetail;
use App\Models\ChampionshipsDetailsPlayer;
use App\Models\ChampionshipsDetailsPlayersGoal;
use App\Models\ChampionshipsDetailsPlayersCard;

class ChampionshipsCategoriesController extends Controller
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
        return view('championshipscategories.browse');
    }

    public function list($search = null){
        $paginate = request('paginate') ?? 10;
        $data = ChampionshipsCategory::where(function($query) use ($search){
                    if($search){
                        $query->OrwhereHas('championship', function($query) use($search){
                            $query->whereRaw("name like '%$search%'");
                        })
                        ->OrwhereHas('category', function($query) use($search){
                            $query->whereRaw("name like '%$search%'");
                        });
                    }
                })->where('deleted_at', NULL)->orderBy('id', 'DESC')->paginate($paginate);
        // dd($data);
        return view('championshipscategories.list', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('championshipscategories.edit-add');
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
            $championship_category = ChampionshipsCategory::create([
                'category_id' => $request->category_id,
                'championship_id' => $request->championship_id,
            ]);

            // Registrar lista de equipos del campeonato
            $teams = array_unique(array_merge($request->local_id,$request->visitor_id), SORT_REGULAR);
            foreach ($teams as $team) {
                ChampionshipsTeam::create([
                    'championships_category_id' => $championship_category->id,
                    'team_id' => $team
                ]);
            }

            // Registrar encuentros
            for ($i = 0; $i < count($request->local_id); $i++) {
                ChampionshipsDetail::create([
                    'championships_category_id' => $championship_category->id,
                    'local_id' => $request->local_id[$i],
                    'visitor_id' => $request->visitor_id[$i],
                    'title' => $request->title[$i],
                    'datetime' => $request->datetime[$i]
                ]);
            }

            DB::commit();
            return redirect()->route('championshipscategories.index')->with(['message' => 'Campeonato registrado exitosamente', 'alert-type' => 'success']);

        } catch (\Throwable $th) {
            DB::rollback();
            // dd($th);
            return redirect()->route('championshipscategories.index')->with(['message' => 'Ocurrió un error', 'alert-type' => 'error']);
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
        $fixture = ChampionshipsCategory::with(['championship', 'category','teams.team', 'details.local.team_players.player', 'details.visitor.team_players.player', 'details.players.cards'])->find($id);
        return view('championshipscategories.read', compact('fixture'));
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
            ChampionshipsCategory::where('id', $id)->delete();
            ChampionshipsTeam::where('championships_category_id', $id)->delete();
            ChampionshipsDetail::where('championships_category_id', $id)->delete();
            DB::commit();
            return redirect()->route('championshipscategories.index')->with(['message' => 'Campeonato registrado exitosamente', 'alert-type' => 'success']);
        } catch (\Throwable $th) {
            DB::rollback();
            // dd($th);
            return redirect()->route('championshipscategories.index')->with(['message' => 'Ocurrió un error', 'alert-type' => 'error']);
        }
    }

    // =================================================

    public function details_enable($id, Request $request){
        // dd($request->all());
        DB::beginTransaction();
        try {
            if($request->player_id){
                $details = ChampionshipsDetail::find($request->championships_detail_id);
                $team_players = TeamPlayer::whereHas('player', function($q){
                                $q->where('status', 'activo')->where('deleted_at', NULL);
                            })
                            ->whereRaw('(team_id = '.$details->local_id.' or team_id = '.$details->visitor_id.')')
                            ->where('deleted_at', NULL)->get();
                foreach ($team_players as $item) {
                    $index = array_search($item->player_id, $request->player_id);
                    ChampionshipsDetailsPlayer::create([
                        'championships_detail_id' => $request->championships_detail_id,
                        'player_id' => $item->player_id,
                        'type' => $index !== false ? 'titular' : 'suplente',
                        'playing' => $index !== false ? 1 : 0,
                        'number' => $index !== false ? $request->number[$index] : null,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('championshipscategories.show', ['championshipscategory' => $id])->with(['message' => 'Encuantro habilitado exitosamente', 'alert-type' => 'success']);
        } catch (\Throwable $th) {
            DB::rollback();
            dd($th);
            return redirect()->route('championshipscategories.show', ['championshipscategory' => $id])->with(['message' => 'Ocurrió un error', 'alert-type' => 'error']);
        }
    }
    
    public function game($id){
        $game = ChampionshipsDetail::with(['local.team_players.player', 'visitor.team_players.player', 'players.player.teams', 'players.goals', 'players.cards'])->find($id);
        // dd($game);
        return view('championshipscategories.game', compact('game'));
    }

    public function game_goal($id, Request $request){
        try {
            ChampionshipsDetailsPlayersGoal::create([
                'championships_details_player_id' => $request->championships_details_player_id,
                'type' => $request->type,
                'time' => $request->time
            ]);
            return redirect()->route('championshipscategories.game', ['id' => $id])->with(['message' => 'Gol registrado', 'alert-type' => 'success']);
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('championshipscategories.game', ['id' => $id])->with(['message' => 'Ocurrió un error', 'alert-type' => 'error']);
        }
    }

    public function game_card($id, Request $request){
        try {

            // Buscar si ya tiene una tarjeta amarilla
            if($request->type){
                $card = ChampionshipsDetailsPlayersCard::where('championships_details_player_id', $request->championships_details_player_id)
                        ->where('type', 'yellow')->where('deleted_at', NULL)->first();
            }

            // Guardar tarjeta
            ChampionshipsDetailsPlayersCard::create([
                'championships_details_player_id' => $request->championships_details_player_id,
                'type' => $request->type,
                'time' => $request->time,
                'observations' => $request->observations
            ]);

            // Si ya tenía tarjeta amarilla se agrega una tarjeta roja
            if($card){
                ChampionshipsDetailsPlayersCard::create([
                    'championships_details_player_id' => $request->championships_details_player_id,
                    'type' => 'red',
                    'time' => $request->time,
                    'observations' => $request->observations
                ]);
            }

            // Si la tarjeta es roja o acumula 2 amaillas
            if($card || $request->type == 'red'){
                $player = ChampionshipsDetailsPlayer::find($request->championships_details_player_id);
                $player->playing = 0;
                $player->status = 'inactivo';
                $player->save();
            }


            return redirect()->route('championshipscategories.game', ['id' => $id])->with(['message' => 'Tarjeta registrada', 'alert-type' => 'success']);
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('championshipscategories.game', ['id' => $id])->with(['message' => 'Ocurrió un error', 'alert-type' => 'error']);
        }
    }

    public function game_change($id, Request $request){
        try {
            $player_in = ChampionshipsDetailsPlayer::where('championships_detail_id', $id)
                        ->where('player_id', $request->player_id)
                        ->where('deleted_at', null)->first();
            $player_in->playing = 1;
            $player_in->save();

            $player_out = ChampionshipsDetailsPlayer::find($request->championships_details_player_id);
            $player_out->playing = 0;
            $player_out->status = 'inactivo';
            $player_out->save();

            return redirect()->route('championshipscategories.game', ['id' => $id])->with(['message' => 'Cambio registrado', 'alert-type' => 'success']);
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('championshipscategories.game', ['id' => $id])->with(['message' => 'Ocurrió un error', 'alert-type' => 'error']);
        }
    }

    public function game_finish($id, Request $request){
        try {
            ChampionshipsDetail::where('id', $id)->update([
                'winner_id' => $request->win_type == 'normal' ? $request->winner_id : $request->winner_id_alt,
                'win_type' => $request->win_type,
                'status' => 'finalizado',
                'observations' => $request->observations
            ]);
            return redirect()->route('championshipscategories.game', ['id' => $id])->with(['message' => 'Partido finalizado', 'alert-type' => 'success']);
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('championshipscategories.game', ['id' => $id])->with(['message' => 'Ocurrió un error', 'alert-type' => 'error']);
        }
    }
}
