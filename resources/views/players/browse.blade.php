@extends('voyager::master')

@section('page_title', 'Viendo Jugadores')

@section('page_header')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8" style="margin: 0px">
                <h1 class="page-title">
                    <i class="voyager-person"></i> Jugadores
                </h1>
                <a href="#" class="btn btn-success btn-add-new">
                    <i class="voyager-plus"></i> <span>Crear</span>
                </a>
            </div>
            <div class="col-md-4" style="margin: 0px">

            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="page-content browse container-fluid">
        @include('voyager::alerts')
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="dataTable" class="table table-hover">
                                <thead>
                                    <th>Id</th>
                                    <th>Nombre completo</th>
                                    <th>CI</th>
                                    <th>Fecha nac.</th>
                                    <th>lugar nac.</th>
                                    <th>Club</th>
                                    <th>Foto</th>
                                    <th class="text-right">Acciones</th>
                                </thead>
                                <tbody>
                                    @foreach ($players as $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->first_name }} {{ $item->last_name }}</td>
                                            <td>{{ $item->ci }}</td>
                                            <td>{{ $item->birthday }}</td>
                                            <td>{{ $item->origin }}</td>
                                            <td>{{ $item->teams[0]->team->club->name }}</td>
                                            <td>
                                                @if ($item->image)
                                                    <img src="{{ asset('storage/'.$item->image) }}" width="50px" />
                                                @endif
                                            </td>
                                            <td class="no-sort no-click bread-actions text-right">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-default dropdown-toggle"
                                                            data-toggle="dropdown">
                                                      Imprimir <span class="caret"></span>
                                                    </button>
                                                  
                                                    <ul class="dropdown-menu" role="menu">
                                                      <li><a href="{{ route('players.print', ['id' => $item->id, 'type' => 'credencial']) }}" target="_blank">Credencial</a></li>
                                                      <li><a href="{{ route('players.print', ['id' => $item->id, 'type' => 'certificado']) }}" target="_blank">kardex</a></li>
                                                    </ul>
                                                  </div>
                                                <a href="{{ route('voyager.players.show', ['id' => $item->id]) }}" title="Ver" class="btn btn-sm btn-warning view">
                                                    <i class="voyager-eye"></i> <span class="hidden-xs hidden-sm">Ver</span>
                                                </a>
                                                <a href="{{ route('voyager.players.edit', ['id' => $item->id]) }}" title="Editar" class="btn btn-sm btn-primary edit">
                                                    <i class="voyager-edit"></i> <span class="hidden-xs hidden-sm">Editar</span>
                                                </a>
                                                <a href="javascript:;" title="Borrar" class="btn btn-sm btn-danger delete" onclick="deleteItem({{ $item->id }})" data-toggle="modal" data-target="#delete_modal">
                                                    <i class="voyager-trash"></i> <span class="hidden-xs hidden-sm">Borrar</span>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Single delete modal --}}
    <div class="modal modal-danger fade" tabindex="-1" id="delete_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="voyager-trash"></i> Desea eliminar el siguiente registro?</h4>
                </div>
                <div class="modal-footer">
                    <form action="#" id="delete_form" method="POST">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-danger pull-right delete-confirm" value="Sí, eliminar">
                    </form>
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')

@stop

@section('javascript')
    <script>
        $(document).ready(function() {
            var table = $('#dataTable').DataTable({"order":[],"language":{"sEmptyTable":"No hay datos disponibles en la tabla","sInfo":"Mostrando _START_ a _END_ de _TOTAL_ entradas","sInfoEmpty":"Mostrando 0 a 0 de 0 entradas","sInfoFiltered":"(Filtrada de _MAX_ entradas totales)","sInfoPostFix":"","sInfoThousands":",","sLengthMenu":"Mostrar _MENU_ entradas","sLoadingRecords":"Cargando...","sProcessing":"Procesando...","sSearch":"Buscar:","sZeroRecords":"No se encontraron registros coincidentes","oPaginate":{"sFirst":"Primero","sLast":"\u00daltimo","sNext":"Siguiente","sPrevious":"Anterior"},"oAria":{"sSortAscending":": Activar para ordenar la columna ascendente","sSortDescending":": Activar para ordenar la columna descendente"}},"columnDefs":[{"targets":"dt-not-orderable","searchable":false,"orderable":false}]});
        });

        function deleteItem(id){
            let url = '{{ url("admin/players") }}/'+id;
            $('#delete_form').attr('action', url);
        }
    </script>
@stop
