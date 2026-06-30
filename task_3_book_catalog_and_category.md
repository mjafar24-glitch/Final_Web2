# Task 3: Manajemen Katalog Buku dan Kategori

## Deskripsi Tugas
Mengembangkan modul katalog buku utama yang berfungsi sebagai master data buku. Diperlukan juga tabel referensi kategori untuk memetakan buku berdasarkan subjeknya.

## Referensi Entitas (Berdasarkan PRD)
- **CATEGORIES**: `id`, `name`
- **BOOKS**: `id`, `category_id`, `isbn`, `title`, `author`, `publisher`, `year_published`

## Langkah Pengerjaan
1. **Migration & Model:** 
   - Buat migration dan model untuk tabel `categories` dan `books`. Atur relasi (One to Many).
2. **Pembuatan Seeder & Factory (Wajib Data Dummy):**
   - Buat `CategorySeeder` untuk mengisi kategori buku standar (misal: Fiksi, Sains, Sejarah).
   - Buat `BookFactory` dan `BookSeeder` yang otomatis terhubung ke kategori yang sudah ada secara *random*.
3. **Logika CRUD dan Relasi:**
   - Buat `CategoryController` dan `BookController`.
   - Pastikan di form pembuatan/edit Buku, terdapat pilihan *dropdown* yang memuat data kategori.
   - Buat fitur *Advanced Search* pada katalog buku.

## Kriteria Selesai (Definition of Done)
- [ ] Tabel categories dan books berhasil di-*migrate* dan relasinya berjalan baik.
- [ ] Visualisasi tabel katalog di *frontend* atau panel admin menampilkan data buku *dummy*.
- [ ] Fitur CRUD, relasi, dan pencarian berjalan dengan sempurna.
