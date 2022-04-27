@extends('voyager::master')

@section('page_title', 'Ver Traspases')

@php
    $current_team = NULL;
    if(count($player->teams) > 0){
        $current_team = $player->teams[0]->team ? $player->teams[0]->team->club : NULL;
    }


@endphp

@section('page_header')
    <h1 class="page-title">
        <i class="voyager-person"></i> Traspases
        @if ($current_team)
        <button data-toggle="modal" data-target="#transfer_modal" class="btn btn-primary">
            <i class="voyager-plus"></i> <span>Crear</span>
        </button> 
        @endif
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
                                <p>{{ $current_team ? $current_team->name : 'No definido' }}</p>
                            </div>
                            <hr style="margin:0;">
                        </div>
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table id="dataTable" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>N&deg;</th>
                                            <th>Código</th>
                                            <th>Origen</th>
                                            <th>Destino</th>
                                            <th>Fecha</th>
                                            <th class="text-right" style="max-width: 200px">Acciones</th>
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
                                                <td>{{ $item->origin_club ? $item->origin_club->name : 'No definido' }}</td>
                                                <td>{{ $item->destiny_club ? $item->destiny_club->name : 'No definido' }}</td>
                                                <td>{{ date('d/m/Y', strtotime($item->date)) }}<br><small>{{ Carbon\Carbon::parse($item->date)->diffForHumans() }}</small></td>
                                                <td class="no-sort no-click bread-actions text-right">
                                                    <a href="{{ route('players.transfers.print', ['id' => $item->id, 'type' => 'transfer']) }}" title="Imprimir traspase" target="_blank" class="btn btn-sm btn-default view">
                                                        <i class="glyphicon glyphicon-print"></i> <span class="hidden-xs hidden-sm">Imprimir</span>
                                                    </a>
                                                    @if ($cont == 1)
                                                    <button title="Borrar" class="btn btn-sm btn-danger btn-delete" data-toggle="modal" data-id="{{ $item->id }}" data-target="#delete_modal">
                                                        <i class="voyager-trash"></i> <span class="hidden-xs hidden-sm">Borrar</span>
                                                    </button>
                                                    @endif
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
        <input type="hidden" name="origin" value="{{ $current_team ? $current_team->id : '' }}">
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
                                <label for="destiny">Club de destino</label>
                                <select name="destiny" id="select-destiny" class="form-control select2" required>
                                    <option value="">Seleccione el equipo de destino</option>
                                    @foreach (\App\Models\Club::where('status', 'activo')->where('deleted_at', NULL)->get() as $item)
                                    <option value="{{ $item->id }}" @if($current_team) {{ $current_team->id == $item->id ? 'disabled' : '' }} @endif>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-12">
                                <label class="control-label" for="first_name">Equipo(s)</label>
                                <select name="team_id[]" id="select-team_id" class="form-control select2" multiple required></select>
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

    {{-- delete modal --}}
    <div class="modal modal-danger fade" tabindex="-1" id="delete_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="voyager-trash"></i> Desea eliminar el siguiente registro?</h4>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('players.transfers.delete', ['id' => $player->id]) }}" id="delete_form" method="POST">
                        @csrf
                        <input type="hidden" name="id">
                        <input type="submit" class="btn btn-danger pull-right delete-confirm" value="Sí, eliminar">
                    </form>
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('javascript')
    <script>
        $(document).ready(function () {
            $('#select-destiny').change(function(){
                $.ajax({
                    url: '/admin/clubs/' + $('#select-destiny').val()+'/teams?type=ajax',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data){
                        $('#select-team_id').empty();
                        $.each(data.teams, (index, value) => {
                            $('#select-team_id').append('<option value="' + value.id + '">' + value.name + ' - ' + value.category.name + '</option>');
                        });
                    }
                });
            });

            $('.btn-delete').click(function(){
                let id = $(this).data('id');
                $('#delete_form input[name="id"]').val(id);
            });
        });
    </script>
@stop
