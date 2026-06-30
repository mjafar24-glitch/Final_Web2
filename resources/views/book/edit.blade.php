<x-app>

    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3">

        <form action="{{ route('book.update', $book) }}" method="post" class="form">
            @csrf
            @method('put')

            <div class="row g-3 mb-3">

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="category_id" class="form-label required">Kategori</label>
                        <select class="form-select select2-default @error('category_id') is-invalid @enderror"
                            id="category_id" name="category_id" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}" @selected(old('category_id', $book->category_id) == $cat->id)>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="isbn" class="form-label required">ISBN</label>
                        <input class="form-control @error('isbn') is-invalid @enderror" type="text" id="isbn"
                            name="isbn" required value="{{ old('isbn', $book->isbn) }}">
                        @error('isbn')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="mb-3">
                        <label for="title" class="form-label required">Judul Buku</label>
                        <input class="form-control @error('title') is-invalid @enderror" type="text" id="title"
                            name="title" required value="{{ old('title', $book->title) }}">
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="author" class="form-label required">Penulis</label>
                        <input class="form-control @error('author') is-invalid @enderror" type="text" id="author"
                            name="author" required value="{{ old('author', $book->author) }}">
                        @error('author')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="publisher" class="form-label">Penerbit (Opsional)</label>
                        <input class="form-control @error('publisher') is-invalid @enderror" type="text" id="publisher"
                            name="publisher" value="{{ old('publisher', $book->publisher) }}">
                        @error('publisher')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="year_published" class="form-label">Tahun Terbit (Opsional)</label>
                        <input class="form-control @error('year_published') is-invalid @enderror" type="number"
                            id="year_published" name="year_published" value="{{ old('year_published', $book->year_published) }}"
                            min="1000" max="{{ date('Y') }}">
                        @error('year_published')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

            </div>

            <div class="text-end">
                <a href="{{ route('book.index') }}" class="btn btn-warning me-1">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>

        </form>

    </div>

</x-app>
