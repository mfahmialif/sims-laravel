<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Jadwal Pelajaran - SDN Pekoren</title>
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
            padding: 6px;
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
                <td><strong>Kelas</strong></td>
                <td>: {{ $data->first()->kelas }} {{ $data->first()->sub }}</td>
            </tr>
            <tr>
                <td><strong>Semester</strong></td>
                <td>: {{ ucfirst(strtolower($data->first()->semester)) }}</td>
            </tr>
            <tr>
                <td><strong>Tahun Pelajaran</strong></td>
                <td>: {{ $data->first()->tahun }}</td>
            </tr>
        </table>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Tahun Pelajaran</th>
                <th>Mapel</th>
                <th>Kelas</th>
                <th>Hari</th>
                <th>Jam</th>
                <th>Guru</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $i => $item)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $item->tahun }} {{ ucfirst($item->semester) }}</td>
                    <td>{{ $item->kode }} - {{ $item->mapel }}</td>
                    <td>{{ $item->kelas }} - {{ $item->sub }}</td>
                    <td>{{ ucfirst($item->hari) }}</td>
                    <td>{{ date('H:i', strtotime($item->jam_mulai)) }} - {{ date('H:i', strtotime($item->jam_selesai)) }}</td>
                    <td>{{ $item->guru }}</td>
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
