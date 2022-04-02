<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Kardex</title>

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
            #span-category{
                display: none
            }
            .qr-code{
                display: none;
                position: fixed;
                bottom: 0px;
                right: 0px
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
                {!! QrCode::size(90)->generate($player->first_name.' '.$player->last_name.' CI: '.$player->ci.' Club: '.Str::upper($player->teams[0]->team->club->name)) !!}
            </div>
            <div style="text-align: center">
                <img src="{{ asset('images/logo.png') }}" height="220px">
            </div>
            <div style="position: absolute; top: 150px; left: px; z-index: -1; opacity: 0.1">
                <img src="{{ asset('images/copa.png') }}" height="768px">
            </div>
            <table width="100%" cellspacing="18">
                <tr>
                    <td style="text-align: center" colspan="2">
                        <img src="{{ asset('storage/'.$player->image) }}" style="width: 100px; height: 100px; border: 1px solid rgb(116, 116, 116)">
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right"><b class="text-red">CLUB</b></td>
                    <td>
                        {{ Str::upper($player->teams[0]->team->club->name) }}
                    </td>
                </tr>
                <tr>
                    <td style="width: 50%; text-align: right"><b class="text-red">CATEGORÍA</b></td>
                    <td>
                        <select id="select-category">
                            @foreach ($player->teams as $item)
                                <option value="{{ $item->team->category->name }}" data-team="{{ $item->team->name }}">{{ $item->team->category->name }}</option>
                            @endforeach
                        </select>
                        <span id="span-category">{{ Str::upper($player->teams[0]->team->category->name) }}</span>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right"><b class="text-red">EQUIPO</b></td>
                    <td>
                        <span id="span-team">{{ Str::upper($player->teams[0]->team->name) }}</span>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right"><b class="text-red">CÓDIGO</b></td>
                    <td>
                        <span>{{ str_pad($player->id, 4, "0", STR_PAD_LEFT) }}</span>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right"><b class="text-red">NOMBRE</b></td>
                    <td>{{ Str::upper($player->first_name.' '.$player->last_name) }}</td>
                </tr>
                <tr>
                    <td style="text-align: right"><b class="text-red">CI</b></td>
                    <td>{{ $player->ci }}</td>
                </tr>
                <tr>
                    <td style="text-align: right"><b class="text-red">GÉNERO</b></td>
                    <td>{{ Str::upper($player->gender) }}</td>
                </tr>
                <tr>
                    <td style="text-align: right"><b class="text-red">FECHA DE NAC.</b></td>
                    <td>{{ date('d/m/Y', strtotime($player->birthday)) }}</td>
                </tr>
                <tr>
                    <td style="text-align: right"><b class="text-red">LUGAR DE NAC.</b></td>
                    <td>{{ Str::upper($player->origin) }}</td>
                </tr>
            </table>
            <div style="margin-top: 100px">
                <table width="100%" style="text-align: center; font-size: 12px">
                    <tr>
                        <td width="33%">.......................................<br>PDTE. COMITÉ TÉCNICO</td>
                        <td width="34%">.......................................<br>JUGADOR</td>
                        <td width="33%">.......................................<br>PRESIDENTE</td>
                    </tr>
                </table>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script>
            $(document).ready(function(){
                $('#select-category').change(function(){
                    var category = $(this).val();
                    var team = $(this).find(':selected').attr('data-team');
                    $('#span-category').text(category.toUpperCase());
                    $('#span-team').text(team.toUpperCase());
                });
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