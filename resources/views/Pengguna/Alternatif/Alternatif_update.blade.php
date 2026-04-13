<div class="modal fade" id="alternatifEditModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true"
    data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="#">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Alternatif</h5>
                </div>

                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="modal-body">
                    @foreach($alternatif as $item)
                    <input type="hidden" id="editIdKategori" name="id_kategori_alternatif"
                        value="{{ $item->id_kategori_alternatif }}">
                    @endforeach
                    <div class="mb-3">
                        <label for="editNamaAlternatif" class="form-label">Nama Alternatif</label>
                        <input type="text" class="form-control" id="editNamaAlternatif" name="nama" required>
                    </div>


                    <div class="mb-3">
                        <label for="editKeterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control" id="editKeterangan" name="keterangan" rows="3" required
                            style="resize: none;"></textarea>
                    </div>

                    <input type="hidden" id="editStatus" name="status" value="aktif">
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
