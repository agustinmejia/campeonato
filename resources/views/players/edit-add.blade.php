@extends('voyager::master')

@section('page_title', isset($player) ? 'Editar Jugador' : 'Añadir Jugador')

@section('page_header')
    <h1 class="page-title">
        <i class="voyager-person"></i>
        {{ isset($player) ? 'Editar' : 'Añadir' }} Jugador
    </h1>
@stop

@section('content')
    <div class="page-content edit-add container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form action="{{ isset($player) ? route('voyager.players.update', ['id' => $player->id]) : route('voyager.players.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @isset($player)
                        @method('PUT')
                    @endisset
                    <div class="panel panel-bordered">
                        <div class="panel-body">
                            <div class="form-group  col-md-6 ">
                                <label class="control-label" for="first_name">Nombre(s)</label>
                                <input type="text" class="form-control" name="first_name" placeholder="Nombre(s)" value="{{ isset($player) ? $player->first_name : '' }}" required>
                            </div>
                            <div class="form-group  col-md-6 ">
                                <label class="control-label" for="last_name">Apellidos</label>
                                <input type="text" class="form-control" name="last_name" placeholder="Apellidos" value="{{ isset($player) ? $player->last_name : '' }}" required>
                            </div>
                            <div class="form-group  col-md-6 ">
                                <label class="control-label" for="ci">CI</label>
                                <input type="text" class="form-control" name="ci" placeholder="CI" value="{{ isset($player) ? $player->ci : '' }}" required>
                            </div>
                            <div class="form-group  col-md-6 ">
                                <label class="control-label" for="gender">Género</label>
                                <select name="gender" class="form-control select2" required>
                                    <option value="masculino">Masculino</option>
                                    <option value="femenino">Femenino</option>
                                </select>
                            </div>   
                            <div class="form-group  col-md-6 ">
                                <label class="control-label" for="birthday">Fecha de nacimiento</label>
                                <input type="date" class="form-control" name="birthday" placeholder="Fecha de nacimiento" value="{{ isset($player) ? $player->birthday : '' }}" required>
                            </div>
                            <div class="form-group  col-md-6 ">
                                <label class="control-label" for="origin">Lugar de nacimiento</label>
                                <select name="origin" class="form-control select2" required>
                                    <option value="" selected disabled>Lugar de nacimiento</option>
                                    <option value="beni">Beni</option>
                                    <option value="chuquisaca">Chuquisaca</option>
                                    <option value="cochabamba">Cochabamba</option>
                                    <option value="la paz">La paz</option>
                                    <option value="oruro">Oruro</option>
                                    <option value="pando">Pando</option>
                                    <option value="potosí">Potosí</option>
                                    <option value="santa cruz">Santa cruz</option>
                                    <option value="tarija">Tarija</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6 ">
                                <label class="control-label" for="first_name">Club</label>
                                <select name="club_id" id="select-club_id" class="form-control select2">
                                    <option value="">Seleccione el club</option>
                                    @foreach (App\Models\Club::where('status', 'activo')->where('deleted_at', NULL)->get() as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6 ">
                                <label class="control-label" for="first_name">Club(es)</label>
                                <select name="team_id[]" id="select-team_id" class="form-control select2" multiple required>
    
                                </select>
                            </div>
                            <div class="form-group  col-md-6">
                                <label class="control-label" for="image">Fotografía</label>
                                <input type="file" name="image" accept="image/*">
                            </div>
                        </div>
                        <div class="panel-footer text-right">
                            <button type="submit" class="btn btn-primary save">Guardar <i class="voyager-check"></i> </button>
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
        $(document).ready(function(){
            @isset($player)
                $('select[name="gender"]').val('{{ $player->gender }}');
                $('select[name="gender"]').trigger('change');
                $('select[name="origin"]').val('{{ $player->origin }}');
                $('select[name="origin"]').trigger('change');
                let teams = @json($player->teams);
                if(teams.length > 0){
                    $('#select-club_id').val(teams[0].team.club_id);
                    setTimeout(() => {
                        $('#select-club_id').trigger('change');
                    }, 0);
                }
            @endisset

            $('#select-club_id').change(function(){
                $.ajax({
                    url: '/admin/clubs/' + $('#select-club_id').val()+'/teams?type=ajax',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data){
                        $('#select-team_id').empty();
                        $.each(data.teams, (index, value) => {
                            $('#select-team_id').append('<option value="' + value.id + '">' + value.name + ' - ' + value.category.name + '</option>');
                        });

                        @isset($player)
                            teams = @json($player->teams);
                            data = [];
                            $.each(teams, (index, value) => {
                                data.push(value.team_id);
                            });
                            $('#select-team_id').val(data);
                        @endisset
                    }
                });
            });
        });
    </script>
@stop
