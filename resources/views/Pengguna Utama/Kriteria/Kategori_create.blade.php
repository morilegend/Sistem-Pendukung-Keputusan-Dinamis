<div class="modal fade" id="kategoriCreateModal" tabindex="-1" aria-labelledby="kategoriCreateModalLabel"
    aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="kategoriCreateModalLabel">Tambah Kategori Kriteria</h5>
            </div>
            <form method="POST" action="{{ route('pengguna_utama.kategori_kriteria.store') }}">
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

                    <!-- Nama Kategori -->
                    <div class="mb-3">
                        <label for="namaKategori" class="form-label">Nama Kategori</label>
                        <input type="text" class="form-control" id="namaKategori" name="nama" required>
                    </div>

                    <!-- Keterangan -->
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control" id="keterangan" name="keterangan" rows="3" required
                            style="resize: none;"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <!-- Tombol Batal -->
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <!-- Tombol Simpan -->
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

