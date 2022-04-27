@extends('voyager::master')

@section('page_title', 'Ver Title')

@section('content')
    <div class="page-content read container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-bordered">
                    <div class="row">
                        <br>
                        <div class="col-xs-4 col-sm-4 text-right">
                            <div style="display: flex; flex-direction: row-reverse">
                                <div style="padding: 0px 10px"><h3>Equipo A</h3></div>
                                <div><img src="{{ asset('images/team1.png') }}" width="60px" alt=""></div>
                            </div>
                        </div>
                        <div class="col-xs-4 col-sm-4 text-center">
                            <h1>
                                <span>1 - 0</span>
                                <br>
                                <small id="timer">00:00</small>
                            </h1>
                            <div class="btn-group btn-group-sm">
                                <button type="button" id="strt" class="btn btn-success">Iniciar</button>
                                <button type="button" id="stp" class="btn btn-default">Pause</button>
                                <button type="button" id="rst" class="btn btn-warning">Reset</button>
                            </div>
                        </div>
                        <div class="col-xs-4 col-sm-4">
                            <div style="display: flex; flex-direction: row">
                                <div style="padding: 0px 10px"><h3>Equipo B</h3></div>
                                <div><img src="{{ asset('images/team2.png') }}" width="60px" alt=""></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-bordered">
                            <div class="row">
                                <div class="col-xs-6">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th style="width: 50px">N&deg;</th>
                                                <th>Nombre</th>
                                                <th class="text-right">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $cont = 1;
                                            @endphp
                                            @foreach(['Juan perez', 'José Mendez', 'Pedro Nosa', 'Mario Mendez', 'Luis Suarez', 'Marcelo Perez'] as $item)
                                                <tr>
                                                    <td><h4>{{ $cont }}</h4></td>
                                                    <td><h4>{{ $item }}</h4></td>
                                                    <td style="width: 120px;" class="td-actions text-right">
                                                        <a href="#"><img src="{{ asset('images/ball.png') }}" width="25px" alt=""></a>
                                                        <a href="#"><img src="{{ asset('images/yellow-card.png') }}" width="25px" alt=""></a>
                                                        <a href="#"><img src="{{ asset('images/red-card.png') }}" width="25px" alt=""></a>
                                                    </td>
                                                </tr>
                                                @php
                                                    $cont++;
                                                @endphp
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="col-xs-6">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th style="width: 50px">N&deg;</th>
                                                <th>Nombre</th>
                                                <th class="text-right">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $cont = 1;
                                            @endphp
                                            @foreach(['Juan perez', 'José Mendez', 'Pedro Nosa', 'Mario Mendez', 'Luis Suarez', 'Marcelo Perez'] as $item)
                                                <tr>
                                                    <td><h4>{{ $cont }}</h4></td>
                                                    <td><h4>{{ $item }}</h4></td>
                                                    <td style="width: 120px;" class="td-actions text-right">
                                                        <a href="#"><img src="{{ asset('images/ball.png') }}" width="25px" alt=""></a>
                                                        <a href="#"><img src="{{ asset('images/yellow-card.png') }}" width="25px" alt=""></a>
                                                        <a href="#"><img src="{{ asset('images/red-card.png') }}" width="25px" alt=""></a>
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
        </div>
    </div>
@stop

@section('css')
    <style>
        .td-actions img{
            filter: grayscale(100%);
        }
        .td-actions img:hover{
            filter: grayscale(0%);;
            /* width: 28px */
        }
    </style>
@endsection

@section('javascript')
    <script>
        $(document).ready(function () {
            
        });

        var h1 = document.getElementById('timer');
        var start = document.getElementById('strt');
        var stop = document.getElementById('stp');
        var reset = document.getElementById('rst');
        var sec = 0;
        var min = 0;
        var t;

        function tick(){
            sec++;
            if (sec >= 60) {
                sec = 0;
                min++;
            }
        }
        function add() {
            tick();
            h1.textContent = (min > 9 ? min : "0" + min)
                    + ":" + (sec > 9 ? sec : "0" + sec);
            timer();
        }
        function timer() {
            t = setTimeout(add, 1000);
        }

        // timer();
        start.onclick = timer;
        stop.onclick = function() {
            clearTimeout(t);
        }
        reset.onclick = function() {
            let time = window.prompt('Ingresa el tiempo actual');
            if(time){
                time = time.split(':');
                if(time.length == 2){
                    min = !isNaN(time[0]) ? time[0] : 0;
                    sec = !isNaN(time[1]) ? time[1] : 0;
                    h1.textContent = min+':'+sec;
                }else{
                    h1.textContent = '00:00';
                    seconds = 0; minutes = 0;
                } 
            }
            timer();
        }
    </script>
@stop
