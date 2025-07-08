@extends('layouts.app')

@section('title', 'Daftar Karyawan')

@section('main')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex justify-content-between align-items-md-center flex-md-row flex-column">
                    <h4 class="page-title">Rincian Data Karyawan</h4>
                    <ol class="m-0 breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Rincian</a></li>
                        <li class="breadcrumb-item active">{{ $karyawan->nama }}</li>
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

        <div class="row">
            <div class="col-12 ">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-column align-items-center">
                            {{-- Foto Karyawan --}}
                            @php
                                $avatarIndex = rand(1, 10);
                            @endphp

                            <img src="{{ asset('assets/images/users/avatar-' . $avatarIndex . '.jpg') }}" alt="user-image"
                                width="150" class="rounded-circle">

                            {{-- Nama --}}
                            <h5 class="my-3">{{ $karyawan->nama }}</h5>

                            {{-- Tombol Edit --}}
                            <a href="{{ route('karyawan.edit', $karyawan->id) }}" class="mb-3 btn btn-primary">Edit</a>
                        </div>

                        <div class="fm-menu">
                            <div class="list-group list-group-flush">
                                {{-- Jabatan --}}
                                <a href="javascript:;" class="py-1 list-group-item">
                                    <i class='ri-user-star-line me-2'></i><span>{{ $karyawan->jabatan_terakhir }}</span>
                                </a>
                                {{-- NIP/NIK --}}
                                <a href="javascript:;" class="py-1 list-group-item">
                                    <i class='ri-bank-card-line me-2'></i><span>{{ $karyawan->nip_nrp_nipppk_nipb }}</span>
                                </a>
                                {{-- Status Kepegawaian --}}
                                <a href="javascript:;" class="py-1 list-group-item">
                                    <i
                                        class='ri-list-settings-line me-2'></i><span>{{ $karyawan->status_kepegawaian }}</span>
                                </a>
                                {{-- Tanggal Lahir --}}
                                <a href="javascript:;" class="py-1 list-group-item">
                                    <i class='ri-calendar-2-line me-2'></i>
                                    <span>
                                        @php
                                            $tglLahir = \Carbon\Carbon::parse($karyawan->tgl_lahir)->format('d-m-Y');
                                        @endphp
                                        {{ $tglLahir }}
                                    </span>
                                </a>
                                {{-- Umur --}}
                                <a href="javascript:;" class="py-1 list-group-item">
                                    <i class='ri-calendar-2-line me-2'></i>
                                    <span>
                                        @php
                                            $umur = \Carbon\Carbon::parse($karyawan->tgl_lahir)->age;
                                        @endphp
                                        {{ $umur }} tahun
                                    </span>
                                </a>
                                {{-- NPWP --}}
                                <a href="javascript:;" class="py-1 list-group-item">
                                    <i class='ri-profile-line me-2'></i><span>{{ $karyawan->npwp }}</span>
                                </a>
                                {{-- Alamat --}}
                                <a href="javascript:;" class="py-1 list-group-item">
                                    <i class='ri-home-line me-2'></i>
                                    <span>{{ $karyawan->alamat_ktp }}, {{ $karyawan->desa }}, {{ $karyawan->kecamatan }},
                                        {{ $karyawan->kabupaten }}</span>
                                </a>
                                {{-- Pendidikan --}}
                                <a href="javascript:;" class="py-1 list-group-item">
                                    <i class='ri-book-line me-2'></i><span>{{ $karyawan->pendidikan_terakhir }}</span>
                                </a>
                                {{-- Ruangan --}}
                                <a href="javascript:;" class="py-1 list-group-item">
                                    <i class='ri-building-line me-2'></i><span>{{ $karyawan->ruangan }}</span>
                                </a>
                                {{-- Agama --}}
                                <a href="javascript:;" class="py-1 list-group-item">
                                    <i class='ri-heart-pulse-line me-2'></i><span>{{ $karyawan->agama }}</span>
                                </a>
                                {{-- Status Nakes --}}
                                <a href="javascript:;" class="py-1 list-group-item">
                                    <i class='ri-stethoscope-line me-2'></i><span>{{ $karyawan->status_nakes }}</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Overlay dan back to top -->
    <div class="overlay toggle-icon"></div>
    <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
@endsection

@push('scripts')
    <!-- Tambahan script jika perlu -->
@endpush
