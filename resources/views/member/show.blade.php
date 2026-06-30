<div class="row">
    <div class="col-md-4 text-center border-end">
        <i class='bx bx-user-circle text-primary' style="font-size: 100px;"></i>
        <h4 class="fw-bold mt-3">{{ $member->name }}</h4>
        <span class="badge {{ $member->is_active ? 'bg-success' : 'bg-danger' }} fs-6">
            {{ $member->is_active ? 'Aktif' : 'Non-Aktif' }}
        </span>
        <div class="mt-3">
            <span class="badge bg-secondary fs-6">{{ $member->type }}</span>
        </div>
    </div>
    <div class="col-md-8">
        <h5 class="fw-bold mb-3 border-bottom pb-2">Informasi Anggota</h5>
        <div class="row mb-2">
            <div class="col-sm-4 text-muted">Kode Member</div>
            <div class="col-sm-8 fw-semibold">{{ $member->member_code }}</div>
        </div>
        <div class="row mb-2">
            <div class="col-sm-4 text-muted">Tipe Anggota</div>
            <div class="col-sm-8">{{ $member->type }}</div>
        </div>
        <div class="row mb-2">
            <div class="col-sm-4 text-muted">Kontak</div>
            <div class="col-sm-8">{{ $member->contact ?? 'Tidak ada data' }}</div>
        </div>
        <div class="row mb-2">
            <div class="col-sm-4 text-muted">Bergabung Sejak</div>
            <div class="col-sm-8">{{ $member->created_at->format('d M Y') }}</div>
        </div>
    </div>
</div>
