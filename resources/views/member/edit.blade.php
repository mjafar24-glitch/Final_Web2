<x-app>

    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3">

        <form action="{{ route('member.update', $member) }}" method="post" class="form">
            @csrf
            @method('put')

            <div class="row g-3 mb-3">
                <div class="col-md-12">
                    
                    <div class="mb-3">
                        <label for="member_code" class="form-label required">Kode Member (NIS/NIP)</label>
                        <input class="form-control @error('member_code') is-invalid @enderror" type="text" id="member_code"
                            name="member_code" required value="{{ old('member_code', $member->member_code) }}">
                        @error('member_code')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label required">Nama</label>
                        <input class="form-control @error('name') is-invalid @enderror" type="text" id="name"
                            name="name" required value="{{ old('name', $member->name) }}">
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="type" class="form-label required">Tipe Anggota</label>
                        <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                            <option value="">Pilih Tipe</option>
                            <option value="Student" @selected(old('type', $member->type) == 'Student')>Student (Siswa)</option>
                            <option value="Teacher" @selected(old('type', $member->type) == 'Teacher')>Teacher (Guru)</option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="contact" class="form-label">Kontak (Opsional)</label>
                        <input class="form-control @error('contact') is-invalid @enderror" type="text" id="contact"
                            name="contact" value="{{ old('contact', $member->contact) }}">
                        @error('contact')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="is_active" class="form-label required">Status</label>
                        <select class="form-select @error('is_active') is-invalid @enderror" id="is_active" name="is_active" required>
                            <option value="1" @selected(old('is_active', $member->is_active) == 1)>Aktif</option>
                            <option value="0" @selected(old('is_active', $member->is_active) == 0)>Non-Aktif</option>
                        </select>
                        @error('is_active')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>
            </div>

            <div class="text-end">
                <a href="{{ route('member.index') }}" class="btn btn-warning me-1">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>

        </form>

    </div>

</x-app>
