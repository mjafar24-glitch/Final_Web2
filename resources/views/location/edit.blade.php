<x-app>

    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3">

        <form action="{{ route('location.update', $location) }}" method="post" class="form">
            @csrf
            @method('put')

            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="floor" class="form-label">Lantai</label>
                        <input class="form-control @error('floor') is-invalid @enderror" type="text" id="floor"
                            name="floor" value="{{ old('floor', $location->floor) }}">
                        @error('floor')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="aisle" class="form-label">Lorong</label>
                        <input class="form-control @error('aisle') is-invalid @enderror" type="text" id="aisle"
                            name="aisle" value="{{ old('aisle', $location->aisle) }}">
                        @error('aisle')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="shelf_number" class="form-label">Nomor Rak</label>
                        <input class="form-control @error('shelf_number') is-invalid @enderror" type="text" id="shelf_number"
                            name="shelf_number" value="{{ old('shelf_number', $location->shelf_number) }}">
                        @error('shelf_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="text-end">
                <a href="{{ route('location.index') }}" class="btn btn-warning me-1">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>

        </form>

    </div>

</x-app>
