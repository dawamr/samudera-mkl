<x-admin>
    @section('title','Edit MKL')
    <div class="card bg-white">
        <div class="card-header">
            <h3 class="card-title">Edit MKL</h3>
            <div class="card-tools">
                <a href="{{ route('admin.mkl.index') }}" class="btn btn-sm btn-secondary">Kembali</a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.mkl.update', $mkl->nik) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="nik">NIK</label>
                    <input type="text" class="form-control" id="nik" value="{{ $mkl->nik }}" disabled>
                </div>
                <div class="form-group">
                    <label for="nama_pribadi">Nama Pribadi</label>
                    <input type="text" class="form-control @error('nama_pribadi') is-invalid @enderror" id="nama_pribadi" name="nama_pribadi" value="{{ old('nama_pribadi', $mkl->nama_pribadi) }}" required>
                    @error('nama_pribadi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="nama_mkl">Nama MKL</label>
                    <input type="text" class="form-control @error('nama_mkl') is-invalid @enderror" id="nama_mkl" name="nama_mkl" value="{{ old('nama_mkl', $mkl->nama_mkl) }}" required>
                    @error('nama_mkl')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="nama_pt_mkl">Nama PT MKL</label>
                    <input type="text" class="form-control @error('nama_pt_mkl') is-invalid @enderror" id="nama_pt_mkl" name="nama_pt_mkl" value="{{ old('nama_pt_mkl', $mkl->nama_pt_mkl) }}" required>
                    @error('nama_pt_mkl')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="no_telepon_pribadi">No. Telepon Pribadi</label>
                    <input type="text" class="form-control @error('no_telepon_pribadi') is-invalid @enderror" id="no_telepon_pribadi" name="no_telepon_pribadi" value="{{ old('no_telepon_pribadi', $mkl->no_telepon_pribadi) }}" required>
                    @error('no_telepon_pribadi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="no_telepon_kantor">No. Telepon Kantor</label>
                    <input type="text" class="form-control @error('no_telepon_kantor') is-invalid @enderror" id="no_telepon_kantor" name="no_telepon_kantor" value="{{ old('no_telepon_kantor', $mkl->no_telepon_kantor) }}" required>
                    @error('no_telepon_kantor')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email_kantor">Email Kantor</label>
                    <input type="email" class="form-control @error('email_kantor') is-invalid @enderror" id="email_kantor" name="email_kantor" value="{{ old('email_kantor', $mkl->email_kantor) }}" required>
                    @error('email_kantor')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="npwp_kantor">NPWP Kantor</label>
                    <input type="text" class="form-control @error('npwp_kantor') is-invalid @enderror" id="npwp_kantor" name="npwp_kantor" value="{{ old('npwp_kantor', $mkl->npwp_kantor) }}" required>
                    @error('npwp_kantor')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="menggunakan_mtki_payment">Menggunakan MTKI Payment</label>
                    <select class="form-control @error('menggunakan_mtki_payment') is-invalid @enderror" id="menggunakan_mtki_payment" name="menggunakan_mtki_payment" required>
                        <option value="1" {{ old('menggunakan_mtki_payment', $mkl->menggunakan_mtki_payment) == '1' ? 'selected' : '' }}>Ya</option>
                        <option value="0" {{ old('menggunakan_mtki_payment', $mkl->menggunakan_mtki_payment) == '0' ? 'selected' : '' }}>Tidak</option>
                    </select>
                    @error('menggunakan_mtki_payment')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group" id="alasan_container" style="display: none;">
                    <label for="alasan_tidak_menggunakan_mtki_payment">Alasan Tidak Menggunakan MTKI Payment</label>
                    <textarea class="form-control @error('alasan_tidak_menggunakan_mtki_payment') is-invalid @enderror" id="alasan_tidak_menggunakan_mtki_payment" name="alasan_tidak_menggunakan_mtki_payment" rows="3">{{ old('alasan_tidak_menggunakan_mtki_payment', $mkl->alasan_tidak_menggunakan_mtki_payment) }}</textarea>
                    @error('alasan_tidak_menggunakan_mtki_payment')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="status_aktif">Status Aktif</label>
                    <select class="form-control @error('status_aktif') is-invalid @enderror" id="status_aktif" name="status_aktif" required>
                        <option value="1" {{ old('status_aktif', $mkl->status_aktif) == '1' ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ old('status_aktif', $mkl->status_aktif) == '0' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                    @error('status_aktif')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="file_ktp">File KTP</label>
                    @if($mkl->file_ktp)
                        <div class="mb-2">
                            <a href="{{ Storage::url($mkl->file_ktp) }}" target="_blank" class="btn btn-sm btn-info">Lihat KTP</a>
                        </div>
                    @endif
                    <input type="file" class="form-control @error('file_ktp') is-invalid @enderror" id="file_ktp" name="file_ktp">
                    @error('file_ktp')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="file_npwp">File NPWP</label>
                    @if($mkl->file_npwp)
                        <div class="mb-2">
                            <a href="{{ Storage::url($mkl->file_npwp) }}" target="_blank" class="btn btn-sm btn-info">Lihat NPWP</a>
                        </div>
                    @endif
                    <input type="file" class="form-control @error('file_npwp') is-invalid @enderror" id="file_npwp" name="file_npwp">
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
                if ($(this).val() == '0') {
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