<div class="modal fade" id="kriteriaCreateModal" tabindex="-1" aria-labelledby="kriteriaCreateModalLabel"
    aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="kriteriaCreateModalLabel">Tambah Kriteria</h5>
            </div>
            <form method="POST" action="{{ route('pengguna.kriteria.store') }}">
                @csrf
                <div class="modal-body">
                    <!-- Display Validation Errors -->
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <!-- ID Kategori Kriteria (hidden) -->
                    <input type="hidden" name="id_kategori_kriteria" value="{{ $kategori_id ?? '' }}">

                    <div class="mb-3">
                        <label for="nama" class="form-label">
                            Kriteria {{ $kategori ? $kategori->nama : 'Kriteria' }}
                        </label>
                        <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama') }}"
                            required>
                    </div>

                    <!-- Bobot -->
                    <div class="mb-3">
                        <label for="bobot" class="form-label">Bobot</label>
                        <input type="number" class="form-control" id="bobot" name="bobot" value="{{ old('bobot') }}"
                            required min="1" max="100">
                        <small class="text-muted">Masukkan bobot antara 1 hingga 100. Semakin tinggi bobot semakin
                        berpengaruh bobot tersebut</small>
                    </div>

                    <!-- Jenis -->
                    <div class="mb-3">
                        <label for="jenis" class="form-label">Jenis</label>
                        <select class="form-control" id="jenis" name="jenis" required>
                            <option value="" disabled {{ old('jenis') ? '' : 'selected' }}>Pilih Jenis</option>
                            <option value="benefit" {{ old('jenis') == 'benefit' ? 'selected' : '' }}>Benefit</option>
                            <option value="cost" {{ old('jenis') == 'cost' ? 'selected' : '' }}>Cost</option>
                        </select>
                        <small class="text-muted d-block mt-1">Pilih Benefit Jika Semakin tinggi nilai kriteria ini,
                        semakin baik untuk pengambilan keputusan .</small>
                        <small class="text-muted d-block">Pilih Cost jika Semakin kecil nilai kriteria ini,
                        semakin baik untuk pengambilan keputusan .</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary shadow-sm" data-dismiss="modal">
                        <i class="fas fa-times mr-2"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-primary shadow-sm">
                        <i class="fas fa-save mr-2"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

