@extends('layouts.auth')

@section('title', 'Login')

@push('style')
    <!-- CSS Libraries -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('main')

    <body class="pb-0 authentication-bg">
        <div class="auth-fluid">

            <!-- Auth fluid right content -->
            <div class="text-center auth-fluid-right">
                <div class="auth-user-testimonial">
                    <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel">

                        <div class="carousel-inner">

                            <div class="carousel-item active">

                                <h2 class="mb-3">Bergabung dengan SIGALING!</h2>
                                <p class="lead"><i class="ri-double-quotes-l"></i> Jika Anda belum memiliki akun SIGALING
                                    dan ingin bergabung, daftarkan diri Anda sekarang melalui Sistem Informasi Kepegawaian
                                    Leuwiliang!</p>
                                <p>
                                    <a href="{{ route('register') }}" class="btn btn-primary">Daftar Sekarang</a>
                                </p>

                            </div>

                            <!-- Item Carousel Baru -->
                            <div class="carousel-item">
                            </div>

                        </div>

                    </div>
                </div> <!-- end auth-user-testimonial -->
            </div>
            <!-- end Auth fluid right content -->

            <!--Auth fluid left content -->
            <div class="auth-fluid-form-box">
                <div class="gap-3 card-body d-flex flex-column h-100">

                    <!-- Logo -->
                    <div class="text-center auth-brand text-lg-start">
                        <a href="index.html" class="logo-dark">
                            <span><img src="{{ asset('assets/images/logo-dark.png') }}" alt="dark logo"
                                    height="24"></span>
                        </a>
                        <a href="index.html" class="logo-light">
                            <span><img src="{{ asset('assets/images/logo.png') }}" alt="logo" height="24"></span>
                        </a>
                    </div>

                    <div class="my-auto">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        <h4 class="mt-0">Sign In</h4>
                        <p class="mb-4 text-muted">Masukkan alamat email dan kata sandi Anda untuk mengakses Sistem
                            Informasi Kepegawaian Leuwiliang.</p>

                        <!-- form -->
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="emailaddress" class="form-label">No Kartu atau Email</label>
                                <input class="form-control @error('email') is-invalid @enderror" type="text"
                                    id="emailaddress" name="email" value="{{ old('email') }}" required
                                    placeholder="Masukkan No Kartu atau Email">
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <a href="{{ route('password.request') }}" class="text-muted float-end"><small>Lupa kata
                                        sandi?</small></a>
                                <label for="password" class="form-label">Kata Sandi</label>
                                <input class="form-control @error('password') is-invalid @enderror" type="password"
                                    id="password" name="password" required placeholder="Masukkan kata sandi Anda">
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="checkbox-signin" name="remember">
                                    <label class="form-check-label" for="checkbox-signin">Ingat saya</label>
                                </div>
                            </div>
                            <div class="mb-0 text-center d-grid">
                                <button class="btn btn-primary" type="submit"><i class="ri-login-box-line"></i>
                                    Masuk</button>
                            </div>

                        </form>
                        <!-- end form -->
                        <div class="mb-3 mt-4">
                            <p class="text-muted">Belum punya akun? <a href="{{ route('register') }}"
                                    class="text-muted ms-1">
                                    <b>Daftar di Sistem Informasi Kepegawaian Leuwiliang</b></a></p>
                        </div>
                    </div>
                </div> <!-- end .card-body -->
            </div>
            <!-- end auth-fluid-form-box-->
        </div>
        <!-- end auth-fluid-->
    @endsection

    @push('scripts')
        <!-- Vendor js -->
        <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
        <!-- App js -->
        <script src="{{ asset('assets/js/app.min.js') }}"></script>
    @endpush
