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

        <!-- Kanan: Log + Jam Operasional -->
        <div class="col-lg-8">

            {{-- Jam Operasional --}}
            @if(auth()->user()->isAdmin())
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-clock mr-1"></i> Jam Operasional
                    </h6>
                    <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalTambahJam">
                        <i class="fas fa-plus mr-1"></i> Tambah
                    </button>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>Hari</th>
                                    <th>Jam Mulai</th>
                                    <th>Jam Selesai</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($device->operationalHours()->orderBy('day_of_week')->get() as $hour)
                                <tr>
                                    <td class="font-weight-bold">{{ $hour->day_label }}</td>
                                    <td>{{ substr($hour->start_time, 0, 5) }}</td>
                                    <td>{{ substr($hour->end_time, 0, 5) }}</td>
                                    <td>
                                        @if($hour->is_active)
                                            <span class="badge badge-success">Aktif</span>
                                        @else
                                            <span class="badge badge-secondary">Nonaktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{-- Toggle Status --}}
                                        <form action="{{ route('devices.operational-hours.update', [$device, $hour]) }}"
                                            method="POST" class="d-inline">
                                            @csrf @method('PUT')
                                            <input type="hidden" name="is_active" value="{{ $hour->is_active ? 0 : 1 }}">
                                            <button type="submit" class="btn btn-xs {{ $hour->is_active ? 'btn-warning' : 'btn-success' }}">
                                                {{ $hour->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                            </button>
                                        </form>
                                        {{-- Hapus --}}
                                        <form action="{{ route('devices.operational-hours.destroy', [$device, $hour]) }}"
                                            method="POST" class="d-inline"
                                            onsubmit="return confirm('Hapus jadwal ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-xs btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-3">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        Belum ada jadwal — akses bebas 24 jam
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            <!-- Log Table -->
            <div class="card shadow mb-4">
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

    {{-- Modal Tambah Jam Operasional --}}
    @if(auth()->user()->isAdmin())
    <div class="modal fade" id="modalTambahJam" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-clock mr-1"></i> Tambah Jam Operasional
                    </h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <form action="{{ route('devices.operational-hours.store', $device) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="font-weight-bold small">Hari</label>
                            <select name="day_of_week" class="form-control" required>
                                <option value="">-- Pilih Hari --</option>
                                <option value="monday">Senin</option>
                                <option value="tuesday">Selasa</option>
                                <option value="wednesday">Rabu</option>
                                <option value="thursday">Kamis</option>
                                <option value="friday">Jumat</option>
                                <option value="saturday">Sabtu</option>
                                <option value="sunday">Minggu</option>
                            </select>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="font-weight-bold small">Jam Mulai</label>
                                <input type="time" name="start_time" class="form-control" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="font-weight-bold small">Jam Selesai</label>
                                <input type="time" name="end_time" class="form-control" required>
                            </div>
                        </div>
                        <div class="alert alert-info small mb-0">
                            <i class="fas fa-info-circle mr-1"></i>
                            Jika tidak ada jadwal → akses bebas 24 jam. Jadwal yang nonaktif tidak berpengaruh.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

</x-app-layout>