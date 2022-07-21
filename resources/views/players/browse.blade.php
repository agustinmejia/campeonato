@extends('voyager::master')

@section('page_title', 'Viendo Jugadores')

@if (auth()->user()->hasPermission('browse_players'))

    @section('page_header')
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8" style="margin: 0px">
                    <h1 class="page-title">
                        <i class="voyager-person"></i> Jugadores
                    </h1>
                    @if (auth()->user()->hasPermission('add_players'))
                        <a href="{{ route('voyager.players.create') }}" class="btn btn-success btn-add-new">
                            <i class="voyager-plus"></i> <span>Crear</span>
                        </a>
                    @endif
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
                                        <th>Estado</th>
                                        <th class="text-right">Acciones</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($players as $item)
                                            <tr>
                                                <td>{{ $item->id }}</td>
                                                <td>{{ $item->first_name }} {{ $item->last_name }}</td>
                                                <td>{{ $item->ci }}</td>
                                                <td>{{ $item->birthday }}</td>
                                                <td>{{ Str::ucfirst($item->origin) }}</td>
                                                <td>{{ count($item->teams) > 0 ? $item->teams[0]->team ? $item->teams[0]->team->club->name : 'No definido' : 'No definido' }}</td>
                                                <td>
                                                    @if ($item->image)
                                                        <img src="{{ asset('storage/'.$item->image) }}" width="50px" />
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($item->status == 'activo')
                                                        <label class="label label-primary">Activo</label>
                                                    @else
                                                    <label class="label label-default">Inactivo</label>
                                                    @endif
                                                </td>
                                                <td class="no-sort no-click bread-actions text-right">
                                                    @if (auth()->user()->hasPermission('options_players'))
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-default dropdown-toggle"
                                                                    data-toggle="dropdown">
                                                            Más <span class="caret"></span>
                                                            </button>
                                                        
                                                            <ul class="dropdown-menu" role="menu">
                                                                <li><a href="{{ route('players.print', ['id' => $item->id, 'type' => 'credencial']) }}" target="_blank">Imprimir Credencial</a></li>
                                                                <li><a href="{{ route('players.print', ['id' => $item->id, 'type' => 'certificado']) }}" target="_blank">Imprimir kardex</a></li>
                                                                <li class="divider"></li>
                                                                <li><a href="{{ route('players.transfers', ['id' => $item->id]) }}">Traspasos</a></li>
                                                                @if ($item->origin == 'beni')
                                                                <li><a href="#" class="btn-documents" data-item='@json($item)' data-toggle="modal" data-target="#documents_modal">Datos de los padres</a></li>
                                                                @endif
                                                            </ul>
                                                        </div>
                                                    @endif
                                                    @if (auth()->user()->hasPermission('read_players'))
                                                        <a href="{{ route('voyager.players.show', ['id' => $item->id]) }}" title="Ver" class="btn btn-sm btn-warning view">
                                                            <i class="voyager-eye"></i> <span class="hidden-xs hidden-sm">Ver</span>
                                                        </a>
                                                    @endif
                                                    @if (auth()->user()->hasPermission('edit_players'))
                                                        <a href="{{ route('voyager.players.edit', ['id' => $item->id]) }}" title="Editar" class="btn btn-sm btn-primary edit">
                                                            <i class="voyager-edit"></i> <span class="hidden-xs hidden-sm">Editar</span>
                                                        </a>
                                                    @endif
                                                    @if (auth()->user()->hasPermission('delete_players'))
                                                        <a href="javascript:;" title="Borrar" class="btn btn-sm btn-danger delete" onclick="deleteItem({{ $item->id }})" data-toggle="modal" data-target="#delete_modal">
                                                            <i class="voyager-trash"></i> <span class="hidden-xs hidden-sm">Borrar</span>
                                                        </a>
                                                    @endif
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

        {{-- Documents modal --}}
        <form id="form-documents" action="" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal fade" tabindex="-1" id="documents_modal" role="dialog">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title"><i class="voyager-person"></i> Documentos</h4>
                        </div>
                        <div class="modal-body">
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#tab-list">Lista</a></li>
                                <li><a data-toggle="tab" href="#tab-create">Nuevo</a></li>
                              </ul>
                              
                              <div class="tab-content">
                                <div id="tab-list" class="tab-pane fade in active">
                                    <table id="table-documents" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>N&deg;</th>
                                                <th>Parentesco</th>
                                                <th>Nombre completo</th>
                                                <th>Procedencia</th>
                                                <th>Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                                <div id="tab-create" class="tab-pane fade">
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="type">Parentesco</label>
                                            <select name="type" class="form-control" required>
                                                <option value="">Seleccione el parentesco</option>
                                                <option value="padre">Padre</option>
                                                <option value="madre">Madre</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="full_name">Nombre completo</label>
                                            <input type="text" name="full_name" class="form-control" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="ci">CI</label>
                                            <input type="text" name="ci" class="form-control" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="origin">Procedencia</label>
                                            <select name="origin" class="form-control" required>
                                                <option value="">Seleccione la procedencia</option>
                                                @foreach (['chuquisaca', 'la paz', 'oruro', 'pando', 'potosí', 'santa cruz', 'tarija' ] as $item)
                                                <option value="{{ $item }}">{{ Str::ucfirst($item) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group  col-md-6">
                                            <label for="file">Documento</label>
                                            <input type="file" name="file" class="form-control" accept="application/pdf" required>
                                        </div>
                                    </div>
                                </div>
                              </div>
                        </div>
                        <div class="modal-footer text-right">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <input type="submit" class="btn btn-primary" value="Guardar">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @stop

    @section('css')

    @stop

    @section('javascript')
        <script>
            $(document).ready(function() {
                var table = $('#dataTable').DataTable({"order":[],"language":{"sEmptyTable":"No hay datos disponibles en la tabla","sInfo":"Mostrando _START_ a _END_ de _TOTAL_ entradas","sInfoEmpty":"Mostrando 0 a 0 de 0 entradas","sInfoFiltered":"(Filtrada de _MAX_ entradas totales)","sInfoPostFix":"","sInfoThousands":",","sLengthMenu":"Mostrar _MENU_ entradas","sLoadingRecords":"Cargando...","sProcessing":"Procesando...","sSearch":"Buscar:","sZeroRecords":"No se encontraron registros coincidentes","oPaginate":{"sFirst":"Primero","sLast":"\u00daltimo","sNext":"Siguiente","sPrevious":"Anterior"},"oAria":{"sSortAscending":": Activar para ordenar la columna ascendente","sSortDescending":": Activar para ordenar la columna descendente"}},"columnDefs":[{"targets":"dt-not-orderable","searchable":false,"orderable":false}]});

                $('.btn-documents').click(function(){
                    let item = $(this).data('item');
                    let url = '{{ url("") }}';

                    $('#form-documents').attr('action', `${url}/admin/players/${item.id}/documents/store`);
                    console.log(item)

                    $('#table-documents tbody').empty();
                    item.documents.map((item, index) => {
                        $('#table-documents tbody').append(`
                            <tr>
                                <td>${index +1}</td>
                                <td>${item.type}</td>
                                <td>${item.full_name} <br> <small>${item.ci}</small></td>
                                <td>${item.origin}</td>
                                <td>
                                    <a href="${url}/storage/${item.file}" class="btn btn-warning" target="_blank"><i class="voyager-eye"></i></a>    
                                </td>
                            </tr>
                        `);
                    });
                });
            });

            function deleteItem(id){
                let url = '{{ url("admin/players") }}/'+id;
                $('#delete_form').attr('action', url);
            }
        </script>
    @stop

@endif