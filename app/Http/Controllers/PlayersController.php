<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

// Models
use App\Models\Player;
use App\Models\TeamPlayer;
use App\Models\PlayersTransfer;

class PlayersController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $players = Player::where('deleted_at', NULL)
                    ->with(['teams' => function($q){
                        $q->where('status', 'activo')->where('deleted_at', NULL);
                    }, 'teams.team'])
                    ->whereHas('teams.team', function($q){
                        $q->whereRaw(Auth::user()->club_id ? 'club_id = '.Auth::user()->club_id : 1);
                    })
                    ->orderBy('id', 'DESC')->get();
        return view('players.browse', compact('players'));
    }

    public function create(){
        return view('players.edit-add');
    }

    public function store(Request $request){
        DB::beginTransaction();
        try {
            $player = Player::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'ci' => $request->ci,
                'gender' => $request->gender,
                'birthday' => $request->birthday,
                'origin' => $request->origin,
                'image' => $this->store_image($request->file('image'))
            ]);

            foreach ($request->team_id as $value) {
                TeamPlayer::create([
                    'team_id' => $value,
                    'player_id' => $player->id,
                ]);
            }

            DB::commit();
            return redirect()->route('voyager.players.index')->with(['message' => 'Jugador añadido exitosamente.', 'alert-type' => 'success']);
        } catch (\Throwable $th) {
            DB::rollback();
            // dd($th);
        }
    }

    public function edit($id){
        $player = Player::where('id', $id)->with(['teams' => function($q){
                        $q->where('status', 'activo')->where('deleted_at', NULL);
                    }, 'teams.team'])
                    ->first();
        return view('players.edit-add', compact('player'));
    }

    public function update($id, Request $request){
        DB::beginTransaction();
        try {
            $player = Player::findOrFail($id);
            $player->first_name = $request->first_name;
            $player->last_name = $request->last_name;
            $player->ci = $request->ci;
            $player->gender = $request->gender;
            $player->birthday = $request->birthday;
            $player->origin = $request->origin;
            if($request->file('image')){
                $player->image = $this->store_image($request->file('image'));
            }
            $player->save();

            TeamPlayer::where('player_id', $id)->delete();
            foreach ($request->team_id as $value) {
                TeamPlayer::create([
                    'team_id' => $value,
                    'player_id' => $player->id,
                ]);
            }

            DB::commit();
            return redirect()->route('voyager.players.index')->with(['message' => 'Jugador editado exitosamente', 'alert-type' => 'success']);
        } catch (\Throwable $th) {
            DB::rollback();
            // dd($th);
            return redirect()->route('voyager.players.index')->with(['message' => 'Ocurrió un error', 'alert-type' => 'error']);
        }
    }

    public function transfers($id){
        $player = Player::with(['teams' => function($q){
                        $q->where('status', 'activo')->where('deleted_at', NULL);
                    }, 'teams.team', 'transfers' => function($q){
                        $q->orderBy('id', 'DESC');
                    }])
                    ->where('id', $id)->where('deleted_at', NULL)
                    ->first();
        return view('players.transfers', compact('player'));
    }

    public function transfers_store($id, Request $request){
        DB::beginTransaction();
        try {
            TeamPlayer::where('player_id', $id)->where('status', 'activo')->update([
                'status' => 'inactivo'
            ]);

            foreach ($request->team_id as $value) {
                TeamPlayer::create([
                    'team_id' => $value,
                    'player_id' => $id,
                ]);
            }

            PlayersTransfer::create([
                'user_id' => Auth::user()->id,
                'player_id' => $id,
                'origin' => $request->origin,
                'destiny' => $request->destiny,
                'observations' => $request->observations,
                'date' => $request->date
            ]);

            DB::commit();
            return redirect()->route('players.transfers', ['id' => $id])->with(['message' => 'Transferencia registrada exitosamente', 'alert-type' => 'success']);

        } catch (\Throwable $th) {
            DB::rollback();
            //throw $th;
            return redirect()->route('players.transfers', ['id' => $id])->with(['message' => 'Ocurrió un error', 'alert-type' => 'error']);
        }
    }

    public function transfers_print($id){
        $transfer = PlayersTransfer::with(['player', 'origin_club', 'destiny_club'])
                    ->where('id', $id)->first();
        return view('players.print.transfer', compact('transfer'));
    }

    public function print($id, $type){
        $player = Player::where('id', $id)->with('teams.team')->first();
        switch ($type) {
            case 'credencial':
                return view('players.print.credential', compact('player'));
                break;
            case 'certificado':
                return view('players.print.certificate', compact('player'));
                break;
            default:
                return 'Error 404';
                break;
        }
        
    }

    public function transfers_delete($id, Request $request){
        DB::beginTransaction();
        try {

            $transfer = PlayersTransfer::find($request->id);
            $transfer->delete();

            // Buscar el último equipo asociado al jugador
            $team_player = TeamPlayer::where('player_id', $transfer->player_id)
                            ->where('status', 'inactivo')->where('deleted_at', NULL)
                            ->orderBy('id', 'DESC')->first();
            
            // Anular equipos asociados al jugador
            TeamPlayer::where('player_id', $transfer->player_id)
                            ->where('status', 'activo')->update(['status' => 'inactivo']);
            
            // Restaurar el último equipo asociado al jugador
            if($team_player){
                $team_player->status = 'activo';
                $team_player->update();
            }

            DB::commit();
            return redirect()->route('players.transfers', ['id' => $id])->with(['message' => 'Transferencia anulada exitosamente', 'alert-type' => 'success']);

        } catch (\Throwable $th) {
            DB::rollback();
            dd($th);
            return redirect()->route('players.transfers', ['id' => $id])->with(['message' => 'Ocurrió un error', 'alert-type' => 'error']);
        }
    }

    // ===============================================

    public function store_image($file, $size = 512){
        try {
            Storage::makeDirectory('players/'.date('F').date('Y'));
            $base_name = Str::random(20);

            // imagen normal
            $filename = $base_name.'.'.$file->getClientOriginalExtension();
            $image_resize = Image::make($file->getRealPath())->orientate();
            $image_resize->resize($size, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $path =  'players/'.date('F').date('Y').'/'.$filename;
            $image_resize->save(public_path('../storage/app/public/'.$path));
            return $path;
        } catch (\Throwable $th) {
            return null;
        }
    }
}
