<x-app-layout>
    <x-slot name="title">Access Logs</x-slot>

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

        /* Danger button */
        .btn-danger-custom {
            display:inline-flex; align-items:center; gap:7px;
            padding:8px 16px; background:rgba(239,68,68,0.1); color:var(--danger);
            border:1px solid rgba(239,68,68,0.2); border-radius:var(--radius-sm);
            font-size:0.82rem; font-weight:700; cursor:pointer; text-decoration:none;
            transition:background 0.2s, transform 0.1s;
        }
        .btn-danger-custom:hover { background:rgba(239,68,68,0.18); transform:translateY(-1px); }

        /* SD Card */
        .sd-card {
            background:var(--card); border-radius:var(--radius);
            border:1px solid var(--border); box-shadow:var(--shadow); overflow:hidden;
            margin-bottom:20px;
        }
        .sd-card-header {
            display:flex; align-items:center; justify-content:space-between;
            padding:18px 20px 16px; border-bottom:1px solid var(--border);
        }
        .sd-card-title { font-size:0.9rem; font-weight:700; color:var(--text-main); }
        .sd-card-body { padding:20px; }

        /* Filter form */
        .filter-grid {
            display:flex; flex-wrap:wrap; gap:12px; align-items:flex-end;
        }
        .filter-item { display:flex; flex-direction:column; gap:6px; }
        .filter-label {
            font-size:0.7rem; font-weight:700; text-transform:uppercase;
            letter-spacing:0.6px; color:var(--text-faint);
        }
        .filter-select, .filter-input {
            padding:8px 12px; border:1.5px solid var(--border);
            border-radius:var(--radius-sm); font-size:0.82rem; color:var(--text-main);
            background:#fff; outline:none; transition:border-color 0.2s, box-shadow 0.2s;
            min-width:160px;
        }
        .filter-select:focus, .filter-input:focus {
            border-color:var(--blue); box-shadow:0 0 0 3px rgba(30,111,217,0.1);
        }
        .filter-actions { display:flex; gap:8px; }
        .btn-filter {
            display:inline-flex; align-items:center; gap:6px;
            padding:8px 16px; background:var(--blue); color:#fff;
            border:none; border-radius:var(--radius-sm); font-size:0.82rem;
            font-weight:700; cursor:pointer; transition:background 0.2s;
        }
        .btn-filter:hover { background:#1558b0; }
        .btn-reset {
            display:inline-flex; align-items:center; gap:6px;
            padding:8px 16px; background:#F1F5F9; color:var(--text-muted);
            border:1px solid var(--border); border-radius:var(--radius-sm);
            font-size:0.82rem; font-weight:600; text-decoration:none;
            transition:background 0.15s;
        }
        .btn-reset:hover { background:#E2E8F0; color:var(--text-main); }

        /* Table */
        .sd-table { width:100%; border-collapse:collapse; font-size:0.83rem; }
        .sd-table thead th {
            padding:10px 16px; font-size:0.68rem; font-weight:700;
            text-transform:uppercase; letter-spacing:0.6px; color:var(--text-faint);
            background:#F8FAFC; border-bottom:1px solid var(--border); white-space:nowrap;
        }
        .sd-table tbody td {
            padding:13px 16px; color:var(--text-main);
            border-bottom:1px solid #F1F5F9; vertical-align:middle;
        }
        .sd-table tbody tr:last-child td { border-bottom:none; }
        .sd-table tbody tr:hover td { background:#F8FAFC; }

        /* Badges */
        .badge-status {
            display:inline-flex; align-items:center; gap:5px;
            padding:3px 10px; border-radius:100px;
            font-size:0.7rem; font-weight:700; white-space:nowrap;
        }
        .badge-status::before {
            content:''; width:6px; height:6px; border-radius:50%;
            background:currentColor; flex-shrink:0;
        }
        .badge-granted { background:rgba(16,185,129,0.1); color:var(--success); }
        .badge-denied  { background:rgba(239,68,68,0.1);  color:var(--danger); }
        .badge-method {
            display:inline-block; padding:2px 9px; border-radius:6px;
            font-size:0.68rem; font-weight:700;
            background:rgba(30,111,217,0.1); color:var(--blue); letter-spacing:0.3px;
        }

        /* Mono */
        .mono { font-family:'JetBrains Mono','Courier New',monospace; font-size:0.76rem; color:var(--text-muted); }

        /* Delete button */
        .btn-delete-xs {
            display:inline-flex; align-items:center; justify-content:center;
            width:30px; height:30px; border-radius:8px; border:none;
            background:rgba(239,68,68,0.1); color:var(--danger);
            font-size:0.75rem; cursor:pointer; transition:opacity 0.15s;
        }
        .btn-delete-xs:hover { opacity:0.75; }

        /* Empty state */
        .empty-state { text-align:center; padding:60px 20px; color:var(--text-faint); }
        .empty-state i { font-size:2rem; margin-bottom:12px; display:block; opacity:0.3; }
        .empty-state p { margin:0; font-size:0.85rem; }

        /* Pagination */
        .card-footer-custom { padding:14px 20px; border-top:1px solid var(--border); background:#FAFBFD; }

        /* Total badge */
        .total-chip {
            background:#F1F5F9; border-radius:100px;
            padding:3px 12px; font-size:0.75rem; font-weight:700;
            color:var(--text-muted);
        }

        @media (max-width:768px) {
            .page-header { flex-direction:column; align-items:flex-start; }
            .hide-mobile { display:none; }
            .filter-select, .filter-input { min-width:130px; }
        }
    </style>
    @endpush

    <div class="page">

        {{-- Header --}}
        <div class="page-header">
            <div>
                <h1><i class="fas fa-clipboard-list" style="color:var(--blue);margin-right:10px;font-size:1.2rem"></i>Access Logs</h1>
                <p>Riwayat seluruh akses masuk ke sistem</p>
            </div>
            @if(auth()->user()->isAdmin())
            <form action="{{ route('logs.destroyAll') }}" method="POST"
                onsubmit="return confirm('Hapus SEMUA log? Tindakan ini tidak bisa dibatalkan!')">
                @csrf @method('DELETE')
                <button type="submit" class="btn-danger-custom">
                    <i class="fas fa-trash"></i> Hapus Semua Log
                </button>
            </form>
            @endif
        </div>

        {{-- Filter Card --}}
        <div class="sd-card">
            <div class="sd-card-header">
                <span class="sd-card-title">
                    <i class="fas fa-filter" style="color:var(--blue);margin-right:8px;font-size:0.85rem"></i>
                    Filter Log
                </span>
            </div>
            <div class="sd-card-body">
                <form method="GET" action="{{ route('logs.index') }}">
                    <div class="filter-grid">

                        @if(auth()->user()->isAdmin())
                        <div class="filter-item">
                            <label class="filter-label">Device</label>
                            <select name="device_id" class="filter-select">
                                <option value="">Semua Device</option>
                                @foreach(\App\Models\Device::all() as $device)
                                    <option value="{{ $device->id }}" {{ request('device_id') == $device->id ? 'selected' : '' }}>
                                        {{ $device->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @endif

                        <div class="filter-item">
                            <label class="filter-label">Status</label>
                            <select name="status" class="filter-select">
                                <option value="">Semua Status</option>
                                <option value="granted" {{ request('status') === 'granted' ? 'selected' : '' }}>Diterima</option>
                                <option value="denied"  {{ request('status') === 'denied'  ? 'selected' : '' }}>Ditolak</option>
                            </select>
                        </div>

                        <div class="filter-item">
                            <label class="filter-label">Metode</label>
                            <select name="method" class="filter-select">
                                <option value="">Semua Metode</option>
                                <option value="rfid" {{ request('method') === 'rfid' ? 'selected' : '' }}>RFID</option>
                                <option value="pin"  {{ request('method') === 'pin'  ? 'selected' : '' }}>PIN</option>
                                <option value="face" {{ request('method') === 'face' ? 'selected' : '' }}>Face</option>
                            </select>
                        </div>

                        <div class="filter-item">
                            <label class="filter-label">&nbsp;</label>
                            <div class="filter-actions">
                                <button type="submit" class="btn-filter">
                                    <i class="fas fa-search"></i> Filter
                                </button>
                                <a href="{{ route('logs.index') }}" class="btn-reset">
                                    <i class="fas fa-times"></i> Reset
                                </a>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>

        {{-- Log Table Card --}}
        <div class="sd-card">
            <div class="sd-card-header">
                <span class="sd-card-title">
                    <i class="fas fa-history" style="color:var(--blue);margin-right:8px;font-size:0.85rem"></i>
                    Daftar Log Akses
                </span>
                <span class="total-chip">{{ $logs->total() }} entri</span>
            </div>
            <table class="sd-table">
                <thead>
                    <tr>
                        <th width="40">#</th>
                        <th>Waktu</th>
                        <th>Nama User</th>
                        <th class="hide-mobile">Device</th>
                        <th>Identifier</th>
                        <th class="hide-mobile">Metode</th>
                        <th class="hide-mobile">IP Address</th>
                        <th>Status</th>
                        @if(auth()->user()->isAdmin())
                        <th width="50">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                    <tr>
                        <td style="color:var(--text-faint);font-size:0.75rem;text-align:center">
                            {{ $logs->firstItem() + $loop->index }}
                        </td>
                        <td style="white-space:nowrap">
                            <div style="font-weight:600;font-size:0.8rem">{{ $log->created_at->format('d M Y') }}</div>
                            <div style="font-size:0.72rem;color:var(--text-faint)">{{ $log->created_at->format('H:i:s') }}</div>
                        </td>
                        <td style="font-weight:700">{{ $log->user_name }}</td>
                        <td class="hide-mobile" style="font-size:0.8rem">{{ $log->device->name ?? '—' }}</td>
                        <td class="mono">{{ $log->identifier }}</td>
                        <td class="hide-mobile">
                            <span class="badge-method">{{ strtoupper($log->method) }}</span>
                        </td>
                        <td class="hide-mobile mono">{{ $log->ip_address ?? '—' }}</td>
                        <td>
                            @if($log->status === 'granted')
                                <span class="badge-status badge-granted">Diterima</span>
                            @else
                                <span class="badge-status badge-denied">Ditolak</span>
                            @endif
                        </td>
                        @if(auth()->user()->isAdmin())
                        <td>
                            <form action="{{ route('logs.destroy', $log) }}" method="POST"
                                onsubmit="return confirm('Hapus log ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-delete-xs" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ auth()->user()->isAdmin() ? 9 : 8 }}">
                            <div class="empty-state">
                                <i class="fas fa-clipboard-list"></i>
                                <p>Tidak ada log yang ditemukan</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            @if($logs->hasPages())
            <div class="card-footer-custom">
                {{ $logs->appends(request()->query())->links() }}
            </div>
            @endif
        </div>

    </div>
</x-app-layout>