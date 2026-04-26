<x-app-layout>
    <x-slot name="title">Manajemen Device</x-slot>

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Manajemen Device</h1>
        @if(auth()->user()->isAdmin())
            <a href="{{ route('devices.create') }}" class="btn btn-primary shadow-sm">
                <i class="fas fa-plus fa-sm mr-1"></i> Tambah Device
            </a>
        @endif
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Perangkat</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%">
                    <thead class="thead-light">
                        <tr>
                            <th width="40">#</th>
                            <th>Nama Device</th>
                            <th>Lokasi</th>
                            <th>Token</th>
                            <th>Total Akses</th>
                            <th>Status</th>
                            <th width="130">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($devices as $i => $device)
                        <tr>
                            <td class="text-center text-muted">{{ $i + 1 }}</td>
                            <td class="font-weight-bold">{{ $device->name }}</td>
                            <td>{{ $device->location ?? '—' }}</td>
                            <td class="mono">{{ $device->token }}</td>
                            <td class="text-center">{{ $device->access_logs_count }}</td>
                            <td class="text-center">
                                @if($device->is_active)
                                    <span class="badge badge-success px-3">Aktif</span>
                                @else
                                    <span class="badge badge-danger px-3">Nonaktif</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('devices.show', $device) }}" class="btn btn-sm btn-info" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if(auth()->user()->isAdmin())
                                <a href="{{ route('devices.edit', $device) }}" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('devices.destroy', $device) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Hapus device ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger" title="Hapus"><i class="fas fa-trash"></i></button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="fas fa-microchip fa-2x mb-2 d-block text-gray-300"></i>
                                Belum ada device terdaftar
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>