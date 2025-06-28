<x-admin>
    @section('title','Tambah MKL')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Tambah MKL</h3>
            <div class="card-tools">
                <a href="{{ route('admin.mkl.index') }}" class="btn btn-sm btn-secondary">Kembali</a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.mkl.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="nik">NIK</label>
                    <input type="text" class="form-control @error('nik') is-invalid @enderror" id="nik" name="nik" value="{{ old('nik') }}" maxlength="16" pattern="[0-9]{16}" title="NIK harus 16 digit angka" required>
                    @error('nik')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="nama_pribadi">Nama Pribadi</label>
                    <input type="text" class="form-control @error('nama_pribadi') is-invalid @enderror" id="nama_pribadi" name="nama_pribadi" value="{{ old('nama_pribadi') }}" required>
                    @error('nama_pribadi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="nama_mkl">Nama MKL</label>
                    <input type="text" class="form-control @error('nama_mkl') is-invalid @enderror" id="nama_mkl" name="nama_mkl" value="{{ old('nama_mkl') }}" >
                    @error('nama_mkl')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="nama_pt_mkl">Nama PT MKL</label>
                    <input type="text" class="form-control @error('nama_pt_mkl') is-invalid @enderror" id="nama_pt_mkl" name="nama_pt_mkl" value="{{ old('nama_pt_mkl') }}" >
                    @error('nama_pt_mkl')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="no_telepon_pribadi">No. Telepon Pribadi</label>
                    <input type="tel" class="form-control @error('no_telepon_pribadi') is-invalid @enderror" id="no_telepon_pribadi" name="no_telepon_pribadi" value="{{ old('no_telepon_pribadi') }}" maxlength="20" pattern="[0-9\-\+\(\)\s]+" title="Masukkan nomor telepon yang valid" >
                    @error('no_telepon_pribadi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="no_telepon_kantor">No. Telepon Kantor</label>
                    <input type="tel" class="form-control @error('no_telepon_kantor') is-invalid @enderror" id="no_telepon_kantor" name="no_telepon_kantor" value="{{ old('no_telepon_kantor') }}" maxlength="20" pattern="[0-9\-\+\(\)\s]+" title="Masukkan nomor telepon yang valid" >
                    @error('no_telepon_kantor')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email_kantor">Email Kantor</label>
                    <input type="email" class="form-control @error('email_kantor') is-invalid @enderror" id="email_kantor" name="email_kantor" value="{{ old('email_kantor') }}" >
                    @error('email_kantor')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="npwp_kantor">NPWP Kantor</label>
                    <input type="text" class="form-control @error('npwp_kantor') is-invalid @enderror" id="npwp_kantor" name="npwp_kantor" value="{{ old('npwp_kantor') }}" maxlength="15" pattern="[0-9\.\-]+" placeholder="00.000.000.0-000.000" title="Format NPWP: 00.000.000.0-000.000" >
                    @error('npwp_kantor')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="menggunakan_mtki_payment">Menggunakan MTKI Payment</label>
                    <select class="form-control @error('menggunakan_mtki_payment') is-invalid @enderror" id="menggunakan_mtki_payment" name="menggunakan_mtki_payment" required>
                        <option value="">-- Pilih --</option>
                        <option value="YA" {{ old('menggunakan_mtki_payment') == 'YA' ? 'selected' : '' }}>YA</option>
                        <option value="TIDAK" {{ old('menggunakan_mtki_payment') == 'TIDAK' ? 'selected' : '' }}>TIDAK</option>
                    </select>
                    @error('menggunakan_mtki_payment')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group" id="alasan_container" style="display: none;">
                    <label for="alasan_tidak_menggunakan_mtki_payment">Alasan Tidak Menggunakan MTKI Payment</label>
                    <textarea class="form-control @error('alasan_tidak_menggunakan_mtki_payment') is-invalid @enderror" id="alasan_tidak_menggunakan_mtki_payment" name="alasan_tidak_menggunakan_mtki_payment" rows="3">{{ old('alasan_tidak_menggunakan_mtki_payment') }}</textarea>
                    @error('alasan_tidak_menggunakan_mtki_payment')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="status_aktif">Status Aktif</label>
                    <select class="form-control @error('status_aktif') is-invalid @enderror" id="status_aktif" name="status_aktif" required>
                        <option value="">-- Pilih --</option>
                        <option value="1" {{ old('status_aktif') == '1' ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ old('status_aktif') == '0' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                    @error('status_aktif')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="file_ktp">File KTP</label>
                    <input type="file" class="form-control @error('file_ktp') is-invalid @enderror" id="file_ktp" name="file_ktp" >
                    @error('file_ktp')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="file_npwp">File NPWP</label>
                    <input type="file" class="form-control @error('file_npwp') is-invalid @enderror" id="file_npwp" name="file_npwp" >
                    @error('file_npwp')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
    @section('js')
    <script>
        $(function() {
            $('#menggunakan_mtki_payment').change(function() {
                if ($(this).val() == 'TIDAK') {
                    $('#alasan_container').show();
                    $('#alasan_tidak_menggunakan_mtki_payment').prop('required', true);
                } else {
                    $('#alasan_container').hide();
                    $('#alasan_tidak_menggunakan_mtki_payment').prop('required', false);
                }
            }).trigger('change');
        });
    </script>
    @endsection
</x-admin>
