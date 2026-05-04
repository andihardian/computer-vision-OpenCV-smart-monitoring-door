<x-guest-layout>
    <x-slot name="title">Login</x-slot>

    <x-slot name="leftPanel">
        <div class="auth-left-body">
            <h2>Selamat Datang Kembali</h2>
            <p>Masuk ke sistem manajemen akses untuk memantau dan mengelola perangkat Anda.</p>
        </div>
        <div class="auth-left-footer">
            <div class="left-feature-list">
                <div class="left-feature-item"><div class="left-feature-dot"></div>Monitoring akses real-time</div>
                <div class="left-feature-item"><div class="left-feature-dot"></div>Manajemen perangkat terpusat</div>
                <div class="left-feature-item"><div class="left-feature-dot"></div>Log & laporan lengkap</div>
            </div>
        </div>
    </x-slot>

    <h1 class="auth-heading">Masuk ke Sistem</h1>
    <p class="auth-sub">Masukkan kredensial Anda untuk melanjutkan</p>

    @if(session('status'))
        <div class="auth-alert-info">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="auth-group">
            <label class="auth-label">Alamat Email</label>
            <input type="email" name="email" value="{{ old('email') }}"
                class="auth-input @error('email') is-invalid @enderror"
                placeholder="nama@email.com" autofocus>
            @error('email')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="auth-group">
            <label class="auth-label">Password</label>
            <input type="password" name="password"
                class="auth-input @error('password') is-invalid @enderror"
                placeholder="••••••••">
            @error('password')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="auth-row-between">
            <label class="auth-check">
                <input type="checkbox" name="remember" id="rememberMe">
                <span>Ingat saya</span>
            </label>
            @if(Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="auth-link">Lupa password?</a>
            @endif
        </div>

        <button type="submit" class="auth-btn">
            <i class="fas fa-sign-in-alt"></i> Masuk
        </button>

        @if(Route::has('register'))
            <div class="auth-divider">atau</div>
            <div class="auth-footer">
                Belum punya akun? <a href="{{ route('register') }}" class="auth-link">Daftar sekarang</a>
            </div>
        @endif
    </form>
</x-guest-layout>