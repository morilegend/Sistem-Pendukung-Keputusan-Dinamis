<div class="modal fade" id="alternatifEditModal" tabindex="-1" aria-labelledby="alternatifEditModalLabel"
    aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="alternatifEditModalLabel">Edit Kategori Alternatif</h5>
            </div>
            <form method="POST" action="">
                @csrf
                @method('PUT')
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

                    <div class="mb-3">
                        <label for="editNamaAlternatif" class="form-label">Nama Kategori Alternatif</label>
                        <input type="text" class="form-control" id="editNamaAlternatif" name="nama" required>
                    </div>

<div class="modal fade" id="alternatifEditModal" tabindex="-1" aria-labelledby="alternatifEditModalLabel"
    aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="alternatifEditModalLabel">Edit Kategori Alternatif</h5>
            </div>
            <form method="POST" action="">
                @csrf
                @method('PUT')
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

                    <div class="mb-3">
                        <label for="editNamaAlternatif" class="form-label">Nama Kategori Alternatif</label>
                        <input type="text" class="form-control" id="editNamaAlternatif" name="nama" required>
                    </div>

                    <div class="mb-3">
                        <label for="editKeterangan" class="form-label">Keterangan</label>
                        <input type="text" class="form-control" id="editKeterangan" name="keterangan"
                            style="resize: none;" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary shadow-sm" data-dismiss="modal">
                        <i class="fas fa-times mr-2"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-primary shadow-sm">
                        <i class="fas fa-save mr-2"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
