<x-app-layout>
    <x-slot name="title">Tambah Device</x-slot>

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Tambah Device</h1>
        <a href="{{ route('devices.index') }}" class="btn btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm mr-1"></i> Kembali
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Device</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('devices.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label class="font-weight-bold small">Nama Device <span class="text-danger">*</span></label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                class="form-control @error('name') is-invalid @enderror"
                                placeholder="Contoh: Raspberry Pi - Pintu Utama">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold small">Lokasi</label>
                            <input type="text" name="location" value="{{ old('location') }}"
                                class="form-control @error('location') is-invalid @enderror"
                                placeholder="Contoh: Depan, Belakang, Lantai 2">
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="alert alert-info small">
                            <i class="fas fa-info-circle mr-1"></i>
                            Token akan dibuat secara otomatis setelah device disimpan.
                        </div>

                        <hr>
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('devices.index') }}" class="btn btn-secondary mr-2">Batal</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-1"></i> Simpan Device
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>