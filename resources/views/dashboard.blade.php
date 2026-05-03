<x-app-layout>
    <x-slot name="title">Dashboard</x-slot>

    @push('styles')
    <style>
        /* ── Variables ── */
        :root {
            --navy:        #0F2044;
            --navy-mid:    #1B3A6B;
            --blue:        #1E6FD9;
            --blue-light:  #3B82F6;
            --blue-glow:   rgba(30,111,217,0.15);
            --success:     #10B981;
            --danger:      #EF4444;
            --warning:     #F59E0B;
            --info:        #06B6D4;
            --white:       #FFFFFF;
            --bg:          #F0F4FA;
            --card:        #FFFFFF;
            --border:      #E2E8F0;
            --text-main:   #0F2044;
            --text-muted:  #64748B;
            --text-faint:  #94A3B8;
            --radius:      16px;
            --radius-sm:   10px;
            --shadow:      0 2px 16px rgba(15,32,68,0.08);
            --shadow-lg:   0 8px 32px rgba(15,32,68,0.14);
        }

        /* ── Page ── */
        .dash-page { animation: fadeUp 0.4s ease both; }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(12px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── Page Header ── */
        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 28px;
            flex-wrap: wrap;
            gap: 12px;
        }

        .page-header-left h1 {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--text-main);
            margin: 0 0 2px;
            letter-spacing: -0.3px;
        }

        .page-header-left p {
            font-size: 0.82rem;
            color: var(--text-muted);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .page-header-right {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .date-chip {
            display: flex;
            align-items: center;
            gap: 8px;
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 100px;
            padding: 6px 14px;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text-muted);
            box-shadow: var(--shadow);
        }

        .date-chip i { color: var(--blue); }

        /* ── Stat Cards ── */
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 16px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: var(--card);
            border-radius: var(--radius);
            padding: 20px;
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            display: flex;
            align-items: flex-start;
            gap: 14px;
            position: relative;
            overflow: hidden;
            transition: transform 0.2s, box-shadow 0.2s;
            animation: fadeUp 0.4s ease both;
        }

        .stat-card:nth-child(1) { animation-delay: 0.05s; }
        .stat-card:nth-child(2) { animation-delay: 0.10s; }
        .stat-card:nth-child(3) { animation-delay: 0.15s; }
        .stat-card:nth-child(4) { animation-delay: 0.20s; }
        .stat-card:nth-child(5) { animation-delay: 0.25s; }

        .stat-card::after {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            border-radius: var(--radius) var(--radius) 0 0;
            background: var(--accent-color, var(--blue));
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-lg);
        }

        .stat-card.blue   { --accent-color: var(--blue); }
        .stat-card.green  { --accent-color: var(--success); }
        .stat-card.red    { --accent-color: var(--danger); }
        .stat-card.teal   { --accent-color: var(--info); }
        .stat-card.amber  { --accent-color: var(--warning); }

        .stat-icon {
            width: 46px;
            height: 46px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        .stat-info { flex: 1; min-width: 0; }

        .stat-label {
            font-size: 0.68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: var(--text-faint);
            margin-bottom: 6px;
        }

        .stat-value {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--text-main);
            line-height: 1;
            letter-spacing: -0.5px;
        }

        .stat-value small {
            font-size: 1rem;
            font-weight: 500;
            color: var(--text-faint);
        }

        .stat-sub {
            font-size: 0.72rem;
            color: var(--text-muted);
            margin-top: 6px;
        }

        /* ── Chart Grid ── */
        .chart-grid {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 16px;
            margin-bottom: 24px;
        }

        /* ── SD Card (shared card component) ── */
        .sd-card {
            background: var(--card);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            overflow: hidden;
            animation: fadeUp 0.4s ease 0.3s both;
        }

        .sd-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 20px 16px;
            border-bottom: 1px solid var(--border);
        }

        .sd-card-title {
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--text-main);
        }

        .sd-card-body { padding: 20px; }

        /* ── Chart Container ── */
        .chart-container {
            position: relative;
            height: 240px;
        }

        .chart-legend {
            display: flex;
            gap: 18px;
            font-size: 0.75rem;
        }

        .legend-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            flex-shrink: 0;
            margin-top: 3px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 6px;
            font-weight: 600;
        }

        /* ── Telegram Setting ── */
        .tg-card {
            background: var(--card);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            padding: 20px 24px;
            margin-bottom: 24px;
            animation: fadeUp 0.4s ease 0.35s both;
        }

        .tg-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
            flex-wrap: wrap;
            gap: 12px;
        }

        .tg-title {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--text-main);
        }

        .tg-icon {
            width: 32px;
            height: 32px;
            background: rgba(34,158,217,0.12);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #229ED9;
            font-size: 0.95rem;
        }

        .status-pill {
            font-size: 0.7rem;
            font-weight: 700;
            padding: 4px 12px;
            border-radius: 100px;
            letter-spacing: 0.3px;
        }

        .status-pill.all-active { background: rgba(16,185,129,0.1); color: var(--success); }
        .status-pill.partial    { background: rgba(245,158,11,0.1);  color: var(--warning); }
        .status-pill.inactive   { background: rgba(239,68,68,0.1);   color: var(--danger); }

        .tg-body {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
        }

        .toggle-group { display: flex; align-items: center; gap: 28px; flex-wrap: wrap; }

        .toggle-item  { display: flex; align-items: center; gap: 10px; }

        .toggle-switch {
            position: relative;
            width: 44px;
            height: 24px;
            flex-shrink: 0;
        }

        .toggle-switch input { opacity: 0; width: 0; height: 0; position: absolute; }

        .toggle-slider {
            position: absolute;
            inset: 0;
            background: var(--border);
            border-radius: 100px;
            cursor: pointer;
            transition: 0.3s;
        }

        .toggle-slider::before {
            content: '';
            position: absolute;
            width: 18px;
            height: 18px;
            left: 3px;
            top: 3px;
            background: white;
            border-radius: 50%;
            transition: 0.3s;
            box-shadow: 0 1px 4px rgba(0,0,0,0.2);
        }

        .toggle-switch input:checked + .toggle-slider { background: var(--blue); }
        .toggle-switch input:checked + .toggle-slider::before { transform: translateX(20px); }

        .toggle-label {
            font-size: 0.83rem;
            font-weight: 600;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .btn-save {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 9px 20px;
            background: var(--blue);
            color: white;
            border: none;
            border-radius: var(--radius-sm);
            font-size: 0.82rem;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.2s, transform 0.1s;
        }

        .btn-save:hover { background: #1558b0; transform: translateY(-1px); }
        .btn-save:active { transform: translateY(0); }

        /* ── Bottom Grid ── */
        .bottom-grid {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 16px;
            animation: fadeUp 0.4s ease 0.4s both;
        }

        /* ── Tables ── */
        .sd-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.83rem;
        }

        .sd-table thead th {
            padding: 10px 16px;
            font-size: 0.68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: var(--text-faint);
            background: #F8FAFC;
            border-bottom: 1px solid var(--border);
            white-space: nowrap;
        }

        .sd-table tbody td {
            padding: 12px 16px;
            color: var(--text-main);
            border-bottom: 1px solid #F1F5F9;
            vertical-align: middle;
        }

        .sd-table tbody tr:last-child td { border-bottom: none; }

        .sd-table tbody tr:hover td { background: #F8FAFC; }

        /* ── Badges ── */
        .badge-status {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 3px 10px;
            border-radius: 100px;
            font-size: 0.7rem;
            font-weight: 700;
            white-space: nowrap;
        }

        .badge-status::before {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
            flex-shrink: 0;
        }

        .badge-granted { background: rgba(16,185,129,0.1); color: var(--success); }
        .badge-denied  { background: rgba(239,68,68,0.1);  color: var(--danger); }
        .badge-active  { background: rgba(16,185,129,0.1); color: var(--success); }
        .badge-offline { background: rgba(239,68,68,0.1);  color: var(--danger); }

        .badge-method {
            display: inline-block;
            padding: 2px 9px;
            border-radius: 6px;
            font-size: 0.68rem;
            font-weight: 700;
            background: rgba(30,111,217,0.1);
            color: var(--blue);
            letter-spacing: 0.3px;
        }

        .mono {
            font-family: 'JetBrains Mono', 'Courier New', monospace;
            font-size: 0.78rem;
            color: var(--text-muted);
        }

        .link-more {
            font-size: 0.78rem;
            color: var(--blue);
            text-decoration: none;
            font-weight: 700;
            transition: opacity 0.15s;
        }

        .link-more:hover { opacity: 0.75; }

        /* ── Divider Section ── */
        .section-divider {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 0 0 16px;
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-faint);
        }

        .section-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        /* ── Responsive ── */
        @media (max-width: 1200px) {
            .stat-grid { grid-template-columns: repeat(3, 1fr); }
            .chart-grid { grid-template-columns: 1fr; }
        }

        @media (max-width: 900px) {
            .stat-grid { grid-template-columns: repeat(2, 1fr); }
            .bottom-grid { grid-template-columns: 1fr; }
        }

        @media (max-width: 560px) {
            .stat-grid { grid-template-columns: 1fr 1fr; }
            .page-header { flex-direction: column; align-items: flex-start; }
        }

        @media (max-width: 380px) {
            .stat-grid { grid-template-columns: 1fr; }
        }
    </style>
    @endpush

    <div class="dash-page">

        {{-- ── Page Header ── --}}
        <div class="page-header">
            <div class="page-header-left">
                <h1>Dashboard</h1>
                <p>
                    <i class="fas fa-circle" style="font-size:0.45rem;color:var(--success)"></i>
                    Sistem berjalan normal
                </p>
            </div>
            <div class="page-header-right">
                <div class="date-chip">
                    <i class="fas fa-calendar-alt"></i>
                    {{ now()->translatedFormat('l, d F Y') }}
                </div>
            </div>
        </div>

        {{-- ── Stat Cards ── --}}
        <div class="stat-grid">

            {{-- Total Akses --}}
            <div class="stat-card blue">
                <div class="stat-icon" style="background:rgba(30,111,217,0.1);color:var(--blue)">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-label">Total Akses</div>
                    <div class="stat-value">{{ number_format($total) }}</div>
                    <div class="stat-sub">Semua waktu</div>
                </div>
            </div>

            {{-- Diterima --}}
            <div class="stat-card green">
                <div class="stat-icon" style="background:rgba(16,185,129,0.1);color:var(--success)">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-label">Diterima</div>
                    <div class="stat-value">{{ number_format($granted) }}</div>
                    <div class="stat-sub">
                        {{ $total > 0 ? number_format($granted / $total * 100, 1) : 0 }}% dari total
                    </div>
                </div>
            </div>

            {{-- Ditolak --}}
            <div class="stat-card red">
                <div class="stat-icon" style="background:rgba(239,68,68,0.1);color:var(--danger)">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-label">Ditolak</div>
                    <div class="stat-value">{{ number_format($denied) }}</div>
                    <div class="stat-sub">
                        {{ $total > 0 ? number_format($denied / $total * 100, 1) : 0 }}% dari total
                    </div>
                </div>
            </div>

            {{-- Device Aktif --}}
            <div class="stat-card teal">
                <div class="stat-icon" style="background:rgba(6,182,212,0.1);color:var(--info)">
                    <i class="fas fa-microchip"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-label">Device Aktif</div>
                    <div class="stat-value">
                        {{ $activeDevices }}<small>/{{ $totalDevices }}</small>
                    </div>
                    <div class="stat-sub">Terhubung</div>
                </div>
            </div>

            {{-- Total User (Admin only) --}}
            @if(auth()->user()->isAdmin())
            <div class="stat-card amber">
                <div class="stat-icon" style="background:rgba(245,158,11,0.1);color:var(--warning)">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-label">Total User</div>
                    <div class="stat-value">{{ number_format($totalUsers) }}</div>
                    <div class="stat-sub">Terdaftar</div>
                </div>
            </div>
            @endif

        </div>

        {{-- ── Charts ── --}}
        <div class="section-divider">Statistik Visual</div>

        <div class="chart-grid">

            {{-- Line Chart --}}
            <div class="sd-card">
                <div class="sd-card-header">
                    <span class="sd-card-title">
                        <i class="fas fa-chart-line" style="color:var(--blue);margin-right:8px;font-size:0.85rem"></i>
                        Akses 7 Hari Terakhir
                    </span>
                    <div class="chart-legend">
                        <div class="legend-item">
                            <div class="legend-dot" style="background:var(--success)"></div>
                            <span style="color:var(--success)">Diterima</span>
                        </div>
                        <div class="legend-item">
                            <div class="legend-dot" style="background:var(--danger)"></div>
                            <span style="color:var(--danger)">Ditolak</span>
                        </div>
                    </div>
                </div>
                <div class="sd-card-body">
                    <div class="chart-container">
                        <canvas id="lineChart"></canvas>
                    </div>
                </div>
            </div>

            {{-- Donut Chart --}}
            <div class="sd-card">
                <div class="sd-card-header">
                    <span class="sd-card-title">
                        <i class="fas fa-chart-pie" style="color:var(--blue);margin-right:8px;font-size:0.85rem"></i>
                        Metode Akses
                    </span>
                </div>
                <div class="sd-card-body">
                    <div class="chart-container" style="height:220px">
                        <canvas id="donutChart"></canvas>
                    </div>
                </div>
            </div>

        </div>

        {{-- ── Telegram Setting (Admin) ── --}}
        @if(auth()->user()->isAdmin())
        <div class="tg-card">
            <div class="tg-header">
                <div class="tg-title">
                    <div class="tg-icon">
                        <i class="fab fa-telegram"></i>
                    </div>
                    Notifikasi Telegram
                </div>
                @php
                    $tgStatus = $notifGranted && $notifDenied ? 'all-active'
                        : ($notifGranted || $notifDenied ? 'partial' : 'inactive');
                    $tgLabel  = $notifGranted && $notifDenied ? '● Semua Aktif'
                        : ($notifGranted || $notifDenied ? '● Sebagian Aktif' : '● Nonaktif');
                @endphp
                <span class="status-pill {{ $tgStatus }}">{{ $tgLabel }}</span>
            </div>
            <form action="{{ route('settings.notifications') }}" method="POST">
                @csrf
                <div class="tg-body">
                    <div class="toggle-group">
                        <div class="toggle-item">
                            <label class="toggle-switch">
                                <input type="checkbox" name="telegram_notif_granted"
                                    {{ $notifGranted ? 'checked' : '' }}
                                    onchange="this.form.submit()">
                                <span class="toggle-slider"></span>
                            </label>
                            <span class="toggle-label">
                                <i class="fas fa-check-circle" style="color:var(--success)"></i>
                                Akses Diterima
                            </span>
                        </div>
                        <div class="toggle-item">
                            <label class="toggle-switch">
                                <input type="checkbox" name="telegram_notif_denied"
                                    {{ $notifDenied ? 'checked' : '' }}
                                    onchange="this.form.submit()">
                                <span class="toggle-slider"></span>
                            </label>
                            <span class="toggle-label">
                                <i class="fas fa-times-circle" style="color:var(--danger)"></i>
                                Akses Ditolak
                            </span>
                        </div>
                    </div>
                    <button type="submit" class="btn-save">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
        @endif

        {{-- ── Bottom: Devices + Logs ── --}}
        <div class="section-divider">Data Terbaru</div>

        <div class="bottom-grid">

            {{-- Devices --}}
            <div class="sd-card">
                <div class="sd-card-header">
                    <span class="sd-card-title">
                        <i class="fas fa-microchip" style="color:var(--info);margin-right:8px;font-size:0.85rem"></i>
                        Perangkat Terdaftar
                    </span>
                    <a href="{{ route('devices.index') }}" class="link-more">Lihat Semua →</a>
                </div>
                <table class="sd-table">
                    <thead>
                        <tr>
                            <th>Nama Perangkat</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($devices as $device)
                        <tr>
                            <td>
                                <a href="{{ route('devices.show', $device) }}"
                                   style="font-weight:700;color:var(--text-main);text-decoration:none">
                                    {{ $device->name }}
                                </a>
                                @if($device->location)
                                <div style="font-size:0.72rem;color:var(--text-faint);margin-top:2px">
                                    <i class="fas fa-map-marker-alt" style="font-size:0.65rem"></i>
                                    {{ $device->location }}
                                </div>
                                @endif
                            </td>
                            <td>
                                @if($device->is_active)
                                    <span class="badge-status badge-active">Aktif</span>
                                @else
                                    <span class="badge-status badge-offline">Nonaktif</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" style="text-align:center;color:var(--text-faint);padding:36px 16px">
                                <i class="fas fa-microchip" style="font-size:1.5rem;margin-bottom:8px;display:block;opacity:0.3"></i>
                                Belum ada perangkat terdaftar
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Recent Logs --}}
            <div class="sd-card">
                <div class="sd-card-header">
                    <span class="sd-card-title">
                        <i class="fas fa-history" style="color:var(--blue);margin-right:8px;font-size:0.85rem"></i>
                        Log Akses Terbaru
                    </span>
                    <a href="{{ route('logs.index') }}" class="link-more">Lihat Semua →</a>
                </div>
                <table class="sd-table">
                    <thead>
                        <tr>
                            <th>Waktu</th>
                            <th>Identifier</th>
                            <th>Metode</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                        <tr>
                            <td style="white-space:nowrap">
                                <div style="font-weight:600;color:var(--text-main);font-size:0.8rem">
                                    {{ $log->created_at->format('d M') }}
                                </div>
                                <div style="font-size:0.72rem;color:var(--text-faint)">
                                    {{ $log->created_at->format('H:i') }}
                                </div>
                            </td>
                            <td class="mono">{{ $log->identifier }}</td>
                            <td>
                                <span class="badge-method">{{ strtoupper($log->method) }}</span>
                            </td>
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
                            <td colspan="4" style="text-align:center;color:var(--text-faint);padding:36px 16px">
                                <i class="fas fa-history" style="font-size:1.5rem;margin-bottom:8px;display:block;opacity:0.3"></i>
                                Belum ada log akses
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

    </div>{{-- end .dash-page --}}

    @push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
    <script>
        const chartData  = @json($chartData  ?? []);
        const methodData = @json($methodData ?? []);

        // ── Defaults Chart.js ──
        Chart.defaults.font.family = "'Nunito', sans-serif";
        Chart.defaults.color       = '#94A3B8';

        // ── Line Chart ──
        new Chart(document.getElementById('lineChart').getContext('2d'), {
            type: 'line',
            data: {
                labels: chartData.labels ?? [],
                datasets: [
                    {
                        label: 'Diterima',
                        data: chartData.granted ?? [],
                        borderColor: '#10B981',
                        backgroundColor: 'rgba(16,185,129,0.08)',
                        borderWidth: 2.5,
                        tension: 0.45,
                        fill: true,
                        pointBackgroundColor: '#10B981',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7,
                    },
                    {
                        label: 'Ditolak',
                        data: chartData.denied ?? [],
                        borderColor: '#EF4444',
                        backgroundColor: 'rgba(239,68,68,0.05)',
                        borderWidth: 2.5,
                        tension: 0.45,
                        fill: true,
                        pointBackgroundColor: '#EF4444',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: { mode: 'index', intersect: false },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#0F2044',
                        titleColor: '#94A3B8',
                        bodyColor: '#F8FAFC',
                        padding: 12,
                        cornerRadius: 10,
                        boxPadding: 4,
                    }
                },
                scales: {
                    x: {
                        grid: { color: 'rgba(0,0,0,0.04)', drawBorder: false },
                        ticks: { font: { size: 11, weight: '600' }, color: '#94A3B8' },
                        border: { display: false }
                    },
                    y: {
                        grid: { color: 'rgba(0,0,0,0.04)', drawBorder: false },
                        ticks: { font: { size: 11 }, color: '#94A3B8', stepSize: 1, precision: 0 },
                        border: { display: false },
                        beginAtZero: true
                    }
                }
            }
        });

        // ── Donut Chart ──
        new Chart(document.getElementById('donutChart').getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: ['Face', 'RFID', 'PIN'],
                datasets: [{
                    data: [
                        methodData.face ?? 0,
                        methodData.rfid ?? 0,
                        methodData.pin  ?? 0,
                    ],
                    backgroundColor: ['#1E6FD9', '#10B981', '#F59E0B'],
                    borderWidth: 0,
                    hoverOffset: 6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '72%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 18,
                            font: { size: 11, weight: '700' },
                            color: '#475569',
                            usePointStyle: true,
                            pointStyleWidth: 8,
                        }
                    },
                    tooltip: {
                        backgroundColor: '#0F2044',
                        titleColor: '#94A3B8',
                        bodyColor: '#F8FAFC',
                        padding: 12,
                        cornerRadius: 10,
                        callbacks: {
                            label: function(ctx) {
                                const total = ctx.dataset.data.reduce((a, b) => a + b, 0);
                                const pct   = total > 0 ? ((ctx.parsed / total) * 100).toFixed(1) : 0;
                                return ` ${ctx.label}: ${ctx.parsed} (${pct}%)`;
                            }
                        }
                    }
                }
            }
        });
    </script>
    @endpush

</x-app-layout>