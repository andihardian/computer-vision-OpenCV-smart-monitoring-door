<x-app-layout>
    <x-slot name="title">Access Logs</x-slot>

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Access Logs</h1>
        @if(auth()->user()->isAdmin())
        <form action="{{ route('logs.destroyAll') }}" method="POST"
            onsubmit="return confirm('Hapus SEMUA log? Tindakan ini tidak bisa dibatalkan!')">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm shadow-sm">
                <i class="fas fa-trash mr-1"></i> Hapus Semua Log
            </button>
        </form>
        @endif
    </div>

    <!-- Filter Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filter Log</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('logs.index') }}" class="form-inline flex-wrap gap-2">
                @if(auth()->user()->isAdmin())
                <div class="form-group mr-3 mb-2">
                    <label class="mr-2 small font-weight-bold">Device</label>
                    <select name="device_id" class="form-control form-control-sm">
                        <option value="">Semua Device</option>
                        @foreach(\App\Models\Device::all() as $device)
                            <option value="{{ $device->id }}" {{ request('device_id') == $device->id ? 'selected' : '' }}>
                                {{ $device->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @endif
                <div class="form-group mr-3 mb-2">
                    <label class="mr-2 small font-weight-bold">Status</label>
                    <select name="status" class="form-control form-control-sm">
                        <option value="">Semua Status</option>
                        <option value="granted" {{ request('status') === 'granted' ? 'selected' : '' }}>Diterima</option>
                        <option value="denied" {{ request('status') === 'denied' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>
                <div class="form-group mr-3 mb-2">
                    <label class="mr-2 small font-weight-bold">Metode</label>
                    <select name="method" class="form-control form-control-sm">
                        <option value="">Semua Metode</option>
                        <option value="rfid" {{ request('method') === 'rfid' ? 'selected' : '' }}>RFID</option>
                        <option value="pin" {{ request('method') === 'pin' ? 'selected' : '' }}>PIN</option>
                        <option value="face" {{ request('method') === 'face' ? 'selected' : '' }}>Face</option>
                    </select>
                </div>
                <div class="mb-2">
                    <button type="submit" class="btn btn-primary btn-sm mr-1">
                        <i class="fas fa-filter mr-1"></i> Filter
                    </button>
                    <a href="{{ route('logs.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-times mr-1"></i> Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Log Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Log Akses</h6>
            <span class="text-muted small">Total: {{ $logs->total() }} log</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Waktu</th>
                            <th>Nama User</th>
                            <th>Device</th>
                            <th>Identifier</th>
                            <th>Metode</th>
                            <th>IP Address</th>
                            <th>Status</th>
                            @if(auth()->user()->isAdmin())
                            <th>Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                        <tr>
                            <td class="text-muted small">{{ $logs->firstItem() + $loop->index }}</td>
                            <td class="text-muted small">{{ $log->created_at->format('d M Y H:i:s') }}</td>
                            <td class="font-weight-bold">{{ $log->user_name }}</td>
                            <td>{{ $log->device->name ?? '—' }}</td>
                            <td class="mono">{{ $log->identifier }}</td>
                            <td><span class="badge badge-secondary text-uppercase">{{ $log->method }}</span></td>
                            <td class="mono small">{{ $log->ip_address ?? '—' }}</td>
                            <td>
                                @if($log->status === 'granted')
                                    <span class="badge badge-granted"><i class="fas fa-check mr-1"></i>Diterima</span>
                                @else
                                    <span class="badge badge-denied"><i class="fas fa-times mr-1"></i>Ditolak</span>
                                @endif
                            </td>
                            @if(auth()->user()->isAdmin())
                            <td>
                                <form action="{{ route('logs.destroy', $log) }}" method="POST"
                                    onsubmit="return confirm('Hapus log ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-xs btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                            @endif
                        </tr>
                        @empty
                        <tr>
                            <td colspan="{{ auth()->user()->isAdmin() ? 9 : 8 }}" class="text-center text-muted py-5">
                                <i class="fas fa-clipboard-list fa-2x mb-2 d-block text-gray-300"></i>
                                Tidak ada log yang ditemukan
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($logs->hasPages())
        <div class="card-footer">
            {{ $logs->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</x-app-layout>