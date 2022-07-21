<div>
    @if ($players->count() > 0)
        <div class="text-right">
            <button type="button" onclick="report_export('pdf')" class="btn btn-danger">PDF <i class="voyager-file-text"></i></button>
        </div>
    @endif
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>N&deg;</th>
                <th>Fotografía</th>
                <th>Nombre completo</th>
                <th>CI</th>
                <th>Edad</th>
                <th>Lugar nac.</th>
                <th>Estado</th>
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
                        @if ($item->player->status == 'activo')
                            <label class="label label-primary">Activo</label>
                        @else
                            <label class="label label-default">Inactivo</label>
                        @endif
                    </td>
                    <td>
                        @foreach ($item->player->documents as $document)
                            <span>
                                {{ $document->full_name }} (<b>{{ Str::ucfirst($document->type) }}</b>) <br>
                                CI: {{ $document->ci }} | {{ $document->origin }} <a href="{{ url('storage/'.$document->file) }}" title="Ver documento" target="_blank"><i class="voyager-external"></i></a>
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