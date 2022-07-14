<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Credencial</title>

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
                margin: 50px auto;
                width: 10cm;
                border: 1px solid black;
                height: 7cm;
                font-size: 10px;
            }
            .table-container{
                width: 100%;
            }
            .text-red{
                color: red;
            }
            @media print{
                .container{
                    margin: 0px;
                }
                .hide-print{
                    display: none
                }
                @page {
                    margin: 0mm 0mm 0mm 0mm;
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
            <div style="text-align: center">
                <img src="{{ asset('images/logo.png') }}" width="250px" height="80px">
            </div>
            <table class="table-container">
                <tr>
                    <td colspan="2" style="text-align: center"><h3 style="margin: 0px">CREDENCIAL DE DELEGADO</h3></td>
                </tr>
                <tr>
                    <td style="text-align: center; width: 100px">
                        <b class="text-red" style="margin-bottom: 10px">COD: {{ str_pad($delegate->id, 4, "0", STR_PAD_LEFT) }}</b>
                        <img src="{{ asset('storage/'.$delegate->image) }}" style="width: 80px; height: 80px; border: 1px solid rgb(116, 116, 116)">
                        <b class="text-red">{{ date('d/m/Y') }}</b>
                    </td>
                    <td>
                        <table width="100%" cellspacing="0">
                            <tr>
                                <td><b class="text-red">NOMBRE(S)</b></td>
                                <td>{{ Str::upper($delegate->first_name) }}</td>
                            </tr>
                            <tr>
                                <td><b class="text-red">APELLIDOS</b></td>
                                <td>{{ Str::upper($delegate->last_name) }}</td>
                            </tr>
                            <tr>
                                <td><b class="text-red">CI</b></td>
                                <td>{{ $delegate->ci }}</td>
                            </tr>
                            <tr>
                                <td><b class="text-red">CARGO</b></td>
                                <td>{{ $delegate->job }}</td>
                            </tr>
                            <tr>
                                <td><b class="text-red">CLUB</b></td>
                                <td>
                                    {{ Str::upper($delegate->club->name) }}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            
            <div style="text-align: center; margin-top: 20px; padding: 0px 40px">
                <table width="100%">
                    <tr>
                        <td><b>PRESIDENTE CLUB</b></td>
                        <td><b>DIRIGENTE&nbsp;&nbsp;&nbsp;&nbsp;</b></td>
                    </tr>
                </table>
            </div>

            <div style="position: absolute; bottom: 25px; right: 10px">
                {!! QrCode::size(40)->generate($delegate->first_name.' '.$delegate->last_name.' CI: '.$delegate->ci.' CARGO: '.$delegate->job.' Club: '.Str::upper($delegate->club->name)) !!}
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