<table class="table table-bordered">
    <thead>
        <tr>
            <th rowspan="3">No</th>
            <th rowspan="3">NIS</th>
            <th rowspan="3">Nama</th>
            <th colspan="{{ $pertemuan['jumlah'] }}">Pertemuan / Tanggal</th>
        </tr>
        <tr>
            @foreach (range(1, $pertemuan['jumlah']) as $i)
                <th>{{ $i == $pertemuan['uts'] ? 'UTS' : ($i == $pertemuan['uas'] ? 'UAS' : $i) }}</th>
            @endforeach
        </tr>
        <tr>
            @for ($i = 0; $i < $pertemuan['jumlah']; $i++)
                <th>/</th>
            @endfor
        </tr>
    </thead>

    <tbody>
        @foreach ($data as $i => $item)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $item->nis }}</td>
                <td>{{ $item->nama_siswa }}</td>
                @for ($i = 0; $i < $pertemuan['jumlah']; $i++)
                    <td class="text-center">
                        {{ @$item->absensiDetail[$i]['status'] === 'hadir' ? 'v' : '-' }}
                    </td>
                @endfor
            </tr>
        @endforeach
    </tbody>
</table>
