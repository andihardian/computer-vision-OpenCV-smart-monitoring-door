<x-guest-layout>
    <x-slot name="title">Login</x-slot>

    <h1 class="h4 text-gray-900 mb-1 font-weight-bold text-left">Masuk ke Sistem</h1>
    <p class="text-muted small mb-4 text-left">Masukkan kredensial Anda untuk melanjutkan</p>

    @if(session('status'))
        <div class="alert alert-info small">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group">
            <label class="small font-weight-bold text-gray-700">Alamat Email</label>
            <input type="email" name="email" value="{{ old('email') }}"
                class="form-control form-control-user @error('email') is-invalid @enderror"
                placeholder="Masukkan email..." autofocus>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="small font-weight-bold text-gray-700">Password</label>
            <input type="password" name="password"
                class="form-control form-control-user @error('password') is-invalid @enderror"
                placeholder="Masukkan Sandi">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group d-flex justify-content-between align-items-center">
            <div class="custom-control custom-checkbox small">
                <input type="checkbox" class="custom-control-input" id="rememberMe" name="remember">
                <label class="custom-control-label" for="rememberMe">Ingat saya</label>
            </div>
            @if(Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="small text-primary">Lupa password?</a>
            @endif
        </div>

        <button type="submit" class="btn btn-primary btn-user btn-block font-weight-bold">
            <i class="fas fa-sign-in-alt mr-2"></i> Masuk
        </button>

        @if(Route::has('register'))
            <hr>
            <div class="text-center">
                <a href="{{ route('register') }}" class="small text-primary">Belum punya akun? Daftar</a>
            </div>
        @endif
    </form>
</x-guest-layout>