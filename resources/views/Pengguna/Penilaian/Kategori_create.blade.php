<div class="modal fade" id="kategoriCreateModal" tabindex="-1" aria-labelledby="kategoriCreateModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="kategoriCreateModalLabel">Penilaian</h5>
            </div>
            <form action="{{ route('pengguna.kategori_penilaian.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Penilaian</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="kategoriKriteria" class="form-label">Kategori Kriteria</label>
                        <select class="form-control" id="kategoriKriteria" name="id_kategori_kriteria" required>
                            <option value="" selected disabled>Pilih Kategori Kriteria</option>
                            @foreach ($kategoriKriteria as $kriteria)
                            <option value="{{ $kriteria->id }}">{{ $kriteria->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="kategoriAlternatif" class="form-label">Kategori Alternatif</label>
                        <select class="form-control" id="kategoriAlternatif" name="id_kategori_alternatif" required>
                            <option value="" selected disabled>Pilih Kategori Alternatif</option>
                            @foreach ($kategoriAlternatif as $alternatif)
                            <option value="{{ $alternatif->id }}">{{ $alternatif->nama }}</option>
                            @endforeach
                        </select>
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
