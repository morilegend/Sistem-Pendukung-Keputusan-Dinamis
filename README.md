# Sistem Pendukung Keputusan (SPK) Dinamis

Aplikasi Sistem Pendukung Keputusan (SPK) Dinamis yang dibangun menggunakan framework **Laravel 11**. Aplikasi ini memungkinkan pengguna untuk membuat, mengelola, dan melakukan perhitungan SPK secara dinamis dengan dukungan multi-kategori untuk Kriteria, Alternatif, dan Penilaian.

##Fitur Utama
Aplikasi ini dilengkapi dengan berbagai fitur yang mendukung fleksibilitas dalam proses pengambilan keputusan:

1. **Multi-Role / Hak Akses Pengguna:**
   - **Admin:** Memiliki akses penuh untuk mengelola pengguna (manajemen *user* dan validasinya) serta akses *dashboard* utama.
   - **Pengguna Utama:** Dapat mengelola referensi SPK secara penuh mulai dari kategori, kriteria, alternatif, penilaian, hingga manajemen anggota.
   - **Pengguna:** Memiliki akses yang diatur untuk melakukan proses penilaian dan perhitungan berdasarkan kategori yang diizinkan.

2. **Fleksibilitas Manajemen Data SPK (Dinamis):**
   - **Kategori Kriteria:** Pemisahan kriteria berdasarkan kategori tertentu.
   - **Kategori Alternatif:** Mengelompokkan alternatif agar penilaian lebih terstruktur.
   - **Kategori Penilaian:** Memungkinkan pembuatan beberapa sesi atau kelompok penilaian yang berbeda secara mandiri.

3. **Komponen Inti SPK:**
   - **Manajemen Kriteria & Subkriteria:** Penentuan bobot dan jenis kriteria secara dinamis.
   - **Manajemen Alternatif:** Penambahan data alternatif yang akan dinilai.
   - **Proses Penilaian:** Input nilai pada setiap alternatif berdasarkan kriteria yang telah ditetapkan.
   - **Perhitungan Evaluasi:** Melakukan komputasi algoritma SPK untuk menghasilkan nilai preferensi/akhir.
   - **Hasil & Perankingan:** Menampilkan hasil akhir perhitungan beserta fungsi penyimpanan ranking.

---

##System Requirements

- **PHP: Versi 8.2 atau lebih baru**
- **Composer:** Sebagai *dependency manager* PHP.
- **Node.js & npm:**
- **Database: MySQL, MariaDB, atau SQLite**

---
### 1. Clone Repository
```bash
git clone https://github.com/morilegend/Sistem-Pendukung-Keputusan-Dinamis
```

### 2. Instalasi Dependensi PHP
```bash
composer install
```

### 3. Instalasi Dependensi Node.js (Frontend)
```bash
npm install
```

### 4. Generate Application Key
```bash
php artisan key:generate
```

### 5. Migrasi Database (Setup Tabel)
```bash
php artisan migrate
```

### 6. Membangun Aset (Build Assets)
```bash
npm run build
```

### 7. Menjalankan Aplikasi
```bash
php artisan serve
```
Aplikasi sekarang dapat diakses melalui browser di alamat:
**[http://localhost:8000](http://localhost:8000)**

---
