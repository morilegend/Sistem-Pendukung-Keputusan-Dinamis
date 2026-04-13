<div class="modal fade" id="alternatifCreateModal" tabindex="-1" aria-labelledby="alternatifCreateModalLabel"
    aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="alternatifCreateModalLabel">Tambah Alternatif</h5>
            </div>
            <form method="POST" action="{{ route('pengguna.alternatif.store') }}">
                @csrf
                <!-- Hidden Input untuk ID Kategori -->
                <input type="hidden" name="id_kategori_alternatif" value="{{ $kategori->id }}">

                <div class="modal-body">
                    <!-- Nama Alternatif -->
                    <div class="mb-3">

                        <label for="namaAlternatif" class="form-label">Nama
                            {{ $kategori->nama }}</label>
                        <input type="text" name="nama" id="namaAlternatif" class="form-control" placeholder="" required>
                    </div>

                    <!-- Keterangan -->
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea name="keterangan" id="keterangan" class="form-control" rows="3" required
                            style="resize: none;"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary shadow-sm" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-primary shadow-sm">
                        <i class="fas fa-save mr-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

