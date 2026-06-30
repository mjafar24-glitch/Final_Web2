<x-app>

    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3">

        <h5 class="fw-bold mb-3 border-bottom pb-2">Buku: {{ $book->title }}</h5>

        <form action="{{ route('book_copy.store') }}" method="post" class="form">
            @csrf
            <input type="hidden" name="book_id" value="{{ $book->id }}">

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="copy_code" class="form-label">Kode / Barcode (Opsional)</label>
                        <input class="form-control @error('copy_code') is-invalid @enderror" type="text" id="copy_code"
                            name="copy_code" value="{{ old('copy_code') }}" placeholder="Kosongkan untuk generate otomatis">
                        @error('copy_code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Biarkan kosong jika ingin sistem yang membuatkan barcode.</small>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="location_id" class="form-label required">Lokasi Rak</label>
                        <select class="form-select select2-default @error('location_id') is-invalid @enderror"
                            id="location_id" name="location_id" required>
                            <option value="">-- Pilih Lokasi --</option>
                            @foreach ($locations as $loc)
                                <option value="{{ $loc->id }}" @selected(old('location_id') == $loc->id)>
                                    Lt.{{ $loc->floor }} / Lrg.{{ $loc->aisle }} / Rak.{{ $loc->shelf_number }}
                                </option>
                            @endforeach
                        </select>
                        @error('location_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="status" class="form-label required">Status</label>
                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                            <option value="available" @selected(old('status', 'available') == 'available')>Available (Tersedia)</option>
                            <option value="borrowed" @selected(old('status') == 'borrowed')>Borrowed (Dipinjam)</option>
                            <option value="reserved" @selected(old('status') == 'reserved')>Reserved (Dipesan)</option>
                            <option value="lost" @selected(old('status') == 'lost')>Lost (Hilang)</option>
                            <option value="damaged" @selected(old('status') == 'damaged')>Damaged (Rusak)</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="condition" class="form-label">Kondisi (Opsional)</label>
                        <input class="form-control @error('condition') is-invalid @enderror" type="text" id="condition"
                            name="condition" value="{{ old('condition') }}" placeholder="Contoh: Baru, Baik, Kusam">
                        @error('condition')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="text-end">
                <a href="{{ route('book_copy.index', ['book_id' => $book->id]) }}" class="btn btn-warning me-1">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>

        </form>

    </div>

</x-app>
