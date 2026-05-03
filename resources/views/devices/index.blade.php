<x-app-layout>
    <x-slot name="title">Manajemen Device</x-slot>

    @push('styles')
    <style>
        :root {
            --navy:       #0F2044;
            --navy-mid:   #1B3A6B;
            --blue:       #1E6FD9;
            --blue-light: #3B82F6;
            --blue-glow:  rgba(30,111,217,0.15);
            --success:    #10B981;
            --danger:     #EF4444;
            --warning:    #F59E0B;
            --info:       #06B6D4;
            --white:      #FFFFFF;
            --bg:         #F0F4FA;
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

        /* Button */
        .btn-primary-custom {
            display:inline-flex; align-items:center; gap:7px;
            padding:9px 18px; background:var(--blue); color:#fff;
            border:none; border-radius:var(--radius-sm); font-size:0.82rem;
            font-weight:700; cursor:pointer; text-decoration:none;
            transition:background 0.2s, transform 0.1s;
        }
        .btn-primary-custom:hover { background:#1558b0; transform:translateY(-1px); color:#fff; }

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
        .sd-card-subtitle { font-size:0.78rem; color:var(--text-muted); }

        /* Table */
        .sd-table { width:100%; border-collapse:collapse; font-size:0.83rem; }
        .sd-table thead th {
            padding:10px 16px; font-size:0.68rem; font-weight:700;
            text-transform:uppercase; letter-spacing:0.6px; color:var(--text-faint);
            background:#F8FAFC; border-bottom:1px solid var(--border); white-space:nowrap;
        }
        .sd-table tbody td {
            padding:14px 16px; color:var(--text-main);
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
        .badge-active  { background:rgba(16,185,129,0.1); color:var(--success); }
        .badge-offline { background:rgba(239,68,68,0.1);  color:var(--danger); }

        /* Mono */
        .mono { font-family:'JetBrains Mono','Courier New',monospace; font-size:0.78rem; color:var(--text-muted); }

        /* Device Name */
        .device-name { font-weight:700; color:var(--text-main); }
        .device-loc  { font-size:0.72rem; color:var(--text-faint); margin-top:2px; }

        /* Token chip */
        .token-chip {
            display:inline-block; background:#F1F5F9; border-radius:6px;
            padding:3px 10px; font-family:'JetBrains Mono','Courier New',monospace;
            font-size:0.73rem; color:var(--text-muted); max-width:200px;
            overflow:hidden; text-overflow:ellipsis; white-space:nowrap;
        }

        /* Action buttons */
        .action-btn {
            display:inline-flex; align-items:center; justify-content:center;
            width:32px; height:32px; border-radius:8px; border:none;
            font-size:0.8rem; cursor:pointer; text-decoration:none;
            transition:opacity 0.15s, transform 0.1s;
        }
        .action-btn:hover { opacity:0.8; transform:translateY(-1px); }
        .btn-view   { background:rgba(6,182,212,0.12);  color:var(--info); }
        .btn-edit   { background:rgba(245,158,11,0.12); color:var(--warning); }
        .btn-delete { background:rgba(239,68,68,0.1);   color:var(--danger); }

        /* Empty state */
        .empty-state { text-align:center; padding:60px 20px; color:var(--text-faint); }
        .empty-state i { font-size:2rem; margin-bottom:12px; display:block; opacity:0.3; }
        .empty-state p { margin:0; font-size:0.85rem; }

        /* Section divider */
        .section-divider {
            display:flex; align-items:center; gap:10px; margin:0 0 16px;
            font-size:0.72rem; font-weight:700; text-transform:uppercase;
            letter-spacing:1px; color:var(--text-faint);
        }
        .section-divider::after { content:''; flex:1; height:1px; background:var(--border); }

        /* Pagination */
        .card-footer-custom {
            padding:14px 20px; border-top:1px solid var(--border); background:#FAFBFD;
        }

        @media (max-width:768px) {
            .page-header { flex-direction:column; align-items:flex-start; }
            .hide-mobile { display:none; }
        }
    </style>
    @endpush

    <div class="page">

        {{-- Header --}}
        <div class="page-header">
            <div>
                <h1><i class="fas fa-microchip" style="color:var(--info);margin-right:10px;font-size:1.2rem"></i>Manajemen Device</h1>
                <p>Kelola semua perangkat yang terdaftar dalam sistem</p>
            </div>
            @if(auth()->user()->isAdmin())
            <a href="{{ route('devices.create') }}" class="btn-primary-custom">
                <i class="fas fa-plus"></i> Tambah Device
            </a>
            @endif
        </div>

        {{-- Table Card --}}
        <div class="sd-card">
            <div class="sd-card-header">
                <span class="sd-card-title">
                    <i class="fas fa-list" style="color:var(--blue);margin-right:8px;font-size:0.85rem"></i>
                    Daftar Perangkat
                </span>
                <span class="sd-card-subtitle">{{ $devices->count() }} perangkat terdaftar</span>
            </div>
            <table class="sd-table">
                <thead>
                    <tr>
                        <th width="40">#</th>
                        <th>Nama Device</th>
                        <th class="hide-mobile">Token</th>
                        <th class="hide-mobile">Total Akses</th>
                        <th>Status</th>
                        <th width="110">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($devices as $i => $device)
                    <tr>
                        <td style="color:var(--text-faint);font-size:0.78rem;text-align:center">{{ $i + 1 }}</td>
                        <td>
                            <div class="device-name">{{ $device->name }}</div>
                            @if($device->location)
                            <div class="device-loc">
                                <i class="fas fa-map-marker-alt" style="font-size:0.65rem"></i>
                                {{ $device->location }}
                            </div>
                            @endif
                        </td>
                        <td class="hide-mobile">
                            <span class="token-chip" title="{{ $device->token }}">{{ $device->token }}</span>
                        </td>
                        <td class="hide-mobile" style="text-align:center;font-weight:700;color:var(--text-main)">
                            {{ $device->access_logs_count }}
                        </td>
                        <td>
                            @if($device->is_active)
                                <span class="badge-status badge-active">Aktif</span>
                            @else
                                <span class="badge-status badge-offline">Nonaktif</span>
                            @endif
                        </td>
                        <td>
                            <div style="display:flex;gap:6px;align-items:center">
                                <a href="{{ route('devices.show', $device) }}" class="action-btn btn-view" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if(auth()->user()->isAdmin())
                                <a href="{{ route('devices.edit', $device) }}" class="action-btn btn-edit" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('devices.destroy', $device) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Hapus device ini?')">
                                    @csrf @method('DELETE')
                                    <button class="action-btn btn-delete" title="Hapus" type="submit">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <i class="fas fa-microchip"></i>
                                <p>Belum ada device terdaftar</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</x-app-layout>