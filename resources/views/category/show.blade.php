<div class="row">
    <div class="col-md-4 text-center border-end">
        <i class='bx bx-category text-primary' style="font-size: 80px;"></i>
        <h4 class="fw-bold mt-3">{{ $category->name }}</h4>
        <span class="badge bg-primary fs-6">{{ $category->books->count() }} Buku</span>
    </div>
    <div class="col-md-8">
        <h5 class="fw-bold mb-3 border-bottom pb-2">Daftar Buku dalam Kategori</h5>
        @forelse ($category->books as $book)
            <div class="d-flex align-items-center mb-2 p-2 border rounded">
                <i class='bx bx-book me-2 text-primary fs-5'></i>
                <div>
                    <div class="fw-semibold">{{ $book->title }}</div>
                    <small class="text-muted">{{ $book->author }} &bull; {{ $book->year_published }}</small>
                </div>
            </div>
        @empty
            <p class="text-muted">Belum ada buku dalam kategori ini.</p>
        @endforelse
    </div>
</div>
