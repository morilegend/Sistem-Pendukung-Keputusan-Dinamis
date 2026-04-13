<div class="modal fade" id="penilaianCreateModal" tabindex="-1" aria-labelledby="penilaianCreateModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="penilaianCreateModalLabel">Tambah Penilaian</h5>
            </div>
            <form id="penilaianForm">
                @csrf
                <div class="modal-body">
                    <!-- Kategori Penilaian -->
                    <div class="mb-3">
                        <label for="kategoriPenilaian" class="form-label">Penilaian Untuk</label>
                        <input type="text" class="form-control" value="{{ $kategoriPenilaian->nama }}" disabled>
                        <input type="hidden" name="id_kategori_penilaian" value="{{ $kategoriPenilaian->id }}">
                    </div>

                    <!-- Alternatif -->
                    <div class="mb-3">
                        <label for="alternatif_id" class="form-label">Alternatif</label>
                        <select class="form-control" id="alternatif_id" name="alternatif_id" required>
                            <option value="" selected disabled>Pilih Alternatif</option>
                            @foreach ($alternatif as $alt)
                            @if (!in_array($alt->id, $usedAlternatives))
                            <option value="{{ $alt->id }}">{{ $alt->nama }}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>

                    <!-- Kriteria dan Sub-Kriteria -->
                    <div>
                        @foreach ($kriteria as $k)
                        <div class="mb-3 kriteria-row">
                            <label class="form-label">{{ $k->nama }}</label>
                            <div class="d-flex align-items-center">
                                <select class="form-control sub-kriteria-select" data-kriteria-id="{{ $k->id }}"
                                    name="id_sub_kriteria[{{ $k->id }}]">
                                    <option value="" selected disabled>Pilih Sub-Kriteria</option>
                                    @forelse ($k->sub_kriteria as $subKriteria)
                                    <option value="{{ $subKriteria->id }}">{{ $subKriteria->nama }}</option>
                                    @empty
                                    <option value="" selected disabled>Sub-Kriteria Tidak Tersedia</option>
                                    @endforelse
                                </select>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary shadow-sm" data-dismiss="modal">
                        <i class="fas fa-times mr-2"></i> Batal
                    </button>
                    <button type="button" class="btn btn-primary shadow-sm" id="submitPenilaian">
                        <i class="fas fa-save mr-2"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#submitPenilaian').click(function() {
        let formData = [];
        let alternatifId = $('#alternatif_id').val();
        let kategoriPenilaianId = $('input[name="id_kategori_penilaian"]').val();

        // Validasi pilihan Alternatif
        if (!alternatifId) {
            alert('Alternatif harus dipilih!');
            return;
        }

        let isComplete = true; // Menandai apakah semua Sub-Kriteria sudah diisi

        // Validasi setiap Sub-Kriteria
        $('.kriteria-row').each(function() {
            let kriteriaId = $(this).find('.sub-kriteria-select').data('kriteria-id');
            let subKriteriaId = $(this).find('.sub-kriteria-select').val();

            if (!subKriteriaId) {
                isComplete = false; // Jika ada yang belum diisi, set false
                $(this).find('.sub-kriteria-select').addClass(
                    'is-invalid'); // Tambahkan gaya error
            } else {
                $(this).find('.sub-kriteria-select').removeClass(
                    'is-invalid'); // Hapus gaya error jika diisi
                formData.push({
                    alternatif_id: alternatifId,
                    id_kategori_penilaian: kategoriPenilaianId,
                    id_kriteria: kriteriaId,
                    id_sub_kriteria: subKriteriaId,
                });
            }
        });

        // Jika ada Sub-Kriteria yang belum diisi, tampilkan alert
        if (!isComplete) {
            alert('Harap isi semua Sub-Kriteria sebelum menyimpan!');
            return;
        }

        // Kirim data melalui AJAX
        $.ajax({
            url: "{{ route('pengguna_utama.penilaian.store') }}",
            type: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                penilaian_data: formData,
            },
            success: function(response) {
                window.location.href =
                    "{{ route('pengguna_utama.penilaian.index', ['kategoriPenilaianId' => $kategoriPenilaian->id]) }}";
            },
            error: function(xhr) {
                console.error('Error:', xhr.responseText);
                alert(
                    'Terjadi kesalahan saat menyimpan penilaian. Periksa kembali data yang Anda masukkan.'
                );
            },
        });
    });
});
</script>
