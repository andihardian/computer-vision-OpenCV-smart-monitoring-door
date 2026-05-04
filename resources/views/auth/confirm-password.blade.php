<x-guest-layout>
    <x-slot name="leftPanel">
        <div class="auth-left-body">
            <h2>Area Aman</h2>
            <p>Halaman ini dilindungi. Konfirmasi identitas Anda sebelum mengakses area sensitif.</p>
        </div>
        <div class="auth-left-footer">
            <div class="left-warn-box">
                <i class="fas fa-lock"></i>
                <p>Autentikasi ulang diperlukan untuk melindungi keamanan akun Anda dari akses yang tidak sah.</p>
            </div>
        </div>
    </x-slot>

    <div class="auth-icon-badge amber">
        <i class="fas fa-lock"></i>
    </div>

    <h1 class="auth-heading">Konfirmasi Password</h1>
    <p class="auth-sub">Ini adalah area aman. Konfirmasi password Anda untuk melanjutkan ke halaman berikutnya.</p>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <div class="auth-group">
            <label class="auth-label">Password</label>
            <input type="password" name="password"
                class="auth-input @error('password') is-invalid @enderror"
                placeholder="Masukkan password Anda"
                autocomplete="current-password" required>
            @error('password')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="auth-btn">
            <i class="fas fa-check-circle"></i> Konfirmasi
        </button>
    </form>
</x-guest-layout>