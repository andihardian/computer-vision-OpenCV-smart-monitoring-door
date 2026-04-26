<x-app-layout>
    <x-slot name="title">Profil Saya</x-slot>

    <div class="row justify-content-center">
        <div class="col-lg-7">

            {{-- Update Profile --}}
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Profil</h6>
                </div>
                <div class="card-body">
                    @if(session('status') === 'profile-updated')
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            Profil berhasil diperbarui.
                            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PATCH')

                        <div class="form-group">
                            <label class="font-weight-bold small">Nama</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                class="form-control @error('name') is-invalid @enderror" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold small">Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                class="form-control @error('email') is-invalid @enderror" required>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold small">Role</label>
                            <input type="text" value="{{ ucfirst($user->role) }}"
                                class="form-control bg-light text-muted" readonly>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i> Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>

            {{-- Update Password --}}
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Ubah Password</h6>
                </div>
                <div class="card-body">
                    @if(session('status') === 'password-updated')
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            Password berhasil diperbarui.
                            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label class="font-weight-bold small">Password Saat Ini</label>
                            <input type="password" name="current_password"
                                class="form-control @error('current_password', 'updatePassword') is-invalid @enderror">
                            @error('current_password', 'updatePassword')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold small">Password Baru</label>
                            <input type="password" name="password"
                                class="form-control @error('password', 'updatePassword') is-invalid @enderror">
                            @error('password', 'updatePassword')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold small">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>

                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-key mr-1"></i> Ubah Password
                        </button>
                    </form>
                </div>
            </div>

            {{-- Hapus Akun --}}
            <div class="card shadow mb-4 border-left-danger">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-danger">Hapus Akun</h6>
                </div>
                <div class="card-body">
                    <p class="text-muted small">Setelah akun dihapus, semua data akan hilang permanen.</p>

                    <form method="POST" action="{{ route('profile.destroy') }}"
                        onsubmit="return confirm('Yakin ingin menghapus akun ini? Tindakan ini tidak bisa dibatalkan.')">
                        @csrf
                        @method('DELETE')

                        <div class="form-group">
                            <label class="font-weight-bold small">Konfirmasi Password</label>
                            <input type="password" name="password"
                                class="form-control @error('password', 'userDeletion') is-invalid @enderror">
                            @error('password', 'userDeletion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash mr-1"></i> Hapus Akun Saya
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>