@extends('voyager::master')

@section('page_title', 'Viendo reporte de jugadores')

@if (auth()->user()->hasPermission('browse_reportsplayers'))

    @section('page_header')
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="page-title">
                        <i class="voyager-people"></i> Reporte de jugadores
                    </h1>
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
                            <div class="col-md-8"></div>
                            <div class="col-md-4">
                                <form id="form-report" name="form_report" action="{{ route('reports.players.list') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="print">
                                    <div class="form-group">
                                        <select name="team_id" id="" class="select2">
                                            <option value="">Todos los equipos</option>
                                            @foreach (App\Models\Team::where('deleted_at', NULL)->whereRaw(Auth::user()->club_id ? 'club_id = '.Auth::user()->club_id : 1)->get() as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }} - {{ $item->category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group text-right">
                                        <button type="submit" class="btn btn-primary">Generar <i class="voyager-settings"></i></button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-12" id="results"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @stop

    @section('css')

    @stop

    @section('javascript')
        <script src="{{ url('js/main.js') }}"></script>
        <script>
            $(document).ready(function() {
                    $('#form-report').on('submit', function(e){
                        e.preventDefault();
                        $('#results').empty();
                        // $('#results').loading({message: 'Cargando...'});
                        $.post($('#form-report').attr('action'), $('#form-report').serialize(), function(res){
                            $('#results').html(res);
                        })
                        .fail(function() {
                            toastr.error('Ocurrió un error!', 'Oops!');
                        })
                        .always(function() {
                            // $('#results').loading('toggle');
                            $('html, body').animate({
                                scrollTop: $("#results").offset().top - 70
                            }, 500);
                        });
                    });
                });
                function report_print(){
                    $('#form-report').attr('target', '_blank');
                    $('#form-report input[name="print"]').val(1);
                    window.form_report.submit();
                    $('#form-report').removeAttr('target');
                    $('#form-report input[name="print"]').val('');
                }
        </script>
    @stop
@endif