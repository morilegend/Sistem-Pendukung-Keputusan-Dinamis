<!-- Modal -->
<div class="modal fade" id="simpanRankingModal" tabindex="-1" role="dialog" aria-labelledby="simpanRankingModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="simpanRankingModalLabel">Simpan Hasil Ranking</h5>
            </div>
            <form action="{{ route('pengguna.perhitungan.simpanRanking') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="kategori_nama">Nama Hasil Ranking</label>
                        <input type="text" class="form-control" id="kategori_nama" name="kategori_nama" required>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan Ranking</button>
                    </div>
            </form>
        </div>
    </div>
</div>