# Task 4: Manajemen Eksemplar Buku dan Lokasi Rak

## Deskripsi Tugas
Melakukan manajemen barang fisik dari katalog buku. Satu entitas buku bisa memiliki banyak *copy* (eksemplar). Modul ini juga menangani pencatatan lokasi rak penyimpanan fisik buku tersebut.

## Referensi Entitas (Berdasarkan PRD)
- **LOCATIONS**: `id`, `floor`, `aisle`, `shelf_number`
- **BOOK_COPIES**: `id`, `book_id`, `location_id`, `copy_code`, `status`, `condition`

## Langkah Pengerjaan
1. **Migration & Model:** 
   - Buat migration dan model untuk tabel `locations` dan `book_copies`.
2. **Pembuatan Seeder & Factory (Wajib Data Dummy):**
   - Buat `LocationSeeder` untuk *generate* variasi nama/nomor rak.
   - Buat `BookCopyFactory` yang terkait dengan model `Book` dan `Location`.
   - Bangkitkan 3-5 eksemplar per buku dengan `status` yang bervariasi (available, borrowed, dll).
3. **Logika CRUD:**
   - Modul ini dapat digabung di halaman detail buku (`show.blade.php` pada BookController) atau dibuat sebagai modul terpisah (`BookCopyController`).
   - Sertakan fitur pembuatan *Barcode/copy_code* secara otomatis atau input manual.

## Kriteria Selesai (Definition of Done)
- [ ] Relasi antara `Books`, `Locations`, dan `Book_Copies` terbentuk dan berjalan baik.
- [ ] Data dummy berhasil di-seed dan dapat ditampilkan dalam bentuk list/tabel eksemplar di aplikasi.
- [ ] Dapat mengedit status dan kondisi per-eksemplar.
