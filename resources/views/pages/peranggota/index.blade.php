@extends('layouts.app')

@section('title', 'Daftar Anggota')

@section('main')
    <!--wrapper-->



    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex justify-content-between align-items-md-center flex-md-row flex-column">
                    <h4 class="page-title">Rincian Data Anggota</h4>
                    <ol class="m-0 breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Rincian</a></li>
                        <li class="breadcrumb-item active">{{ $anggota->nama }}</li>
                    </ol>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <!--end breadcrumb-->
        <div class="row">
            <div class="col-12 ">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-column align-items-center">
                            <!-- Foto Anggota -->
                            @if (empty($anggota->upload_foto_diri))
                                {{-- Use a static number or generate a random number between 1 and 14 --}}
                                @php
                                    $avatarIndex = rand(1, 10);
                                @endphp
                                <img src="{{ asset('assets/images/users/avatar-' . $avatarIndex . '.jpg') }}"
                                    alt="user-image" width="150" class="rounded-circle">
                            @else
                                <img src="{{ asset('storage/' . $anggota->upload_foto_diri) }}"
                                    class="shadow rounded-circle" height="150" alt="User Avatar" />
                            @endif




                            <!-- Nama Anggota -->
                            <h5 class="my-3">{{ $anggota->nama }}</h5>
                            <!-- Tombol Edit -->
                            <a href="{{ route('anggota.edit', $anggota->no_anggota) }}"
                                class="mb-3 btn btn-primary">Edit</a>


                        </div>

                        <div class="fm-menu">
                            <div class="list-group list-group-flush">
                                <!-- Unit Kerja -->
                                <a href="javascript:;" class="py-1 list-group-item">
                                    <i class='ri-first-aid-kit-line me-2'></i><span>{{ $anggota->unit_kerja }}</span>
                                </a>
                                <!-- Status Kepegawaian -->
                                <a href="javascript:;" class="py-1 list-group-item">
                                    <i
                                        class='ri-list-settings-line me-2'></i><span>{{ $anggota->status_kepegawaian }}</span>
                                </a>
                                <!-- Nomor Anggota diubah menjadi Tanggal -->
                                <a href="javascript:;" class="py-1 list-group-item">
                                    <i class='ri-calendar-todo-line me-2'></i>
                                    <span>
                                        @php
                                            $noAnggota = $anggota->no_anggota; // Contoh nomor anggota: 04112022-104352
                                            $tanggal =
                                                substr($noAnggota, 0, 2) .
                                                '-' .
                                                substr($noAnggota, 2, 2) .
                                                '-' .
                                                substr($noAnggota, 4, 4); // Mengubah format menjadi 04-11-2022
                                        @endphp
                                        {{ $tanggal }}
                                    </span>
                                </a>
                                <!-- Tanggal Lahir -->
                                <a href="javascript:;" class="py-1 list-group-item">
                                    <i class='ri-calendar-2-line me-2'></i>
                                    <span>
                                        @php
                                            $tanggalLahir = $anggota->tanggal_lahir; // Format YYYY-MM-DD
                                            $formattedDateLahir = \Carbon\Carbon::parse($tanggalLahir)->format('d-m-Y'); // Mengubah format menjadi 04-11-2022
                                        @endphp
                                        {{ $formattedDateLahir }}
                                    </span>
                                </a>
                                <!-- Umur -->
                                <a href="javascript:;" class="py-1 list-group-item">
                                    <i class='ri-calendar-2-line me-2'></i>
                                    <span>
                                        @php
                                            $tanggalLahir = \Carbon\Carbon::parse($anggota->tanggal_lahir);
                                            $umur = abs((int) \Carbon\Carbon::now()->diffInYears($tanggalLahir));
                                        @endphp
                                        {{ $umur }} tahun
                                    </span>
                                </a>
                                <!-- NIK -->
                                <a href="javascript:;" class="py-1 list-group-item">
                                    <i class=' ri-bank-card-line me-2'></i>
                                    <span>{{ $anggota->nik }}</span>
                                </a>
                                <!-- Alamat -->
                                <a href="javascript:;" class="py-1 list-group-item">
                                    <i class='ri-home-line me-2'></i>
                                    <span>{{ $anggota->alamat }}</span>
                                </a>
                                <!-- Status Pernikahan -->
                                <a href="javascript:;" class="py-1 list-group-item">
                                    <i class='ri-heart-line me-2'></i>
                                    <span>{{ $anggota->status_pernikahan }}</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!--end row-->
    </div>

    <!--end page wrapper -->
    <!--start overlay-->
    <div class="overlay toggle-icon"></div>
    <!--end overlay-->
    <!--Start Back To Top Button--> <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
@endsection

@push('scripts')
    <!-- Select2 Plugin Js -->


    <!-- Input Mask Plugin js -->

    
@endpush
