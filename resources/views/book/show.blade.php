<div class="row">
    <div class="col-md-4 text-center border-end">
        <i class='bx bx-book-alt text-primary' style="font-size: 80px;"></i>
        <h5 class="fw-bold mt-3">{{ $book->title }}</h5>
        <span class="badge bg-secondary fs-6">{{ $book->category->name ?? '-' }}</span>
    </div>
    <div class="col-md-8">
        <h5 class="fw-bold mb-3 border-bottom pb-2">Informasi Buku</h5>
        <div class="row mb-2">
            <div class="col-sm-4 text-muted">ISBN</div>
            <div class="col-sm-8 fw-semibold"><code>{{ $book->isbn }}</code></div>
        </div>
        <div class="row mb-2">
            <div class="col-sm-4 text-muted">Judul</div>
            <div class="col-sm-8">{{ $book->title }}</div>
        </div>
        <div class="row mb-2">
            <div class="col-sm-4 text-muted">Penulis</div>
            <div class="col-sm-8">{{ $book->author }}</div>
        </div>
        <div class="row mb-2">
            <div class="col-sm-4 text-muted">Kategori</div>
            <div class="col-sm-8">{{ $book->category->name ?? '-' }}</div>
        </div>
        <div class="row mb-2">
            <div class="col-sm-4 text-muted">Penerbit</div>
            <div class="col-sm-8">{{ $book->publisher ?? 'Tidak ada data' }}</div>
        </div>
        <div class="row mb-2">
            <div class="col-sm-4 text-muted">Tahun Terbit</div>
            <div class="col-sm-8">{{ $book->year_published ?? 'Tidak ada data' }}</div>
        </div>
        <div class="row mb-2">
            <div class="col-sm-4 text-muted">Ditambahkan</div>
            <div class="col-sm-8">{{ $book->created_at->format('d M Y') }}</div>
        </div>
    </div>
</div>
