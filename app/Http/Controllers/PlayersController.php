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
use App\Models\PlayerDocument;

class PlayersController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $players = Player::where('deleted_at', NULL)
                    ->with(['teams' => function($q){
                        $q->where('status', 'activo')->where('deleted_at', NULL);
                    }, 'teams.team', 'documents'])
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
        $request->validate([
            'ci' => ['required', 'unique:players', 'max:191'],
        ]);

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
                $players = TeamPlayer::whereHas('player', function($q){
                                    $q->where('status', 'activo')->where('deleted_at', null);
                                })
                                ->where('team_id', $value)
                                ->where('deleted_at', null)->count();
                if($players < 30){
                    TeamPlayer::create([
                        'team_id' => $value,
                        'player_id' => $player->id,
                    ]);
                }else{
                    return redirect()->route('voyager.players.create')->with(['message' => 'El quipo seleccionado tiene m??s de 30 jugadores h??biles', 'alert-type' => 'error']);
                }
            }
            
            DB::commit();
            return redirect()->route('voyager.players.index')->with(['message' => 'Jugador a??adido exitosamente', 'alert-type' => 'success']);
        } catch (\Throwable $th) {
            DB::rollback();
            // dd($th);
            return redirect()->route('voyager.players.index')->with(['message' => 'Ocurri?? un error', 'alert-type' => 'error']);
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
        // dd($request->all());
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
            $player->status = $request->status ? 'activo' : 'inactivo';
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
            return redirect()->route('voyager.players.index')->with(['message' => 'Ocurri?? un error', 'alert-type' => 'error']);
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
            return redirect()->route('players.transfers', ['id' => $id])->with(['message' => 'Ocurri?? un error', 'alert-type' => 'error']);
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

            // Buscar el ??ltimo equipo asociado al jugador
            $team_player = TeamPlayer::where('player_id', $transfer->player_id)
                            ->where('status', 'inactivo')->where('deleted_at', NULL)
                            ->orderBy('id', 'DESC')->first();
            
            // Anular equipos asociados al jugador
            TeamPlayer::where('player_id', $transfer->player_id)
                            ->where('status', 'activo')->update(['status' => 'inactivo']);
            
            // Restaurar el ??ltimo equipo asociado al jugador
            if($team_player){
                $team_player->status = 'activo';
                $team_player->update();
            }

            DB::commit();
            return redirect()->route('players.transfers', ['id' => $id])->with(['message' => 'Transferencia anulada exitosamente', 'alert-type' => 'success']);

        } catch (\Throwable $th) {
            DB::rollback();
            dd($th);
            return redirect()->route('players.transfers', ['id' => $id])->with(['message' => 'Ocurri?? un error', 'alert-type' => 'error']);
        }
    }

    function documents_store($id, Request $request){
        try {
            $file = $request->file('file');
            $file_name = Str::random(20).'.'.$file->getClientOriginalExtension();
            $dir = "documents/".date('F').date('Y');
            Storage::makeDirectory($dir);
            Storage::disk('public')->put($dir.'/'.$file_name, file_get_contents($file));
            PlayerDocument::create([
                'player_id' => $id,
                'type' => $request->type,
                'full_name' => $request->full_name,
                'ci' => $request->ci,
                'origin' => $request->origin,
                'file' => $dir.'/'.$file_name
            ]);

            return redirect()->route('voyager.players.index')->with(['message' => 'Archivo agregado correctamente.', 'alert-type' => 'success']);
        } catch (\Throwable $th) {
            dd($th);
            return redirect()->route('voyager.players.index')->with(['message' => 'Ocurrio un error.', 'alert-type' => 'error']);
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
