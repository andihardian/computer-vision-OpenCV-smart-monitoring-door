<x-app-layout>
    <x-slot name="title">Detail Device</x-slot>

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Detail Device</h1>
        <a href="{{ route('devices.index') }}" class="btn btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm mr-1"></i> Kembali
        </a>
    </div>

    <div class="row">

        <!-- Info Card -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Device</h6>
                    @if($device->is_active)
                        <span class="badge badge-success">Aktif</span>
                    @else
                        <span class="badge badge-danger">Nonaktif</span>
                    @endif
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div class="mx-auto rounded-circle bg-primary d-flex align-items-center justify-content-center mb-3"
                            style="width:64px;height:64px">
                            <i class="fas fa-microchip fa-2x text-white"></i>
                        </div>
                        <h5 class="font-weight-bold text-gray-800">{{ $device->name }}</h5>
                        <p class="text-muted small mb-0">{{ $device->location ?? 'Lokasi tidak diatur' }}</p>
                    </div>

                    <hr>

                    <div class="mb-3">
                        <small class="text-muted font-weight-bold d-block text-uppercase mb-1">Token</small>
                        <code class="small">{{ $device->token }}</code>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted font-weight-bold d-block text-uppercase mb-1">Terdaftar</small>
                        <span class="small">{{ $device->created_at->format('d M Y H:i') }}</span>
                    </div>

                    @if(auth()->user()->isAdmin())
                    <hr>
                    <div class="d-flex flex-column gap-2">
                        <a href="{{ route('devices.edit', $device) }}" class="btn btn-warning btn-block">
                            <i class="fas fa-edit mr-1"></i> Edit Device
                        </a>
                        <form action="{{ route('devices.regenerate-token', $device) }}" method="POST"
                            onsubmit="return confirm('Regenerate token? Token lama tidak bisa digunakan lagi.')">
                            @csrf
                            <button type="submit" class="btn btn-info btn-block">
                                <i class="fas fa-sync-alt mr-1"></i> Regenerate Token
                            </button>
                        </form>
                        <form action="{{ route('devices.destroy', $device) }}" method="POST"
                            onsubmit="return confirm('Hapus device ini beserta semua log aksesnya?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-block">
                                <i class="fas fa-trash mr-1"></i> Hapus Device
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Log Table -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Log Akses Device Ini</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>Waktu</th>
                                    <th>Identifier</th>
                                    <th>Metode</th>
                                    <th>IP</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($logs as $log)
                                <tr>
                                    <td class="text-muted small">{{ $log->created_at->format('d M Y H:i:s') }}</td>
                                    <td class="mono">{{ $log->identifier }}</td>
                                    <td><span class="badge badge-secondary text-uppercase">{{ $log->method }}</span></td>
                                    <td class="mono small">{{ $log->ip_address ?? '—' }}</td>
                                    <td>
                                        @if($log->status === 'granted')
                                            <span class="badge badge-granted">Diterima</span>
                                        @else
                                            <span class="badge badge-denied">Ditolak</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">Belum ada log akses</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($logs->hasPages())
                <div class="card-footer">{{ $logs->links() }}</div>
                @endif
            </div>
        </div>

    </div>
</x-app-layout>