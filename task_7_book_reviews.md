# Task 7: Ulasan Buku dan Interaksi Anggota

## Deskripsi Tugas
Memberikan fitur interaksi bagi anggota perpustakaan agar dapat meninggalkan *rating* dan ulasan (review) untuk buku-buku yang telah mereka baca. 

## Referensi Entitas (Berdasarkan PRD)
- **BOOK_REVIEWS**: `id`, `book_id`, `member_id`, `rating`, `review_text`, `created_at`

## Langkah Pengerjaan
1. **Migration & Model:** 
   - Buat file migration untuk `book_reviews` yang memiliki relasi ke `books` dan `members`.
2. **Pembuatan Seeder & Factory (Wajib Data Dummy):**
   - Buat seeder yang menyisipkan data rating (skala 1-5) dan paragraf ulasan *dummy* menggunakan *Faker*.
3. **Logika Ulasan:**
   - Validasi bahwa anggota hanya bisa mengulas buku yang memiliki riwayat pinjam (*Borrowings* sudah berstatus 'returned').
   - Tampilkan daftar ulasan pada halaman detail buku di sisi *frontend* (atau panel khusus).
   - Tampilkan *average rating* (rata-rata bintang) untuk setiap buku.

## Kriteria Selesai (Definition of Done)
- [ ] Database menampung data dummy ulasan.
- [ ] Rata-rata bintang buku terhitung dengan benar berdasarkan data dari seeder.
- [ ] Validasi berhasil mencegah anggota mengulas buku yang belum pernah dipinjam.
