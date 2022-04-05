<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Traspaso</title>

        <!-- Favicon -->
        <?php $admin_favicon = Voyager::setting('admin.icon_image', ''); ?>
        @if($admin_favicon == '')
            <link rel="shortcut icon" href="{{ asset('images/icon.png') }}" type="image/png">
        @else
            <link rel="shortcut icon" href="{{ Voyager::image($admin_favicon) }}" type="image/png">
        @endif

        <style>
            body{
                margin: 0px;
                padding: 0px;
                font-family: 'Roboto', Arial, Helvetica, sans-serif;
            }
            .container{
                position: relative;
                margin: 0px auto;
                width: 768px;
                font-size: 18px
            }
            .text-red{
                color: red;
            }
            .text-bold{
                font-weight: bold
            }
            #span-category{
                display: none
            }
            .qr-code{
                display: none;
                position: fixed;
                bottom: 10px;
                right: 0px;
                text-align: center
            }
            @media print{
                .container{
                    margin: 0px;
                }
                #span-category{
                    display: inline
                }
                select{
                    display: none
                }
                .hide-print{
                    display: none
                }
                .qr-code{
                    display: block;
                }
            }
        </style>
    </head>
    <body>
        <div class="hide-print" style="text-align: right; padding: 10px 20px">
            <button class="btn-print" onclick="window.close()">Cancelar <i class="fa fa-close"></i></button>
            <button class="btn-print" onclick="window.print()"> Imprimir <i class="fa fa-print"></i></button>
        </div>
        <div class="container">
            <div class="qr-code">
                {!! QrCode::size(90)->generate('Traspaso del jugador '.$transfer->player->first_name.' '.$transfer->player->last_name.' del club '.$transfer->origin_club->name.' al club '.$transfer->destiny_club->name) !!}
                <br>
                <b style="color: red">N&deg;{{ str_pad($transfer->id, 4, "0", STR_PAD_LEFT) }}</b>
            </div>
            <div style="text-align: center">
                <img src="{{ asset('images/logo.png') }}" height="220px">
            </div>
            <div style="position: absolute; top: 150px; left: px; z-index: -1; opacity: 0.1">
                <img src="{{ asset('images/copa.png') }}" height="768px">
            </div>

            <div style="text-align: center; margin-top: 20px;">
                <h1>PASE LIBRE DEL JUGADOR</h1>
            </div>

            <div style="padding: 30px">
                <p style="font-size: 25px; text-align: justify">
                    El Club <b>{{ $transfer->origin_club->name }}</b> otorga al Club <b>{{ $transfer->destiny_club->name }}</b> el pase del Jugador <b>{{ $transfer->player->first_name }} {{ $transfer->player->last_name }}</b>.
                </p>
                <br><br>
                @php
                    $months = ['', 'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];
                @endphp
                <p style="text-align: right">Santísima Trinidad, {{ date('d', strtotime($transfer->date)) }} de {{ $months[intval(date('m', strtotime($transfer->date)))] }} de {{ date('Y', strtotime($transfer->date)) }}</p>
            </div>

            <div style="margin-top: 20px">
                <table width="100%" style="text-align: center; font-size: 12px">
                    <tr style="height: 100px">
                        <td width="50%">..............................................................................<br>PDTE. DEL CLUB QUE OTROGA EL PASE</td>
                        <td width="50%">..............................................................................<br>PDTE. DEL CLUB BENEFICIARIO DEL PASE</td>
                    </tr>
                    <tr style="height: 100px">
                        <td colspan="2">..............................................................................<br>JUGADOR TRANSFERIDO</td>
                    </tr>
                    <tr style="height: 100px">
                        <td width="50%">..............................................................................<br>SECRETARIO DE HACIENDA</td>
                        <td width="50%">..............................................................................<br>PDTE. DEL COMITÉ TÉCNICO</td>
                    </tr>
                </table>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script>
            $(document).ready(function(){

            });

            document.body.addEventListener('keypress', function(e) {
                switch (e.key) {
                    case 'Enter':
                        window.print();
                        break;
                    case 'Escape':
                        window.close();
                    default:
                        break;
                }
            });
        </script>
    </body>
</html>