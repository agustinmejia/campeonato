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
                /* margin-top: 90px */
            }
            .text-red{
                color: red;
            }
            #span-division{
                display: none
            }
            @media print{
                .container{
                    margin: 0px;
                }
                #span-division{
                    display: inline
                }
                select{
                    display: none
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
            <table class="table-container">
                <tr>
                    <td colspan="2" style="text-align: center"><img src="{{ asset('images/logo-alt.png') }}" alt="" style="height: 90px"></td>
                </tr>
                <tr>
                    <td style="text-align: center; width: 100px">
                        <b class="text-red" style="margin-bottom: 10px">COD: {{ str_pad($player->id, 4, "0", STR_PAD_LEFT) }}</b>
                        <img src="{{ asset('storage/'.$player->image) }}" style="width: 80px; height: 80px; border: 1px solid rgb(116, 116, 116)">
                        <b class="text-red">{{ date('d/m/Y') }}</b>
                    </td>
                    <td>
                        <table width="100%" cellspacing="0">
                            <tr>
                                <td style="max-width: 100px"><b class="text-red">DIVISIÓN</b></td>
                                <td>
                                    <select id="select-division">
                                        @foreach ($player->teams as $item)
                                            <option value="{{ $item->team->category->division->name }}" data-category="{{ $item->team->category->name }}">{{ $item->team->category->division->name }}</option>
                                        @endforeach
                                    </select>
                                    <span id="span-division">{{ Str::upper($player->teams[0]->team->category->division->name) }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td><b class="text-red">CATEGORÍA</b></td>
                                <td>
                                    <span id="span-category">{{ Str::upper($player->teams[0]->team->category->name) }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td><b class="text-red">NOMBRE</b></td>
                                <td>{{ Str::upper($player->first_name.' '.$player->last_name) }}</td>
                            </tr>
                            <tr>
                                <td><b class="text-red">CI</b></td>
                                <td>{{ $player->ci }}</td>
                            </tr>
                            <tr>
                                <td><b class="text-red">GÉNERO</b></td>
                                <td>{{ Str::upper($player->gender) }}</td>
                            </tr>
                            <tr>
                                <td><b class="text-red">FECHA DE NAC.</b></td>
                                <td>{{ date('d/m/Y', strtotime($player->birthday)) }}</td>
                            </tr>
                            <tr>
                                <td><b class="text-red">LUGAR DE NAC.</b></td>
                                <td>{{ Str::upper($player->origin) }}</td>
                            </tr>
                            <tr>
                                <td><b class="text-red">CLUB</b></td>
                                <td>
                                    {{ Str::upper($player->teams[0]->team->club->name) }}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            
            <div style="text-align: center; margin-top: 15px">
                <br>
                <b>JUGADOR</b>
            </div>

            <div style="position: absolute; bottom: 25px; right: 10px">
                {!! QrCode::size(40)->generate($player->first_name.' '.$player->last_name.' CI: '.$player->ci.' Club: '.Str::upper($player->teams[0]->team->club->name)) !!}
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script>
            $(document).ready(function(){
                $('#select-division').change(function(){
                    var division = $(this).val();
                    var category = $(this).find(':selected').attr('data-category');
                    $('#span-division').text(division.toUpperCase());
                    $('#span-category').text(category.toUpperCase());
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