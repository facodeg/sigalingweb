@extends('layouts.app')
@section('title', 'Perbarui Data')

@section('main')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex justify-content-between align-items-md-center flex-md-row flex-column">
                    <h4 class="page-title">Perbarui Data</h4>
                    <ol class="m-0 breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Edit</a></li>
                        <li class="breadcrumb-item active">Data Anggota</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="card">
                <div class="card-header">{{ __('Perbarui Data Anggota') }}</div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Tampilkan foto diri jika ada -->
                    @if ($anggota->upload_foto_diri)
                        <div class="text-center mb-4">
                            <img src="{{ Storage::url($anggota->upload_foto_diri) }}" alt="Foto Diri" class="img-thumbnail"
                                style="width: 150px; height: auto;">
                        </div>
                    @endif

                    <form method="POST" action="{{ route('anggotas.perbarui') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Tampilkan No Anggota (Readonly) -->
                        <div class="form-group row">
                            <label for="no_anggota"
                                class="col-md-4 col-form-label text-md-right">{{ __('No Anggota') }}</label>

                            <div class="mb-3 col-md-6">
                                <input id="no_anggota" type="text" class="form-control" name="no_anggota"
                                    value="{{ $anggota->no_anggota }}" readonly>
                            </div>
                        </div>

                        <!-- Tampilkan Nama Anggota (Readonly) -->
                        <div class="form-group row">
                            <label for="nama" class="col-md-4 col-form-label text-md-right">{{ __('Nama') }}</label>

                            <div class="mb-3 col-md-6">
                                <input id="nama" type="text" class="form-control" name="nama"
                                    value="{{ $anggota->nama }}" readonly>
                            </div>
                        </div>

                        <!-- Jenis Kelamin -->
                        <div class="form-group row">
                            <label for="jk"
                                class="col-md-4 col-form-label text-md-right">{{ __('Jenis Kelamin') }}</label>

                            <div class="mb-3 col-md-6">
                                <select id="jk" class="form-control @error('jk') is-invalid @enderror" name="jk"
                                    required>
                                    <option value="">-- Pilih Jenis Kelamin --</option>
                                    <option value="L" {{ old('jk', $anggota->jk) == 'L' ? 'selected' : '' }}>Laki-laki
                                    </option>
                                    <option value="P" {{ old('jk', $anggota->jk) == 'P' ? 'selected' : '' }}>Perempuan
                                    </option>
                                </select>

                                @error('jk')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Nomor Handphone -->
                        <div class="form-group row">
                            <label for="no_hp"
                                class="col-md-4 col-form-label text-md-right">{{ __('Nomor Handphone') }}</label>

                            <div class="mb-3 col-md-6">
                                <input id="no_hp" type="text"
                                    class="form-control @error('no_hp') is-invalid @enderror" name="no_hp"
                                    value="{{ old('no_hp', $anggota->no_hp) }}" required minlength="10">

                                @error('no_hp')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email2" class="col-md-4 col-form-label text-md-right">{{ __('Email') }}</label>

                            <div class="mb-3 col-md-6">
                                <input id="email2" type="email"
                                    class="form-control @error('email2') is-invalid @enderror" name="email2"
                                    value="{{ old('email2', $user->email2) }}" required>

                                @error('email2')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="unit_kerja"
                                class="col-md-4 col-form-label text-md-right">{{ __('Unit Kerja') }}</label>

                            <div class="mb-3 col-md-6">
                                <select class="form-control select2" data-toggle="select2" name="unit_kerja" required>
                                    <option value="">Pilih Unit Kerja</option>
                                    <option value="Lainya" {{ $anggota->unit_kerja == 'Lainya' ? 'selected' : '' }}>Lainya
                                    </option>
                                    <option value="Pejabat Struktural Eselon III"
                                        {{ $anggota->unit_kerja == 'Pejabat Struktural Eselon III' ? 'selected' : '' }}>
                                        Pejabat Struktural Eselon III</option>
                                    <option value="Pejabat Struktural Eselon IV"
                                        {{ $anggota->unit_kerja == 'Pejabat Struktural Eselon IV' ? 'selected' : '' }}>
                                        Pejabat Struktural Eselon IV</option>
                                    <option value="Sub Bagian Kepegawaian"
                                        {{ $anggota->unit_kerja == 'Sub Bagian Kepegawaian' ? 'selected' : '' }}>Sub Bagian
                                        Kepegawaian</option>
                                    <option value="Sub Bag. Rekam Medik"
                                        {{ $anggota->unit_kerja == 'Sub Bag. Rekam Medik' ? 'selected' : '' }}>Sub Bag.
                                        Rekam Medik</option>
                                    <option value="Sub Bagian Umum"
                                        {{ $anggota->unit_kerja == 'Sub Bagian Umum' ? 'selected' : '' }}>Sub Bagian Umum
                                    </option>
                                    <option value="UPBJ" {{ $anggota->unit_kerja == 'UPBJ' ? 'selected' : '' }}>UPBJ
                                    </option>
                                    <option value="Sub Bagian Anggaran"
                                        {{ $anggota->unit_kerja == 'Sub Bagian Anggaran' ? 'selected' : '' }}>Sub Bagian
                                        Anggaran</option>
                                    <option value="Sub Bagian Perbendaharaan"
                                        {{ $anggota->unit_kerja == 'Sub Bagian Perbendaharaan' ? 'selected' : '' }}>Sub
                                        Bagian Perbendaharaan</option>
                                    <option value="Sub Bagian Verifikasi & Pelaporan"
                                        {{ $anggota->unit_kerja == 'Sub Bagian Verifikasi & Pelaporan' ? 'selected' : '' }}>
                                        Sub Bagian Verifikasi & Pelaporan</option>
                                    <option value="Ketua Tim Pelayanan & Pengembang Medik"
                                        {{ $anggota->unit_kerja == 'Ketua Tim Pelayanan & Pengembang Medik' ? 'selected' : '' }}>
                                        Ketua Tim Pelayanan & Pengembang Medik</option>
                                    <option value="Ketua Tim Penunjang Medik"
                                        {{ $anggota->unit_kerja == 'Ketua Tim Penunjang Medik' ? 'selected' : '' }}>Ketua
                                        Tim Penunjang Medik</option>
                                    <option value="MPP" {{ $anggota->unit_kerja == 'MPP' ? 'selected' : '' }}>MPP
                                    </option>
                                    <option value="Ketua Tim Penunjang Keperawatan"
                                        {{ $anggota->unit_kerja == 'Ketua Tim Penunjang Keperawatan' ? 'selected' : '' }}>
                                        Ketua Tim Penunjang Keperawatan</option>
                                    <option value="Ketua Tim Asuhan & Mutu Keperawatan"
                                        {{ $anggota->unit_kerja == 'Ketua Tim Asuhan & Mutu Keperawatan' ? 'selected' : '' }}>
                                        Ketua Tim Asuhan & Mutu Keperawatan</option>
                                    <option value="Kepala Ruangan"
                                        {{ $anggota->unit_kerja == 'Kepala Ruangan' ? 'selected' : '' }}>Kepala Ruangan
                                    </option>
                                    <option value="R. I Lily" {{ $anggota->unit_kerja == 'R. I Lily' ? 'selected' : '' }}>
                                        R. I Lily</option>
                                    <option value="R. Teratai"
                                        {{ $anggota->unit_kerja == 'R. Teratai' ? 'selected' : '' }}>R. Teratai</option>
                                    <option value="R. Matahari"
                                        {{ $anggota->unit_kerja == 'R. Matahari' ? 'selected' : '' }}>R. Matahari</option>
                                    <option value="Instalasi IT & SIMRS"
                                        {{ $anggota->unit_kerja == 'Instalasi IT & SIMRS' ? 'selected' : '' }}>Instalasi IT
                                        & SIMRS</option>
                                    <option value="R. Catleya Magnolia"
                                        {{ $anggota->unit_kerja == 'R. Catleya Magnolia' ? 'selected' : '' }}>R. Catleya
                                        Magnolia</option>
                                    <option value="R. Perinatologi"
                                        {{ $anggota->unit_kerja == 'R. Perinatologi' ? 'selected' : '' }}>R. Perinatologi
                                    </option>
                                    <option value="R. Bougenvile 2"
                                        {{ $anggota->unit_kerja == 'R. Bougenvile 2' ? 'selected' : '' }}>R. Bougenvile 2
                                    </option>
                                    <option value="R.I PICU" {{ $anggota->unit_kerja == 'R.I PICU' ? 'selected' : '' }}>
                                        R.I PICU</option>
                                    <option value="Instalasi Laboratorium"
                                        {{ $anggota->unit_kerja == 'Instalasi Laboratorium' ? 'selected' : '' }}>Instalasi
                                        Laboratorium</option>
                                    <option value="Rawat Jalan Poliklinik"
                                        {{ $anggota->unit_kerja == 'Rawat Jalan Poliklinik' ? 'selected' : '' }}>Rawat
                                        Jalan Poliklinik</option>
                                    <option value="Instalasi Gizi"
                                        {{ $anggota->unit_kerja == 'Instalasi Gizi' ? 'selected' : '' }}>Instalasi Gizi
                                    </option>
                                    <option value="Instalasi Laundry"
                                        {{ $anggota->unit_kerja == 'Instalasi Laundry' ? 'selected' : '' }}>Instalasi
                                        Laundry</option>
                                    <option value="R.I NICU" {{ $anggota->unit_kerja == 'R.I NICU' ? 'selected' : '' }}>
                                        R.I NICU</option>
                                    <option value="R. Alamanda"
                                        {{ $anggota->unit_kerja == 'R. Alamanda' ? 'selected' : '' }}>R. Alamanda</option>
                                    <option value="R. Tulip" {{ $anggota->unit_kerja == 'R. Tulip' ? 'selected' : '' }}>R.
                                        Tulip</option>
                                    <option value="Instalasi Bank Darah"
                                        {{ $anggota->unit_kerja == 'Instalasi Bank Darah' ? 'selected' : '' }}>Instalasi
                                        Bank Darah</option>
                                    <option value="Instalasi CSSD"
                                        {{ $anggota->unit_kerja == 'Instalasi CSSD' ? 'selected' : '' }}>Instalasi CSSD
                                    </option>
                                    <option value="IPSRS" {{ $anggota->unit_kerja == 'IPSRS' ? 'selected' : '' }}>IPSRS
                                    </option>
                                    <option value="R. Bougenvile 1"
                                        {{ $anggota->unit_kerja == 'R. Bougenvile 1' ? 'selected' : '' }}>R. Bougenvile 1
                                    </option>
                                    <option value="Instalasi Rekam Medik"
                                        {{ $anggota->unit_kerja == 'Instalasi Rekam Medik' ? 'selected' : '' }}>Instalasi
                                        Rekam Medik</option>
                                    <option value="Instalasi Dialisis"
                                        {{ $anggota->unit_kerja == 'Instalasi Dialisis' ? 'selected' : '' }}>Instalasi
                                        Dialisis</option>
                                    <option value="IGD" {{ $anggota->unit_kerja == 'IGD' ? 'selected' : '' }}>IGD
                                    </option>
                                    <option value="PPI" {{ $anggota->unit_kerja == 'PPI' ? 'selected' : '' }}>PPI
                                    </option>
                                    <option value="R. Ponek" {{ $anggota->unit_kerja == 'R. Ponek' ? 'selected' : '' }}>R.
                                        Ponek</option>
                                    <option value="R. Anyelir"
                                        {{ $anggota->unit_kerja == 'R. Anyelir' ? 'selected' : '' }}>R. Anyelir</option>
                                    <option value="Instalasi Gas Medik"
                                        {{ $anggota->unit_kerja == 'Instalasi Gas Medik' ? 'selected' : '' }}>Instalasi Gas
                                        Medik</option>
                                    <option value="Instalasi Kedokteran Forensik"
                                        {{ $anggota->unit_kerja == 'Instalasi Kedokteran Forensik' ? 'selected' : '' }}>
                                        Instalasi Kedokteran Forensik</option>
                                    <option value="Cleaning Service"
                                        {{ $anggota->unit_kerja == 'Cleaning Service' ? 'selected' : '' }}>Cleaning Service
                                    </option>
                                    <option value="Petugas Taman"
                                        {{ $anggota->unit_kerja == 'Petugas Taman' ? 'selected' : '' }}>Petugas Taman
                                    </option>
                                    <option value="R. VK" {{ $anggota->unit_kerja == 'R. VK' ? 'selected' : '' }}>R. VK
                                    </option>
                                    <option value="Instalasi Radiologi"
                                        {{ $anggota->unit_kerja == 'Instalasi Radiologi' ? 'selected' : '' }}>Instalasi
                                        Radiologi</option>
                                    <option value="Instalasi Rehabilitasi Medik"
                                        {{ $anggota->unit_kerja == 'Instalasi Rehabilitasi Medik' ? 'selected' : '' }}>
                                        Instalasi Rehabilitasi Medik</option>
                                    <option value="Instalasi Casemix"
                                        {{ $anggota->unit_kerja == 'Instalasi Casemix' ? 'selected' : '' }}>Instalasi
                                        Casemix</option>
                                    <option value="Driver" {{ $anggota->unit_kerja == 'Driver' ? 'selected' : '' }}>Driver
                                    </option>
                                    <option value="Security" {{ $anggota->unit_kerja == 'Security' ? 'selected' : '' }}>
                                        Security</option>
                                    <option value="ICU" {{ $anggota->unit_kerja == 'ICU' ? 'selected' : '' }}>ICU
                                    </option>
                                    <option value="Instalasi PKRS"
                                        {{ $anggota->unit_kerja == 'Instalasi PKRS' ? 'selected' : '' }}>Instalasi PKRS
                                    </option>
                                    <option value="Instalasi K3L"
                                        {{ $anggota->unit_kerja == 'Instalasi K3L' ? 'selected' : '' }}>Instalasi K3L
                                    </option>
                                    <option value="IBS" {{ $anggota->unit_kerja == 'IBS' ? 'selected' : '' }}>IBS
                                    </option>
                                    <option value="Dokter Umum"
                                        {{ $anggota->unit_kerja == 'Dokter Umum' ? 'selected' : '' }}>Dokter Umum</option>
                                    <option value="Dokter Spesialis"
                                        {{ $anggota->unit_kerja == 'Dokter Spesialis' ? 'selected' : '' }}>Dokter Spesialis
                                    </option>
                                    <option value="Instalasi Farmasi"
                                        {{ $anggota->unit_kerja == 'Instalasi Farmasi' ? 'selected' : '' }}>Instalasi
                                        Farmasi</option>
                                    <option value="Instalasi Diklat"
                                        {{ $anggota->unit_kerja == 'Instalasi Diklat' ? 'selected' : '' }}>Instalasi Diklat
                                    </option>
                                    <option value="Instalasi Diklat"
                                        {{ $anggota->unit_kerja == 'Luar Rumah Sakit' ? 'selected' : '' }}>Luar Rumah Sakit
                                    </option>
                                    <option value="Instalasi Diklat"
                                        {{ $anggota->unit_kerja == 'Luar Rumah Sakit' ? 'selected' : '' }}>Luar Rumah Sakit
                                    </option>
                                </select>
                                <small class="form-text text-muted">
                                    Jika unit kerja Anda tidak ada dalam daftar, silakan pilih <strong>"Lainnya"</strong>.
                                    Jika Anda bekerja di luar rumah sakit, pilih <strong>"Luar Rumah Sakit"</strong>.
                                </small>
                            </div>
                        </div>


                        <!-- Upload Foto Diri -->
                        <div class="form-group row">
                            <label for="upload_foto_diri"
                                class="col-md-4 col-form-label text-md-right">{{ __('Unggah Foto Diri') }}</label>

                            <div class="mb-3 col-md-6">
                                <input id="upload_foto_diri" type="file"
                                    class="form-control-file @error('upload_foto_diri') is-invalid @enderror"
                                    name="upload_foto_diri" accept="image/*">

                                @error('upload_foto_diri')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Tombol Submit -->
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Perbarui') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    @push('scripts')
        <script src="{{ asset('assets/vendor/select2/js/select2.min.js') }}"></script>

        <script>
            $(document).ready(function() {
                $('.select2').select2(); // Inisialisasi Select2
            });
        </script>
    @endpush
@endsection
