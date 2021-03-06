@extends('voyager::master')

@section('page_title', 'Ver Fixture')

@section('page_header')
    <h1 class="page-title">
        <i class="voyager-folder"></i> Viendo Fixture
        <a href="{{ route('championshipscategories.index') }}" class="btn btn-warning">
            <span class="glyphicon glyphicon-list"></span>&nbsp;
            Volver a la lista
        </a>
    </h1>
@stop

@section('content')
    <div class="page-content read container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered" style="padding-bottom:5px;">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="panel-heading" style="border-bottom:0;">
                                <h3 class="panel-title">Nombre</h3>
                            </div>
                            <div class="panel-body" style="padding-top:0;">
                                <p>{{ $fixture->championship->name }}</p>
                            </div>
                            <hr style="margin:0;">
                        </div>
                        <div class="col-md-6">
                            <div class="panel-heading" style="border-bottom:0;">
                                <h3 class="panel-title">Gestión</h3>
                            </div>
                            <div class="panel-body" style="padding-top:0;">
                                <p>{{ $fixture->championship->year }}</p>
                            </div>
                            <hr style="margin:0;">
                        </div>
                        <div class="col-md-6">
                            <div class="panel-heading" style="border-bottom:0;">
                                <h3 class="panel-title">Fecha de inicio</h3>
                            </div>
                            <div class="panel-body" style="padding-top:0;">
                                <p>{{ date('d/m/Y', strtotime($fixture->championship->start)) }}</p>
                            </div>
                            <hr style="margin:0;">
                        </div>
                        <div class="col-md-6">
                            <div class="panel-heading" style="border-bottom:0;">
                                <h3 class="panel-title">Fecha de finalización</h3>
                            </div>
                            <div class="panel-body" style="padding-top:0;">
                                <p>{{ date('d/m/Y', strtotime($fixture->championship->finish)) }}</p>
                            </div>
                            <hr style="margin:0;">
                        </div>
                        <div class="col-md-6">
                            <div class="panel-heading" style="border-bottom:0;">
                                <h3 class="panel-title">Categoría</h3>
                            </div>
                            <div class="panel-body" style="padding-top:0;">
                                <p>{{ $fixture->category->name }}</p>
                            </div>
                            <hr style="margin:0;">
                        </div>
                        <div class="col-md-6">
                            <div class="panel-heading" style="border-bottom:0;">
                                <h3 class="panel-title">Estado</h3>
                            </div>
                            <div class="panel-body" style="padding-top:0;">
                                <p>{{ $fixture->status }}</p>
                            </div>
                            <hr style="margin:0;">
                        </div>
                    </div>
                </div>

                <div class="panel panel-bordered" style="padding-bottom:5px;">
                    <div class="row">
                        <div class="col-md-12">
                            <table id="dataTable" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th colspan="8"><h4 class="text-center">FIXTURE</h4></th>
                                    </tr>
                                    <tr>
                                        <th>N&deg;</th>
                                        <th>Descripción</th>
                                        <th>Local</th>
                                        <th>Visitante</th>
                                        <th>Fecha y hora</th>
                                        <th>Tarjetas</th>
                                        <th class="text-center">Resultado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $cont = 1;
                                    @endphp
                                    @foreach ($fixture->details as $detail)
                                        <tr>
                                            <td>{{ $cont }}</td>
                                            <td>{{ $detail->title }}</td>
                                            <td><img src="{{ $detail->local->club->logo ? asset('storage/'.$detail->local->club->logo) : asset('images/default.jpg') }}" width="20px" alt=""> {{ $detail->local->name }}</td>
                                            <td><img src="{{ $detail->visitor->club->logo ? asset('storage/'.$detail->visitor->club->logo) : asset('images/default.jpg') }}" width="20px" alt=""> {{ $detail->visitor->name }}</td>
                                            <td>{{ date('d/m/Y H:i', strtotime($detail->datetime)) }}</td>
                                            <td>
                                                @php
                                                    $yellow_cards = 0;
                                                    $red_cards = 0;
                                                    foreach ($detail->players as $player){
                                                        $yellow_cards += $player->cards->where('type', 'yellow')->count();
                                                        $red_cards += $player->cards->where('type', 'red')->count();
                                                    }
                                                @endphp
                                                <img src="{{ asset('images/yellow-card.png') }}" width="12px"> <b>{{ $yellow_cards }}</b> | <img src="{{ asset('images/red-card.png') }}" width="12px"> <b>{{ $red_cards }}</b>
                                            </td>
                                            <td class="text-center">
                                                @if ($detail->status == 'finalizado')
                                                    @if ($detail->win_type == 'normal')
                                                        @php
                                                            $local_goals = 0;
                                                            $visitor_goals = 0;
                                                            $local_goals_details = collect();
                                                            $visitor_goals_details = collect();
                                                            
                                                            foreach($detail->players as $item){
                                                                foreach ($item->player->teams as $team){
                                                                    if ($team->team_id == $detail->local_id){
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
                                                            foreach($detail->players as $item){
                                                                foreach ($item->player->teams as $team){
                                                                    if ($team->team_id == $detail->visitor_id){
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
                                                        {{ $local_goals }} - {{ $visitor_goals }} <br>
                                                    @else
                                                        Walkover <br>
                                                    @endif
                                                    <b>
                                                        @if ($detail->winner)
                                                            <label class="label label-success">{{ $detail->winner->name }}    </label>    
                                                        @else
                                                            <label class="label label-info">Empate</label>
                                                        @endif
                                                    </b>
                                                @else
                                                    por definirse
                                                @endif
                                            </td>
                                            <td class="no-sort no-click bread-actions">
                                                @if (count($detail->players) == 0 && $detail->status != 'finalizado')
                                                    <a href="#" data-detail='@json($detail)' data-toggle="modal" data-target="#enable-modal" title="Habilitar" class="btn btn-sm btn-info btn-enable">
                                                        <i class="voyager-check"></i> <span class="hidden-xs hidden-sm">Habilitar</span>
                                                    </a>    
                                                    <a href="#" data-detail='@json($detail)' data-toggle="modal" data-target="#finish-modal" title="Finalizar" class="btn btn-sm btn-danger btn-finish">
                                                        <i class="glyphicon glyphicon-time"></i> <span class="hidden-xs hidden-sm">Finalizar</span>
                                                    </a>    
                                                @endif
                                                @if (count($detail->players) > 0 && $detail->status == 'pendiente')
                                                    <a href="{{ route('championshipscategories.game', ['id' => $detail->id]) }}" title="Jugar" class="btn btn-sm btn-success">
                                                        <i class="voyager-play"></i> <span class="hidden-xs hidden-sm">Jugar</span>
                                                    </a>
                                                @endif
                                                @if ($detail->status == 'finalizado')
                                                    <a href="{{ route('championshipscategories.game', ['id' => $detail->id]) }}" title="Ver detalles" class="btn btn-sm btn-warning">
                                                        <i class="voyager-list"></i> <span class="hidden-xs hidden-sm">Ver</span>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                        @php
                                            $cont++;
                                        @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="panel panel-bordered" style="padding-bottom:5px;">
                    <div class="row">
                        <div class="col-md-12">
                            <table id="dataTable" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th colspan="7"><h4 class="text-center">TABLA DE POSICIONES</h4></th>
                                    </tr>
                                    <tr>
                                        <th>N&deg;</th>
                                        <th>Equipo</th>
                                        <th>PJ</th>
                                        <th>PG</th>
                                        <th>PE</th>
                                        <th>PP</th>
                                        <th>Pts.</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $cont = 0;
                                    @endphp
                                    @foreach ($fixture->teams as $item)
                                        @php
                                            $pg = 0;
                                            $pe = 0;
                                            $pp = 0;
                                            foreach($fixture->details as $detail){
                                                if($detail->status == 'finalizado'){
                                                    if(($detail->local_id == $item->team_id || $detail->visitor_id == $item->team_id) && $detail->winner_id == $item->team_id){
                                                        $pg++;
                                                    }
                                                    if(($detail->local_id == $item->team_id || $detail->visitor_id == $item->team_id) && $detail->winner_id == null){
                                                        $pe++;
                                                    }

                                                    if(($detail->local_id == $item->team_id || $detail->visitor_id == $item->team_id) && $detail->winner_id != null && $detail->winner_id != $item->team_id){
                                                        $pp++;
                                                    }
                                                }
                                            }
                                            $fixture->teams[$cont]->pj = $pg + $pe + $pp;
                                            $fixture->teams[$cont]->pg = $pg;
                                            $fixture->teams[$cont]->pe = $pe;
                                            $fixture->teams[$cont]->pp = $pp;
                                            $fixture->teams[$cont]->points = ($pg *3) + ($pe *1);
                                            $cont++;
                                        @endphp
                                    @endforeach

                                    @php
                                        $cont = 1;
                                    @endphp
                                    @foreach ($fixture->teams->sortByDesc('points') as $item)
                                        <tr>
                                            <td>{{ $cont }}</td>
                                            <td><img src="{{ $item->team->club->logo ? asset('storage/'.$item->team->club->logo) : asset('images/default.jpg') }}" width="20px" alt=""> {{ $item->team->name }}</td>
                                            <td>{{ $item->pj }}</td>
                                            <td>{{ $item->pg }}</td>
                                            <td>{{ $item->pe }}</td>
                                            <td>{{ $item->pp }}</td>
                                            <td>{{ $item->points }}</td>
                                        </tr>
                                        @php
                                            $cont++;
                                        @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Enable modal --}}
    <form id="form-enable" action="{{ route('championshipscategories.details.enable', ['id' => $fixture->id]) }}" method="post">
        @csrf
        <input type="hidden" name="championships_detail_id">
        <div class="modal fade" tabindex="-1" id="enable-modal" role="dialog">
            <div class="modal-dialog modal-warning modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><i class="voyager-check"></i> Habilitar encuentro</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6" style="padding-left: 20px; padding-right: 10px">
                                <table id="table-local" class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th colspan="4" class="text-center" id="label-local">Local</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                            <div class="col-md-6" style="padding-right: 20px; padding-left: 10px">
                                <table id="table-visitor" class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th colspan="4" class="text-center" id="label-visitor">Visita</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer text-right">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-warning">habilitar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    {{-- Finish modal --}}
    <form id="form-finish" action="#" method="post">
        @csrf
        <input type="hidden" name="win_type" value="walkover">
        <div class="modal fade modal-danger" tabindex="-1" id="finish-modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><i class="glyphicon glyphicon-time"></i> Finalizar partido por walkover</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group" id="div-winner_id_alt">
                            <label for="winner_id_alt">Equipo ganador</label>
                            <select name="winner_id_alt" id="select-winner_id_alt" class="form-control" required>
                                
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="observations">Observaciones</label>
                            <textarea name="observations" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer text-right">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger btn-submit">Finalizar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@stop

@section('css')
    <style>
        .check-player{
            transform: scale(1.2)
        }
    </style>
@endsection

@section('javascript')
    <script>
        $(document).ready(function () {
            $('.btn-enable').click(function(){
                let detail = $(this).data('detail');

                $('#form-enable input[name="championships_detail_id"]').val(detail.id)

                $('#label-local').html(detail.local.name);
                $('#label-visitor').html(detail.visitor.name);

                $('#table-local tbody').empty();
                detail.local.team_players.map(function(value, index){
                    $('#table-local tbody').append(`
                        <tr id="tr-${value.player_id}">
                            <td>${index +1}</td>
                            <td><input type="checkbox" name="player_id[]" value="${value.player_id}" onclick="changePlayer(${value.player_id})" id="check-player-${value.player_id}" class="check-player" /></td>
                            <td><b>${value.player.first_name} ${value.player.last_name}</b></td>
                        </tr>
                    `);
                });

                $('#table-visitor tbody').empty();
                detail.visitor.team_players.map(function(value, index){
                    $('#table-visitor tbody').append(`
                        <tr id="tr-${value.player_id}">
                            <td>${index +1}</td>
                            <td><input type="checkbox" name="player_id[]" value="${value.player_id}" onclick="changePlayer(${value.player_id})" id="check-player-${value.player_id}" class="check-player" /></td>
                            <td><b>${value.player.first_name} ${value.player.last_name}</b></td>
                        </tr>
                    `);
                });
            });

            $('.btn-finish').click(function(){
                let detail = $(this).data('detail');
                let url = "{{ url('admin/championshipscategories/game') }}/"+detail.id+"/finish";
                $('#form-finish').attr('action', url);
                $('#select-winner_id_alt').html(`
                    <option value="">Seleccione al equipo ganador</option>
                    <option value="${detail.local.id}">${detail.local.name}</option>
                    <option value="${detail.visitor.id}">${detail.visitor.name}</option>
                `);
                console.log(detail)
            });
        });

        function changePlayer(id){
            let check = $(`#check-player-${id}`)[0].checked;
            if(check){
                $(`#tr-${id}`).append(`
                    <td class="td-info-player-${id}"><input type="number" name="number[]" min="1" max="99" class="form-control" style="width: 80px" placeholder="N&deg;" /></td>
                `);
            }else{
                $(`.td-info-player-${id}`).remove();
            }
        }
    </script>
@stop
