<x-guest-layout>
    <x-slot name="leftPanel">
        <div class="auth-left-body">
            <h2>Reset Password Anda</h2>
            <p>Kami akan mengirimkan tautan reset password ke alamat email yang Anda daftarkan.</p>
        </div>
        <div class="auth-left-footer">
            <div class="left-info-box">
                <i class="fas fa-info-circle" style="margin-right:7px;color:rgba(255,255,255,0.45)"></i>
                Periksa folder spam jika email tidak masuk dalam beberapa menit setelah permintaan dikirim.
            </div>
        </div>
    </x-slot>

    <div class="auth-icon-badge blue">
        <i class="fas fa-envelope-open-text"></i>
    </div>

    <h1 class="auth-heading">Lupa Password?</h1>
    <p class="auth-sub">Masukkan email Anda dan kami akan mengirimkan tautan untuk membuat password baru.</p>

    <x-auth-session-status class="auth-alert-success" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="auth-group">
            <label class="auth-label">Alamat Email</label>
            <input type="email" name="email" value="{{ old('email') }}"
                class="auth-input @error('email') is-invalid @enderror"
                placeholder="nama@email.com" autofocus required>
            @error('email')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="auth-btn">
            <i class="fas fa-paper-plane"></i> Kirim Link Reset Password
        </button>

        <div style="margin-top:18px;text-align:center">
            <a href="{{ route('login') }}" class="auth-link" style="font-size:0.82rem">
                ← Kembali ke halaman login
            </a>
        </div>
    </form>
</x-guest-layout>