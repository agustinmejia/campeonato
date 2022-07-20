@extends('voyager::master')

@section('page_title', 'Crear Fixture')

@section('page_header')
    <h1 class="page-title">
        <i class="voyager-list"></i>
        Crear Fixture
    </h1>
@stop

@section('content')
    <div class="page-content edit-add container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form action="{{ isset($fixture) ? route('championshipscategories.update', $fixture->id) : route('championshipscategories.store') }}" method="post">
                    @csrf
                    @isset($fixture)
                        @method('PUT')
                    @endisset
                    <div class="panel panel-bordered">
                        <div class="panel-body">
                            <div class="form-group col-md-6">
                                <label class="control-label" for="championship_id">Campeonato</label>
                                <select name="championship_id" id="select-championship_id" class="form-control select2" required>
                                    <option value="">Seleccione el campeonato</option>
                                    @foreach (App\Models\Championship::where('status', 'activo')->where('deleted_at', NULL)->get() as $item)
                                    <option @isset($fixture) {{ $fixture->championship_id != $item->id ? 'disabled' : '' }} @endisset value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="control-label" for="category_id">Categoría</label>
                                <select name="category_id" id="select-category_id" class="form-control select2">
                                    <option value="">Seleccione la categoría</option>
                                    @foreach (App\Models\Category::where('status', '1')->where('deleted_at', NULL)->get() as $item)
                                    <option @isset($fixture) {{ $fixture->category_id != $item->id ? 'disabled' : '' }} @endisset value="{{ $item->id }}" data-teams='@json($item->teams)'>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12" style="margin-top: 20px">
                                <div class="text-right">
                                    <div class="btn-group btn-group-sm">
                                        <button type="button" id="btn-random" class="btn btn-primary">Generar fixture</button>
                                        <button type="button" id="btn-add" class="btn btn-success">Agregar encuentro</button>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>N&deg;</th>
                                                <th>Descripción</th>
                                                <th>Local</th>
                                                <th>Visitante</th>
                                                <th>Fecha</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody id="table-fixtures">
                                            <tr id="tr-empty"><td class="text-center" colspan="6">Lista de encuentros vacía</td></tr>
                                            @isset($fixture)
                                                @php
                                                    $cont = 1;
                                                @endphp
                                                @foreach ($fixture->details as $item)
                                                    {{-- {{ dd($item->local->name) }} --}}
                                                    <tr>
                                                        <td class="td-item">{{ $cont }}</td>
                                                        <td>{{ $item->title }}</td>
                                                        <td>{{ $item->local->name }}</td>
                                                        <td>{{ $item->visitor->name }}</td>
                                                        <td>{{ date('d/m/Y H:i', strtotime($item->datetime)) }}</td>
                                                        <td></td>
                                                    </tr>
                                                    @php
                                                        $cont++;
                                                    @endphp
                                                @endforeach
                                            @endisset
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer text-right">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('css')

@stop

@section('javascript')
    <script>
        var teams;
        $(document).ready(function(){

            @isset($fixture)
                $('#select-championship_id').val("{{ $fixture->championship_id }}").trigger('change');
                setTimeout(() => {
                    $('#select-category_id').val("{{ $fixture->category_id }}").trigger('change');
                }, 0);
            @endisset

            $('#select-category_id').change(function(){
                @isset($fixture)
                    $('#tr-empty').remove();
                @else
                $('#table-fixtures').html('<tr id="tr-empty"><td class="text-center" colspan="6">Lista de encuentros vacía</td></tr>');
                @endisset
                teams = $(this).find('option:selected').data('teams');
            });

            $('#btn-add').click(() => {
                if(!teams){
                    toastr.warning('Debe elegir una categoría', 'Advertencia');
                    return;
                }
                let id = Math.floor(Math.random() * 100000001);;
                $('#table-fixtures').append(`
                    <tr class="tr-item" id="tr-${id}">
                        <td class="td-item"></td>
                        <td><input type="text" name="title[]" class="form-control" placeholder="Fecha #" required /></td>
                        <td>
                            <select name="local_id[]" class="form-control" required>
                                <option selected disabled value="">--Equipo local--</option>
                                ${
                                    teams.map(function(item){
                                        return `<option value="${item.id}">${item.name}</option>`;
                                    })
                                }
                            </select>
                        </td>
                        <td>
                            <select name="visitor_id[]" class="form-control" required>
                                <option selected disabled value="">--Equipo visitante--</option>
                                ${
                                    teams.map(function(item){
                                        return `<option value="${item.id}">${item.name}</option>`;
                                    })
                                }
                            </select>
                        </td>
                        <td><input type="datetime-local" name="datetime[]" class="form-control" required /></td>
                        <td style="padding-top: 15px !important"><button type="button" onclick="removeTr('${id}')" class="btn-remove"><i class="voyager-trash text-danger"></i></button></td>
                    </tr>
                `);
                setNumber();
            });
        });

        function setNumber(){
            var length = 0;
            $(".td-item").each(function(index) {
                $(this).text(index +1);
                length++;
            });
            if(length > 0){
                $('#tr-empty').remove();
            }else{
                $('#table-fixtures').html('<tr id="tr-empty"><td class="text-center" colspan="6">Lista de encuentros vacía</td></tr>');
            }
        }

        function removeTr(id){
            $('#tr-'+id).remove();
            setNumber();
        }
    </script>
@stop
