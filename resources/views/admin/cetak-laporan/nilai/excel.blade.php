<table class="table table-bordered">
    <thead>
        <tr>
            <th rowspan="2">No</th>
            <th rowspan="2">NIS</th>
            <th rowspan="2">Nama</th>
            @foreach ($kelompokKomponen as $jenis => $komponenList)
                <th class="text-center" colspan="{{ count($komponenList) }}">
                    {{ ucfirst($jenis) }}
                </th>
            @endforeach
        </tr>
        <tr>
            @foreach ($kelompokKomponen as $jenis => $komponenList)
                @foreach ($komponenList as $komponen)
                    <th class="text-center">
                        {!! implode('<br>', explode(' ', $komponen['nama'])) !!}
                    </th>
                @endforeach
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $i => $item)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $item->nis }}</td>
                <td>{{ $item->nama_siswa }}</td>

                @foreach ($kelompokKomponen as $jenis => $komponenList)
                    @foreach ($komponenList as $komponen)
                        @php
                            if ($komponen['id']) {
                                $nilaiDetail = collect($item->nilaiDetail)->firstWhere(
                                    'komponen_nilai_id',
                                    $komponen['id'],
                                );
                                $nilaiValue = $nilaiDetail ? $nilaiDetail['nilai'] : 0;
                            } else {
                                $nilai = collect($item->nilai)->firstWhere('jenis', $jenis);
                                $nilaiValue = $nilai ? $nilai['nilai_akhir'] : 0;
                            }
                        @endphp
                        <td class="text-center">
                            {{ $nilaiValue }}
                        </td>
                    @endforeach
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
