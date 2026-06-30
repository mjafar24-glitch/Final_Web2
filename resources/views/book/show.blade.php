<div class="row">
    <div class="col-md-4 text-center border-end">
        <i class='bx bx-book-alt text-primary' style="font-size: 80px;"></i>
        <h5 class="fw-bold mt-3">{{ $book->title }}</h5>
        <span class="badge bg-secondary fs-6">{{ $book->category->name ?? '-' }}</span>

        <div class="mt-4">
            <h1 class="display-5 fw-bold text-warning mb-0">
                {{ number_format($book->average_rating, 1) }}
            </h1>
            <div class="text-warning fs-4">
                @for($i = 1; $i <= 5; $i++)
                    @if($i <= round($book->average_rating))
                        <i class='bx bxs-star'></i>
                    @else
                        <i class='bx bx-star'></i>
                    @endif
                @endfor
            </div>
            <small class="text-muted">{{ $book->bookReviews->count() }} Ulasan</small>
        </div>
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

<hr class="my-4">

<h5 class="fw-bold mb-3"><i class='bx bx-comment-detail'></i> Ulasan Anggota</h5>

<div class="mb-4">
    @forelse($book->bookReviews as $review)
        <div class="card bg-light border-0 mb-2">
            <div class="card-body py-2 px-3">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="fw-semibold">{{ $review->member->name }}</span>
                    <span class="text-warning">
                        @for($i = 1; $i <= 5; $i++)
                            <i class='bx {{ $i <= $review->rating ? 'bxs-star' : 'bx-star' }}'></i>
                        @endfor
                    </span>
                </div>
                <small class="text-muted d-block mb-1">{{ $review->created_at->format('d M Y, H:i') }}</small>
                <p class="mb-0 text-dark">{{ $review->review_text }}</p>
            </div>
        </div>
    @empty
        <div class="alert alert-secondary text-center py-2">Belum ada ulasan untuk buku ini.</div>
    @endforelse
</div>

<div class="card border border-primary">
    <div class="card-header bg-primary text-white py-2">
        <h6 class="mb-0 fw-semibold">Input Ulasan (Oleh Pustakawan)</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('book_review.store') }}" method="post">
            @csrf
            <input type="hidden" name="book_id" value="{{ $book->id }}">
            
            <div class="mb-3">
                <label for="member_id" class="form-label required">Pilih Anggota</label>
                <select class="form-select select2-default" name="member_id" id="member_id" required>
                    <option value="">-- Pilih Anggota yang pernah meminjam --</option>
                    @foreach($members as $member)
                        <option value="{{ $member->id }}">{{ $member->member_code }} - {{ $member->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="rating" class="form-label required">Rating (1-5)</label>
                <select class="form-select" name="rating" id="rating" required>
                    <option value="5">5 - Sangat Bagus</option>
                    <option value="4">4 - Bagus</option>
                    <option value="3">3 - Cukup</option>
                    <option value="2">2 - Kurang</option>
                    <option value="1">1 - Sangat Kurang</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="review_text" class="form-label">Teks Ulasan</label>
                <textarea class="form-control" name="review_text" id="review_text" rows="3" placeholder="Tulis komentar anggota di sini..."></textarea>
            </div>

            <button type="submit" class="btn btn-primary w-100">
                <i class='bx bx-send'></i> Simpan Ulasan
            </button>
        </form>
    </div>
</div>
