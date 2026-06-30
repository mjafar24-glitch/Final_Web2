<div class="row">
    <div class="col-md-4 text-center border-end">
        <i class='bx bx-barcode text-primary' style="font-size: 80px;"></i>
        <h4 class="fw-bold mt-3"><code>{{ $copy->copy_code }}</code></h4>
        @php
            $badge = 'bg-secondary';
            if ($copy->status == 'available') $badge = 'bg-success';
            elseif ($copy->status == 'borrowed') $badge = 'bg-warning text-dark';
            elseif ($copy->status == 'reserved') $badge = 'bg-info text-dark';
            elseif ($copy->status == 'lost' || $copy->status == 'damaged') $badge = 'bg-danger';
        @endphp
        <span class="badge {{ $badge }} fs-6">{{ ucfirst($copy->status) }}</span>
    </div>
    <div class="col-md-8">
        <h5 class="fw-bold mb-3 border-bottom pb-2">Informasi Eksemplar</h5>
        <div class="row mb-2">
            <div class="col-sm-4 text-muted">Buku</div>
            <div class="col-sm-8 fw-semibold">{{ $copy->book->title }}</div>
        </div>
        <div class="row mb-2">
            <div class="col-sm-4 text-muted">Penulis</div>
            <div class="col-sm-8">{{ $copy->book->author }}</div>
        </div>
        <div class="row mb-2">
            <div class="col-sm-4 text-muted">Kondisi</div>
            <div class="col-sm-8">{{ $copy->condition ?? 'Tidak ada catatan' }}</div>
        </div>
        <div class="row mb-2">
            <div class="col-sm-4 text-muted">Lokasi Rak</div>
            <div class="col-sm-8">
                @if($copy->location)
                    Lantai {{ $copy->location->floor }}, Lorong {{ $copy->location->aisle }}, Rak {{ $copy->location->shelf_number }}
                @else
                    <span class="text-danger">Belum diset</span>
                @endif
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-sm-4 text-muted">Ditambahkan Pada</div>
            <div class="col-sm-8">{{ $copy->created_at->format('d M Y H:i') }}</div>
        </div>
    </div>
</div>
