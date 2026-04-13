<div class="modal fade" id="kriteriaEditModal" tabindex="-1" aria-labelledby="kriteriaEditModalLabel" aria-hidden="true"
    data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="kriteriaEditModalLabel">Edit Kriteria</h5>
            </div>
            <form method="POST" id="kriteriaEditForm" action="">
                @csrf
                @method('PUT')

                <div class="modal-body">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    @foreach ($kriteria as $item)
                    <input type="hidden" name="id_kategori_kriteria" id="editKategoriId"
                        value="{{ $item->id_kategori_kriteria }}">
                    @endforeach
                    <div class="mb-3">
                        <label for="editNamaKriteria" class="form-label">Nama Kriteria</label>
                        <input type="text" name="nama" id="editNamaKriteria" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="editBobotKriteria" class="form-label">Bobot</label>
                        <input type="number" name="bobot" id="editBobotKriteria" class="form-control" min="1" max="100"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="editJenisKriteria" class="form-label">Jenis</label>
                        <select name="jenis" id="editJenisKriteria" class="form-control" required>
                            <option value="" disabled {{ empty($item->jenis ?? '') ? 'selected' : '' }}>Pilih Jenis
                            </option>
                            <option value="benefit" {{ ($item->jenis ?? '') === 'benefit' ? 'selected' : '' }}>Benefit
<div class="modal fade" id="kriteriaEditModal" tabindex="-1" aria-labelledby="kriteriaEditModalLabel" aria-hidden="true"
    data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="kriteriaEditModalLabel">Edit Kriteria</h5>
            </div>
            <form method="POST" id="kriteriaEditForm" action="">
                @csrf
                @method('PUT')

                <div class="modal-body">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    @foreach ($kriteria as $item)
                    <input type="hidden" name="id_kategori_kriteria" id="editKategoriId"
                        value="{{ $item->id_kategori_kriteria }}">
                    @endforeach
                    <div class="mb-3">
                        <label for="editNamaKriteria" class="form-label">Nama Kriteria</label>
                        <input type="text" name="nama" id="editNamaKriteria" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="editBobotKriteria" class="form-label">Bobot</label>
                        <input type="number" name="bobot" id="editBobotKriteria" class="form-control" min="1" max="100"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="editJenisKriteria" class="form-label">Jenis</label>
                        <select name="jenis" id="editJenisKriteria" class="form-control" required>
                            <option value="" disabled {{ empty($item->jenis ?? '') ? 'selected' : '' }}>Pilih Jenis
                            </option>
                            <option value="benefit" {{ ($item->jenis ?? '') === 'benefit' ? 'selected' : '' }}>Benefit
                            </option>
                            <option value="cost" {{ ($item->jenis ?? '') === 'cost' ? 'selected' : '' }}>Cost</option>
                        </select>
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
