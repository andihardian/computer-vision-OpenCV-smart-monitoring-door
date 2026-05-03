<x-app-layout>
    <x-slot name="title">Edit User</x-slot>

    @push('styles')
    <style>
        :root {
            --blue:       #1E6FD9;
            --danger:     #EF4444;
            --warning:    #F59E0B;
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

        .page-header {
            display:flex; align-items:center; justify-content:space-between;
            margin-bottom:28px; flex-wrap:wrap; gap:12px;
        }
        .page-header h1 { font-size:1.5rem; font-weight:800; color:var(--text-main); margin:0 0 2px; letter-spacing:-0.3px; }
        .page-header p  { font-size:0.82rem; color:var(--text-muted); margin:0; }

        .btn-back {
            display:inline-flex; align-items:center; gap:7px;
            padding:8px 16px; background:#F1F5F9; color:var(--text-muted);
            border:1px solid var(--border); border-radius:var(--radius-sm);
            font-size:0.82rem; font-weight:600; text-decoration:none; transition:background 0.15s;
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
            background:rgba(245,158,11,0.1); color:var(--warning);
            display:flex; align-items:center; justify-content:center; font-size:0.9rem;
        }
        .form-card-title { font-size:0.95rem; font-weight:700; color:var(--text-main); margin:0; }
        .form-card-body  { padding:24px; }

        /* Section label */
        .section-label {
            font-size:0.68rem; font-weight:700; text-transform:uppercase;
            letter-spacing:0.8px; color:var(--text-faint); margin-bottom:16px;
            display:flex; align-items:center; gap:8px;
        }
        .section-label::after { content:''; flex:1; height:1px; background:var(--border); }

        /* Fields */
        .field-group { margin-bottom:18px; }
        .field-row   { display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:0; }
        .field-label {
            display:block; font-size:0.78rem; font-weight:700;
            color:var(--text-main); margin-bottom:8px;
        }
        .field-required { color:var(--danger); margin-left:2px; }
        .field-input {
            width:100%; padding:10px 14px; border:1.5px solid var(--border);
            border-radius:var(--radius-sm); font-size:0.85rem; color:var(--text-main);
            background:#fff; outline:none; transition:border-color 0.2s, box-shadow 0.2s;
            box-sizing:border-box;
        }
        .field-input:focus  { border-color:var(--blue); box-shadow:0 0 0 3px rgba(30,111,217,0.1); }
        .field-input.is-invalid { border-color:var(--danger); }
        .field-error { font-size:0.75rem; color:var(--danger); margin-top:5px; display:flex; align-items:center; gap:5px; }

        /* Role selector */
        .role-grid { display:grid; grid-template-columns:1fr 1fr; gap:10px; }
        .role-option { position:relative; }
        .role-option input[type="radio"] { position:absolute; opacity:0; width:0; height:0; }
        .role-card {
            display:flex; align-items:center; gap:12px; padding:14px 16px;
            border:1.5px solid var(--border); border-radius:var(--radius-sm);
            cursor:pointer; transition:border-color 0.2s, background 0.2s;
        }
        .role-option input:checked + .role-card { border-color:var(--blue); background:rgba(30,111,217,0.05); }
        .role-card:hover { border-color:#93C5FD; background:#F8FBFF; }
        .role-icon {
            width:36px; height:36px; border-radius:9px;
            display:flex; align-items:center; justify-content:center; font-size:0.85rem; flex-shrink:0;
        }
        .role-icon-user  { background:rgba(100,116,139,0.1); color:var(--text-muted); }
        .role-icon-admin { background:rgba(30,111,217,0.1);  color:var(--blue); }
        .role-name { font-size:0.82rem; font-weight:700; color:var(--text-main); }
        .role-desc { font-size:0.72rem; color:var(--text-faint); margin-top:1px; }

        /* Password box */
        .pw-box {
            background:#F8FAFC; border:1px solid var(--border);
            border-radius:var(--radius-sm); padding:18px; margin-top:20px;
        }
        .pw-box-title {
            font-size:0.78rem; font-weight:700; color:var(--text-main);
            margin-bottom:6px; display:flex; align-items:center; gap:7px;
        }
        .pw-box-hint { font-size:0.75rem; color:var(--text-faint); margin-bottom:16px; }

        .form-divider { border:none; border-top:1px solid var(--border); margin:24px 0; }
        .form-actions { display:flex; justify-content:flex-end; gap:10px; }
        .btn-cancel {
            display:inline-flex; align-items:center; gap:6px;
            padding:9px 18px; background:#F1F5F9; color:var(--text-muted);
            border:1px solid var(--border); border-radius:var(--radius-sm);
            font-size:0.82rem; font-weight:600; text-decoration:none; transition:background 0.15s;
        }
        .btn-cancel:hover { background:#E2E8F0; color:var(--text-main); }
        .btn-submit {
            display:inline-flex; align-items:center; gap:7px;
            padding:9px 22px; background:var(--blue); color:#fff;
            border:none; border-radius:var(--radius-sm); font-size:0.82rem;
            font-weight:700; cursor:pointer; transition:background 0.2s, transform 0.1s;
        }
        .btn-submit:hover { background:#1558b0; transform:translateY(-1px); }

        @media (max-width:576px) {
            .page-header { flex-direction:column; align-items:flex-start; }
            .field-row   { grid-template-columns:1fr; }
            .role-grid   { grid-template-columns:1fr; }
        }
    </style>
    @endpush

    <div class="page">

        <div class="page-header">
            <div>
                <h1><i class="fas fa-user-edit" style="color:var(--warning);margin-right:10px;font-size:1.2rem"></i>Edit User</h1>
                <p>Perbarui data akun <strong>{{ $user->name }}</strong></p>
            </div>
            <a href="{{ route('users.index') }}" class="btn-back">
                <i class="fas fa-arrow-left fa-sm"></i> Kembali
            </a>
        </div>

        <div class="form-card">
            <div class="form-card-header">
                <div class="form-card-icon"><i class="fas fa-user-edit"></i></div>
                <h6 class="form-card-title">Edit Data User — {{ $user->name }}</h6>
            </div>
            <div class="form-card-body">
                <form action="{{ route('users.update', $user) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="section-label">Informasi Akun</div>

                    <div class="field-group">
                        <label class="field-label">Nama Lengkap <span class="field-required">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}"
                            class="field-input {{ $errors->has('name') ? 'is-invalid' : '' }}">
                        @error('name')
                            <div class="field-error"><i class="fas fa-exclamation-circle"></i>{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="field-group">
                        <label class="field-label">Email <span class="field-required">*</span></label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}"
                            class="field-input {{ $errors->has('email') ? 'is-invalid' : '' }}">
                        @error('email')
                            <div class="field-error"><i class="fas fa-exclamation-circle"></i>{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="field-group">
                        <label class="field-label">Role <span class="field-required">*</span></label>
                        <div class="role-grid">
                            <label class="role-option">
                                <input type="radio" name="role" value="user" {{ old('role', $user->role) === 'user' ? 'checked' : '' }}>
                                <div class="role-card">
                                    <div class="role-icon role-icon-user"><i class="fas fa-user"></i></div>
                                    <div>
                                        <div class="role-name">User</div>
                                        <div class="role-desc">Akses terbatas</div>
                                    </div>
                                </div>
                            </label>
                            <label class="role-option">
                                <input type="radio" name="role" value="admin" {{ old('role', $user->role) === 'admin' ? 'checked' : '' }}>
                                <div class="role-card">
                                    <div class="role-icon role-icon-admin"><i class="fas fa-shield-alt"></i></div>
                                    <div>
                                        <div class="role-name">Admin</div>
                                        <div class="role-desc">Akses penuh</div>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>

                    {{-- Password Section --}}
                    <div class="pw-box">
                        <div class="pw-box-title">
                            <i class="fas fa-lock" style="color:var(--blue)"></i>
                            Ubah Password
                        </div>
                        <div class="pw-box-hint">
                            Kosongkan kedua field jika tidak ingin mengubah password.
                        </div>
                        <div class="field-row">
                            <div>
                                <label class="field-label">Password Baru</label>
                                <input type="password" name="password"
                                    class="field-input {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                    placeholder="Min. 8 karakter">
                                @error('password')
                                    <div class="field-error"><i class="fas fa-exclamation-circle"></i>{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label class="field-label">Konfirmasi Password Baru</label>
                                <input type="password" name="password_confirmation"
                                    class="field-input" placeholder="Ulangi password baru">
                            </div>
                        </div>
                    </div>

                    <hr class="form-divider">

                    <div class="form-actions">
                        <a href="{{ route('users.index') }}" class="btn-cancel">Batal</a>
                        <button type="submit" class="btn-submit">
                            <i class="fas fa-save"></i> Update User
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>