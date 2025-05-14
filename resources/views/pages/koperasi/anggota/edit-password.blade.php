@extends('layouts.app')

@section('title', 'Edit Password')

@section('main')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box justify-content-between d-flex align-items-md-center flex-md-row flex-column">
                    <h4 class="page-title">Daftar Merek</h4>
                    <ol class="m-0 breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
                        <li class="breadcrumb-item active">Data Tables</li>
                    </ol>
                </div>
            </div>
        </div>
        @if (session('success'))
            <div class="border-0 alert alert-success alert-dismissible text-bg-success fade show">
                {{ session('success') }} <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                    aria-label="Close"></button></div>
        @endif

        @if (session('error'))
            <div class="border-0 alert alert-danger alert-dismissible text-bg-success fade show">
                {{ session('error') }}</div>
        @endif



        <div class="card">
            <form action="{{ route('koperasi.anggota.update-password', $user->id) }}" method="POST"
                class="dropzone needsclick" id="dropzone-basic">
                @csrf
                @method('PUT')
                <div class="p-4 card-body">
                    <h5 class="mb-3">Ubah Password</h5>

                    @if (session('success'))
                        <div class="py-2 border-0 alert alert-primary bg-primary alert-dismissible fade show">
                            <div class="d-flex align-items-center">
                                <div class="text-white font-35"><i class='bx bx-bookmark-heart'></i></div>
                                <div class="ms-3">
                                    <h6 class="mb-0 text-white">Success</h6>
                                    <div class="text-white">{{ session('success') }}</div>
                                </div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="py-2 border-0 alert alert-danger bg-danger alert-dismissible fade show">
                            <div class="d-flex align-items-center">
                                <div class="text-white font-35"><i class='bx bx-error'></i></div>
                                <div class="ms-3">
                                    <h6 class="mb-0 text-white">Error</h6>
                                    <div class="text-white">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    {{-- Field untuk password lama --}}
                    <div class="mb-3 row">
                        <label for="current_password" class="col-sm-3 col-form-label">Password Lama</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <span class="input-group-text"><i class='bx bx-lock'></i></span>
                                <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                                    name="current_password" required>
                                @error('current_password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Field untuk password baru --}}
                    <div class="mb-3 row">
                        <label for="new_password" class="col-sm-3 col-form-label">Password Baru</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <span class="input-group-text"><i class='bx bx-lock-open'></i></span>
                                <input type="password" class="form-control @error('new_password') is-invalid @enderror"
                                    name="new_password" required>
                                @error('new_password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Field untuk konfirmasi password baru --}}
                    <div class="mb-3 row">
                        <label for="new_password_confirmation" class="col-sm-3 col-form-label">Konfirmasi Password
                            Baru</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <span class="input-group-text"><i class='bx bx-lock-open'></i></span>
                                <input type="password" class="form-control" name="new_password_confirmation" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <label class="col-sm-3 col-form-label"></label>
                        <div class="col-sm-9">
                            <div class="gap-3 d-md-flex d-grid align-items-center">
                                <button class="px-4 btn btn-primary">Submit</button>
                                <button type="button" class="px-4 btn btn-light">Reset</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

    </div>
    </div>

@endsection
