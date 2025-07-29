<div class="col-12">
    @foreach ($kelompokKomponen as $jenis => $komponen)
        <div class="pay-head-roll">
            <h5>{{ strtoupper($jenis) }}</h5>
        </div>
        @foreach ($komponen as $k)
            <div class="input-block row">
                <label class="col-form-label col-lg-2">{{ strtoupper($k['nama']) }}</label>
                <div class="col-md-10">
                    <div class="input-group">
                        <input type="number" class="form-control" placeholder="..." aria-label="..."
                            aria-describedby="basic-addon{{ $k['id'] }}" name="bobot[{{ $k['id'] }}]" value="{{ $k['bobot'] }}">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon{{ $k['id'] }}">%</span>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endforeach
</div>
<div class="col-12">
    <div class="doctor-submit text-end">
        <button type="submit" class="btn btn-primary submit-form me-2">Simpan</button>
        <button onclick="location.href = '{{ route('guru.nilai.index') }}'" type="button"
            class="btn btn-primary cancel-form">Batalkan</button>
    </div>
</div>
