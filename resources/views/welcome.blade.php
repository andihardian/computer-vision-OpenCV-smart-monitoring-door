<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Door — IoT Access Control System</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --navy:      #0B1F3A;
            --navy-mid:  #112240;
            --navy-soft: #1A3358;
            --blue:      #1E6FD9;
            --blue-light:#3B8EF0;
            --accent:    #00D4FF;
            --white:     #FFFFFF;
            --gray-100:  #F4F7FB;
            --gray-300:  #C8D5E8;
            --gray-500:  #7A90AB;
            --success:   #10C98F;
            --danger:    #F04F5A;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--white);
            color: var(--navy);
            overflow-x: hidden;
        }

        /* ── NAVBAR ── */
        nav {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 100;
            padding: 0 5%;
            height: 68px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: rgba(11, 31, 58, 0.95);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255,255,255,0.07);
            transition: all 0.3s ease;
        }

        .nav-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--white);
            font-weight: 700;
            font-size: 1.15rem;
            text-decoration: none;
            letter-spacing: 0.3px;
        }

        .nav-brand .brand-icon {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, var(--blue), var(--accent));
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            color: white;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 32px;
            list-style: none;
        }

        .nav-links a {
            color: var(--gray-300);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: color 0.2s;
        }

        .nav-links a:hover { color: var(--white); }

        .nav-cta {
            background: var(--blue);
            color: var(--white) !important;
            padding: 8px 22px;
            border-radius: 8px;
            font-weight: 600 !important;
            transition: background 0.2s !important;
        }

        .nav-cta:hover { background: var(--blue-light) !important; }

        /* ── HERO ── */
        .hero {
            min-height: 100vh;
            background: var(--navy);
            display: flex;
            align-items: center;
            padding: 120px 5% 80px;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: -200px; right: -200px;
            width: 700px; height: 700px;
            background: radial-gradient(circle, rgba(30,111,217,0.2) 0%, transparent 70%);
            border-radius: 50%;
        }

        .hero::after {
            content: '';
            position: absolute;
            bottom: -100px; left: -100px;
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(0,212,255,0.08) 0%, transparent 70%);
            border-radius: 50%;
        }

        .hero-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 80px;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            width: 100%;
            position: relative;
            z-index: 1;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(30,111,217,0.15);
            border: 1px solid rgba(30,111,217,0.3);
            color: var(--accent);
            padding: 6px 16px;
            border-radius: 100px;
            font-size: 0.8rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            margin-bottom: 24px;
        }

        .hero-badge .dot {
            width: 6px; height: 6px;
            background: var(--accent);
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(1.3); }
        }

        .hero h1 {
            font-size: clamp(2.2rem, 4vw, 3.4rem);
            font-weight: 700;
            color: var(--white);
            line-height: 1.2;
            margin-bottom: 20px;
            letter-spacing: -0.5px;
        }

        .hero h1 span {
            background: linear-gradient(135deg, var(--blue-light), var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero p {
            color: var(--gray-300);
            font-size: 1.05rem;
            line-height: 1.75;
            margin-bottom: 36px;
            max-width: 480px;
        }

        .hero-actions {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
        }

        .btn-primary-hero {
            background: var(--blue);
            color: white;
            padding: 14px 32px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
            box-shadow: 0 4px 20px rgba(30,111,217,0.4);
        }

        .btn-primary-hero:hover {
            background: var(--blue-light);
            transform: translateY(-2px);
            box-shadow: 0 6px 24px rgba(30,111,217,0.5);
            color: white;
            text-decoration: none;
        }

        .btn-ghost {
            color: var(--gray-300);
            padding: 14px 24px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: 1px solid rgba(255,255,255,0.12);
            transition: all 0.2s;
        }

        .btn-ghost:hover {
            border-color: rgba(255,255,255,0.3);
            color: var(--white);
            text-decoration: none;
        }

        /* Hero Visual */
        .hero-visual {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .door-card {
            background: var(--navy-mid);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 24px;
            padding: 32px;
            width: 100%;
            max-width: 360px;
            box-shadow: 0 24px 64px rgba(0,0,0,0.4);
        }

        .door-card-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 24px;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.07);
        }

        .door-status-icon {
            width: 48px; height: 48px;
            background: linear-gradient(135deg, var(--blue), var(--accent));
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            color: white;
        }

        .door-card-header h3 {
            color: var(--white);
            font-size: 1rem;
            font-weight: 600;
        }

        .door-card-header p {
            color: var(--gray-500);
            font-size: 0.78rem;
            margin: 0;
        }

        .door-status-badge {
            margin-left: auto;
            background: rgba(16,201,143,0.15);
            color: var(--success);
            border: 1px solid rgba(16,201,143,0.3);
            padding: 4px 12px;
            border-radius: 100px;
            font-size: 0.72rem;
            font-weight: 600;
        }

        .door-log-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 0;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }

        .door-log-item:last-child { border-bottom: none; }

        .log-icon {
            width: 34px; height: 34px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            flex-shrink: 0;
        }

        .log-icon.granted { background: rgba(16,201,143,0.15); color: var(--success); }
        .log-icon.denied  { background: rgba(240,79,90,0.15);  color: var(--danger); }

        .log-info { flex: 1; }

        .log-info .log-id {
            font-family: 'DM Mono', monospace;
            font-size: 0.78rem;
            color: var(--white);
            font-weight: 500;
        }

        .log-info .log-time {
            font-size: 0.7rem;
            color: var(--gray-500);
        }

        .log-badge {
            font-size: 0.68rem;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 100px;
        }

        .log-badge.granted {
            background: rgba(16,201,143,0.15);
            color: var(--success);
        }

        .log-badge.denied {
            background: rgba(240,79,90,0.15);
            color: var(--danger);
        }

        /* Hero Stats */
        .hero-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-top: 48px;
        }

        .stat-item {
            text-align: center;
        }

        .stat-item .stat-num {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--white);
            display: block;
        }

        .stat-item .stat-label {
            font-size: 0.75rem;
            color: var(--gray-500);
            margin-top: 2px;
        }

        .stat-divider {
            width: 1px;
            background: rgba(255,255,255,0.08);
            margin: 0 auto;
        }

        /* ── FEATURES ── */
        .features {
            padding: 100px 5%;
            background: var(--gray-100);
        }

        .section-header {
            text-align: center;
            margin-bottom: 64px;
        }

        .section-tag {
            display: inline-block;
            background: rgba(30,111,217,0.1);
            color: var(--blue);
            padding: 6px 16px;
            border-radius: 100px;
            font-size: 0.78rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            margin-bottom: 16px;
        }

        .section-header h2 {
            font-size: clamp(1.8rem, 3vw, 2.6rem);
            font-weight: 700;
            color: var(--navy);
            margin-bottom: 16px;
            letter-spacing: -0.3px;
        }

        .section-header p {
            color: var(--gray-500);
            font-size: 1rem;
            max-width: 520px;
            margin: 0 auto;
            line-height: 1.7;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
            max-width: 1100px;
            margin: 0 auto;
        }

        .feature-card {
            background: var(--white);
            border-radius: 20px;
            padding: 32px;
            border: 1px solid rgba(0,0,0,0.06);
            transition: all 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 40px rgba(30,111,217,0.1);
            border-color: rgba(30,111,217,0.2);
        }

        .feature-icon {
            width: 52px; height: 52px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            margin-bottom: 20px;
        }

        .feature-card h3 {
            font-size: 1rem;
            font-weight: 700;
            color: var(--navy);
            margin-bottom: 10px;
        }

        .feature-card p {
            font-size: 0.88rem;
            color: var(--gray-500);
            line-height: 1.7;
        }

        /* ── HOW IT WORKS ── */
        .how-it-works {
            padding: 100px 5%;
            background: var(--white);
        }

        .steps-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 32px;
            max-width: 1100px;
            margin: 0 auto;
            position: relative;
        }

        .steps-grid::before {
            content: '';
            position: absolute;
            top: 28px;
            left: 10%;
            right: 10%;
            height: 2px;
            background: linear-gradient(90deg, var(--blue), var(--accent));
            opacity: 0.3;
            z-index: 0;
        }

        .step-item {
            text-align: center;
            position: relative;
            z-index: 1;
        }

        .step-num {
            width: 56px; height: 56px;
            border-radius: 50%;
            background: var(--navy);
            color: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.1rem;
            margin: 0 auto 20px;
            border: 3px solid var(--blue);
            box-shadow: 0 0 0 6px rgba(30,111,217,0.1);
        }

        .step-item h3 {
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--navy);
            margin-bottom: 8px;
        }

        .step-item p {
            font-size: 0.82rem;
            color: var(--gray-500);
            line-height: 1.6;
        }

        /* ── CTA ── */
        .cta-section {
            padding: 80px 5%;
            background: var(--navy);
            text-align: center;
        }

        .cta-section h2 {
            font-size: clamp(1.8rem, 3vw, 2.4rem);
            font-weight: 700;
            color: var(--white);
            margin-bottom: 16px;
        }

        .cta-section p {
            color: var(--gray-300);
            font-size: 1rem;
            margin-bottom: 36px;
        }

        /* ── FOOTER ── */
        footer {
            background: var(--navy-mid);
            padding: 24px 5%;
            text-align: center;
            border-top: 1px solid rgba(255,255,255,0.06);
        }

        footer p {
            color: var(--gray-500);
            font-size: 0.82rem;
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 900px) {
            .hero-grid {
                grid-template-columns: 1fr;
                gap: 48px;
            }
            .features-grid { grid-template-columns: repeat(2, 1fr); }
            .steps-grid { grid-template-columns: repeat(2, 1fr); }
            .steps-grid::before { display: none; }
            .hero-visual { display: none; }
            .nav-links { display: none; }
        }

        @media (max-width: 600px) {
            .features-grid { grid-template-columns: 1fr; }
            .steps-grid { grid-template-columns: 1fr; }
            .hero-stats { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav>
    <a href="/" class="nav-brand">
        <div class="brand-icon"><i class="fas fa-lock"></i></div>
        Smart Door
    </a>
    <ul class="nav-links">
        <li><a href="#features">Fitur</a></li>
        <li><a href="#how-it-works">Cara Kerja</a></li>
        <li><a href="{{ route('login') }}" class="nav-cta">Masuk ke Dashboard</a></li>
    </ul>
</nav>

<!-- Hero -->
<section class="hero">
    <div class="hero-grid">
        <div class="hero-content">
            <div class="hero-badge">
                <span class="dot"></span>
                IoT Access Control System
            </div>
            <h1>Keamanan Pintu <span>Cerdas</span> Berbasis AI</h1>
            <p>Sistem kontrol akses pintu modern menggunakan Face Recognition, RFID, dan PIN yang terhubung real-time ke dashboard web dan notifikasi Telegram.</p>
            <div class="hero-actions">
                <a href="{{ route('login') }}" class="btn-primary-hero">
                    <i class="fas fa-sign-in-alt"></i> Masuk Dashboard
                </a>
                <a href="#features" class="btn-ghost">
                    <i class="fas fa-info-circle"></i> Pelajari Lebih
                </a>
            </div>
            <div class="hero-stats">
                <div class="stat-item">
                    <span class="stat-num">3</span>
                    <span class="stat-label">Metode Akses</span>
                </div>
                <div class="stat-item">
                    <span class="stat-num">24/7</span>
                    <span class="stat-label">Monitoring</span>
                </div>
                <div class="stat-item">
                    <span class="stat-num">Real-time</span>
                    <span class="stat-label">Notifikasi</span>
                </div>
            </div>
        </div>

        <div class="hero-visual">
            <div class="door-card">
                <div class="door-card-header">
                    <div class="door-status-icon"><i class="fas fa-door-open"></i></div>
                    <div>
                        <h3>Raspberry Pi Smart Door</h3>
                        <p>Pintu Utama · Depan</p>
                    </div>
                    <span class="door-status-badge">● Aktif</span>
                </div>
                <div class="door-log-item">
                    <div class="log-icon granted"><i class="fas fa-check"></i></div>
                    <div class="log-info">
                        <div class="log-id">FACE-user_1</div>
                        <div class="log-time">Hari ini · 14:53</div>
                    </div>
                    <span class="log-badge granted">Diterima</span>
                </div>
                <div class="door-log-item">
                    <div class="log-icon denied"><i class="fas fa-times"></i></div>
                    <div class="log-info">
                        <div class="log-id">FACE-UNKNOWN</div>
                        <div class="log-time">Hari ini · 14:48</div>
                    </div>
                    <span class="log-badge denied">Ditolak</span>
                </div>
                <div class="door-log-item">
                    <div class="log-icon granted"><i class="fas fa-check"></i></div>
                    <div class="log-info">
                        <div class="log-id">FACE-user_2</div>
                        <div class="log-time">Hari ini · 14:29</div>
                    </div>
                    <span class="log-badge granted">Diterima</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features -->
<section class="features" id="features">
    <div class="section-header">
        <span class="section-tag">FITUR UNGGULAN</span>
        <h2>Semua yang Anda Butuhkan</h2>
        <p>Sistem keamanan pintu lengkap dengan teknologi terkini untuk kendali akses yang aman dan mudah dikelola.</p>
    </div>
    <div class="features-grid">
        <div class="feature-card">
            <div class="feature-icon" style="background:rgba(30,111,217,0.1);color:var(--blue)">
                <i class="fas fa-face-smile"></i>
            </div>
            <h3>Face Recognition</h3>
            <p>Deteksi wajah otomatis menggunakan OpenCV dan algoritma LBPH yang akurat dan cepat tanpa sentuhan.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon" style="background:rgba(16,201,143,0.1);color:var(--success)">
                <i class="fas fa-wifi"></i>
            </div>
            <h3>Notifikasi Real-time</h3>
            <p>Setiap akses langsung terkirim ke Telegram dengan foto snapshot dan informasi lengkap.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon" style="background:rgba(0,212,255,0.1);color:var(--accent)">
                <i class="fas fa-clock"></i>
            </div>
            <h3>Jam Operasional</h3>
            <p>Atur jadwal akses pintu secara fleksibel. Di luar jam operasional, semua akses otomatis ditolak.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon" style="background:rgba(240,79,90,0.1);color:var(--danger)">
                <i class="fas fa-shield-halved"></i>
            </div>
            <h3>Multi-Layer Security</h3>
            <p>Kombinasi Face Recognition, RFID, dan PIN sebagai metode autentikasi berlapis yang fleksibel.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon" style="background:rgba(255,165,0,0.1);color:orange">
                <i class="fas fa-chart-line"></i>
            </div>
            <h3>Dashboard Monitoring</h3>
            <p>Pantau semua aktivitas akses secara real-time lewat dashboard web yang informatif dan responsif.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon" style="background:rgba(147,51,234,0.1);color:#9333ea">
                <i class="fas fa-camera"></i>
            </div>
            <h3>Registrasi Wajah Mudah</h3>
            <p>Daftarkan wajah pengguna baru langsung dari kamera Raspberry Pi tanpa perlu datang ke admin.</p>
        </div>
    </div>
</section>

<!-- How It Works -->
<section class="how-it-works" id="how-it-works">
    <div class="section-header">
        <span class="section-tag">CARA KERJA</span>
        <h2>Sederhana & Otomatis</h2>
        <p>Sistem bekerja secara otomatis dari deteksi hingga notifikasi tanpa intervensi manual.</p>
    </div>
    <div class="steps-grid">
        <div class="step-item">
            <div class="step-num">1</div>
            <h3>Deteksi</h3>
            <p>Sensor PIR mendeteksi gerakan dan mengaktifkan kamera Raspberry Pi secara otomatis.</p>
        </div>
        <div class="step-item">
            <div class="step-num">2</div>
            <h3>Identifikasi</h3>
            <p>OpenCV mengenali wajah dan mencocokkan dengan database pengguna yang terdaftar.</p>
        </div>
        <div class="step-item">
            <div class="step-num">3</div>
            <h3>Validasi</h3>
            <p>Laravel API memvalidasi akses berdasarkan whitelist dan jam operasional yang telah diatur.</p>
        </div>
        <div class="step-item">
            <div class="step-num">4</div>
            <h3>Notifikasi</h3>
            <p>Hasil akses langsung dikirim ke Telegram dan tercatat di dashboard web secara real-time.</p>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="cta-section">
    <h2>Siap Memantau Akses Pintu Anda?</h2>
    <p>Masuk ke dashboard untuk melihat statistik, log akses, dan kelola sistem Smart Door Anda.</p>
    <a href="{{ route('login') }}" class="btn-primary-hero" style="display:inline-flex">
        <i class="fas fa-sign-in-alt"></i> Masuk ke Dashboard
    </a>
</section>

<!-- Footer -->
<footer>
    <p>Smart Door &copy; {{ date('Y') }} — IoT Access Control System &nbsp;·&nbsp; Powered by Laravel + OpenCV + Raspberry Pi</p>
</footer>

</body>
</html>