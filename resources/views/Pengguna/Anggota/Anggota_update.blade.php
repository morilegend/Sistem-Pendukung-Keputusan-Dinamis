<!-- Modal Edit Anggota -->
<div class="modal fade" id="anggotaEditModal" tabindex="-1" aria-labelledby="anggotaEditModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content shadow-lg rounded-3">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title d-flex align-items-center" id="anggotaEditModalLabel">
                    <i class="bi bi-pencil-fill me-2" style="font-size: 1.3rem;"></i>Edit Anggota
                </h5>
            </div>
            <form id="editAnggotaForm" action="" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" id="anggota_id" name="id">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label for="nama_update" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama_update" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="email_update" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email_update" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="jabatan_update" class="form-label">Jabatan</label>
                        <input type="text" class="form-control" id="jabatan_update" name="jabatan" required>
                    </div>
                    <div class="mb-3">
                        <label for="jenis_kelamin_update" class="form-label">Jenis Kelamin</label>
                        <select class="form-control" id="jenis_kelamin_update" name="jenis_kelamin" required>
                            <option value="Pria">Pria</option>
                            <option value="Wanita">Wanita</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label ">Hak Akses</label>
                        <div class="form-check">
                            <input type="hidden" name="akses_kriteria" value="0">
                            <input type="checkbox" class="form-check-input" id="akses_kriteria_update"
                                name="akses_kriteria" value="1">
                            <label class="form-check-label" for="akses_kriteria_update">Berikan akses kriteria</label>
                        </div>
                        <div class="form-check">
                            <input type="hidden" name="akses_alternatif" value="0">
                            <input type="checkbox" class="form-check-input" id="akses_alternatif_update"
                                name="akses_alternatif" value="1">
                            <label class="form-check-label" for="akses_alternatif_update">Berikan akses
                                alternatif</label>
                        </div>
                        <div class="form-check">
                            <input type="hidden" name="akses_penilaian" value="0">
                            <input type="checkbox" class="form-check-input" id="akses_penilaian_update"
                                name="akses_penilaian" value="1">
                            <label class="form-check-label" for="akses_penilaian_update">Berikan akses penilaian</label>
                        </div>
                        <div class="form-check">
                            <input type="hidden" name="akses_simpan_perhitungan" value="0">
                            <input type="checkbox" class="form-check-input" id="akses_simpan_perhitungan_update"
                                name="akses_simpan_perhitungan" value="1">
                            <label class="form-check-label" for="akses_simpan_perhitungan_update">Berikan akses simpan
                                perhitungan</label>
                        </div>

                        <div class="form-check">
                            <input type="hidden" name="akses_anggota" value="0">
                            <input type="checkbox" class="form-check-input" id="akses_anggota_update"
                                name="akses_anggota" value="1">
                            <label class="form-check-label" for="akses_anggota_update">Berikan akses tambah
                                anggota</label>
                        </div>
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

