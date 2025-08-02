<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Nilai - SDN Pekoren</title>
    <style>
        /* body {
            font-family: "DejaVu Sans", sans-serif;
            font-size: 12px;
            margin: 20px;
        } */

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 18px;
            margin: 0;
        }

        .header h2 {
            font-size: 14px;
            margin: 5px 0;
        }

        .info {
            margin-bottom: 20px;
        }

        .info table {
            width: 100%;
        }

        .info td {
            padding: 3px 0;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            border: 1px solid #000;
            padding: 3px;
            text-align: center;
        }

        .footer {
            margin-top: 40px;
            width: 100%;
        }

        .footer .ttd {
            float: right;
            text-align: center;
        }
    </style>
</head>

<body>

    <div class="header">
        <h1>{{ env('NAMA_SEKOLAH') }}</h1>
        <h2>JADWAL PELAJARAN</h2>
    </div>

    <div class="info">
        <table>
            <tr>
                <td><strong>Mata Pelajaran</strong></td>
                <td>: {{ $jadwal->kurikulumDetail->mataPelajaran->nama }}</td>
            </tr>
            <tr>
                <td><strong>Kelas</strong></td>
                <td>: {{ $jadwal->kelasSub->kelas->angka }} - {{ $jadwal->kelasSub->sub }}</td>
            </tr>
            <tr>
                <td><strong>Semester</strong></td>
                <td>: {{ $jadwal->tahunPelajaran->semester }}</td>
            </tr>
            <tr>
                <td><strong>Tahun Pelajaran</strong></td>
                <td>: {{ $jadwal->tahunPelajaran->nama }}</td>
            </tr>
        </table>
    </div>

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


    <div class="footer">
        <div class="ttd">
            <p>Pekoren, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
            <p>Kepala Sekolah</p>
            <p style="margin-top: 60px;font-weight: bold; text-decoration: underline;">
                {{ env('KEPALA_SEKOLAH') }}
            </p>
            <p>{{ env('KEPALA_SEKOLAH_NIP') }}</p>
        </div>
    </div>

</body>

</html>
