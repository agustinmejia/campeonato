@extends('voyager::master')

@section('page_title', 'Viendo Campeonatos')

@section('page_header')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <h1 class="page-title">
                    <i class="voyager-list"></i> Campeonatos
                </h1>
                <a href="{{ route('championships.create') }}" class="btn btn-success btn-add-new">
                    <i class="voyager-plus"></i> <span>Crear</span>
                </a>
            </div>
            <div class="col-md-4">

            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="page-content browse container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-10">
                                <div class="dataTables_length" id="dataTable_length">
                                    <label>Mostrar <select id="select-paginate" class="form-control input-sm">
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select> registros</label>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <input type="text" id="input-search" class="form-control">
                            </div>
                        </div>
                        <div class="row" id="results" style="min-height: 120px"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')

@stop

@section('javascript')
    <script>
        var countPage = 10, order = 'id', typeOrder = 'desc';
        $(document).ready(() => {
            list();
            
            $('#input-search').on('keyup', function(e){
                if(e.keyCode == 13) {
                    list();
                }
            });
            $('#select-paginate').change(function(){
                countPage = $(this).val();
                list();
            });
        });
        function list(page = 1){
            let url = '{{ url("admin/championships/list/ajax") }}';
            let search = $('#input-search').val() ? $('#input-search').val() : '';
            $.get(`${url}/${search}?paginate=${countPage}&page=${page}`, function(res){
                $('#results').html(res);
            });
        }

    </script>
@stop
