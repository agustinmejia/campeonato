<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de jugadores</title>
</head>
<body>
    <div style="text-align: right">
        <h2>
            Reporte de jugadores
            @if ($team)
                <br>
                <small>{{ $team->name }}</small>
            @endif
        </h2>
    </div>
    <br>
    <div>
        <table>
            <thead>
                <tr>
                    <th>N&deg;</th>
                    <th>Fotografía</th>
                    <th>Nombre completo</th>
                    <th>CI</th>
                    <th>Edad</th>
                    <th>Lugar nac.</th>
                    <th>Datos adicionales</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $cont = 1;
                @endphp
                @forelse ($players as $item)
                    @php
                        $now = \Carbon\Carbon::now();
                        $birthday = 'S/N';
                        if($item->player->birthday){
                            $birthday = new \Carbon\Carbon($item->player->birthday);
                            $age = $birthday->diffInYears($now);
                        }
                    @endphp
                    <tr>
                        <td>{{ $cont }}</td>
                        <td>
                            @if ($item->player->image)
                                <img src="{{ asset('storage/'.$item->player->image) }}" width="50px" />
                            @else
                                <img src="{{ asset('images/default.jpg') }}" width="50px" />
                            @endif
                        </td>
                        <td>{{ $item->player->first_name }} {{ $item->player->last_name }}</td>
                        <td>{{ $item->player->ci }}</td>
                        <td>{{ $age }} años</td>
                        <td>{{ Str::ucfirst($item->player->origin) }}</td>
                        <td>
                            @foreach ($item->player->documents as $document)
                                <span>
                                    {{ $document->full_name }} (<b>{{ Str::ucfirst($document->type) }}</b>) <br>
                                    CI: {{ $document->ci }} | {{ $document->origin }}
                                </span>
                            @endforeach
                        </td>
                    </tr>
                    @php
                        $cont++;
                    @endphp
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Sin resultados</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>

<style>
    h2 small{
        font-size: 18px
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }
    table, th, td {
        border: 1px solid;
        padding: 5px;
    }
    thead{
        background-color: rgba(102, 112, 131, 0.7);
        color: white
    }
</style>
</html>