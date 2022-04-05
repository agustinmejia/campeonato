@extends('voyager::master')

@section('page_title', 'Ver Traspases')

@section('page_header')
    <h1 class="page-title">
        <i class="voyager-person"></i> Traspases
        <button data-toggle="modal" data-target="#transfer_modal" class="btn btn-primary">
            <i class="voyager-plus"></i> <span>Crear</span>
        </button>
        <a href="{{ route('voyager.players.index') }}" class="btn btn-warning">
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
                        <div class="col-md-4">
                            <div class="panel-heading" style="border-bottom:0;">
                                <h3 class="panel-title">Código</h3>
                            </div>
                            <div class="panel-body" style="padding-top:0;">
                                <p>{{ str_pad($player->id, 4, "0", STR_PAD_LEFT) }}</p>
                            </div>
                            <hr style="margin:0;">
                        </div>
                        <div class="col-md-4">
                            <div class="panel-heading" style="border-bottom:0;">
                                <h3 class="panel-title">Nombre completo</h3>
                            </div>
                            <div class="panel-body" style="padding-top:0;">
                                <p>{{ $player->first_name }} {{ $player->last_name }}</p>
                            </div>
                            <hr style="margin:0;">
                        </div>
                        <div class="col-md-4">
                            <div class="panel-heading" style="border-bottom:0;">
                                <h3 class="panel-title">Club actual</h3>
                            </div>
                            <div class="panel-body" style="padding-top:0;">
                                <p>{{ count($player->teams) > 0 ? $player->teams[0]->team ? $player->teams[0]->team->club->name : 'No definido' : 'No definido' }}</p>
                            </div>
                            <hr style="margin:0;">
                        </div>
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>N&deg;</th>
                                            <th>Código</th>
                                            <th>Origen</th>
                                            <th>Destino</th>
                                            <th>Fecha</th>
                                            <th class="text-right">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $cont = 1;
                                        @endphp
                                        @forelse ($player->transfers as $item)
                                            <tr>
                                                <td>{{ $cont }}</td>
                                                <td>{{ str_pad($item->id, 4, "0", STR_PAD_LEFT) }}</td>
                                                <td>{{ $item->origin_club->name }}</td>
                                                <td>{{ $item->destiny_club->name }}</td>
                                                <td>{{ date('d/m/Y', strtotime($item->date)) }}<br><small>{{ Carbon\Carbon::parse($item->date)->diffForHumans() }}</small></td>
                                                <td class="no-sort no-click bread-actions text-right">
                                                    <a href="{{ route('players.transfers.print', ['id' => $item->id, 'type' => 'transfer']) }}" title="Imprimir traspase" target="_blank" class="btn btn-sm btn-danger view">
                                                        <i class="glyphicon glyphicon-print"></i> <span class="hidden-xs hidden-sm">Imprimir</span>
                                                    </a>
                                                </td>
                                            </tr>
                                            @php
                                                $cont++;
                                            @endphp
                                        @empty
                                        <tr>
                                            <td colspan="6"><h5 class="text-center">No hay traspases registradas</h5></td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- transfer modal --}}
    <form action="{{ route('players.transfers.store', ['id' => $player->id]) }}" id="transfer_form" method="POST">
        @csrf
        <input type="hidden" name="origin" value="{{ count($player->teams) > 0 ? $player->teams[0]->team ? $player->teams[0]->team_id : '' : '' }}">
        <div class="modal modal-info fade" tabindex="-1" id="transfer_modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><i class="voyager-person"></i> Registrar traspase</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="destiny">Equipo de destino</label>
                                <select name="destiny" class="form-control select2" required>
                                    <option value="">Seleccione el equipo de destino</option>
                                    @foreach (\App\Models\Club::where('status', 'activo')->where('deleted_at', NULL)->get() as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label for="date">Fecha de transferencia</label>
                                <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}" required>
                            </div>
                            <div class="col-md-12">
                                <label for="observations">Observaciones</label>
                                <textarea name="observations" rows="3" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <input type="submit" class="btn btn-info" value="Sí, registrar">
                    </div>
                </div>
            </div>
        </div>
    </form>
@stop

@section('javascript')
    <script>
        $(document).ready(function () {
            
        });
    </script>
@stop
