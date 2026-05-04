<x-guest-layout>
    <x-slot name="leftPanel">
        <div class="auth-left-body">
            <h2>Verifikasi Email Anda</h2>
            <p>Langkah terakhir sebelum Anda dapat menggunakan semua fitur sistem.</p>
        </div>
        <div class="auth-left-footer">
            <div class="left-vstep-list">
                <div class="left-vstep-item">
                    <div class="left-vstep-icon"><i class="fas fa-user-plus"></i></div>
                    <div class="left-vstep-text">Akun berhasil dibuat</div>
                </div>
                <div class="left-vstep-item">
                    <div class="left-vstep-icon"><i class="fas fa-envelope"></i></div>
                    <div class="left-vstep-text">Email verifikasi telah dikirimkan</div>
                </div>
                <div class="left-vstep-item">
                    <div class="left-vstep-icon"><i class="fas fa-check"></i></div>
                    <div class="left-vstep-text">Klik tautan di email untuk verifikasi</div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="verify-circle-wrap">
        <div class="verify-circle">
            <i class="fas fa-envelope"></i>
        </div>
    </div>

    <h1 class="auth-heading" style="text-align:center">Cek Email Anda</h1>
    <p class="auth-sub" style="text-align:center">
        Kami telah mengirimkan tautan verifikasi ke alamat email Anda. Klik tautan tersebut untuk mengaktifkan akun.
    </p>

    @if (session('status') == 'verification-link-sent')
        <div class="auth-alert-success">
            <i class="fas fa-check-circle"></i>
            Tautan verifikasi baru telah dikirim ke email Anda.
        </div>
    @endif

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" class="auth-btn">
            <i class="fas fa-redo"></i> Kirim Ulang Email Verifikasi
        </button>
    </form>

    <div class="auth-divider">atau</div>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="auth-btn-outline">
            <i class="fas fa-sign-out-alt"></i> Keluar dari Akun
        </button>
    </form>
</x-guest-layout>