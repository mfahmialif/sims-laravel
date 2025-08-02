@extends('layouts.admin.template')
@section('title', ' Absensi Siswa')
@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.siswa.index') }}">Siswa </a></li>
                    <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                    <li class="breadcrumb-item"><a
                            href="{{ route('admin.siswa.show', ['siswa' => $siswa]) }}">{{ $siswa->nama_siswa }} </a></li>
                    <li class="breadcrumb-item"><i class="feather-chevron-right"></i></li>
                    <li class="breadcrumb-item active">Absensi Siswa</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->
    <div class="row">
        <div class="col-sm-12">

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Absensi Siswa</h3>
                </div>
                <div class="card-body">
                    @if ($absensi->isEmpty())
                        <div class="alert alert-info">
                            Tidak ada absensi
                        </div>
                    @endif
                    <ol class="list-group list-group-numbered">
                        @foreach ($absensi as $item)
                            @php
                                $status = $item->detail->where('siswa_id', $siswa->id)->first();
                                $status = $status ? $status->status : 'Belum Absen';
                            @endphp
                            <li class="list-group-item d-flex justify-content-between align-items-start list-group-item-action"
                                style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#info-alert-modal"
                                data-keterangan="{{ $item->keterangan }}" data-tanggal="{{ $item->tanggal }}">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">{{ $item->tanggal }}</div>
                                    {{ \Str::limit($item->keterangan, 20, '...') }}
                                </div>
                                <span class="badge text-bg-{{ $color[$status] }} rounded-pill">{{ $status }}</span>
                            </li>
                        @endforeach
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Alert Modal -->
    <div id="info-alert-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body p-4">
                    <div class="text-center">
                        <i class="dripicons-information h1 text-info"></i>
                        <h4 class="mt-2" id="modal-title">Heads up!</h4>
                        <p class="mt-3" id="modal-keterangan">Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac
                            facilisis in, egestas eget quam.</p>
                        <button type="button" class="btn btn-secondary my-2" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection
@push('script')
    <script>
        const keteranganModal = document.getElementById('info-alert-modal')
        if (keteranganModal) {
            keteranganModal.addEventListener('show.bs.modal', event => {
                const button = event.relatedTarget
                const tanggal = button.getAttribute('data-tanggal')
                const keterangan = button.getAttribute('data-keterangan')

                const modalTitle = keteranganModal.querySelector('#modal-title')
                const modalKeterangan = keteranganModal.querySelector('#modal-keterangan')

                modalTitle.textContent = `${tanggal}`
                modalKeterangan.textContent = `${keterangan}`
            })
        }
    </script>
@endpush
