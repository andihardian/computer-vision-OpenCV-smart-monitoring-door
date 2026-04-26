<x-guest-layout>
    <x-slot name="title">Register</x-slot>

    <h1 class="h4 text-gray-900 mb-1 font-weight-bold text-left">Buat Akun Baru</h1>
    <p class="text-muted small mb-4 text-left">Isi formulir berikut untuk mendaftar</p>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="form-group">
            <label class="small font-weight-bold text-gray-700">Nama Lengkap</label>
            <input type="text" name="name" value="{{ old('name') }}"
                class="form-control form-control-user @error('name') is-invalid @enderror"
                placeholder="Nama lengkap..." autofocus>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="small font-weight-bold text-gray-700">Alamat Email</label>
            <input type="email" name="email" value="{{ old('email') }}"
                class="form-control form-control-user @error('email') is-invalid @enderror"
                placeholder="Masukkan email...">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group row">
            <div class="col-sm-6 mb-3 mb-sm-0">
                <label class="small font-weight-bold text-gray-700">Password</label>
                <input type="password" name="password"
                    class="form-control form-control-user @error('password') is-invalid @enderror"
                    placeholder="••••••••">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-sm-6">
                <label class="small font-weight-bold text-gray-700">Konfirmasi Password</label>
                <input type="password" name="password_confirmation"
                    class="form-control form-control-user"
                    placeholder="••••••••">
            </div>
        </div>

        <button type="submit" class="btn btn-primary btn-user btn-block font-weight-bold">
            <i class="fas fa-user-plus mr-2"></i> Daftar
        </button>

        <hr>
        <div class="text-center">
            <a href="{{ route('login') }}" class="small text-primary">Sudah punya akun? Masuk</a>
        </div>
    </form>
</x-guest-layout>