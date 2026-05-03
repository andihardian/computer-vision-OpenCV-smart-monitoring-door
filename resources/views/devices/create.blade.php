<x-app-layout>
    <x-slot name="title">Tambah Device</x-slot>

    @push('styles')
    <style>
        :root {
            --navy:       #0F2044;
            --blue:       #1E6FD9;
            --success:    #10B981;
            --danger:     #EF4444;
            --info:       #06B6D4;
            --card:       #FFFFFF;
            --border:     #E2E8F0;
            --text-main:  #0F2044;
            --text-muted: #64748B;
            --text-faint: #94A3B8;
            --radius:     16px;
            --radius-sm:  10px;
            --shadow:     0 2px 16px rgba(15,32,68,0.08);
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

        /* Back button */
        .btn-back {
            display:inline-flex; align-items:center; gap:7px;
            padding:8px 16px; background:#F1F5F9; color:var(--text-muted);
            border:1px solid var(--border); border-radius:var(--radius-sm);
            font-size:0.82rem; font-weight:600; text-decoration:none;
            transition:background 0.15s;
        }
        .btn-back:hover { background:#E2E8F0; color:var(--text-main); }

        /* Form Card */
        .form-card {
            background:var(--card); border-radius:var(--radius);
            border:1px solid var(--border); box-shadow:var(--shadow);
            overflow:hidden; max-width:680px; margin:0 auto;
        }
        .form-card-header {
            padding:20px 24px 18px; border-bottom:1px solid var(--border);
            display:flex; align-items:center; gap:12px;
        }
        .form-card-icon {
            width:36px; height:36px; border-radius:10px;
            background:rgba(30,111,217,0.1); color:var(--blue);
            display:flex; align-items:center; justify-content:center; font-size:0.9rem;
        }
        .form-card-title { font-size:0.95rem; font-weight:700; color:var(--text-main); margin:0; }
        .form-card-body { padding:24px; }

        /* Form fields */
        .field-group { margin-bottom:20px; }
        .field-label {
            display:block; font-size:0.78rem; font-weight:700;
            color:var(--text-main); margin-bottom:8px; letter-spacing:0.2px;
        }
        .field-required { color:var(--danger); margin-left:2px; }
        .field-input {
            width:100%; padding:10px 14px; border:1.5px solid var(--border);
            border-radius:var(--radius-sm); font-size:0.85rem; color:var(--text-main);
            background:#fff; outline:none; transition:border-color 0.2s, box-shadow 0.2s;
            box-sizing:border-box;
        }
        .field-input:focus { border-color:var(--blue); box-shadow:0 0 0 3px rgba(30,111,217,0.1); }
        .field-input.is-invalid { border-color:var(--danger); }
        .field-error { font-size:0.75rem; color:var(--danger); margin-top:5px; display:flex; align-items:center; gap:5px; }

        /* Info box */
        .info-box {
            display:flex; gap:12px; align-items:flex-start;
            background:rgba(6,182,212,0.07); border:1px solid rgba(6,182,212,0.2);
            border-radius:var(--radius-sm); padding:14px 16px;
            margin-bottom:24px;
        }
        .info-box i { color:var(--info); margin-top:2px; flex-shrink:0; }
        .info-box p { margin:0; font-size:0.8rem; color:var(--text-muted); line-height:1.6; }

        /* Divider */
        .form-divider { border:none; border-top:1px solid var(--border); margin:24px 0; }

        /* Form actions */
        .form-actions { display:flex; justify-content:flex-end; gap:10px; align-items:center; }
        .btn-cancel {
            display:inline-flex; align-items:center; gap:6px;
            padding:9px 18px; background:#F1F5F9; color:var(--text-muted);
            border:1px solid var(--border); border-radius:var(--radius-sm);
            font-size:0.82rem; font-weight:600; text-decoration:none;
            transition:background 0.15s;
        }
        .btn-cancel:hover { background:#E2E8F0; color:var(--text-main); }
        .btn-submit {
            display:inline-flex; align-items:center; gap:7px;
            padding:9px 22px; background:var(--blue); color:#fff;
            border:none; border-radius:var(--radius-sm); font-size:0.82rem;
            font-weight:700; cursor:pointer; transition:background 0.2s, transform 0.1s;
        }
        .btn-submit:hover { background:#1558b0; transform:translateY(-1px); }
        .btn-submit:active { transform:translateY(0); }

        @media (max-width:576px) {
            .page-header { flex-direction:column; align-items:flex-start; }
        }
    </style>
    @endpush

    <div class="page">

        {{-- Header --}}
        <div class="page-header">
            <div>
                <h1><i class="fas fa-plus-circle" style="color:var(--blue);margin-right:10px;font-size:1.2rem"></i>Tambah Device</h1>
                <p>Daftarkan perangkat baru ke dalam sistem</p>
            </div>
            <a href="{{ route('devices.index') }}" class="btn-back">
                <i class="fas fa-arrow-left fa-sm"></i> Kembali
            </a>
        </div>

        {{-- Form Card --}}
        <div class="form-card">
            <div class="form-card-header">
                <div class="form-card-icon"><i class="fas fa-microchip"></i></div>
                <h6 class="form-card-title">Informasi Device</h6>
            </div>
            <div class="form-card-body">
                <form action="{{ route('devices.store') }}" method="POST">
                    @csrf

                    <div class="field-group">
                        <label class="field-label">
                            Nama Device <span class="field-required">*</span>
                        </label>
                        <input type="text" name="name" value="{{ old('name') }}"
                            class="field-input {{ $errors->has('name') ? 'is-invalid' : '' }}"
                            placeholder="Contoh: Raspberry Pi - Pintu Utama">
                        @error('name')
                            <div class="field-error"><i class="fas fa-exclamation-circle"></i>{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="field-group">
                        <label class="field-label">Lokasi</label>
                        <input type="text" name="location" value="{{ old('location') }}"
                            class="field-input {{ $errors->has('location') ? 'is-invalid' : '' }}"
                            placeholder="Contoh: Depan, Belakang, Lantai 2">
                        @error('location')
                            <div class="field-error"><i class="fas fa-exclamation-circle"></i>{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="info-box">
                        <i class="fas fa-info-circle"></i>
                        <p>Token akan dibuat secara otomatis setelah device disimpan. Token digunakan untuk autentikasi perangkat ke API sistem.</p>
                    </div>

                    <hr class="form-divider">

                    <div class="form-actions">
                        <a href="{{ route('devices.index') }}" class="btn-cancel">Batal</a>
                        <button type="submit" class="btn-submit">
                            <i class="fas fa-save"></i> Simpan Device
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>