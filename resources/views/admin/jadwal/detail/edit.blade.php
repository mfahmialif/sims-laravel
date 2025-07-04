@extends('layouts.admin.template')
@section('title', 'Edit Data Jadwal')
@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.jadwal.index') }}">Jadwal
                        </a></li>
                    <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                    <li class="breadcrumb-item"><a
                            href="{{ route('admin.jadwal.detail.index', ['kurikulumDetail' => $kurikulumDetail, 'tahunPelajaran' => $tahunPelajaran]) }}">Detail
                            Jadwal
                        </a></li>
                    <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                    <li class="breadcrumb-item active">Edit Jadwal</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->
    <div class="row">
        <div class="col-sm-12">
            <div class="alert alert-info d-flex align-items-start gap-3" role="alert">
                <i class="feather-info mt-1"></i>
                <div>
                    <strong>Informasi:</strong><br>
                    Anda sedang mengedit jadwal untuk mata pelajaran: <br>
                    <strong>{{ $kurikulumDetail->mataPelajaran->kode }} /
                        {{ $kurikulumDetail->mataPelajaran->nama }}</strong><br>
                    Kelas: <strong>{{ $kurikulumDetail->mataPelajaran->kelas->angka ?? '-' }}</strong>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <form
                        action="{{ route('admin.jadwal.detail.update', ['kurikulumDetail' => $kurikulumDetail, 'tahunPelajaran' => $tahunPelajaran, 'jadwal' => $jadwal]) }}"
                        onsubmit="submitForm(this)" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">

                            <div class="col-12">
                                <div class="form-heading">
                                    <h4>Edit Jadwal</h4>
                                </div>
                            </div>
                            @include('admin.jadwal.detail.form')

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        const jadwal = @json($jadwal);
        $('#kelas_sub_id').val(jadwal.kelas_sub_id).change();
        $('#guru_id').val(jadwal.guru_id);
        $('#search').val(jadwal.guru.nama);
        $('#nama').val(jadwal.guru.nama);
        $('#nip').val(jadwal.guru.nip);
        $('#nik').val(jadwal.guru.nik);
        $('#jenis_kelamin').val(jadwal.guru.jenis_kelamin);
        $('#hari').val(jadwal.hari);
        $('#jam_mulai').val(jadwal.jam_mulai);
        $('#jam_selesai').val(jadwal.jam_selesai);
    </script>
@endpush
