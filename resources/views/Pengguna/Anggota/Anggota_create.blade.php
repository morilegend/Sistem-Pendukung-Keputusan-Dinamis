<div class="modal fade" id="anggotaCreateModal" tabindex="-1" aria-labelledby="anggotaCreateModalLabel"
    aria-hidden="Ya">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content shadow-lg rounded-3">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title d-flex align-items-center" id="anggotaCreateModalLabel">
                    <i class="bi bi-person-plus-fill me-2"></i>Tambah Anggota
                </h5>
            </div>
            <form action="{{ route('pengguna.anggota.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama"
                            name="nama" value="{{ old('nama') }}" placeholder="Masukkan nama lengkap" required>
                        @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                            name="email" value="{{ old('email') }}" placeholder="contoh: email@example.com" required>
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            id="password" name="password" placeholder="Masukkan password" required>
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="jabatan" class="form-label">Jabatan</label>
                        <input type="text" class="form-control @error('jabatan') is-invalid @enderror" id="jabatan"
                            name="jabatan" value="{{ old('jabatan') }}" placeholder="Masukkan jabatan" required>
                        @error('jabatan')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                        <select class="form-control @error('jenis_kelamin') is-invalid @enderror" id="jenis_kelamin"
                            name="jenis_kelamin" required>
                            <option value="" selected disabled>Pilih jenis kelamin</option>
                            <option value="Pria" {{ old('jenis_kelamin') == 'Pria' ? 'selected' : '' }}>Pria</option>
                            <option value="Wanita" {{ old('jenis_kelamin') == 'Wanita' ? 'selected' : '' }}>Wanita
                            </option>
                        </select>
                        @error('jenis_kelamin')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label ">Hak Akses</label>
                        <div class="form-check">
                            <input type="hidden" name="akses_kriteria">
                            <input type="checkbox" class="form-check-input" id="akses_kriteria" name="akses_kriteria"
                                value="Ya">
                            <label class="form-check-label" for="akses_kriteria">Berikan akses kriteria</label>
                        </div>
                        <div class="form-check">
                            <input type="hidden" name="akses_alternatif">
                            <input type="checkbox" class="form-check-input" id="akses_alternatif"
                                name="akses_alternatif" value="Ya">
                            <label class="form-check-label" for="akses_alternatif">Berikan akses alternatif</label>
                        </div>
                        <div class="form-check">
                            <input type="hidden" name="akses_penilaian">
                            <input type="checkbox" class="form-check-input" id="akses_penilaian" name="akses_penilaian"
                                value="Ya">
                            <label class="form-check-label" for="akses_penilaian">Berikan akses penilaian</label>
                        </div>
                        <div class="form-check">
                            <input type="hidden" name="akses_simpan_perhitungan">
                            <input type="checkbox" class="form-check-input" id="akses_simpan_perhitungan"
                                name="akses_simpan_perhitungan" value="Ya">
                            <label class="form-check-label" for="akses_simpan_perhitungan">Berikan akses simpan
                                perhitungan</label>
                        </div>
                        <div class="form-check">
                            <input type="hidden" name="akses_anggota">
                            <input type="checkbox" class="form-check-input" id="akses_anggota" name="akses_anggota"
                                value="Ya">
                            <label class="form-check-label" for="akses_anggota">Berikan akses tambah
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

