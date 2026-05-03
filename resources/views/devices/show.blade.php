<x-app-layout>
    <x-slot name="title">Detail Device</x-slot>

    @push('styles')
    <style>
        :root {
            --navy:       #0F2044;
            --blue:       #1E6FD9;
            --success:    #10B981;
            --danger:     #EF4444;
            --warning:    #F59E0B;
            --info:       #06B6D4;
            --card:       #FFFFFF;
            --border:     #E2E8F0;
            --text-main:  #0F2044;
            --text-muted: #64748B;
            --text-faint: #94A3B8;
            --radius:     16px;
            --radius-sm:  10px;
            --shadow:     0 2px 16px rgba(15,32,68,0.08);
            --shadow-lg:  0 8px 32px rgba(15,32,68,0.14);
        }

        .page { animation: fadeUp 0.4s ease both; }

        @keyframes fadeUp {
            from { opacity:0; transform:translateY(12px); }
            to   { opacity:1; transform:translateY(0); }
        }

        /* Page Header */
        .page-header {
            display:flex; align-items:center; justify-content:space-between;
            margin-bottom:28px; flex-wrap:wrap; gap:12px;
        }
        .page-header h1 {
            font-size:1.5rem; font-weight:800; color:var(--text-main);
            margin:0 0 2px; letter-spacing:-0.3px;
        }
        .page-header p { font-size:0.82rem; color:var(--text-muted); margin:0; }

        .btn-back {
            display:inline-flex; align-items:center; gap:7px;
            padding:8px 16px; background:#F1F5F9; color:var(--text-muted);
            border:1px solid var(--border); border-radius:var(--radius-sm);
            font-size:0.82rem; font-weight:600; text-decoration:none;
            transition:background 0.15s;
        }
        .btn-back:hover { background:#E2E8F0; color:var(--text-main); }

        /* Layout */
        .detail-grid {
            display:grid; grid-template-columns:320px 1fr; gap:20px; align-items:start;
        }

        /* SD Card */
        .sd-card {
            background:var(--card); border-radius:var(--radius);
            border:1px solid var(--border); box-shadow:var(--shadow); overflow:hidden;
        }
        .sd-card-header {
            display:flex; align-items:center; justify-content:space-between;
            padding:18px 20px 16px; border-bottom:1px solid var(--border);
        }
        .sd-card-title { font-size:0.9rem; font-weight:700; color:var(--text-main); }
        .sd-card-body { padding:20px; }

        /* Device Info Card */
        .device-avatar {
            width:72px; height:72px; border-radius:18px;
            background:linear-gradient(135deg, var(--blue), #3B82F6);
            display:flex; align-items:center; justify-content:center;
            margin:0 auto 16px; box-shadow:0 4px 16px rgba(30,111,217,0.25);
        }
        .device-avatar i { font-size:1.6rem; color:#fff; }
        .device-name-big { font-size:1.1rem; font-weight:800; color:var(--text-main); text-align:center; margin-bottom:4px; }
        .device-location { font-size:0.78rem; color:var(--text-faint); text-align:center; margin-bottom:16px; }

        /* Badge status */
        .badge-status {
            display:inline-flex; align-items:center; gap:5px;
            padding:3px 10px; border-radius:100px;
            font-size:0.7rem; font-weight:700; white-space:nowrap;
        }
        .badge-status::before {
            content:''; width:6px; height:6px; border-radius:50%;
            background:currentColor; flex-shrink:0;
        }
        .badge-active  { background:rgba(16,185,129,0.1); color:var(--success); }
        .badge-offline { background:rgba(239,68,68,0.1);  color:var(--danger); }
        .badge-granted { background:rgba(16,185,129,0.1); color:var(--success); }
        .badge-denied  { background:rgba(239,68,68,0.1);  color:var(--danger); }
        .badge-method {
            display:inline-block; padding:2px 9px; border-radius:6px;
            font-size:0.68rem; font-weight:700;
            background:rgba(30,111,217,0.1); color:var(--blue); letter-spacing:0.3px;
        }

        /* Info rows */
        .info-divider { border:none; border-top:1px solid var(--border); margin:16px 0; }
        .info-row { margin-bottom:12px; }
        .info-row-label {
            font-size:0.65rem; font-weight:700; text-transform:uppercase;
            letter-spacing:0.8px; color:var(--text-faint); margin-bottom:4px;
        }
        .info-row-value { font-size:0.83rem; color:var(--text-main); font-weight:600; }
        .mono { font-family:'JetBrains Mono','Courier New',monospace; font-size:0.75rem; color:var(--text-muted); word-break:break-all; }

        /* Action buttons sidebar */
        .action-list { display:flex; flex-direction:column; gap:8px; }
        .btn-action {
            display:flex; align-items:center; gap:10px;
            padding:10px 14px; border-radius:var(--radius-sm);
            font-size:0.82rem; font-weight:600; text-decoration:none;
            border:none; cursor:pointer; width:100%;
            transition:opacity 0.15s, transform 0.1s;
        }
        .btn-action:hover { opacity:0.85; transform:translateY(-1px); }
        .btn-action i { width:16px; text-align:center; }
        .btn-action-warning { background:rgba(245,158,11,0.1); color:var(--warning); }
        .btn-action-info    { background:rgba(6,182,212,0.1);   color:var(--info); }
        .btn-action-danger  { background:rgba(239,68,68,0.1);   color:var(--danger); }

        /* Operational Hours Card */
        .btn-add-small {
            display:inline-flex; align-items:center; gap:6px;
            padding:6px 14px; background:var(--blue); color:#fff;
            border:none; border-radius:8px; font-size:0.75rem;
            font-weight:700; cursor:pointer; text-decoration:none;
            transition:background 0.2s;
        }
        .btn-add-small:hover { background:#1558b0; color:#fff; }

        /* Table */
        .sd-table { width:100%; border-collapse:collapse; font-size:0.83rem; }
        .sd-table thead th {
            padding:10px 16px; font-size:0.68rem; font-weight:700;
            text-transform:uppercase; letter-spacing:0.6px; color:var(--text-faint);
            background:#F8FAFC; border-bottom:1px solid var(--border); white-space:nowrap;
        }
        .sd-table tbody td {
            padding:12px 16px; color:var(--text-main);
            border-bottom:1px solid #F1F5F9; vertical-align:middle;
        }
        .sd-table tbody tr:last-child td { border-bottom:none; }
        .sd-table tbody tr:hover td { background:#F8FAFC; }

        /* XS buttons in table */
        .btn-xs {
            display:inline-flex; align-items:center; gap:5px;
            padding:4px 10px; border-radius:6px; font-size:0.72rem;
            font-weight:600; border:none; cursor:pointer;
            transition:opacity 0.15s;
        }
        .btn-xs:hover { opacity:0.8; }
        .btn-xs-warn   { background:rgba(245,158,11,0.12); color:var(--warning); }
        .btn-xs-succ   { background:rgba(16,185,129,0.12); color:var(--success); }
        .btn-xs-danger { background:rgba(239,68,68,0.1);   color:var(--danger); }

        /* Log table */
        .mb-card { margin-bottom:20px; }

        /* Empty state */
        .empty-state { text-align:center; padding:48px 20px; color:var(--text-faint); }
        .empty-state i { font-size:1.8rem; margin-bottom:10px; display:block; opacity:0.3; }
        .empty-state p { margin:0; font-size:0.82rem; }

        /* Section divider */
        .section-divider {
            display:flex; align-items:center; gap:10px; margin:0 0 16px;
            font-size:0.72rem; font-weight:700; text-transform:uppercase;
            letter-spacing:1px; color:var(--text-faint);
        }
        .section-divider::after { content:''; flex:1; height:1px; background:var(--border); }

        /* Pagination footer */
        .card-footer-custom { padding:14px 20px; border-top:1px solid var(--border); background:#FAFBFD; }

        /* Modal */
        .modal-content { border:none; border-radius:var(--radius); box-shadow:var(--shadow-lg); overflow:hidden; }
        .modal-header { background:#F8FAFC; border-bottom:1px solid var(--border); padding:16px 20px; }
        .modal-title { font-size:0.95rem; font-weight:700; color:var(--text-main); }
        .modal-body { padding:24px; }
        .modal-footer { padding:14px 20px; border-top:1px solid var(--border); background:#F8FAFC; }
        .field-label {
            display:block; font-size:0.78rem; font-weight:700;
            color:var(--text-main); margin-bottom:8px;
        }
        .field-input {
            width:100%; padding:10px 14px; border:1.5px solid var(--border);
            border-radius:var(--radius-sm); font-size:0.85rem; color:var(--text-main);
            background:#fff; outline:none; transition:border-color 0.2s, box-shadow 0.2s;
            box-sizing:border-box;
        }
        .field-input:focus { border-color:var(--blue); box-shadow:0 0 0 3px rgba(30,111,217,0.1); }

        @media (max-width:960px) {
            .detail-grid { grid-template-columns:1fr; }
        }
        @media (max-width:576px) {
            .page-header { flex-direction:column; align-items:flex-start; }
        }
    </style>
    @endpush

    <div class="page">

        {{-- Header --}}
        <div class="page-header">
            <div>
                <h1><i class="fas fa-microchip" style="color:var(--info);margin-right:10px;font-size:1.2rem"></i>Detail Device</h1>
                <p>Informasi lengkap dan log akses perangkat</p>
            </div>
            <a href="{{ route('devices.index') }}" class="btn-back">
                <i class="fas fa-arrow-left fa-sm"></i> Kembali
            </a>
        </div>

        <div class="detail-grid">

            {{-- ── Left: Info Card ── --}}
            <div>
                <div class="sd-card">
                    <div class="sd-card-header">
                        <span class="sd-card-title">
                            <i class="fas fa-info-circle" style="color:var(--blue);margin-right:8px;font-size:0.85rem"></i>
                            Informasi Device
                        </span>
                        @if($device->is_active)
                            <span class="badge-status badge-active">Aktif</span>
                        @else
                            <span class="badge-status badge-offline">Nonaktif</span>
                        @endif
                    </div>
                    <div class="sd-card-body">
                        <div style="text-align:center;margin-bottom:20px">
                            <div class="device-avatar">
                                <i class="fas fa-microchip"></i>
                            </div>
                            <div class="device-name-big">{{ $device->name }}</div>
                            <div class="device-location">
                                <i class="fas fa-map-marker-alt" style="font-size:0.7rem"></i>
                                {{ $device->location ?? 'Lokasi tidak diatur' }}
                            </div>
                        </div>

                        <hr class="info-divider">

                        <div class="info-row">
                            <div class="info-row-label">Token</div>
                            <div class="mono">{{ $device->token }}</div>
                        </div>

                        <div class="info-row">
                            <div class="info-row-label">Terdaftar</div>
                            <div class="info-row-value">{{ $device->created_at->format('d M Y H:i') }}</div>
                        </div>

                        @if(auth()->user()->isAdmin())
                        <hr class="info-divider">
                        <div class="action-list">
                            <a href="{{ route('devices.edit', $device) }}" class="btn-action btn-action-warning">
                                <i class="fas fa-edit"></i> Edit Device
                            </a>
                            <form action="{{ route('devices.regenerate-token', $device) }}" method="POST"
                                onsubmit="return confirm('Regenerate token? Token lama tidak bisa digunakan lagi.')">
                                @csrf
                                <button type="submit" class="btn-action btn-action-info" style="width:100%">
                                    <i class="fas fa-sync-alt"></i> Regenerate Token
                                </button>
                            </form>
                            <form action="{{ route('devices.destroy', $device) }}" method="POST"
                                onsubmit="return confirm('Hapus device ini beserta semua log aksesnya?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-action btn-action-danger" style="width:100%">
                                    <i class="fas fa-trash"></i> Hapus Device
                                </button>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- ── Right: Hours + Logs ── --}}
            <div>

                {{-- Jam Operasional --}}
                @if(auth()->user()->isAdmin())
                <div class="sd-card mb-card">
                    <div class="sd-card-header">
                        <span class="sd-card-title">
                            <i class="fas fa-clock" style="color:var(--warning);margin-right:8px;font-size:0.85rem"></i>
                            Jam Operasional
                        </span>
                        <button class="btn-add-small" data-toggle="modal" data-target="#modalTambahJam">
                            <i class="fas fa-plus"></i> Tambah
                        </button>
                    </div>
                    <table class="sd-table">
                        <thead>
                            <tr>
                                <th>Hari</th>
                                <th>Mulai</th>
                                <th>Selesai</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($device->operationalHours()->orderBy('day_of_week')->get() as $hour)
                            <tr>
                                <td style="font-weight:700">{{ $hour->day_label }}</td>
                                <td>{{ substr($hour->start_time, 0, 5) }}</td>
                                <td>{{ substr($hour->end_time, 0, 5) }}</td>
                                <td>
                                    @if($hour->is_active)
                                        <span class="badge-status badge-active">Aktif</span>
                                    @else
                                        <span class="badge-status badge-offline">Nonaktif</span>
                                    @endif
                                </td>
                                <td>
                                    <div style="display:flex;gap:6px">
                                        <form action="{{ route('devices.operational-hours.update', [$device, $hour]) }}"
                                            method="POST" class="d-inline">
                                            @csrf @method('PUT')
                                            <input type="hidden" name="is_active" value="{{ $hour->is_active ? 0 : 1 }}">
                                            <button type="submit" class="btn-xs {{ $hour->is_active ? 'btn-xs-warn' : 'btn-xs-succ' }}">
                                                {{ $hour->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                            </button>
                                        </form>
                                        <form action="{{ route('devices.operational-hours.destroy', [$device, $hour]) }}"
                                            method="POST" class="d-inline"
                                            onsubmit="return confirm('Hapus jadwal ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn-xs btn-xs-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5">
                                    <div class="empty-state">
                                        <i class="fas fa-clock"></i>
                                        <p>Belum ada jadwal — akses bebas 24 jam</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @endif

                {{-- Log Akses --}}
                <div class="sd-card">
                    <div class="sd-card-header">
                        <span class="sd-card-title">
                            <i class="fas fa-history" style="color:var(--blue);margin-right:8px;font-size:0.85rem"></i>
                            Log Akses Device Ini
                        </span>
                        <span style="font-size:0.78rem;color:var(--text-faint)">{{ $logs->total() }} entri</span>
                    </div>
                    <table class="sd-table">
                        <thead>
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
                                <td style="white-space:nowrap">
                                    <div style="font-weight:600;font-size:0.8rem">{{ $log->created_at->format('d M Y') }}</div>
                                    <div style="font-size:0.72rem;color:var(--text-faint)">{{ $log->created_at->format('H:i:s') }}</div>
                                </td>
                                <td class="mono">{{ $log->identifier }}</td>
                                <td><span class="badge-method">{{ strtoupper($log->method) }}</span></td>
                                <td class="mono">{{ $log->ip_address ?? '—' }}</td>
                                <td>
                                    @if($log->status === 'granted')
                                        <span class="badge-status badge-granted">Diterima</span>
                                    @else
                                        <span class="badge-status badge-denied">Ditolak</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5">
                                    <div class="empty-state">
                                        <i class="fas fa-history"></i>
                                        <p>Belum ada log akses</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    @if($logs->hasPages())
                    <div class="card-footer-custom">{{ $logs->links() }}</div>
                    @endif
                </div>

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
                        <i class="fas fa-clock" style="color:var(--warning);margin-right:8px"></i>
                        Tambah Jam Operasional
                    </h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <form action="{{ route('devices.operational-hours.store', $device) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div style="margin-bottom:16px">
                            <label class="field-label">Hari</label>
                            <select name="day_of_week" class="field-input" required>
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
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:16px">
                            <div>
                                <label class="field-label">Jam Mulai</label>
                                <input type="time" name="start_time" class="field-input" required>
                            </div>
                            <div>
                                <label class="field-label">Jam Selesai</label>
                                <input type="time" name="end_time" class="field-input" required>
                            </div>
                        </div>
                        <div style="display:flex;gap:10px;align-items:flex-start;background:rgba(6,182,212,0.07);border:1px solid rgba(6,182,212,0.2);border-radius:10px;padding:12px 14px">
                            <i class="fas fa-info-circle" style="color:var(--info);margin-top:2px;flex-shrink:0"></i>
                            <p style="margin:0;font-size:0.78rem;color:var(--text-muted)">
                                Jika tidak ada jadwal → akses bebas 24 jam. Jadwal yang nonaktif tidak berpengaruh.
                            </p>
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