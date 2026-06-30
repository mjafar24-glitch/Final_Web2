# Task 1: Penyesuaian Autentikasi dan Manajemen Pengguna (User Management)

## Deskripsi Tugas
Melakukan penyesuaian pada sistem autentikasi dan modul manajemen pengguna (Users) yang sudah ada pada template saat ini. Penyesuaian ini bertujuan agar selaras dengan kebutuhan spesifikasi di `PRD.md`, terutama terkait pengelolaan peran pengguna (User Role). Seluruh pekerjaan harus mematuhi konvensi koding, pola arsitektur, dan penamaan yang sudah eksis di proyek saat ini (tidak membuat pola/pendekatan baru).

## Referensi Entitas (Berdasarkan PRD)
- **USERS**: `id`, `name`, `email`, `password`, `role`, `created_at`

## Langkah Pengerjaan
1. **Pengecekan Struktur Tabel:** 
   - Analisis struktur tabel `users` saat ini. 
   - Sesuaikan *migration* tabel `users` (tambahkan/ubah kolom `role` jika belum sesuai PRD). Role yang valid sesuai sistem perpustakaan (misal: 'admin', 'pustakawan').
2. **Penyesuaian Model:**
   - Update model `User.php` dengan menambahkan fillable untuk atribut `role`.
3. **Pembuatan/Pembaruan Seeder & Factory (Wajib Data Dummy):**
   - Update `UserSeeder.php` dan `UserFactory.php` untuk men-generate data dummy bagi setiap role yang didefinisikan. Tujuannya agar visualisasi data dan pengujian hak akses bisa dilakukan.
4. **Penyesuaian Logika CRUD User:**
   - Periksa controller yang menangani User Management (misal: `UserController`).
   - Sesuaikan fungsi Create, Read, Update, dan Delete agar form dan validasinya mengenali input/proses data `role`.
   - Pastikan view/UI (blade) untuk form pengguna diperbarui agar memiliki *dropdown/select* untuk Role.
5. **Konvensi Kode (Wajib):**
   - Gunakan pendekatan arsitektur yang sudah ada (misal: jika template menggunakan standard resource controller, ikuti pola tersebut).

## Kriteria Selesai (Definition of Done)
- [ ] Migration tabel users telah disesuaikan dan di-*migrate* ulang tanpa error.
- [ ] Menjalankan seeder berhasil mengisi tabel `users` dengan variasi role (Admin, Pustakawan).
- [ ] Fitur CRUD pengguna (Users) berjalan lancar dari antarmuka web, mampu menyimpan dan meng-update kolom role.
- [ ] Tidak ada pelanggaran *coding style* yang ada saat ini.
