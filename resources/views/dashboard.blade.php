<x-app-layout>
    <x-slot name="title">Dashboard</x-slot>

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Dashboard</h1>
        <span class="text-muted small">
            <i class="fas fa-calendar mr-1"></i>{{ now()->translatedFormat('l, d F Y') }}
        </span>
    </div>

    <!-- Stat Cards -->
    <div class="row">

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Akses</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($total) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Akses Diterima</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($granted) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Akses Ditolak</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($denied) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Device Aktif</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $activeDevices }} / {{ $totalDevices }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-microchip fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(auth()->user()->isAdmin())
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total User</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalUsers }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

    </div>

    <div class="row">

        <!-- Devices Table -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Perangkat Terdaftar</h6>
                    <a href="{{ route('devices.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-sm mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>Nama</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($devices as $device)
                                <tr>
                                    <td>
                                        <a href="{{ route('devices.show', $device) }}" class="text-dark font-weight-bold">
                                            {{ $device->name }}
                                        </a>
                                        <br>
                                        <small class="text-muted">{{ $device->location ?? '-' }}</small>
                                    </td>
                                    <td>
                                        @if($device->is_active)
                                            <span class="badge badge-success">Aktif</span>
                                        @else
                                            <span class="badge badge-danger">Nonaktif</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="2" class="text-center text-muted py-3">Belum ada device</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Access Log Table -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Log Akses Terbaru</h6>
                    <a href="{{ route('logs.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>Waktu</th>
                                    <th>Device</th>
                                    <th>Identifier</th>
                                    <th>Metode</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($logs as $log)
                                <tr>
                                    <td class="text-muted small">{{ $log->created_at->format('d M H:i:s') }}</td>
                                    <td>{{ $log->device->name ?? '-' }}</td>
                                    <td class="mono">{{ $log->identifier }}</td>
                                    <td><span class="badge badge-secondary text-uppercase">{{ $log->method }}</span></td>
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
                                    <td colspan="5" class="text-center text-muted py-3">Belum ada log akses</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($logs->hasPages())
                <div class="card-footer py-2">
                    {{ $logs->links() }}
                </div>
                @endif
            </div>
        </div>

    </div>
</x-app-layout>