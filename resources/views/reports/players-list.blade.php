<div>
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>N&deg;</th>
                <th>Nombre(s)</th>
                <th>Apellidos</th>
                <th>CI</th>
                <th>Edad</th>
                <th>Lugar nac.</th>
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
                    <td>{{ $item->player->first_name }}</td>
                    <td>{{ $item->player->last_name }}</td>
                    <td>{{ $item->player->ci }}</td>
                    <td>{{ $age }} años</td>
                    <td>{{ Str::ucfirst($item->player->origin) }}</td>
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