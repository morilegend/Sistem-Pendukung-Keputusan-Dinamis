<div class="modal fade" id="subKriteriaEditModal" tabindex="-1" aria-labelledby="subKriteriaEditModalLabel"
    data-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-content-centered">
            <div class="modal-header">
                <h5 class="modal-title" id="subKriteriaEditModalLabel">Edit Subkriteria</h5>
            </div>
            <form id="subKriteriaEditForm" action="#" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" id="editKriteriaId" name="id_kriteria" value="{{ $kriteria->id }}">
                    <input type="hidden" id="editSubKriteriaId" name="id">

                    <div class="mb-3">
                        <label for="editNamaSubKriteria" class="form-label">Nama Sub Kriteria</label>
                        <input type="text" class="form-control" id="editNamaSubKriteria" name="nama" required>
                    </div>

                    <div class="mb-3">
                        <label for="editNilaiCrisp" class="form-label">Nilai Crisp</label>
                        <input type="number" class="form-control" id="editNilaiCrisp" name="nilai_crisp" min="0"
                            max="100" required placeholder="Masukkan Nilai Crisp">
                    </div>

                    <div class="mb-3">
                        <label for="editNilaiFuzzy" class="form-label">Nilai Fuzzy</label>
                        <input type="number" class="form-control" id="editNilaiFuzzy" name="nilai_fuzzy" min="0"
                            step = "0.001" max="1" required placeholder="Masukkan Nilai Fuzzy">
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
    document.getElementById('subKriteriaEditForm').addEventListener('submit', function(e) {
        e.preventDefault();

        // Mengambil nilai input
        const nama = document.getElementById('editNamaSubKriteria').value.trim();
        const nilaiCrisp = document.getElementById('editNilaiCrisp').value;

        console.log('Edit Nama:', nama, 'Nilai Crisp:', nilaiCrisp);

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

        alert('Berhasil Mengubah subkriteria!');
        this.submit();
    });
});
</script>

