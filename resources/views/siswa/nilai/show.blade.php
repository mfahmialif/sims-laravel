@extends('layouts.admin.template')
@section('title', ' Nilai Siswa')
@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('siswa.nilai.index', ['kelasSub' => $kelasSub]) }}">Siswa
                        </a></li>
                    <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                    <li class="breadcrumb-item active">Nilai Siswa</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->
    <div class="row">
        <div class="col-sm-12">

            @foreach ($dataNilai as $jenis => $nilai)
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            Nilai
                            {{ ucfirst($jenis) }}{{ isset($nilai['nilai_akhir']) ? ': ' . $nilai['nilai_akhir'] : '' }}
                        </h3>
                    </div>

                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            @foreach ($nilai['nilai_detail'] as $detail)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $detail['komponen_nilai_nama'] }}
                                    <span
                                        class="badge text-bg-{{ $detail['nilai'] > 0 ? 'success' : 'danger' }} rounded-pill">{{ $detail['nilai'] }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection
