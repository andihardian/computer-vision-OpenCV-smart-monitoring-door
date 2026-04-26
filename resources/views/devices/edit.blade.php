<x-app-layout>
    <x-slot name="title">Edit Device</x-slot>

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Edit Device</h1>
        <a href="{{ route('devices.index') }}" class="btn btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm mr-1"></i> Kembali
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Edit Informasi Device</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('devices.update', $device) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label class="font-weight-bold small">Nama Device <span class="text-danger">*</span></label>
                            <input type="text" name="name" value="{{ old('name', $device->name) }}"
                                class="form-control @error('name') is-invalid @enderror">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold small">Lokasi</label>
                            <input type="text" name="location" value="{{ old('location', $device->location) }}"
                                class="form-control @error('location') is-invalid @enderror">
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold small">Token (read-only)</label>
                            <input type="text" value="{{ $device->token }}" class="form-control mono bg-light" readonly>
                            <small class="text-muted">Gunakan tombol Regenerate Token di halaman detail untuk memperbarui token.</small>
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="is_active"
                                    name="is_active" value="1" {{ $device->is_active ? 'checked' : '' }}>
                                <label class="custom-control-label font-weight-bold small" for="is_active">
                                    Device Aktif
                                </label>
                            </div>
                        </div>

                        <hr>
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('devices.index') }}" class="btn btn-secondary mr-2">Batal</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-1"></i> Update Device
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>