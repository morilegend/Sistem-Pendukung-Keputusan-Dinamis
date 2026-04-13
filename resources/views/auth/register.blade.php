<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun | SPK App</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    
    <style>
        :root {
            --primary: #4361ee;
            --primary-hover: #3a56d4;
            --bg-body: #f8fafc;
        }

        body {
            font-family: 'Outfit', sans-serif;
            margin: 0;
            padding: 3rem 1rem;
            min-height: 100vh;
            background-color: var(--bg-body);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .register-container {
            width: 100%;
            max-width: 800px;
        }

        .card {
            background: white;
            border-radius: 1rem;
            border: 1px solid #e2e8f0;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
            padding: 3rem;
        }

        .header-section {
            text-align: center;
            margin-bottom: 3rem;
        }

        .header-section i {
            color: var(--primary);
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        h1 {
            font-size: 1.75rem;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 0.5rem;
        }

        .form-label {
            font-weight: 500;
            color: #475569;
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
        }

        .form-control, .form-select, .select2-container--default .select2-selection--single {
            border-radius: 0.75rem;
            padding: 0.7rem 1rem;
            border: 1px solid #e2e8f0;
            background-color: #ffffff;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(67, 97, 238, 0.1);
            outline: none;
        }

        .btn-primary {
            background-color: var(--primary);
            border: none;
            border-radius: 0.75rem;
            padding: 0.9rem;
            font-weight: 500;
            width: 100%;
            margin-top: 2rem;
            transition: all 0.2s;
        }

        /* Select2 Style */
        .select2-container--default .select2-selection--single {
            height: auto;
            border: 1px solid #e2e8f0;
            padding: 0.5rem 0.75rem;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            padding: 0;
            color: #1e293b;
        }

        .gender-options {
            background: #f8fafc;
            padding: 0.75rem 1rem;
            border-radius: 0.75rem;
            border: 1px solid #e2e8f0;
        }

        .footer-text {
            text-align: center;
            margin-top: 2rem;
            font-size: 0.9rem;
            color: #64748b;
        }

        .footer-text a {
            color: var(--primary);
            font-weight: 500;
            text-decoration: none;
        }

        .invalid-feedback {
            font-size: 0.8rem;
            margin-left: 0.5rem;
        }
    </style>
</head>

<body>
    <div class="register-container">
        <div class="card">
            <div class="header-section">
                <i class="fas fa-user-circle"></i>
                <h1>Buat Akun Baru</h1>
                <p class="text-muted">Silakan lengkapi data diri Anda</p>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label for="nama" class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama" id="nama"
                            class="form-control @error('nama') is-invalid @enderror" 
                            placeholder="Andi Wijaya" value="{{ old('nama') }}" required>
                        @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-4">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email"
                            class="form-control @error('email') is-invalid @enderror"
                            placeholder="nama@email.com" value="{{ old('email') }}" required>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-4">
                        <label for="no_hp" class="form-label">Nomor HP / WhatsApp</label>
                        <input type="text" name="no_hp" id="no_hp"
                            class="form-control @error('no_hp') is-invalid @enderror"
                            placeholder="0812xxxx" value="{{ old('no_hp') }}" required>
                        @error('no_hp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-4">
                        <label for="domisili" class="form-label">Domisili</label>
                        <select name="domisili" id="domisili"
                            class="form-control @error('domisili') is-invalid @enderror w-100" required>
                            <option value="" disabled selected>Pilih Domisili</option>
                            @foreach ($domisili as $item)
                            <option value="{{ $item['name'] }}"
                                {{ old('domisili') == $item['name'] ? 'selected' : '' }}>{{ $item['name'] }}
                            </option>
                            @endforeach
                        </select>
                        @error('domisili') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-12 mb-4">
                        <label class="form-label">Jenis Kelamin</label>
                        <div class="gender-options d-flex gap-4">
                            <div class="form-check">
                                <input type="radio" name="jenis_kelamin" id="pria" value="Pria"
                                    class="form-check-input" {{ old('jenis_kelamin') == 'Pria' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="pria">Pria</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" name="jenis_kelamin" id="wanita" value="Wanita"
                                    class="form-check-input" {{ old('jenis_kelamin') == 'Wanita' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="wanita">Wanita</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 mb-4">
                        <label for="keperluan_spk" class="form-label">Keperluan SPK</label>
                        <textarea name="keperluan_spk" id="keperluan_spk"
                            class="form-control @error('keperluan_spk') is-invalid @enderror"
                            placeholder="Jelaskan kebutuhan Anda..." rows="3"
                            required>{{ old('keperluan_spk') }}</textarea>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password"
                            class="form-control @error('password') is-invalid @enderror" required>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="form-control" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    Daftar Sekarang
                </button>

                <div class="footer-text">
                    Sudah punya akun? <a href="{{ route('login') }}">Login Di Sini</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Success -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-sm" style="border-radius: 1rem;">
                <div class="modal-body text-center p-5">
                    <i class="fas fa-check-circle text-success mb-4" style="font-size: 4rem;"></i>
                    <h3 class="">Pendaftaran Berhasil!</h3>
                    <p class="text-muted">Akun Anda sedang menunggu validasi dari Admin. Silakan tunggu informasi selanjutnya.</p>
                    <button type="button" class="btn btn-primary w-100" id="redirectButton">Kembali ke Login</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    @if(session('modal_success'))
    <script>
    $(document).ready(function() {
        var modal = new bootstrap.Modal(document.getElementById('successModal'));
        modal.show();
        $('#redirectButton').on('click', function() {
            window.location.href = "{{ route('login') }}";
        });
    });
    </script>
    @endif

    <script>
    $(document).ready(function() {
        $('#domisili').select2({ placeholder: "Pilih Domisili", allowClear: true });
    });
    </script>
</body>

</html>

