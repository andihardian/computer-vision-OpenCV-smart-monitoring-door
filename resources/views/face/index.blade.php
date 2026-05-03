<x-app-layout>
    <x-slot name="title">Daftar Wajah</x-slot>

    @push('styles')
    <style>
        :root {
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

        .page-header {
            display:flex; align-items:center; justify-content:space-between;
            margin-bottom:28px; flex-wrap:wrap; gap:12px;
        }
        .page-header h1 { font-size:1.5rem; font-weight:800; color:var(--text-main); margin:0 0 2px; letter-spacing:-0.3px; }
        .page-header p  { font-size:0.82rem; color:var(--text-muted); margin:0; }

        /* Center layout */
        .face-wrap { max-width:560px; margin:0 auto; }

        /* SD Card */
        .sd-card {
            background:var(--card); border-radius:var(--radius);
            border:1px solid var(--border); box-shadow:var(--shadow);
            overflow:hidden; margin-bottom:20px;
        }
        .sd-card-header {
            display:flex; align-items:center; justify-content:space-between;
            padding:18px 20px 16px; border-bottom:1px solid var(--border);
        }
        .sd-card-title { font-size:0.9rem; font-weight:700; color:var(--text-main); }
        .sd-card-body  { padding:24px; }

        /* Status card — processing */
        .status-hero { text-align:center; padding:8px 0 20px; }
        .status-icon-wrap {
            width:72px; height:72px; border-radius:20px;
            display:flex; align-items:center; justify-content:center;
            margin:0 auto 16px; font-size:1.8rem;
        }
        .status-icon-processing { background:rgba(245,158,11,0.1); color:var(--warning); }
        .status-icon-success    { background:rgba(16,185,129,0.1);  color:var(--success); }
        .status-icon-danger     { background:rgba(239,68,68,0.1);   color:var(--danger); }
        .status-icon-cancelled  { background:rgba(100,116,139,0.1); color:var(--text-muted); }

        .status-title { font-size:1.1rem; font-weight:800; margin-bottom:4px; }
        .status-title.processing { color:var(--warning); }
        .status-title.success    { color:var(--success); }
        .status-title.danger     { color:var(--danger); }
        .status-title.cancelled  { color:var(--text-muted); }
        .status-subtitle { font-size:0.82rem; color:var(--text-muted); margin-bottom:0; }

        /* Progress bar */
        .progress-section { margin:20px 0; }
        .progress-header {
            display:flex; justify-content:space-between; align-items:center;
            margin-bottom:8px;
        }
        .progress-label { font-size:0.75rem; font-weight:700; color:var(--text-muted); }
        .progress-count { font-size:0.78rem; font-weight:800; color:var(--text-main); }
        .progress-track {
            height:10px; background:#F1F5F9; border-radius:100px; overflow:hidden;
        }
        .progress-fill {
            height:100%; border-radius:100px;
            background:linear-gradient(90deg, var(--blue), #3B82F6);
            transition:width 0.4s ease; width:0%;
        }
        .progress-eta { font-size:0.73rem; color:var(--text-faint); margin-top:6px; text-align:right; }

        /* Tips list */
        .tips-box {
            background:#F8FAFC; border:1px solid var(--border);
            border-radius:var(--radius-sm); padding:14px 16px; margin:20px 0;
        }
        .tips-title {
            font-size:0.72rem; font-weight:700; text-transform:uppercase;
            letter-spacing:0.6px; color:var(--text-faint); margin-bottom:10px;
        }
        .tips-list { list-style:none; padding:0; margin:0; display:flex; flex-direction:column; gap:7px; }
        .tips-list li {
            display:flex; align-items:flex-start; gap:9px;
            font-size:0.8rem; color:var(--text-muted); line-height:1.5;
        }
        .tips-check {
            width:18px; height:18px; border-radius:5px;
            background:rgba(16,185,129,0.1); color:var(--success);
            display:flex; align-items:center; justify-content:center;
            font-size:0.6rem; flex-shrink:0; margin-top:1px;
        }

        /* Cancel button */
        .btn-cancel-danger {
            display:inline-flex; align-items:center; gap:7px;
            padding:9px 20px; background:rgba(239,68,68,0.08); color:var(--danger);
            border:1px solid rgba(239,68,68,0.2); border-radius:var(--radius-sm);
            font-size:0.82rem; font-weight:700; cursor:pointer;
            transition:background 0.2s; margin-top:4px;
        }
        .btn-cancel-danger:hover { background:rgba(239,68,68,0.15); }

        /* Start button */
        .btn-start {
            display:flex; align-items:center; justify-content:center; gap:9px;
            width:100%; padding:13px; background:var(--blue); color:#fff;
            border:none; border-radius:var(--radius-sm); font-size:0.9rem;
            font-weight:700; cursor:pointer; transition:background 0.2s, transform 0.1s;
        }
        .btn-start:hover { background:#1558b0; transform:translateY(-1px); }
        .btn-start:active { transform:translateY(0); }

        /* Spinning icon */
        @keyframes spin { to { transform:rotate(360deg); } }
        .spin { display:inline-block; animation:spin 1s linear infinite; }

        /* Camera pulse animation */
        @keyframes pulse {
            0%, 100% { box-shadow:0 0 0 0 rgba(30,111,217,0.3); }
            50%       { box-shadow:0 0 0 10px rgba(30,111,217,0); }
        }
        .pulsing { animation:pulse 1.5s ease infinite; }

        @media (max-width:576px) {
            .page-header { flex-direction:column; align-items:flex-start; }
        }
    </style>
    @endpush

    <div class="page">

        <div class="page-header">
            <div>
                <h1><i class="fas fa-camera" style="color:var(--blue);margin-right:10px;font-size:1.2rem"></i>Daftar Wajah</h1>
                <p>Pendaftaran biometrik wajah untuk akses sistem</p>
            </div>
        </div>

        <div class="face-wrap">

            {{-- ── Status: PENDING / PROCESSING ── --}}
            @if($request && in_array($request->status, ['pending', 'processing']))
            <div class="sd-card" id="card-processing">
                <div class="sd-card-header">
                    <span class="sd-card-title">
                        <i class="fas fa-camera" style="color:var(--blue);margin-right:8px;font-size:0.85rem"></i>
                        Sedang Mendaftarkan Wajah
                    </span>
                    <span style="font-size:0.72rem;font-weight:700;color:var(--warning);background:rgba(245,158,11,0.1);padding:3px 10px;border-radius:100px" id="status-chip">
                        Menunggu...
                    </span>
                </div>
                <div class="sd-card-body">

                    {{-- Icon + Title --}}
                    <div class="status-hero">
                        <div class="status-icon-wrap status-icon-processing" id="status-icon-wrap">
                            <i class="fas fa-spinner spin" id="status-icon"></i>
                        </div>
                        <div class="status-title processing" id="status-title">Menunggu kamera...</div>
                        <p class="status-subtitle" id="face-message">Hadap ke kamera dan pastikan wajah terlihat jelas</p>
                    </div>

                    {{-- Progress --}}
                    <div class="progress-section">
                        <div class="progress-header">
                            <span class="progress-label">Progress Foto</span>
                            <span class="progress-count" id="progress-text">0 / 30</span>
                        </div>
                        <div class="progress-track">
                            <div class="progress-fill" id="progress-bar"></div>
                        </div>
                        <div class="progress-eta" id="eta-text">Estimasi waktu: ~30 detik</div>
                    </div>

                    {{-- Tips --}}
                    <div class="tips-box">
                        <div class="tips-title">Panduan</div>
                        <ul class="tips-list">
                            <li><div class="tips-check"><i class="fas fa-check"></i></div> Pastikan wajah <strong>masuk ke dalam frame</strong></li>
                            <li><div class="tips-check"><i class="fas fa-check"></i></div> Berada di <strong>tempat yang terang</strong></li>
                            <li><div class="tips-check"><i class="fas fa-check"></i></div> <strong>Lepas masker</strong> dan penutup wajah</li>
                            <li><div class="tips-check"><i class="fas fa-check"></i></div> Hadap langsung ke kamera, <strong>jangan miring</strong></li>
                        </ul>
                    </div>

                    {{-- Cancel --}}
                    <div style="text-align:center">
                        <form action="{{ route('face.cancel') }}" method="POST"
                            onsubmit="return confirm('Yakin ingin membatalkan pendaftaran?')">
                            @csrf
                            <button type="submit" class="btn-cancel-danger">
                                <i class="fas fa-times"></i> Batalkan Pendaftaran
                            </button>
                        </form>
                    </div>

                </div>
            </div>

            @push('scripts')
            <script>
                const requestId = {{ $request->id }};
                const apiUrl    = '{{ url("/api/face-requests") }}/' + requestId + '/status';
                let startTime   = Date.now();

                function updateProgress() {
                    fetch(apiUrl)
                        .then(res => res.json())
                        .then(data => {
                            const status   = data.status;
                            const progress = data.progress || 0;
                            const pct      = Math.round((progress / 30) * 100);
                            const elapsed  = Math.round((Date.now() - startTime) / 1000);
                            const eta      = progress > 0
                                           ? Math.round((30 - progress) * (elapsed / progress))
                                           : 30;

                            document.getElementById('progress-bar').style.width = pct + '%';
                            document.getElementById('progress-text').innerText   = progress + ' / 30';

                            if (status === 'processing' && progress > 0) {
                                // Switch to camera icon
                                document.getElementById('status-icon-wrap').className = 'status-icon-wrap status-icon-processing pulsing';
                                document.getElementById('status-icon').className       = 'fas fa-camera';
                                document.getElementById('status-chip').innerText       = 'Mengambil Foto...';
                                document.getElementById('status-title').innerText      = 'Mengambil foto...';
                                document.getElementById('face-message').innerText      = 'Tetap hadap kamera, jangan bergerak!';
                                document.getElementById('eta-text').innerText          = 'Estimasi selesai: ~' + Math.max(0, eta) + ' detik lagi';
                            }

                            if (['done', 'failed', 'cancelled'].includes(status)) {
                                window.location.reload();
                                return;
                            }

                            setTimeout(updateProgress, 1000);
                        })
                        .catch(() => setTimeout(updateProgress, 2000));
                }

                setTimeout(updateProgress, 1000);
            </script>
            @endpush

            {{-- ── Status: DONE ── --}}
            @elseif($request && $request->status === 'done')
            <div class="sd-card">
                <div class="sd-card-body" style="padding:36px 24px">
                    <div class="status-hero">
                        <div class="status-icon-wrap status-icon-success" style="margin-bottom:20px">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="status-title success">Wajah Berhasil Didaftarkan!</div>
                        <p class="status-subtitle">Anda sekarang bisa membuka pintu menggunakan wajah.</p>
                    </div>
                </div>
            </div>

            {{-- ── Status: FAILED ── --}}
            @elseif($request && $request->status === 'failed')
            <div class="sd-card">
                <div class="sd-card-body" style="padding:36px 24px">
                    <div class="status-hero">
                        <div class="status-icon-wrap status-icon-danger" style="margin-bottom:20px">
                            <i class="fas fa-times-circle"></i>
                        </div>
                        <div class="status-title danger">Pendaftaran Gagal</div>
                        <p class="status-subtitle">{{ $request->message }}</p>
                    </div>
                </div>
            </div>

            {{-- ── Status: CANCELLED ── --}}
            @elseif($request && $request->status === 'cancelled')
            <div class="sd-card">
                <div class="sd-card-body" style="padding:36px 24px">
                    <div class="status-hero">
                        <div class="status-icon-wrap status-icon-cancelled" style="margin-bottom:20px">
                            <i class="fas fa-ban"></i>
                        </div>
                        <div class="status-title cancelled">Pendaftaran Dibatalkan</div>
                        <p class="status-subtitle">Anda membatalkan proses pendaftaran wajah.</p>
                    </div>
                </div>
            </div>
            @endif

            {{-- ── Form Mulai Pendaftaran ── --}}
            @if(!$request || in_array($request->status, ['done', 'failed', 'cancelled']))
            <div class="sd-card">
                <div class="sd-card-header">
                    <span class="sd-card-title">
                        <i class="fas fa-camera" style="color:var(--blue);margin-right:8px;font-size:0.85rem"></i>
                        {{ $request?->status === 'done' ? 'Daftar Ulang Wajah' : 'Daftar Wajah' }}
                    </span>
                </div>
                <div class="sd-card-body">

                    <div class="tips-box" style="margin-top:0;margin-bottom:20px">
                        <div class="tips-title">Panduan Sebelum Mendaftar</div>
                        <ul class="tips-list">
                            <li><div class="tips-check"><i class="fas fa-check"></i></div> Pastikan wajah Anda <strong>masuk ke dalam frame kamera</strong></li>
                            <li><div class="tips-check"><i class="fas fa-check"></i></div> Berada di <strong>tempat yang terang</strong></li>
                            <li><div class="tips-check"><i class="fas fa-check"></i></div> <strong>Lepas penutup wajah</strong> (masker, kacamata, dll)</li>
                            <li><div class="tips-check"><i class="fas fa-check"></i></div> Hadap langsung ke kamera, <strong>jangan miring</strong></li>
                            <li><div class="tips-check"><i class="fas fa-check"></i></div> <strong>Diam</strong> selama proses berlangsung (~30 detik)</li>
                        </ul>
                    </div>

                    <form action="{{ route('face.store') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-start">
                            <i class="fas fa-camera"></i> Mulai Pendaftaran Wajah
                        </button>
                    </form>

                </div>
            </div>
            @endif

        </div>

    </div>
</x-app-layout>