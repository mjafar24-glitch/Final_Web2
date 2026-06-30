# Task 5: Sirkulasi Peminjaman dan Denda Otomatis

## Deskripsi Tugas
Membangun inti sistem perpustakaan yaitu proses transaksi peminjaman dan pengembalian buku, lengkap dengan fitur perhitungan denda jika terjadi keterlambatan.

## Referensi Entitas (Berdasarkan PRD)
- **BORROWINGS**: `id`, `member_id`, `book_copy_id`, `user_id`, `borrow_date`, `due_date`, `return_date`, `status`
- **FINES**: `id`, `borrowing_id`, `amount`, `late_days`, `payment_status`

## Langkah Pengerjaan
1. **Migration & Model:** 
   - Buat migration dan model untuk `borrowings` dan `fines`.
2. **Pembuatan Seeder & Factory (Wajib Data Dummy):**
   - Buat `BorrowingFactory` dan `FineFactory`. Bangkitkan data peminjaman yang masih aktif (borrowed) dan yang sudah selesai (returned).
   - Simulasikan data pengembalian yang terlambat beserta denda (fines) yang di-generate.
3. **Logika Sirkulasi:**
   - **Peminjaman**: Buat antarmuka kasir/petugas (bisa scan barcode member dan buku). Saat dipinjam, ubah status `Book_Copies` menjadi 'borrowed'.
   - **Pengembalian & Denda**: Saat pengembalian, hitung selisih hari. Jika `return_date` > `due_date`, otomatis ciptakan record di `Fines`. Ubah status `Book_Copies` menjadi 'available' (atau 'reserved' jika ada antrean).
   
## Kriteria Selesai (Definition of Done)
- [ ] Transaksi peminjaman dan pengembalian berjalan dengan mengubah status eksemplar secara konsisten.
- [ ] Perhitungan denda tereksekusi dengan benar berdasar parameter hari.
- [ ] Terdapat tampilan data dummy pada tabel riwayat sirkulasi.
