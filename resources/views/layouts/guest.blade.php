<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Smart Door — {{ $title ?? 'Login' }}</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        /* ── Variables ── */
        :root {
            --navy:         #0A1628;
            --navy-mid:     #112240;
            --navy-card:    #0D1B35;
            --blue:         #2563EB;
            --blue-mid:     #1D4ED8;
            --blue-light:   #60A5FA;
            --blue-soft:    rgba(37,99,235,0.10);
            --blue-glow:    rgba(37,99,235,0.18);
            --accent:       #38BDF8;
            --success:      #10B981;
            --danger:       #F87171;
            --warning:      #FBBF24;
            --bg:           #F1F5FB;
            --border:       #E2E8F0;
            --border-focus: #2563EB;
            --text-main:    #0F1C35;
            --text-mid:     #374151;
            --text-muted:   #6B7280;
            --text-faint:   #9CA3AF;
            --white:        #FFFFFF;
            --radius:       20px;
            --radius-md:    14px;
            --radius-sm:    10px;
            --shadow:       0 4px 6px -1px rgba(0,0,0,0.07), 0 2px 4px -1px rgba(0,0,0,0.04);
            --shadow-lg:    0 20px 60px rgba(10,22,40,0.18), 0 4px 16px rgba(10,22,40,0.08);
            --shadow-xl:    0 32px 80px rgba(10,22,40,0.24);
            --transition:   0.2s cubic-bezier(0.4,0,0.2,1);
        }

        /* ── Reset & Base ── */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif !important;
            background: var(--bg) !important;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 28px 20px;
            position: relative;
            overflow-x: hidden;
        }

        /* Background decorations */
        body::before {
            content: '';
            position: fixed;
            top: -120px; left: -80px;
            width: 500px; height: 500px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(37,99,235,0.07) 0%, transparent 70%);
            pointer-events: none;
        }

        body::after {
            content: '';
            position: fixed;
            bottom: -150px; right: -100px;
            width: 600px; height: 600px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(56,189,248,0.06) 0%, transparent 70%);
            pointer-events: none;
        }

        /* ── Page Wrapper ── */
        .auth-page {
            width: 100%;
            max-width: 1020px;
            animation: slideUp 0.55s cubic-bezier(0.4,0,0.2,1) both;
            position: relative;
            z-index: 1;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(24px) scale(0.985); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        /* ── Card ── */
        .auth-card {
            border-radius: var(--radius) !important;
            overflow: hidden;
            box-shadow: var(--shadow-xl) !important;
            border: none !important;
            display: flex;
            min-height: 560px;
        }

        /* ── Left Panel ── */
        .auth-panel-left {
            background: linear-gradient(145deg, var(--navy) 0%, var(--navy-mid) 60%, #0E2045 100%);
            padding: 48px 40px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
            min-width: 0;
        }

        /* Decorative shapes */
        .auth-panel-left::before {
            content: '';
            position: absolute;
            top: -80px; right: -80px;
            width: 340px; height: 340px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(37,99,235,0.14) 0%, transparent 70%);
            pointer-events: none;
        }

        .auth-panel-left::after {
            content: '';
            position: absolute;
            bottom: -100px; left: -60px;
            width: 280px; height: 280px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(56,189,248,0.08) 0%, transparent 70%);
            pointer-events: none;
        }

        /* Grid overlay */
        .auth-panel-left .panel-grid {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,0.022) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.022) 1px, transparent 1px);
            background-size: 40px 40px;
            pointer-events: none;
        }

        /* Brand */
        .auth-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            position: relative;
            z-index: 1;
        }

        .auth-brand-icon {
            width: 42px; height: 42px;
            background: linear-gradient(135deg, var(--blue), var(--blue-mid));
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem; color: #fff;
            box-shadow: 0 4px 16px rgba(37,99,235,0.5), 0 0 0 1px rgba(255,255,255,0.1);
            flex-shrink: 0;
        }

        .auth-brand-name {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 1.05rem;
            font-weight: 800;
            color: #fff;
            letter-spacing: -0.3px;
        }

        .auth-brand-name span { color: var(--accent); }

        /* Left body */
        .auth-left-body {
            position: relative;
            z-index: 1;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 20px 0;
        }

        .auth-left-body h2 {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 1.65rem;
            font-weight: 800;
            color: #fff;
            line-height: 1.25;
            margin-bottom: 12px;
            letter-spacing: -0.5px;
        }

        .auth-left-body p {
            font-size: 0.86rem;
            color: rgba(255,255,255,0.48);
            line-height: 1.7;
        }

        /* Left footer */
        .auth-left-footer {
            position: relative;
            z-index: 1;
        }

        /* ── Right Panel ── */
        .auth-panel-right {
            background: var(--white);
            padding: 48px 44px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
        }

        /* Subtle top accent line */
        .auth-panel-right::before {
            content: '';
            position: absolute;
            top: 0; left: 44px; right: 44px;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--blue), transparent);
            opacity: 0;
        }

        /* ── Typography ── */
        .auth-heading {
            font-family: 'Plus Jakarta Sans', sans-serif !important;
            font-size: 1.5rem !important;
            font-weight: 800 !important;
            color: var(--text-main) !important;
            letter-spacing: -0.4px;
            margin-bottom: 4px !important;
            line-height: 1.2 !important;
        }

        .auth-sub {
            font-size: 0.84rem;
            color: var(--text-muted);
            margin-bottom: 28px;
            line-height: 1.65;
        }

        /* ── Form Elements ── */
        .auth-group { margin-bottom: 18px; }

        .auth-label {
            display: block;
            font-size: 0.72rem !important;
            font-weight: 600 !important;
            color: var(--text-mid) !important;
            text-transform: uppercase;
            letter-spacing: 0.7px;
            margin-bottom: 7px;
        }

        .auth-input {
            width: 100%;
            padding: 11px 14px !important;
            border: 1.5px solid var(--border) !important;
            border-radius: var(--radius-sm) !important;
            font-size: 0.875rem !important;
            font-family: 'Inter', sans-serif !important;
            color: var(--text-main) !important;
            background: #FAFBFD !important;
            outline: none !important;
            box-shadow: 0 1px 2px rgba(0,0,0,0.04) !important;
            transition: border-color var(--transition), box-shadow var(--transition), background var(--transition) !important;
            height: auto !important;
        }

        .auth-input::placeholder { color: var(--text-faint) !important; }

        .auth-input:focus {
            border-color: var(--blue) !important;
            box-shadow: 0 0 0 3px var(--blue-glow), 0 1px 2px rgba(0,0,0,0.04) !important;
            background: #fff !important;
        }

        .auth-input:hover:not(:focus) {
            border-color: #CBD5E1 !important;
        }

        .auth-input.is-invalid {
            border-color: #F87171 !important;
            background: #FFF8F8 !important;
        }

        .auth-input.is-invalid:focus {
            box-shadow: 0 0 0 3px rgba(248,113,113,0.15) !important;
        }

        .invalid-feedback {
            font-size: 0.75rem !important;
            color: #EF4444 !important;
            margin-top: 5px !important;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* ── Checkbox Row ── */
        .auth-row-between {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 22px;
        }

        .auth-check {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            font-size: 0.83rem;
            color: var(--text-muted);
            user-select: none;
        }

        .auth-check input[type="checkbox"] {
            width: 16px; height: 16px;
            accent-color: var(--blue);
            cursor: pointer;
            flex-shrink: 0;
            border-radius: 4px;
        }

        /* ── Button ── */
        .auth-btn {
            width: 100%;
            padding: 12px 20px !important;
            background: linear-gradient(135deg, var(--blue) 0%, var(--blue-mid) 100%) !important;
            color: #fff !important;
            border: none !important;
            border-radius: var(--radius-sm) !important;
            font-family: 'Plus Jakarta Sans', sans-serif !important;
            font-size: 0.9rem !important;
            font-weight: 700 !important;
            letter-spacing: 0.1px;
            cursor: pointer !important;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 4px 14px rgba(37,99,235,0.38) !important;
            transition: all var(--transition) !important;
            position: relative;
            overflow: hidden;
        }

        .auth-btn::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.1), transparent);
            pointer-events: none;
        }

        .auth-btn:hover {
            transform: translateY(-1px) !important;
            box-shadow: 0 8px 22px rgba(37,99,235,0.45) !important;
        }

        .auth-btn:active {
            transform: translateY(0) !important;
            box-shadow: 0 3px 10px rgba(37,99,235,0.35) !important;
        }

        .auth-btn-outline {
            width: 100%;
            padding: 11px 20px !important;
            background: transparent !important;
            color: var(--text-mid) !important;
            border: 1.5px solid var(--border) !important;
            border-radius: var(--radius-sm) !important;
            font-family: 'Plus Jakarta Sans', sans-serif !important;
            font-size: 0.88rem !important;
            font-weight: 600 !important;
            cursor: pointer !important;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all var(--transition) !important;
        }

        .auth-btn-outline:hover {
            background: var(--bg) !important;
            border-color: #CBD5E1 !important;
            color: var(--text-main) !important;
        }

        /* ── Links & Divider ── */
        .auth-link {
            color: var(--blue) !important;
            font-weight: 600 !important;
            text-decoration: none !important;
            font-size: 0.83rem;
            transition: color var(--transition) !important;
        }

        .auth-link:hover {
            color: var(--blue-mid) !important;
            text-decoration: underline !important;
        }

        .auth-divider {
            text-align: center;
            font-size: 0.78rem;
            color: var(--text-faint);
            margin: 18px 0;
            position: relative;
        }

        .auth-divider::before,
        .auth-divider::after {
            content: '';
            position: absolute;
            top: 50%;
            width: calc(50% - 24px);
            height: 1px;
            background: var(--border);
        }

        .auth-divider::before { left: 0; }
        .auth-divider::after  { right: 0; }

        .auth-footer {
            text-align: center;
            font-size: 0.83rem;
            color: var(--text-muted);
        }

        /* ── Alert Styles ── */
        .auth-alert-info {
            background: rgba(37,99,235,0.07);
            border: 1px solid rgba(37,99,235,0.18);
            border-radius: var(--radius-sm);
            padding: 11px 15px;
            font-size: 0.81rem;
            color: #1D4ED8;
            margin-bottom: 18px;
            line-height: 1.55;
        }

        .auth-alert-success {
            background: rgba(16,185,129,0.07);
            border: 1px solid rgba(16,185,129,0.22);
            border-radius: var(--radius-sm);
            padding: 11px 15px;
            font-size: 0.81rem;
            color: #059669;
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 9px;
            line-height: 1.55;
        }

        /* ── Icon Badge ── */
        .auth-icon-badge {
            width: 52px; height: 52px;
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.3rem;
            margin-bottom: 20px;
        }

        .auth-icon-badge.blue  { background: rgba(37,99,235,0.08);  color: var(--blue); box-shadow: 0 0 0 6px rgba(37,99,235,0.05); }
        .auth-icon-badge.green { background: rgba(16,185,129,0.08); color: #10B981; box-shadow: 0 0 0 6px rgba(16,185,129,0.05); }
        .auth-icon-badge.amber { background: rgba(251,191,36,0.1);  color: #D97706; box-shadow: 0 0 0 6px rgba(251,191,36,0.06); }

        /* ── Two-col row ── */
        .auth-row-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        /* ── Left Panel Components ── */

        /* Feature list */
        .left-feature-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .left-feature-item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.81rem;
            color: rgba(255,255,255,0.55);
            font-family: 'Inter', sans-serif;
        }

        .left-feature-dot {
            width: 7px; height: 7px;
            border-radius: 50%;
            background: var(--accent);
            flex-shrink: 0;
            box-shadow: 0 0 6px rgba(56,189,248,0.5);
        }

        /* Step list */
        .left-step-list {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .left-step-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .left-step-num {
            width: 24px; height: 24px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--blue), var(--blue-mid));
            color: #fff;
            font-size: 0.7rem;
            font-weight: 700;
            font-family: 'Plus Jakarta Sans', sans-serif;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            margin-top: 1px;
            box-shadow: 0 2px 8px rgba(37,99,235,0.4);
        }

        .left-step-text {
            font-family: 'Inter', sans-serif;
            font-size: 0.8rem;
            color: rgba(255,255,255,0.55);
            line-height: 1.5;
        }

        .left-step-text strong {
            color: rgba(255,255,255,0.85);
            display: block;
            margin-bottom: 2px;
            font-size: 0.82rem;
            font-weight: 600;
        }

        /* Info box */
        .left-info-box {
            background: rgba(37,99,235,0.12);
            border: 1px solid rgba(37,99,235,0.22);
            border-radius: var(--radius-sm);
            padding: 14px 16px;
            font-size: 0.8rem;
            font-family: 'Inter', sans-serif;
            color: rgba(255,255,255,0.55);
            line-height: 1.6;
        }

        /* Warn box */
        .left-warn-box {
            background: rgba(251,191,36,0.1);
            border: 1px solid rgba(251,191,36,0.22);
            border-radius: var(--radius-sm);
            padding: 14px 16px;
            display: flex;
            align-items: flex-start;
            gap: 11px;
        }

        .left-warn-box i { color: #FBBF24; margin-top: 2px; flex-shrink: 0; }

        .left-warn-box p {
            font-family: 'Inter', sans-serif;
            font-size: 0.8rem;
            color: rgba(255,255,255,0.55);
            line-height: 1.6;
        }

        /* Tip list */
        .left-tip-list {
            display: flex;
            flex-direction: column;
            gap: 9px;
        }

        .left-tip-item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-family: 'Inter', sans-serif;
            font-size: 0.8rem;
            color: rgba(255,255,255,0.55);
        }

        .left-tip-item i { color: var(--success); font-size: 0.7rem; flex-shrink: 0; }

        /* Verify step list */
        .left-vstep-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .left-vstep-item {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .left-vstep-icon {
            width: 32px; height: 32px;
            border-radius: 50%;
            background: rgba(37,99,235,0.15);
            border: 1px solid rgba(37,99,235,0.28);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            font-size: 0.75rem;
            color: var(--accent);
        }

        .left-vstep-text {
            font-family: 'Inter', sans-serif;
            font-size: 0.8rem;
            color: rgba(255,255,255,0.55);
        }

        /* ── Verify Circle ── */
        .verify-circle-wrap {
            text-align: center;
            margin-bottom: 24px;
        }

        .verify-circle {
            width: 80px; height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(37,99,235,0.08), rgba(56,189,248,0.06));
            border: 2px solid rgba(37,99,235,0.15);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: var(--blue);
            position: relative;
        }

        .verify-circle::after {
            content: '';
            position: absolute;
            inset: -10px;
            border-radius: 50%;
            border: 1.5px dashed rgba(37,99,235,0.2);
            animation: spin 16s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* ── Responsive ── */
        @media (max-width: 991px) {
            .auth-panel-left { display: none !important; }
            .auth-panel-right { padding: 44px 36px; }
        }

        @media (max-width: 600px) {
            body { padding: 16px; }
            .auth-panel-right { padding: 36px 24px; }
            .auth-row-2 { grid-template-columns: 1fr; }
            .auth-heading { font-size: 1.3rem !important; }
        }
    </style>

    @stack('styles')
</head>

<body>
<div class="auth-page">
    <div class="card auth-card">
        <div class="row no-gutters" style="flex:1">

            {{-- ── Left Panel ── --}}
            <div class="col-lg-5 auth-panel-left">
                <div class="panel-grid"></div>

                <div class="auth-brand">
                    <div class="auth-brand-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <div class="auth-brand-name">Access<span>Guard</span></div>
                </div>

                {{-- Dynamic left content slot --}}
                @isset($leftPanel)
                    {{ $leftPanel }}
                @else
                    <div class="auth-left-body">
                        <h2>Sistem Manajemen Akses</h2>
                        <p>Pantau dan kelola perangkat akses pintu Anda secara real-time dengan teknologi IoT terkini.</p>
                    </div>
                    <div class="auth-left-footer">
                        <div class="left-feature-list">
                            <div class="left-feature-item"><div class="left-feature-dot"></div>Monitoring akses real-time</div>
                            <div class="left-feature-item"><div class="left-feature-dot"></div>Manajemen perangkat terpusat</div>
                            <div class="left-feature-item"><div class="left-feature-dot"></div>Log & laporan lengkap</div>
                        </div>
                    </div>
                @endisset
            </div>

            {{-- ── Right Panel ── --}}
            <div class="col-lg-7 auth-panel-right">
                {{ $slot }}
            </div>

        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>