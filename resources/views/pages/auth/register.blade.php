<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Register | Sistem Informasi Kepegawaian Leuwiliang</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Sistem Informasi Kepegawaian Leuwiliang" name="description" />
    <meta content="Author" name="author" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!-- App css -->
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />
    <!-- Icons css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
</head>

<body class="pb-0 authentication-bg">

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="auth-fluid">
        <div class="text-center auth-fluid-right">
            <div class="auth-user-testimonial">
                <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <h2 class="mb-3">Bergabung dengan SIGALING!</h2>
                            <p class="lead"><i class="ri-double-quotes-l"></i> Jika Anda belum memiliki akun SIGALING
                                dan ingin bergabung, daftarkan diri Anda sekarang melalui Sistem Informasi Kepegawaian
                                Leuwiliang!</p>
                            <p>
                                <a href="{{ route('register') }}" class="btn btn-primary">Daftar Sekarang</a>
                            </p>

                        </div>
                    </div>
                </div>
            </div> <!-- end auth-user-testimonial-->
        </div>
        <div class="auth-fluid-form-box">
            <div class="gap-3 card-body d-flex flex-column h-100">
                <div class="my-auto">
                    <h4 class="mt-3">Daftar Akun</h4>
                    <p class="mb-4 text-muted">Belum punya akun? Buat akun baru di Sistem Informasi Kepegawaian
                        Leuwiliang di sini.</p>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Form Register -->
                    <form action="{{ route('register') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <input class="form-control" type="text" id="name" name="name"
                                placeholder="Masukkan nama Anda" value="{{ old('name') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">Nomor Whatsapp</label>
                            <input class="form-control" type="text" id="phone" name="phone"
                                placeholder="Masukkan nomor whatsapp" value="{{ old('phone') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="email2" class="form-label">Email</label>
                            <input class="form-control" type="email" id="email2" name="email2"
                                placeholder="Masukkan email Anda" value="{{ old('email2') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Kata Sandi</label>
                            <input class="form-control" type="password" id="password" name="password"
                                placeholder="Masukkan kata sandi" required>
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
                            <input class="form-control" type="password" id="password_confirmation"
                                name="password_confirmation" placeholder="Ulangi kata sandi" required>
                        </div>

                        <div class="mb-0 text-center d-grid">
                            <button class="btn btn-primary fw-semibold" type="submit">Daftar</button>
                        </div>
                    </form>
                    <!-- End Form Register -->
                </div>

                <!-- Footer -->
                <footer class="footer footer-alt">
                    <p class="text-muted">Sudah punya akun? <a href="{{ route('login') }}"
                            class="text-muted ms-1"><b>Masuk</b></a></p>
                </footer>

            </div> <!-- end card-body -->
        </div> <!-- end auth-fluid-form-box-->
    </div> <!-- end auth-fluid -->

    <!-- Vendor js -->
    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
    <!-- App js -->
    <script src="{{ asset('assets/js/app.min.js') }}"></script>

</body>

</html>
