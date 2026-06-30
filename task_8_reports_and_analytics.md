# Task 8: Laporan dan Dashboard Analitik

## Deskripsi Tugas
Modul terakhir untuk merepresentasikan seluruh data perpustakaan menjadi informasi yang berguna (Laporan & Dashboard). 

## Referensi Entitas (Berdasarkan PRD)
- Berinteraksi dengan seluruh tabel yang ada (`Books`, `Members`, `Borrowings`, `Fines`).

## Langkah Pengerjaan
1. **Pembuatan Dashboard:**
   - Gunakan data dummy yang telah disemai (seeded) di task 1-7 untuk menampilkan *chart* statistik.
   - Indikator utama (Widget): Total Buku, Total Eksemplar, Anggota Aktif, Jumlah Peminjaman Bulan Ini, Total Pendapatan Denda.
2. **Pembuatan Laporan Peminjaman:**
   - Halaman dengan tabel filter tanggal (Date Range) untuk rekap sirkulasi.
   - (Opsional) Tambahkan fitur ekspor ke Excel atau PDF.
3. **Laporan Kinerja Buku:**
   - Menampilkan 10 Buku paling sering dipinjam (Top Books).
   - Daftar eksemplar buku yang rusak atau hilang (berdasarkan status di `Book_Copies`).

## Kriteria Selesai (Definition of Done)
- [ ] Dashboard penuh dengan grafik visualisasi dari data dummy yang dihasilkan semua modul.
- [ ] Admin dapat melihat buku mana yang terpopuler dan melacak eksemplar yang hilang.
