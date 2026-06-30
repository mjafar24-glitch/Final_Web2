<x-app>

    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3">

        <form action="{{ route('category.store') }}" method="post" class="form">
            @csrf

            <div class="row g-3 mb-3">
                <div class="col-md-12">

                    <div class="mb-3">
                        <label for="name" class="form-label required">Nama Kategori</label>
                        <input class="form-control @error('name') is-invalid @enderror" type="text" id="name"
                            name="name" required value="{{ old('name') }}" placeholder="Contoh: Fiksi, Sains, Sejarah">
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>
            </div>

            <div class="text-end">
                <a href="{{ route('category.index') }}" class="btn btn-warning me-1">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>

        </form>

    </div>

</x-app>
