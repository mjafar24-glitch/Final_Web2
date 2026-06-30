# Task 6: Reservasi Buku Otomatis

## Deskripsi Tugas
Membangun alur booking / reservasi agar anggota perpustakaan dapat memesan buku yang sedang tidak tersedia (dipinjam orang lain). 

## Referensi Entitas (Berdasarkan PRD)
- **RESERVATIONS**: `id`, `member_id`, `book_id`, `allocated_copy_id`, `request_date`, `expiry_date`, `status`

## Langkah Pengerjaan
1. **Migration & Model:** 
   - Buat migration dan model untuk `reservations`.
2. **Pembuatan Seeder & Factory (Wajib Data Dummy):**
   - Buat *Seeder* untuk menghasilkan data dummy reservasi dengan status (pending, fulfilled, expired).
3. **Logika Trigger Reservasi:**
   - Tambahkan *event listener* atau *observer* pada proses pengembalian buku (modul Borrowings). 
   - Saat suatu eksemplar dikembalikan, sistem harus mengecek apakah ada `Reservations` *pending* untuk `book_id` bersangkutan.
   - Jika ada, update tabel reservasi (isi `allocated_copy_id`, set `expiry_date`) dan update status eksemplar menjadi 'reserved'.
4. **Logika Pembatalan (Expired):**
   - Buat sebuah *artisan command* (bisa dipanggil via cron job) untuk mengecek reservasi yang *expired* agar status buku kembali ke 'available'.

## Kriteria Selesai (Definition of Done)
- [ ] Alur reservasi sukses diuji dari pemesanan hingga buku tersedia.
- [ ] Data dummy reservasi tampil pada *dashboard* admin.
- [ ] Terdapat *command* untuk membersihkan reservasi yang sudah kedaluwarsa.
