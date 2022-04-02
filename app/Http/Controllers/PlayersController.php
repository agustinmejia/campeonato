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

class PlayersController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $players = Player::where('deleted_at', NULL)->orderBy('id', 'DESC')->get();
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
        $player = Player::where('id', $id)->with('teams.team')->first();
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
            return redirect()->route('voyager.players.index')->with(['message' => 'Jugador editado exitosamente.', 'alert-type' => 'success']);
        } catch (\Throwable $th) {
            DB::rollback();
            // dd($th);
        }
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
