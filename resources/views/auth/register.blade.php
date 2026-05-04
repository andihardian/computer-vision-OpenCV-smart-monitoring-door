<x-guest-layout>
    <x-slot name="title">Register</x-slot>

    <x-slot name="leftPanel">
        <div class="auth-left-body">
            <h2>Buat Akun Baru</h2>
            <p>Daftarkan diri Anda untuk mulai mengelola sistem akses dengan mudah dan aman.</p>
        </div>
        <div class="auth-left-footer">
            <div class="left-step-list">
                <div class="left-step-item">
                    <div class="left-step-num">1</div>
                    <div class="left-step-text">
                        <strong>Isi Data Diri</strong>
                        Lengkapi formulir pendaftaran
                    </div>
                </div>
                <div class="left-step-item">
                    <div class="left-step-num">2</div>
                    <div class="left-step-text">
                        <strong>Verifikasi Email</strong>
                        Konfirmasi melalui email Anda
                    </div>
                </div>
                <div class="left-step-item">
                    <div class="left-step-num">3</div>
                    <div class="left-step-text">
                        <strong>Mulai Gunakan</strong>
                        Akses semua fitur sistem
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <h1 class="auth-heading">Buat Akun Baru</h1>
    <p class="auth-sub">Isi formulir berikut untuk mendaftar</p>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="auth-group">
            <label class="auth-label">Nama Lengkap</label>
            <input type="text" name="name" value="{{ old('name') }}"
                class="auth-input @error('name') is-invalid @enderror"
                placeholder="Nama lengkap Anda" autofocus>
            @error('name')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="auth-group">
            <label class="auth-label">Alamat Email</label>
            <input type="email" name="email" value="{{ old('email') }}"
                class="auth-input @error('email') is-invalid @enderror"
                placeholder="nama@email.com">
            @error('email')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="auth-row-2">
            <div class="auth-group">
                <label class="auth-label">Password</label>
                <input type="password" name="password"
                    class="auth-input @error('password') is-invalid @enderror"
                    placeholder="••••••••">
                @error('password')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
            <div class="auth-group">
                <label class="auth-label">Konfirmasi Password</label>
                <input type="password" name="password_confirmation"
                    class="auth-input"
                    placeholder="••••••••">
            </div>
        </div>

        <button type="submit" class="auth-btn" style="margin-top:4px">
            <i class="fas fa-user-plus"></i> Daftar
        </button>

        <div class="auth-divider">atau</div>
        <div class="auth-footer">
            Sudah punya akun? <a href="{{ route('login') }}" class="auth-link">Masuk sekarang</a>
        </div>
    </form>
</x-guest-layout>