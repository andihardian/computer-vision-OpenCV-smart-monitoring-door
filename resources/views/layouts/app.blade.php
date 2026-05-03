<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Smart Door — {{ $title ?? 'Dashboard' }}</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        /* ══════════════════════════════════════════
           RESET & BASE
        ══════════════════════════════════════════ */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            /* Brand */
            --navy:         #0D1F3C;
            --navy-hover:   #162d56;
            --navy-active:  #1B3A6B;
            --blue:         #1E6FD9;
            --blue-soft:    rgba(30,111,217,0.12);

            /* Neutral */
            --sidebar-w:    240px;
            --sidebar-w-sm: 68px;
            --topbar-h:     60px;
            --bg:           #F0F4FA;
            --white:        #FFFFFF;
            --border:       #E2E8F0;
            --shadow:       0 2px 12px rgba(13,31,60,0.08);
            --shadow-lg:    0 8px 32px rgba(13,31,60,0.14);

            /* Text */
            --text-main:    #0D1F3C;
            --text-muted:   #64748B;
            --text-faint:   #94A3B8;

            /* Status */
            --success:      #10B981;
            --danger:       #EF4444;
            --warning:      #F59E0B;

            /* Misc */
            --radius:       12px;
            --radius-sm:    8px;
            --transition:   0.22s ease;
        }

        html, body {
            height: 100%;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg);
            color: var(--text-main);
            font-size: 14px;
            -webkit-font-smoothing: antialiased;
        }

        a { text-decoration: none; color: inherit; }
        button { font-family: inherit; }

        /* ══════════════════════════════════════════
           LAYOUT SHELL
        ══════════════════════════════════════════ */
        .app-shell {
            display: flex;
            min-height: 100vh;
        }

        /* ══════════════════════════════════════════
           SIDEBAR
        ══════════════════════════════════════════ */
        .sidebar {
            width: var(--sidebar-w);
            background: var(--navy);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0; bottom: 0;
            z-index: 200;
            transition: width var(--transition), transform var(--transition);
            overflow: hidden;
        }

        /* Collapsed state */
        .sidebar.collapsed { width: var(--sidebar-w-sm); }

        /* ── Brand ── */
        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 18px;
            height: var(--topbar-h);
            border-bottom: 1px solid rgba(255,255,255,0.07);
            flex-shrink: 0;
            overflow: hidden;
            white-space: nowrap;
        }

        .brand-icon {
            width: 34px;
            height: 34px;
            background: var(--blue);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 0.9rem;
            flex-shrink: 0;
        }

        .brand-text {
            font-size: 1rem;
            font-weight: 800;
            color: white;
            letter-spacing: -0.2px;
            transition: opacity var(--transition);
        }

        .sidebar.collapsed .brand-text { opacity: 0; pointer-events: none; }

        /* ── Nav ── */
        .sidebar-nav {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            padding: 14px 10px;
            scrollbar-width: thin;
            scrollbar-color: rgba(255,255,255,0.1) transparent;
        }

        .sidebar-nav::-webkit-scrollbar { width: 4px; }
        .sidebar-nav::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 4px; }

        .nav-section-label {
            font-size: 0.62rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: rgba(255,255,255,0.3);
            padding: 14px 10px 6px;
            white-space: nowrap;
            overflow: hidden;
            transition: opacity var(--transition);
        }

        .sidebar.collapsed .nav-section-label { opacity: 0; }

        .nav-item {
            list-style: none;
            margin-bottom: 2px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 12px;
            border-radius: var(--radius-sm);
            color: rgba(255,255,255,0.6);
            font-size: 0.85rem;
            font-weight: 600;
            transition: background var(--transition), color var(--transition);
            white-space: nowrap;
            overflow: hidden;
            position: relative;
        }

        .nav-link:hover {
            background: rgba(255,255,255,0.07);
            color: rgba(255,255,255,0.95);
        }

        .nav-link.active {
            background: var(--blue-soft);
            color: #60A5FA;
        }

        .nav-link.active .nav-icon {
            color: #60A5FA;
        }

        .nav-icon {
            width: 18px;
            text-align: center;
            font-size: 0.9rem;
            flex-shrink: 0;
            transition: color var(--transition);
        }

        .nav-label {
            transition: opacity var(--transition);
            flex: 1;
        }

        .sidebar.collapsed .nav-label { opacity: 0; pointer-events: none; }

        /* Tooltip for collapsed state */
        .nav-link[data-tooltip] { position: relative; }

        .sidebar.collapsed .nav-link[data-tooltip]:hover::after {
            content: attr(data-tooltip);
            position: absolute;
            left: calc(var(--sidebar-w-sm) - 4px);
            top: 50%;
            transform: translateY(-50%);
            background: var(--navy-active);
            color: white;
            font-size: 0.78rem;
            font-weight: 600;
            padding: 6px 12px;
            border-radius: var(--radius-sm);
            white-space: nowrap;
            box-shadow: var(--shadow-lg);
            z-index: 999;
            pointer-events: none;
        }

        /* ── Sidebar Footer ── */
        .sidebar-footer {
            padding: 12px 10px;
            border-top: 1px solid rgba(255,255,255,0.07);
            flex-shrink: 0;
        }

        .sidebar-footer-user {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 10px;
            border-radius: var(--radius-sm);
            overflow: hidden;
            white-space: nowrap;
        }

        .user-avatar-sm {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: var(--blue);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.72rem;
            font-weight: 800;
            color: white;
            flex-shrink: 0;
        }

        .user-info-sm { overflow: hidden; transition: opacity var(--transition); }
        .sidebar.collapsed .user-info-sm { opacity: 0; }

        .user-name-sm {
            font-size: 0.8rem;
            font-weight: 700;
            color: rgba(255,255,255,0.9);
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-role-sm {
            font-size: 0.68rem;
            color: rgba(255,255,255,0.4);
        }

        /* ── Collapse Toggle Button ── */
        .sidebar-toggle-btn {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 9px;
            background: rgba(255,255,255,0.06);
            border: none;
            border-radius: var(--radius-sm);
            color: rgba(255,255,255,0.5);
            font-size: 0.78rem;
            font-weight: 600;
            cursor: pointer;
            transition: background var(--transition), color var(--transition);
            margin-top: 8px;
            white-space: nowrap;
            overflow: hidden;
        }

        .sidebar-toggle-btn:hover {
            background: rgba(255,255,255,0.1);
            color: rgba(255,255,255,0.85);
        }

        .sidebar-toggle-btn .toggle-label { transition: opacity var(--transition); }
        .sidebar.collapsed .sidebar-toggle-btn .toggle-label { opacity: 0; width: 0; }
        .sidebar.collapsed .sidebar-toggle-btn { justify-content: center; }

        .toggle-chevron { transition: transform var(--transition); flex-shrink: 0; }
        .sidebar.collapsed .toggle-chevron { transform: rotate(180deg); }

        /* ══════════════════════════════════════════
           MAIN CONTENT AREA
        ══════════════════════════════════════════ */
        .main-area {
            flex: 1;
            margin-left: var(--sidebar-w);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            transition: margin-left var(--transition);
        }

        .main-area.sidebar-collapsed { margin-left: var(--sidebar-w-sm); }

        /* ══════════════════════════════════════════
           TOPBAR
        ══════════════════════════════════════════ */
        .topbar {
            height: var(--topbar-h);
            background: var(--white);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            padding: 0 24px;
            gap: 16px;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 1px 0 var(--border);
        }

        /* Mobile hamburger */
        .topbar-hamburger {
            display: none;
            background: none;
            border: none;
            color: var(--text-muted);
            font-size: 1.1rem;
            cursor: pointer;
            padding: 6px;
            border-radius: var(--radius-sm);
            transition: background var(--transition);
        }

        .topbar-hamburger:hover { background: var(--bg); color: var(--text-main); }

        .topbar-title {
            font-size: 0.92rem;
            font-weight: 700;
            color: var(--text-main);
            flex: 1;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        /* ── Topbar Icon Button ── */
        .topbar-icon-btn {
            position: relative;
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: none;
            border: none;
            border-radius: var(--radius-sm);
            color: var(--text-muted);
            font-size: 0.95rem;
            cursor: pointer;
            transition: background var(--transition), color var(--transition);
        }

        .topbar-icon-btn:hover { background: var(--bg); color: var(--text-main); }

        /* ── Notif Badge ── */
        .notif-count {
            position: absolute;
            top: 4px;
            right: 4px;
            width: 16px;
            height: 16px;
            background: var(--danger);
            color: white;
            border-radius: 50%;
            font-size: 0.6rem;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid white;
            display: none;
        }

        .notif-count.visible { display: flex; }

        /* ── Dropdown ── */
        .dropdown { position: relative; }

        .dropdown-panel {
            display: none;
            position: absolute;
            right: 0;
            top: calc(100% + 8px);
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow-lg);
            z-index: 500;
            animation: dropIn 0.18s ease;
        }

        .dropdown-panel.open { display: block; }

        @keyframes dropIn {
            from { opacity: 0; transform: translateY(-6px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Notif Panel */
        .notif-panel {
            width: 340px;
        }

        .notif-panel-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 16px 12px;
            border-bottom: 1px solid var(--border);
        }

        .notif-panel-header strong {
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--text-main);
        }

        .btn-clear-notif {
            background: none;
            border: none;
            font-size: 0.72rem;
            font-weight: 600;
            color: var(--blue);
            cursor: pointer;
            padding: 2px 6px;
            border-radius: 4px;
            transition: background var(--transition);
        }

        .btn-clear-notif:hover { background: var(--bg); }

        .notif-list {
            max-height: 360px;
            overflow-y: auto;
        }

        .notif-empty {
            text-align: center;
            padding: 32px 16px;
            color: var(--text-faint);
            font-size: 0.8rem;
        }

        .notif-empty i { font-size: 1.6rem; margin-bottom: 8px; display: block; opacity: 0.4; }

        .notif-item {
            display: flex;
            gap: 10px;
            padding: 12px 16px;
            border-bottom: 1px solid #F1F5F9;
            cursor: default;
            transition: background var(--transition);
        }

        .notif-item:hover { background: var(--bg); }
        .notif-item:last-child { border-bottom: none; }

        .notif-item-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            margin-top: 5px;
            flex-shrink: 0;
        }

        .notif-item-body { flex: 1; min-width: 0; }
        .notif-item-title { font-size: 0.8rem; font-weight: 700; margin-bottom: 2px; }
        .notif-item-detail { font-size: 0.73rem; color: var(--text-muted); line-height: 1.5; }
        .notif-item-time { font-size: 0.68rem; color: var(--text-faint); margin-top: 3px; }

        /* User Panel */
        .user-panel {
            width: 220px;
            padding: 8px;
        }

        .user-panel-header {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 10px 12px;
            border-bottom: 1px solid var(--border);
            margin-bottom: 4px;
        }

        .user-avatar {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: var(--blue);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.82rem;
            font-weight: 800;
            color: white;
            flex-shrink: 0;
        }

        .user-panel-name {
            font-size: 0.83rem;
            font-weight: 700;
            color: var(--text-main);
            line-height: 1.2;
        }

        .user-panel-role {
            font-size: 0.68rem;
            font-weight: 600;
            padding: 2px 8px;
            border-radius: 100px;
            margin-top: 3px;
            display: inline-block;
        }

        .role-admin { background: rgba(30,111,217,0.1); color: var(--blue); }
        .role-user  { background: rgba(100,116,139,0.1); color: var(--text-muted); }

        .user-menu-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 10px;
            border-radius: var(--radius-sm);
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--text-muted);
            cursor: pointer;
            transition: background var(--transition), color var(--transition);
            border: none;
            background: none;
            width: 100%;
            text-align: left;
        }

        .user-menu-item:hover { background: var(--bg); color: var(--text-main); }

        .user-menu-item.danger:hover { background: rgba(239,68,68,0.08); color: var(--danger); }

        .user-menu-divider {
            height: 1px;
            background: var(--border);
            margin: 4px 0;
        }

        /* Topbar Divider */
        .topbar-divider {
            width: 1px;
            height: 24px;
            background: var(--border);
            margin: 0 4px;
        }

        /* ══════════════════════════════════════════
           TOAST NOTIFICATIONS
        ══════════════════════════════════════════ */
        #notif-container {
            position: fixed;
            bottom: 24px;
            right: 24px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 10px;
            max-width: 340px;
        }

        .notif-toast {
            background: var(--white);
            border-radius: var(--radius);
            box-shadow: var(--shadow-lg);
            padding: 14px 16px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            border-left: 4px solid var(--success);
            animation: toastIn 0.3s ease;
        }

        .notif-toast.denied { border-left-color: var(--danger); }

        @keyframes toastIn {
            from { transform: translateX(110%); opacity: 0; }
            to   { transform: translateX(0);    opacity: 1; }
        }

        @keyframes toastOut {
            from { transform: translateX(0);    opacity: 1; }
            to   { transform: translateX(110%); opacity: 0; }
        }

        .toast-icon { font-size: 1.3rem; margin-top: 1px; flex-shrink: 0; }

        .toast-body { flex: 1; min-width: 0; }

        .toast-title {
            font-size: 0.82rem;
            font-weight: 800;
            margin-bottom: 3px;
        }

        .toast-title.granted { color: var(--success); }
        .toast-title.denied  { color: var(--danger); }

        .toast-detail {
            font-size: 0.75rem;
            color: var(--text-muted);
            line-height: 1.55;
        }

        .toast-close {
            background: none;
            border: none;
            color: var(--text-faint);
            cursor: pointer;
            font-size: 0.9rem;
            padding: 0;
            line-height: 1;
            transition: color var(--transition);
            flex-shrink: 0;
        }

        .toast-close:hover { color: var(--text-muted); }

        /* ══════════════════════════════════════════
           PAGE CONTENT
        ══════════════════════════════════════════ */
        .page-content {
            flex: 1;
            padding: 28px 28px 20px;
        }

        /* ── Alerts ── */
        .sd-alert {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 16px;
            border-radius: var(--radius-sm);
            font-size: 0.83rem;
            font-weight: 600;
            margin-bottom: 20px;
            animation: fadeUp 0.3s ease;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(6px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .sd-alert.success {
            background: rgba(16,185,129,0.1);
            color: #065F46;
            border: 1px solid rgba(16,185,129,0.25);
        }

        .sd-alert.error {
            background: rgba(239,68,68,0.08);
            color: #7F1D1D;
            border: 1px solid rgba(239,68,68,0.2);
        }

        .sd-alert-close {
            margin-left: auto;
            background: none;
            border: none;
            font-size: 0.85rem;
            cursor: pointer;
            color: inherit;
            opacity: 0.6;
            transition: opacity var(--transition);
        }

        .sd-alert-close:hover { opacity: 1; }

        /* ══════════════════════════════════════════
           FOOTER
        ══════════════════════════════════════════ */
        .page-footer {
            padding: 16px 28px;
            border-top: 1px solid var(--border);
            background: var(--white);
            font-size: 0.75rem;
            color: var(--text-faint);
            text-align: center;
        }

        /* ══════════════════════════════════════════
           SCROLL TO TOP
        ══════════════════════════════════════════ */
        .scroll-top {
            position: fixed;
            bottom: 24px;
            left: calc(var(--sidebar-w) + 24px);
            width: 36px;
            height: 36px;
            background: var(--navy);
            color: white;
            border: none;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s, background var(--transition);
            z-index: 50;
            font-size: 0.8rem;
        }

        .scroll-top.visible { opacity: 1; pointer-events: auto; }
        .scroll-top:hover { background: var(--blue); }

        /* ══════════════════════════════════════════
           LOGOUT MODAL
        ══════════════════════════════════════════ */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(13,31,60,0.45);
            z-index: 800;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(2px);
        }

        .modal-overlay.open { display: flex; }

        .modal-box {
            background: var(--white);
            border-radius: var(--radius);
            box-shadow: var(--shadow-lg);
            width: 100%;
            max-width: 380px;
            animation: dropIn 0.2s ease;
            overflow: hidden;
        }

        .modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 20px 16px;
            border-bottom: 1px solid var(--border);
        }

        .modal-header h5 {
            font-size: 0.95rem;
            font-weight: 800;
            color: var(--text-main);
        }

        .modal-close-btn {
            background: none;
            border: none;
            color: var(--text-faint);
            font-size: 1rem;
            cursor: pointer;
            padding: 4px;
            border-radius: 6px;
            transition: background var(--transition);
        }

        .modal-close-btn:hover { background: var(--bg); color: var(--text-main); }

        .modal-body {
            padding: 20px;
            font-size: 0.87rem;
            color: var(--text-muted);
            line-height: 1.6;
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            padding: 14px 20px;
            background: #F8FAFC;
            border-top: 1px solid var(--border);
        }

        .btn-modal {
            padding: 8px 18px;
            border-radius: var(--radius-sm);
            font-size: 0.82rem;
            font-weight: 700;
            cursor: pointer;
            border: none;
            transition: background var(--transition), transform 0.1s;
        }

        .btn-modal:active { transform: scale(0.97); }

        .btn-modal.secondary {
            background: var(--bg);
            color: var(--text-muted);
            border: 1px solid var(--border);
        }

        .btn-modal.secondary:hover { background: var(--border); }

        .btn-modal.danger {
            background: var(--danger);
            color: white;
        }

        .btn-modal.danger:hover { background: #dc2626; }

        /* ══════════════════════════════════════════
           MOBILE OVERLAY
        ══════════════════════════════════════════ */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(13,31,60,0.4);
            z-index: 150;
            backdrop-filter: blur(1px);
        }

        /* ══════════════════════════════════════════
           RESPONSIVE
        ══════════════════════════════════════════ */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                width: var(--sidebar-w) !important;
            }

            .sidebar.mobile-open {
                transform: translateX(0);
            }

            .sidebar-overlay.open { display: block; }

            .main-area { margin-left: 0 !important; }

            .topbar-hamburger { display: flex; }

            .scroll-top { left: 24px; }

            .page-content { padding: 20px 16px; }
        }

        @media (max-width: 480px) {
            .topbar { padding: 0 14px; }
            .notif-panel { width: 300px; }
        }
    </style>

    @stack('styles')
</head>

<body>

<!-- Toast Container -->
<div id="notif-container"></div>

<!-- Mobile Sidebar Overlay -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<div class="app-shell">

    <!-- ══════════════════════════════════════════
         SIDEBAR
    ══════════════════════════════════════════ -->
    <aside class="sidebar" id="sidebar">

        <!-- Brand -->
        <a class="sidebar-brand" href="{{ route('dashboard') }}">
            <div class="brand-icon">
                <i class="fas fa-lock"></i>
            </div>
            <span class="brand-text">Smart Door</span>
        </a>

        <!-- Nav -->
        <nav class="sidebar-nav">

            <!-- Main -->
            <div class="nav-section-label">Utama</div>
            <ul style="list-style:none">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}"
                       class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                       data-tooltip="Dashboard">
                        <i class="fas fa-gauge-high nav-icon"></i>
                        <span class="nav-label">Dashboard</span>
                    </a>
                </li>
            </ul>

            <!-- Manajemen -->
            <div class="nav-section-label">Manajemen</div>
            <ul style="list-style:none">
                <li class="nav-item">
                    <a href="{{ route('devices.index') }}"
                       class="nav-link {{ request()->routeIs('devices.*') ? 'active' : '' }}"
                       data-tooltip="Devices">
                        <i class="fas fa-microchip nav-icon"></i>
                        <span class="nav-label">Devices</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('logs.index') }}"
                       class="nav-link {{ request()->routeIs('logs.*') ? 'active' : '' }}"
                       data-tooltip="Access Logs">
                        <i class="fas fa-clipboard-list nav-icon"></i>
                        <span class="nav-label">Access Logs</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('face.index') }}"
                       class="nav-link {{ request()->routeIs('face.*') ? 'active' : '' }}"
                       data-tooltip="Daftar Wajah">
                        <i class="fas fa-camera nav-icon"></i>
                        <span class="nav-label">Daftar Wajah</span>
                    </a>
                </li>
            </ul>

            <!-- Admin -->
            @if(auth()->user()->isAdmin())
            <div class="nav-section-label">Admin</div>
            <ul style="list-style:none">
                <li class="nav-item">
                    <a href="{{ route('users.index') }}"
                       class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}"
                       data-tooltip="Manajemen User">
                        <i class="fas fa-users nav-icon"></i>
                        <span class="nav-label">Manajemen User</span>
                    </a>
                </li>
            </ul>
            @endif

        </nav>

        <!-- Footer -->
        <div class="sidebar-footer">
            <div class="sidebar-footer-user">
                <div class="user-avatar-sm">
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                </div>
                <div class="user-info-sm">
                    <div class="user-name-sm">{{ auth()->user()->name }}</div>
                    <div class="user-role-sm">{{ ucfirst(auth()->user()->role) }}</div>
                </div>
            </div>
            <button class="sidebar-toggle-btn" id="sidebarToggleBtn" title="Toggle sidebar">
                <i class="fas fa-chevron-left toggle-chevron"></i>
                <span class="toggle-label">Tutup sidebar</span>
            </button>
        </div>

    </aside>

    <!-- ══════════════════════════════════════════
         MAIN AREA
    ══════════════════════════════════════════ -->
    <div class="main-area" id="mainArea">

        <!-- Topbar -->
        <header class="topbar">

            <!-- Mobile hamburger -->
            <button class="topbar-hamburger" id="mobileMenuBtn" aria-label="Toggle menu">
                <i class="fas fa-bars"></i>
            </button>

            <!-- Page Title -->
            <span class="topbar-title">{{ $title ?? 'Dashboard' }}</span>

            <!-- Right side -->
            <div class="topbar-right">

                <!-- Notification Bell -->
                <div class="dropdown">
                    <button class="topbar-icon-btn" id="notifBtn" aria-label="Notifikasi">
                        <i class="fas fa-bell"></i>
                        <span class="notif-count" id="notif-badge">0</span>
                    </button>
                    <div class="dropdown-panel notif-panel" id="notifPanel">
                        <div class="notif-panel-header">
                            <strong>Notifikasi</strong>
                            <button class="btn-clear-notif" id="notif-clear-all">Hapus Semua</button>
                        </div>
                        <div class="notif-list" id="notif-list">
                            <div class="notif-empty" id="notif-empty">
                                <i class="fas fa-bell-slash"></i>
                                Belum ada notifikasi
                            </div>
                        </div>
                    </div>
                </div>

                <div class="topbar-divider"></div>

                <!-- User Dropdown -->
                <div class="dropdown">
                    <button class="topbar-icon-btn" id="userBtn"
                            style="width:auto;padding:0 10px;gap:8px;font-weight:700;font-size:0.82rem;color:var(--text-main)">
                        <div class="user-avatar" style="width:30px;height:30px;border-radius:8px;font-size:0.7rem">
                            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                        </div>
                        <span class="d-none d-lg-inline" style="max-width:120px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">
                            {{ auth()->user()->name }}
                        </span>
                        <i class="fas fa-chevron-down" style="font-size:0.6rem;color:var(--text-faint)"></i>
                    </button>
                    <div class="dropdown-panel user-panel" id="userPanel">
                        <div class="user-panel-header">
                            <div class="user-avatar">
                                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                            </div>
                            <div>
                                <div class="user-panel-name">{{ auth()->user()->name }}</div>
                                <span class="user-panel-role {{ auth()->user()->isAdmin() ? 'role-admin' : 'role-user' }}">
                                    {{ ucfirst(auth()->user()->role) }}
                                </span>
                            </div>
                        </div>
                        <a href="{{ route('profile.edit') }}" class="user-menu-item">
                            <i class="fas fa-user" style="width:14px;text-align:center"></i>
                            Profil Saya
                        </a>
                        <a href="{{ route('face.index') }}" class="user-menu-item">
                            <i class="fas fa-camera" style="width:14px;text-align:center"></i>
                            Daftar Wajah
                        </a>
                        <div class="user-menu-divider"></div>
                        <button class="user-menu-item danger" id="logoutBtn">
                            <i class="fas fa-sign-out-alt" style="width:14px;text-align:center"></i>
                            Keluar
                        </button>
                    </div>
                </div>

            </div>
        </header>

        <!-- Page Content -->
        <main class="page-content">

            @if(session('success'))
            <div class="sd-alert success" id="alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
                <button class="sd-alert-close" onclick="this.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            @endif

            @if(session('error'))
            <div class="sd-alert error" id="alert-error">
                <i class="fas fa-exclamation-circle"></i>
                {{ session('error') }}
                <button class="sd-alert-close" onclick="this.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            @endif

            {{ $slot }}

        </main>

        <footer class="page-footer">
            Smart Door &copy; {{ date('Y') }} — IoT Access Control System
        </footer>

    </div>

</div>

<!-- Scroll to Top -->
<button class="scroll-top" id="scrollTop" onclick="window.scrollTo({top:0,behavior:'smooth'})" title="Ke atas">
    <i class="fas fa-chevron-up"></i>
</button>

<!-- Logout Modal -->
<div class="modal-overlay" id="logoutModal">
    <div class="modal-box">
        <div class="modal-header">
            <h5>Konfirmasi Keluar</h5>
            <button class="modal-close-btn" id="closeLogoutModal">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            Yakin ingin keluar dari sistem? Sesi Anda akan diakhiri.
        </div>
        <div class="modal-footer">
            <button class="btn-modal secondary" id="cancelLogout">Batal</button>
            <form method="POST" action="{{ route('logout') }}" style="display:inline">
                @csrf
                <button type="submit" class="btn-modal danger">
                    <i class="fas fa-sign-out-alt" style="margin-right:6px"></i>Keluar
                </button>
            </form>
        </div>
    </div>
</div>

<script>
(function () {
    'use strict';

    /* ── Sidebar Toggle (Desktop collapse) ── */
    const sidebar      = document.getElementById('sidebar');
    const mainArea     = document.getElementById('mainArea');
    const toggleBtn    = document.getElementById('sidebarToggleBtn');
    const COLLAPSED_KEY = 'sd_sidebar_collapsed';

    function setSidebarCollapsed(collapsed) {
        sidebar.classList.toggle('collapsed', collapsed);
        mainArea.classList.toggle('sidebar-collapsed', collapsed);
        localStorage.setItem(COLLAPSED_KEY, collapsed ? '1' : '0');
    }

    // Restore state
    if (localStorage.getItem(COLLAPSED_KEY) === '1') {
        setSidebarCollapsed(true);
    }

    if (toggleBtn) {
        toggleBtn.addEventListener('click', function () {
            const isCollapsed = sidebar.classList.contains('collapsed');
            setSidebarCollapsed(!isCollapsed);
        });
    }

    /* ── Mobile Sidebar ── */
    const mobileBtn  = document.getElementById('mobileMenuBtn');
    const overlay    = document.getElementById('sidebarOverlay');

    function openMobileSidebar() {
        sidebar.classList.add('mobile-open');
        overlay.classList.add('open');
        document.body.style.overflow = 'hidden';
    }

    function closeMobileSidebar() {
        sidebar.classList.remove('mobile-open');
        overlay.classList.remove('open');
        document.body.style.overflow = '';
    }

    if (mobileBtn)  mobileBtn.addEventListener('click', openMobileSidebar);
    if (overlay)    overlay.addEventListener('click', closeMobileSidebar);

    /* ── Dropdown (Notif + User) ── */
    function setupDropdown(btnId, panelId) {
        const btn   = document.getElementById(btnId);
        const panel = document.getElementById(panelId);
        if (!btn || !panel) return;

        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            // close others
            document.querySelectorAll('.dropdown-panel.open').forEach(function (p) {
                if (p !== panel) p.classList.remove('open');
            });
            panel.classList.toggle('open');
        });
    }

    setupDropdown('notifBtn', 'notifPanel');
    setupDropdown('userBtn',  'userPanel');

    document.addEventListener('click', function () {
        document.querySelectorAll('.dropdown-panel.open').forEach(function (p) {
            p.classList.remove('open');
        });
    });

    document.querySelectorAll('.dropdown-panel').forEach(function (p) {
        p.addEventListener('click', function (e) { e.stopPropagation(); });
    });

    /* ── Logout Modal ── */
    const logoutModal    = document.getElementById('logoutModal');
    const logoutBtn      = document.getElementById('logoutBtn');
    const closeLogoutBtn = document.getElementById('closeLogoutModal');
    const cancelLogout   = document.getElementById('cancelLogout');

    function openLogoutModal()  { logoutModal.classList.add('open'); }
    function closeLogoutModal() { logoutModal.classList.remove('open'); }

    if (logoutBtn)      logoutBtn.addEventListener('click', openLogoutModal);
    if (closeLogoutBtn) closeLogoutBtn.addEventListener('click', closeLogoutModal);
    if (cancelLogout)   cancelLogout.addEventListener('click', closeLogoutModal);

    logoutModal.addEventListener('click', function (e) {
        if (e.target === logoutModal) closeLogoutModal();
    });

    /* ── Auto-dismiss Alerts ── */
    ['alert-success', 'alert-error'].forEach(function (id) {
        const el = document.getElementById(id);
        if (el) setTimeout(function () {
            el.style.transition = 'opacity 0.4s';
            el.style.opacity = '0';
            setTimeout(function () { el.remove(); }, 400);
        }, 4000);
    });

    /* ── Scroll to Top ── */
    const scrollTopBtn = document.getElementById('scrollTop');
    window.addEventListener('scroll', function () {
        if (scrollTopBtn) {
            scrollTopBtn.classList.toggle('visible', window.scrollY > 300);
        }
    });

    /* ══════════════════════════════════════════════
       NOTIFIKASI REAL-TIME (Polling 7 detik)
    ══════════════════════════════════════════════ */
    let lastTimestamp = Math.floor(Date.now() / 1000);
    let unreadCount   = 0;

    function showToast(log) {
        const isGranted = log.status === 'granted';
        const icon      = isGranted ? '✅' : '🚫';
        const cls       = isGranted ? 'granted' : 'denied';
        const title     = isGranted ? 'AKSES DITERIMA' : 'AKSES DITOLAK';

        const toast = document.createElement('div');
        toast.className = 'notif-toast ' + cls;
        toast.innerHTML = `
            <div class="toast-icon">${icon}</div>
            <div class="toast-body">
                <div class="toast-title ${cls}">${title}</div>
                <div class="toast-detail">
                    🔑 ${log.identifier}<br>
                    📡 ${log.method}&nbsp;&nbsp;|&nbsp;&nbsp;📍 ${log.device}<br>
                    🕐 ${log.waktu}
                </div>
            </div>
            <button class="toast-close">&times;</button>
        `;

        toast.querySelector('.toast-close').addEventListener('click', function () {
            dismissToast(toast);
        });

        const container = document.getElementById('notif-container');
        container.insertBefore(toast, container.firstChild);

        setTimeout(function () { dismissToast(toast); }, 10000);
    }

    function dismissToast(toast) {
        toast.style.animation = 'toastOut 0.3s ease forwards';
        setTimeout(function () { toast.remove(); }, 300);
    }

    function addToPanel(log) {
        const isGranted = log.status === 'granted';
        const color     = isGranted ? 'var(--success)' : 'var(--danger)';
        const title     = isGranted ? 'Akses Diterima' : 'Akses Ditolak';
        const timeOnly  = log.waktu ? log.waktu.split(' ')[1] : '';

        const emptyEl = document.getElementById('notif-empty');
        if (emptyEl) emptyEl.style.display = 'none';

        const item = document.createElement('div');
        item.className = 'notif-item';
        item.innerHTML = `
            <div class="notif-item-dot" style="background:${color}"></div>
            <div class="notif-item-body">
                <div class="notif-item-title" style="color:${color}">${title}</div>
                <div class="notif-item-detail">
                    🔑 ${log.identifier}&nbsp;&nbsp;|&nbsp;&nbsp;📡 ${log.method}<br>
                    📍 ${log.device}
                </div>
                <div class="notif-item-time">🕐 ${timeOnly}</div>
            </div>
        `;

        const list = document.getElementById('notif-list');
        list.insertBefore(item, list.firstChild);

        const items = list.querySelectorAll('.notif-item');
        if (items.length > 20) items[items.length - 1].remove();
    }

    function updateBadge(count) {
        const badge = document.getElementById('notif-badge');
        if (!badge) return;
        if (count > 0) {
            badge.textContent = count > 9 ? '9+' : count;
            badge.classList.add('visible');
        } else {
            badge.classList.remove('visible');
        }
    }

    // Reset badge on bell click
    document.getElementById('notifBtn') && document.getElementById('notifBtn').addEventListener('click', function () {
        unreadCount = 0;
        updateBadge(0);
    });

    // Clear all
    document.getElementById('notif-clear-all') && document.getElementById('notif-clear-all').addEventListener('click', function (e) {
        e.stopPropagation();
        document.querySelectorAll('#notif-list .notif-item').forEach(function (el) { el.remove(); });
        const emptyEl = document.getElementById('notif-empty');
        if (emptyEl) emptyEl.style.display = '';
        unreadCount = 0;
        updateBadge(0);
    });

    function pollNotifications() {
        fetch('/notifications/latest?since=' + lastTimestamp, {
            method: 'GET',
            credentials: 'same-origin',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
            }
        })
        .then(function (r) { return r.ok ? r.json() : null; })
        .then(function (res) {
            if (!res) return;
            if (res.logs && res.logs.length > 0) {
                res.logs.forEach(function (log) {
                    showToast(log);
                    addToPanel(log);
                    unreadCount++;
                });
                updateBadge(unreadCount);
            }
            if (res.server_time) lastTimestamp = res.server_time;
        })
        .catch(function () { /* silent */ });
    }

    setTimeout(function () {
        pollNotifications();
        setInterval(pollNotifications, 7000);
    }, 3000);

})();
</script>

@stack('scripts')

</body>
</html>