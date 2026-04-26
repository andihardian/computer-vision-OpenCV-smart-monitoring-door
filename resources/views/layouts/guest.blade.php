<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Smart Door — {{ $title ?? 'Login' }}</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;300;400;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/startbootstrap-sb-admin-2/4.1.4/css/sb-admin-2.min.css" rel="stylesheet">

    <style>
        body { font-family: 'Nunito', sans-serif; background: #f0f4f8; }
        .bg-login-image { background: linear-gradient(135deg, #1B3A6B 0%, #2563EB 100%); }
        .card-login { border: none; border-radius: 1rem; overflow: hidden; }
        .brand-icon { font-size: 3rem; color: #1B3A6B; }
    </style>
</head>

<body class="bg-gradient-primary">

<div class="container">
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-xl-10 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg card-login my-5">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-flex align-items-center justify-content-center bg-login-image">
                            <div class="text-center text-white p-5">
                                <i class="fas fa-lock mb-4" style="font-size:5rem;opacity:0.9"></i>
                                <h2 class="font-weight-bold mb-3">Smart Door</h2>
                                <p class="mb-0 opacity-75">Sistem Kontrol Akses Pintu Berbasis IoT</p>
                                <hr class="border-white-50 my-4">
                                <small class="opacity-75">Pantau & kelola akses perangkat Anda secara real-time</small>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center mb-4">
                                    <div class="brand-icon d-lg-none mb-2">
                                        <i class="fas fa-lock text-primary"></i>
                                    </div>
                                    {{ $slot }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/startbootstrap-sb-admin-2/4.1.4/js/sb-admin-2.min.js"></script>
</body>
</html>