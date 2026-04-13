<div class="modal fade" id="subKriteriaCreateModal" tabindex="-1" aria-labelledby="subKriteriaCreateModalLabel"
    data-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="subKriteriaCreateModalLabel">Tambah Subkriteria</h5>
            </div>
            <form id="subKriteriaForm" action="{{ route('pengguna.sub_kriteria.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" id="kriteriaId" name="id_kriteria" value="{{ $kriteria->id }}">
                    <div class="mb-3">
                        <label for="namaSubKriteria" class="form-label">Nama Sub Kriteria {{ $kriteria->nama }}</label>
                        <input type="text" class="form-control" id="namaSubKriteria" name="nama" required>
                    </div>

                    <div class="mb-3">
                        <label for="nilaiCrisp" class="form-label">Nilai Crisp</label>
                        <input type="number" class="form-control" id="nilaiCrisp" name="nilai_crisp" min="0" max="100"
                            required placeholder="Masukkan Nilai Crisp">
                        <small class="text-muted">Masukkan nilai antara 0-100 contoh 50</small>
                    </div>

                    <div class="mb-3">
                        <label for="nilaiCrisp" class="form-label">Nilai Fuzzy</label>
                        <input type="number" class="form-control" id="nilaiFuzzy" name="nilai_fuzzy" min="0" max="1"
                            step="0.001" required placeholder="Masukkan Nilai Fuzzy">
                        <small class="text-muted">Masukkan nilai antara 0-1 contoh 0.5</small>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('subKriteriaForm').addEventListener('submit', function(e) {
        e.preventDefault();

        // Mengambil nilai input
        const nama = document.getElementById('namaSubKriteria').value.trim();
        const nilaiCrisp = document.getElementById('nilaiCrisp').value;

        // Validasi nama
        if (!nama) {
            alert('Nama Sub Kriteria harus diisi!');
            return;
        }

        // Validasi nilai crisp
        if (!nilaiCrisp) {
            alert('Harap pilih bobot!');
            return;
        }

        alert('Berhasil Dibuat!');

        // Jika semua validasi lulus, kirimkan form
        this.submit();
    });
});
</script>

