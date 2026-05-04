<x-guest-layout>
    <x-slot name="leftPanel">
        <div class="auth-left-body">
            <h2>Buat Password Baru</h2>
            <p>Pilih password yang kuat untuk menjaga keamanan akun Anda.</p>
        </div>
        <div class="auth-left-footer">
            <div class="left-tip-list">
                <div class="left-tip-item"><i class="fas fa-check"></i>Minimal 8 karakter</div>
                <div class="left-tip-item"><i class="fas fa-check"></i>Kombinasi huruf besar & kecil</div>
                <div class="left-tip-item"><i class="fas fa-check"></i>Sertakan angka & karakter spesial</div>
                <div class="left-tip-item"><i class="fas fa-check"></i>Jangan gunakan informasi pribadi</div>
            </div>
        </div>
    </x-slot>

    <div class="auth-icon-badge green">
        <i class="fas fa-key"></i>
    </div>

    <h1 class="auth-heading">Reset Password</h1>
    <p class="auth-sub">Masukkan password baru Anda. Pastikan mudah diingat namun sulit ditebak.</p>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="auth-group">
            <label class="auth-label">Email</label>
            <input type="email" name="email"
                value="{{ old('email', $request->email) }}"
                class="auth-input @error('email') is-invalid @enderror"
                placeholder="nama@email.com"
                autocomplete="username" autofocus required>
            @error('email')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="auth-row-2">
            <div class="auth-group">
                <label class="auth-label">Password Baru</label>
                <input type="password" name="password"
                    class="auth-input @error('password') is-invalid @enderror"
                    placeholder="••••••••"
                    autocomplete="new-password" required>
                @error('password')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
            <div class="auth-group">
                <label class="auth-label">Konfirmasi Password</label>
                <input type="password" name="password_confirmation"
                    class="auth-input @error('password_confirmation') is-invalid @enderror"
                    placeholder="••••••••"
                    autocomplete="new-password" required>
                @error('password_confirmation')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <button type="submit" class="auth-btn" style="margin-top:4px">
            <i class="fas fa-save"></i> Simpan Password Baru
        </button>
    </form>
</x-guest-layout>