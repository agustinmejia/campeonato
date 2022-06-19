@extends('voyager::master')

@section('page_title', 'Ver Campeonato')

@section('page_header')
    <h1 class="page-title">
        <i class="voyager-folder"></i> Viendo Campeonato
        <a href="{{ route('championships.index') }}" class="btn btn-warning">
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
                                <p>{{ $championship->name }}</p>
                            </div>
                            <hr style="margin:0;">
                        </div>
                        <div class="col-md-6">
                            <div class="panel-heading" style="border-bottom:0;">
                                <h3 class="panel-title">Gestión</h3>
                            </div>
                            <div class="panel-body" style="padding-top:0;">
                                <p>{{ $championship->year }}</p>
                            </div>
                            <hr style="margin:0;">
                        </div>
                        <div class="col-md-6">
                            <div class="panel-heading" style="border-bottom:0;">
                                <h3 class="panel-title">Fecha de inicio</h3>
                            </div>
                            <div class="panel-body" style="padding-top:0;">
                                <p>{{ date('d/m/Y', strtotime($championship->start)) }}</p>
                            </div>
                            <hr style="margin:0;">
                        </div>
                        <div class="col-md-6">
                            <div class="panel-heading" style="border-bottom:0;">
                                <h3 class="panel-title">Fecha de finalización</h3>
                            </div>
                            <div class="panel-body" style="padding-top:0;">
                                <p>{{ date('d/m/Y', strtotime($championship->finish)) }}</p>
                            </div>
                            <hr style="margin:0;">
                        </div>
                        <div class="col-md-6">
                            <div class="panel-heading" style="border-bottom:0;">
                                <h3 class="panel-title">Categoría</h3>
                            </div>
                            <div class="panel-body" style="padding-top:0;">
                                <p>{{ $championship->category->name }}</p>
                            </div>
                            <hr style="margin:0;">
                        </div>
                        <div class="col-md-6">
                            <div class="panel-heading" style="border-bottom:0;">
                                <h3 class="panel-title">Estado</h3>
                            </div>
                            <div class="panel-body" style="padding-top:0;">
                                <p>{{ $championship->status }}</p>
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
                                        <th colspan="7"><h4 class="text-center">FIXTURE</h4></th>
                                    </tr>
                                    <tr>
                                        <th>N&deg;</th>
                                        <th>Descripción</th>
                                        <th>Local</th>
                                        <th>Visitante</th>
                                        <th>Fecha y hora</th>
                                        <th>Resultado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $cont = 1;
                                    @endphp
                                    @foreach ($championship->details as $item)
                                        <tr>
                                            <td>{{ $cont }}</td>
                                            <td>{{ $item->title }}</td>
                                            <td><img src="{{ $item->local->club->logo ? asset('storage/'.$item->local->club->logo) : asset('images/default.jpg') }}" width="20px" alt=""> {{ $item->local->name }}</td>
                                            <td><img src="{{ $item->visitor->club->logo ? asset('storage/'.$item->visitor->club->logo) : asset('images/default.jpg') }}" width="20px" alt=""> {{ $item->visitor->name }}</td>
                                            <td>{{ date('d/m/Y H:i', strtotime($item->datetime)) }}</td>
                                            <td></td>
                                            <td class="no-sort no-click bread-actions">
                                                @if (count($item->players) == 0)
                                                <a href="#" data-item='@json($item)' data-toggle="modal" data-target="#enable-modal" title="Habilitar" class="btn btn-sm btn-warning btn-enable">
                                                    <i class="voyager-check"></i> <span class="hidden-xs hidden-sm">Habilitar</span>
                                                </a>    
                                                @endif
                                                @if (count($item->players) > 0 && $item->status == 'pendiente')
                                                <a href="{{ route('championships.game', ['id' => $item->id]) }}" title="Jugar" class="btn btn-sm btn-success">
                                                    <i class="voyager-play"></i> <span class="hidden-xs hidden-sm">Jugar</span>
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
            </div>
        </div>
    </div>

    {{-- Enable modal --}}
    <form id="form-enable" action="{{ route('championships.details.enable', ['id' => $championship->id]) }}" method="post">
        @csrf
        <input type="hidden" name="championship_detail_id">
        <div class="modal fade" tabindex="-1" id="enable-modal" role="dialog">
            <div class="modal-dialog modal-warning modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><i class="voyager-check"></i> Habilitar encuentro</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table id="table-local" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th colspan="3" class="text-center">Local</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table id="table-visitor" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th colspan="3" class="text-center">Visita</th>
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
@stop

@section('javascript')
    <script>
        $(document).ready(function () {
            $('.btn-enable').click(function(){
                let item = $(this).data('item');

                $('#form-enable input[name="championship_detail_id"]').val(item.id)

                $('#table-local tbody').empty();
                item.local.team_players.map(function(value){
                    $('#table-local tbody').append(`
                        <tr>
                            <td><input type="checkbox" name="local_id[]" value="${value.player_id}" style=" transform: scale(1.5);" /></td>
                            <td>${value.player.first_name} ${value.player.last_name}</td>
                            <td><input type="number" name="local_number[]" class="form-control" style="width: 80px" placeholder="N&deg;" /></td>
                        </tr>
                    `);
                });

                $('#table-visitor tbody').empty();
                item.visitor.team_players.map(function(value){
                    $('#table-visitor tbody').append(`
                        <tr>
                            <td><input type="checkbox" name="visitor_id[]" value="${value.player_id}" style=" transform: scale(1.5);" /></td>
                            <td>${value.player.first_name} ${value.player.last_name}</td>
                            <td><input type="number" name="visitor_number[]" class="form-control" style="width: 80px" placeholder="N&deg;" /></td>
                        </tr>
                    `);
                });
            });
        });
    </script>
@stop
