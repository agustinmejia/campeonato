@extends('voyager::master')

@section('page_title', 'Viendo juego')

@section('content')
    <div class="page-content read container-fluid">
        <div class="row">
            <div class="col-md-12">
                @php
                    $local_goals = 0;
                    $visitor_goals = 0;
                    $local_goals_details = collect();
                    $visitor_goals_details = collect();
                    
                    foreach($game->players as $item){
                        foreach ($item->player->teams as $team){
                            if ($team->team_id == $game->local_id){
                                foreach ($item->goals as $goal) {
                                    if($goal->type == 'normal' || $goal->type == 'penal'){
                                        $local_goals++;
                                        $local_goals_details->push([
                                            'player' => $item->player->first_name,
                                            'number' => $item->number,
                                            'type' => $goal->type,
                                            'min' => $goal->time
                                        ]);
                                    }elseif($goal->type == 'autogol'){
                                        $visitor_goals++;
                                        $visitor_goals_details->push([
                                            'player' => $item->player->first_name,
                                            'number' => $item->number,
                                            'type' => $goal->type,
                                            'min' => $goal->time
                                        ]);
                                    }
                                }
                            }
                        }
                    }
                    foreach($game->players as $item){
                        foreach ($item->player->teams as $team){
                            if ($team->team_id == $game->visitor_id){
                                foreach ($item->goals as $goal) {
                                    if($goal->type == 'normal' || $goal->type == 'penal'){
                                        $visitor_goals++;
                                        $visitor_goals_details->push([
                                            'player' => $item->player->first_name,
                                            'number' => $item->number,
                                            'type' => $goal->type,
                                            'min' => $goal->time
                                        ]);
                                    }elseif($goal->type == 'autogol'){
                                        $local_goals++;
                                        $local_goals_details->push([
                                            'player' => $item->player->first_name,
                                            'number' => $item->number,
                                            'type' => $goal->type,
                                            'min' => $goal->time
                                        ]);
                                    }
                                }
                            }
                        }
                    }
                @endphp
                <div class="panel panel-bordered">
                    <div class="row">
                        <br>
                        <div class="col-xs-4 col-sm-4 text-right">
                            <div style="display: flex; flex-direction: row-reverse">
                                <div style="padding: 0px 10px"><h3>{{ $game->local->name }}</h3></div>
                                <div><img src="{{ $game->local->club->logo ? asset('storage/'.$game->local->club->logo) : asset('images/default.jpg') }}" width="60px" alt=""></div>
                            </div>
                            @foreach ($local_goals_details->sortBy('min') as $item)
                                <small>{{ $item['player'] }} {{ $item['min'] }}' @if($item['type'] != 'normal') ({{ substr($item['type'], 0, 1) }}) @endif</small> <br>
                            @endforeach
                        </div>
                        <div class="col-xs-4 col-sm-4 text-center">
                            @if($game->status != 'finalizado')
                                <h1>
                                    <span>{{ $local_goals }} - {{ $visitor_goals }}</span>
                                    <br>
                                    <small id="timer">00:00</small>
                                </h1>
                                <div class="btn-group btn-group-sm">
                                    <button type="button" id="strt" class="btn btn-success">Iniciar</button>
                                    <button type="button" id="stp" class="btn btn-default">Pause</button>
                                    <button type="button" id="rst" class="btn btn-warning">Reset</button>
                                </div>
                            @else
                                <h1><span>{{ $local_goals }} - {{ $visitor_goals }}</span></h1>
                                <label class="label label-danger">{{ Str::ucfirst($game->status) }}</label> <br>
                                <a href="{{ route('championships.show', ['championship' => $game->championship_id]) }}" class="btn btn-warning">Volver a la lista <i class="voyager-list"></i></a>
                            @endif
                        </div>
                        <div class="col-xs-4 col-sm-4">
                            <div style="display: flex; flex-direction: row">
                                <div style="padding: 0px 10px"><h3>{{ $game->visitor->name }}</h3></div>
                                <div><img src="{{ $game->visitor->club->logo ? asset('storage/'.$game->visitor->club->logo) : asset('images/default.jpg') }}" width="60px" alt=""></div>
                            </div>
                            @foreach ($visitor_goals_details->sortBy('min') as $item)
                                <small>{{ $item['player'] }} {{ $item['min'] }}' @if($item['type'] != 'normal') ({{ substr($item['type'], 0, 1) }}) @endif</small> <br>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12" style="margin-bottom: 10px">
                        <div class="panel panel-bordered">
                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th style="width: 50px">N&deg;</th>
                                                    <th>Nombre</th>
                                                    <th class="text-right">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $cont = 0;
                                                    $local_enable_change = collect();
                                                @endphp
                                                @foreach($game->players->sortBy('number')->sortByDesc('playing') as $item)
                                                    @foreach ($item->player->teams as $team)
                                                        @if ($team->team_id == $game->local_id)
                                                            @php
                                                                $cont++;
                                                                if($item->type == 'suplente' && !$item->playing && $item->status == 'activo'){
                                                                    $local_enable_change->push($item->player);
                                                                }
                                                            @endphp
                                                            <tr>
                                                                <td><h5>{{ $cont }}</h5></td>
                                                                <td>
                                                                    <h5>
                                                                        @php
                                                                            $image = asset('images/default.jpg');
                                                                            if($item->player->image){
                                                                                $image = asset('storage/'.str_replace('.', '.', $item->player->image));
                                                                            }
                                                                        @endphp
                                                                        <img class="img-avatar" src="{{ $image }}" alt="">
                                                                        {{ $item->player->first_name }} {{ $item->player->last_name }} 
                                                                        @if($item->number) ({{ $item->number }}) @endif
                                                                            @if ($item->cards->count() > 0)
                                                                                @if ($item->cards->where('type', 'red')->count() > 0)
                                                                                    <img src="{{ asset('images/red-card.png') }}" width="10px" alt="">
                                                                                @else
                                                                                    <img src="{{ asset('images/yellow-card.png') }}" width="10px" alt="">  
                                                                                @endif
                                                                            @else
                                                                        @endif
                                                                    </h5>
                                                                </td>
                                                                <td style="width: 140px;" class="td-actions text-right">
                                                                    @if ($game->status != 'finalizado')
                                                                        @if ($item->playing)
                                                                            <a href="#" class="btn-change" data-item='@json($item)' data-type="local" data-toggle="modal" data-target="#change-modal"><img src="{{ asset('images/change.png') }}" width="25px" alt=""></a>    
                                                                            <a href="#" class="btn-goal" data-item='@json($item)' data-toggle="modal" data-target="#goal-modal"><img src="{{ asset('images/ball.png') }}" width="25px" alt=""></a>
                                                                            <a href="#" class="btn-card" data-item='@json($item)' data-type="yellow" data-toggle="modal" data-target="#card-modal"><img src="{{ asset('images/yellow-card.png') }}" width="25px" alt=""></a>
                                                                            <a href="#" class="btn-card" data-item='@json($item)' data-type="red" data-toggle="modal" data-target="#card-modal"><img src="{{ asset('images/red-card.png') }}" width="25px" alt=""></a>
                                                                        @endif
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="col-xs-6">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th style="width: 50px">N&deg;</th>
                                                    <th>Nombre</th>
                                                    <th class="text-right">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $cont = 0;
                                                    $visitor_enable_change = collect();
                                                @endphp
                                                @foreach($game->players->sortBy('number')->sortByDesc('playing') as $item)
                                                @foreach ($item->player->teams as $team)
                                                    @if ($team->team_id == $game->visitor_id)
                                                        @php
                                                            $cont++;
                                                            if($item->type == 'suplente' && !$item->playing && $item->status == 'activo'){
                                                                $visitor_enable_change->push($item->player);
                                                            }
                                                        @endphp
                                                        <tr>
                                                            <td><h5>{{ $cont }}</h5></td>
                                                            <td>
                                                                <h5>
                                                                    @php
                                                                        $image = asset('images/default.jpg');
                                                                        if($item->player->image){
                                                                            $image = asset('storage/'.str_replace('.', '.', $item->player->image));
                                                                        }
                                                                    @endphp
                                                                    <img class="img-avatar" src="{{ $image }}" alt="">
                                                                    {{ $item->player->first_name }} {{ $item->player->last_name }}
                                                                    @if($item->number) ({{ $item->number }}) @endif
                                                                        @if ($item->cards->count() > 0)
                                                                            @if ($item->cards->where('type', 'red')->count() > 0)
                                                                                <img src="{{ asset('images/red-card.png') }}" width="10px" alt="">
                                                                            @else
                                                                                <img src="{{ asset('images/yellow-card.png') }}" width="10px" alt="">  
                                                                            @endif
                                                                        @else
                                                                    @endif
                                                                </h5>
                                                            </td>
                                                            <td style="width: 140px;" class="td-actions text-right">
                                                                @if ($game->status != 'finalizado')
                                                                    @if ($item->playing)
                                                                        <a href="#" class="btn-change" data-item='@json($item)' data-type="visitor" data-toggle="modal" data-target="#change-modal"><img src="{{ asset('images/change.png') }}" width="25px" alt=""></a>    
                                                                        <a href="#" class="btn-goal" data-item='@json($item)' data-toggle="modal" data-target="#goal-modal"><img src="{{ asset('images/ball.png') }}" width="25px" alt=""></a>
                                                                        <a href="#" class="btn-card" data-item='@json($item)' data-type="yellow" data-toggle="modal" data-target="#card-modal"><img src="{{ asset('images/yellow-card.png') }}" width="25px" alt=""></a>
                                                                        <a href="#" class="btn-card" data-item='@json($item)' data-type="red" data-toggle="modal" data-target="#card-modal"><img src="{{ asset('images/red-card.png') }}" width="25px" alt=""></a>
                                                                    @endif
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                @if($game->status != 'finalizado')
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-bordered text-right">
                                <button class="btn btn-danger btn-lg" data-toggle="modal" data-target="#finish-modal" style="padding: 10px 20px; margin: 20px 10px">Finalizar partido <i class="glyphicon glyphicon-time"></i></button>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Goal modal --}}
    <form id="form-goal" action="{{ route('championships.game.goal', ['id' => $game->id]) }}" method="post">
        @csrf
        <input type="hidden" name="championship_details_player_id">
        <div class="modal fade" tabindex="-1" id="goal-modal" role="dialog">
            <div class="modal-dialog modal-primary">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><i class="voyager-edit"></i> Registrar gol</h4>
                    </div>
                    <div class="modal-body">
                        <table width="100%">
                            <tr>
                                <td class="text-center"><label class="radio-inline"><input type="radio" name="type" value="normal" checked>Normal</label></td>
                                <td class="text-center"><label class="radio-inline"><input type="radio" name="type" value="penal">Penal</label></td>
                                <td class="text-center"><label class="radio-inline"><input type="radio" name="type" value="autogol">Autogol</label></td>
                            </tr>
                        </table>
                        <div class="form-group">
                            <label for="time">Minuto</label>
                            <input type="number" name="time" class="form-control" min="1" required>
                        </div>
                    </div>
                    <div class="modal-footer text-right">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Registrar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    {{-- Card modal --}}
    <form id="form-card" action="{{ route('championships.game.card', ['id' => $game->id]) }}" method="post">
        @csrf
        <input type="hidden" name="championship_details_player_id">
        <div class="modal fade" tabindex="-1" id="card-modal" role="dialog">
            <div class="modal-dialog modal-primary">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><i class="voyager-edit"></i> Registrar tarjeta</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="type">Tipo</label>
                            <select name="type" class="form-control">
                                <option value="yellow">Tarjeta amarilla</option>
                                <option value="red">Tarjeta roja</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="time">Minuto</label>
                            <input type="number" name="time" class="form-control" min="1" required>
                        </div>
                        <div class="form-group">
                            <label for="observations">Observaciones</label>
                            <textarea name="observations" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer text-right">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Registrar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    {{-- Card modal --}}
    <form id="form-change" action="{{ route('championships.game.change', ['id' => $game->id]) }}" method="post">
        @csrf
        <input type="hidden" name="championship_details_player_id">
        <div class="modal fade" tabindex="-1" id="change-modal" role="dialog">
            <div class="modal-dialog modal-primary">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><i class="voyager-person"></i> Registrar cambio de jugador</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="player_id">Jugador entrante</label>
                            <select name="player_id" class="form-control" required></select>
                        </div>
                    </div>
                    <div class="modal-footer text-right">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Registrar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    {{-- Finish modal --}}
    <form id="form-finish" action="{{ route('championships.game.finish', ['id' => $game->id]) }}" method="post">
        @csrf
        @php
            $winner_id = null;
            if($local_goals > $visitor_goals){
                $winner_id = $game->local_id;
            }elseif($local_goals < $visitor_goals){
                $winner_id = $game->visitor_id;
            }
        @endphp
        <input type="hidden" name="winner_id" value="{{ $winner_id }}">
        <div class="modal fade modal-danger" tabindex="-1" id="finish-modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><i class="glyphicon glyphicon-time"></i> Finalizar partido</h4>
                    </div>
                    <div class="modal-body">
                        <table width="100%">
                            <tr>
                                <td class="text-center"><label class="radio-inline"><input type="radio" name="win_type" value="normal" checked>Normal</label></td>
                                <td class="text-center"><label class="radio-inline"><input type="radio" name="win_type" value="walkover">Walkover</label></td>
                            </tr>
                        </table>
                        <div class="form-group" id="div-winner_id_alt" style="display: none">
                            <label for="winner_id_alt">Equipo ganador</label>
                            <select name="winner_id_alt" class="form-control">
                                <option value="{{ $game->local_id }}">{{ $game->local->name }}</option>
                                <option value="{{ $game->visitor_id }}">{{ $game->visitor->name }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="observations">Observaciones</label>
                            <textarea name="observations" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer text-right">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger">Finalizar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@stop

@section('css')
    <style>
        .td-actions img{
            filter: grayscale(100%);
        }
        .td-actions img:hover{
            filter: grayscale(0%);;
            /* width: 28px */
        }
        .img-avatar{
            width: 30px;
            height: 30px;
            border-radius: 15px;
            margin-right: 5px
        }
    </style>
@endsection

@section('javascript')
    <script>

        // Si el partio está finalizado se debe resetear el reloj
        @if($game->status == 'finalizado')
        localStorage.setItem('time', '')
        @endif

        var h1 = document.getElementById('timer');
        var start = document.getElementById('strt');
        var stop = document.getElementById('stp');
        var reset = document.getElementById('rst');
        var sec = 0;
        var min = 0;
        var t;

        if(localStorage.getItem('time')){
            let currentTime = JSON.parse(localStorage.getItem('time'));
            min = currentTime.min;
            sec = currentTime.sec;
            timer();
        }

        function tick(){
            sec++;
            if (sec >= 60) {
                sec = 0;
                min++;
            }
        }
        function add() {
            tick();
            h1.textContent = (min > 9 ? min : "0" + min)
                    + ":" + (sec > 9 ? sec : "0" + sec);
            localStorage.setItem('time', `{"min": ${min}, "sec": ${sec}}`);
            timer();
        }
        function timer() {
            t = setTimeout(add, 1000);
            start.disabled = true;
            stop.disabled = false;
        }

        // timer();
        start.onclick = timer;
        stop.onclick = function() {
            clearTimeout(t);
            start.disabled = false;
            stop.disabled = true;
        }
        reset.onclick = function() {
            clearTimeout(t);
            start.disabled = false;
            stop.disabled = true;
            let time = window.prompt('Ingresa el tiempo actual');
            if(time){
                time = time.split(':');
                if(time.length == 2){
                    min = !isNaN(time[0]) ? parseInt(time[0]) : 0;
                    sec = !isNaN(time[1]) ? parseInt(time[1]) : 0;
                    h1.textContent = min+':'+sec;
                }else{
                    h1.textContent = '00:00';
                    seconds = 0; minutes = 0;
                } 
            }
        }
    </script>

    <script>
        $(document).ready(function () {
            let local_enable_change = @json($local_enable_change);
            let visitor_enable_change = @json($visitor_enable_change);

            // Click en gol
            $('.btn-goal').click(function(){
                let item = $(this).data('item');
                $('#form-goal input[name="championship_details_player_id"]').val(item.id)
                $('#form-goal input[name="time"]').val(min)
            });

            $('.btn-card').click(function(){
                let item = $(this).data('item');
                let type = $(this).data('type');
                $('#form-card input[name="championship_details_player_id"]').val(item.id);
                $('#form-card input[name="time"]').val(min);
                $('#form-card select[name="type"]').val(type);
            });

            $('.btn-change').click(function(){
                let item = $(this).data('item');
                let type = $(this).data('type');
                $('#form-change input[name="championship_details_player_id"]').val(item.id);

                $('#form-change select[name=player_id]').html('<option value="">--Seleccione jugador--</option>');
                let players = type == 'local' ? local_enable_change : visitor_enable_change;
                players.map(item => {
                    $('#form-change select[name=player_id]').append(`
                        <option value="${item.id}">${item.first_name} ${item.last_name}</option>
                    `);
                });
            });

            $('#form-finish input[name="win_type"]').click(function(){
                let value = $("#form-finish input[name='win_type']:checked").val();
                value == 'normal' ? $('#div-winner_id_alt').fadeOut() : $('#div-winner_id_alt').fadeIn();
            });
        });
    </script>
@stop
