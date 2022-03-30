<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Credencial</title>

    <style>
        body{
            margin: 0px;
            padding: 0px;
        }
        .container{
            margin: 50px auto;
            width: 450px;
            border: 1px solid black;
            height: 280px
        }
        @media print{
            .container{
                margin: 0px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <table width="100%" style="margin-top: 100px">
            <tr>
                <td style="text-align: center; width: 150px">
                    <img src="{{ asset('storage/'.$player->image) }}" style="width: 100px; border: 1px solid rgb(116, 116, 116)">
                </td>
                <td>
                    <table width="100%">
                        <tr>
                            <td><b>Nombre completo</b></td>
                            <td>{{ $player->first_name }} {{ $player->last_name }}</td>
                        </tr>
                        <tr>
                            <td><b>CI</b></td>
                            <td>{{ $player->ci }}</td>
                        </tr>
                        <tr>
                            <td><b>Edad</b></td>
                            <td>{{ \Carbon\Carbon::now()->diffInYears($player->birthday) }} Años</td>
                        </tr>
                        <tr>
                            <td><b>Género</b></td>
                            <td>{{ Str::ucfirst($player->gender) }}</td>
                        </tr>
                        <tr>
                            <td><b>Procedencia</b></td>
                            <td>{{ Str::ucfirst($player->origin) }}</td>
                        </tr>
                        <tr>
                            <td><b>Equipo(s)</b></td>
                            <td>
                                @foreach ($player->teams as $item)
                                {{ Str::ucfirst($item->team->name) }} <br>        
                                @endforeach
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>