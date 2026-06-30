# Task 2: Pendaftaran dan Manajemen Anggota Perpustakaan

## Deskripsi Tugas
Membangun fitur untuk mengelola data keanggotaan perpustakaan. Modul ini ditujukan agar sistem dapat mencatat data Siswa dan Guru yang berhak meminjam buku.

## Referensi Entitas (Berdasarkan PRD)
- **MEMBERS**: `id`, `member_code`, `name`, `type`, `contact`, `is_active`

## Langkah Pengerjaan
1. **Migration & Model:** 
   - Buat file migration untuk tabel `members`.
   - Buat model `Member.php` dengan penyesuaian *fillable*.
2. **Pembuatan Seeder & Factory (Wajib Data Dummy):**
   - Buat `MemberFactory` dan `MemberSeeder` untuk men-generate puluhan data anggota dummy (gabungan tipe Student dan Teacher) lengkap dengan status aktif dan non-aktif.
3. **Logika CRUD Members:**
   - Buat `MemberController` dengan standard resource controller.
   - Sediakan fitur pencarian, filter berdasarkan tipe anggota, dan *toggle* status aktif/non-aktif.
   - Pembuatan view (blade) untuk index, create, edit, show.

## Kriteria Selesai (Definition of Done)
- [x] Migration tabel members dan *Seeder* berhasil dijalankan.
- [x] Visualisasi data pada antarmuka admin menampilkan data *dummy*.
- [x] Fitur CRUD anggota berfungsi sepenuhnya.
