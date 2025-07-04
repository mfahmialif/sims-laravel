@foreach ($kurikulum as $k)
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-header bg-white border-bottom-0">
            <h5 class="m-0">
                <a class="d-flex justify-content-between align-items-center text-dark text-decoration-none"
                    data-bs-toggle="collapse" href="#accordion-{{ $k->id }}" role="button" aria-expanded="false"
                    aria-controls="accordion-{{ $k->id }}">
                    <span>{{ $k->nama }}</span>
                    <i class="feather-chevron-down transition"></i>
                </a>
            </h5>
        </div>
        <div id="accordion-{{ $k->id }}" class="collapse" data-bs-parent="#custom-accordion-one">
            <div class="list-group list-group-flush px-2 pt-2">
                @foreach ($k->detail as $detail)
                    <a href="{{ route('admin.jadwal.detail.index', ['kurikulumDetail' => $detail->id, 'tahunPelajaran' => $tahunPelajaran]) }}"
                        class="list-group-item list-group-item-action border rounded mb-2 shadow-sm">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="fw-bold text-primary">
                                    {{ $detail->mataPelajaran->kode }} /
                                </span>
                                <span class="text-dark">
                                    {{ $detail->mataPelajaran->nama }}
                                    <small class="text-muted">- Kelas {{ $detail->mataPelajaran->kelas->angka }}</small>
                                </span>
                            </div>
                            <div>
                                @php
                                    $count = $detail->jadwal->count();
                                @endphp
                                <span
                                    class="badge bg-{{ $count == 0 ? 'danger' : 'success' }}">{{ $count }}</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endforeach
