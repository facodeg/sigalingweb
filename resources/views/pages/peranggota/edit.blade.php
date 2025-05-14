@extends('layouts.app')

@section('title', 'Edit Anggota')

@section('main')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex justify-content-between align-items-md-center flex-md-row flex-column">
                    <h4 class="page-title">Formulir Pendaftaran Anggota Koperasi Karyawan RSUD Leuwiliang</h4>
                    <ol class="m-0 breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Edit</a></li>
                        <li class="breadcrumb-item active">Data Anggota</li>
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

        <div class="card">
            <div class="card-body">

                @if ($anggota->status == 'pending')
                    <!-- Pernyataan Keanggotaan -->
                    <div class="mb-4">
                        <h5 class="card-title">Pernyataan Kesediaan</h5>
                        <p>Dengan ini menyatakan bersedia menjadi anggota koperasi karyawan RSUD Leuwiliang dan akan
                            melaksanakan segala ketentuan koperasi yang telah disepakati. Bersedia dilakukan pemotongan oleh
                            Bendahara rumah sakit untuk:</p>
                        <ul>
                            <li>Simpanan Pokok hanya satu kali: Rp.200.000,- (boleh dicicil 4x)</li>
                            <li>Simpanan Wajib: Rp.30.000,- / Bulan</li>
                        </ul>
                        <p>Bersedia mengisi data dibawah ini:</p>
                    </div>
                @endif
                <!-- Form Update Anggota -->
                <form action="{{ route('anggotass.update', $anggota->no_anggota) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <!-- Data Pribadi -->
                    <div class="mb-4">

                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="no_anggota" class="form-label">No Anggota</label>
                                <input type="text" class="form-control" id="no_anggota" name="no_anggota"
                                    value="{{ $anggota->no_anggota }}" required>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama"
                                    value="{{ $anggota->nama }}" required>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="nip_nipb_nrptt" class="form-label">NIP/NIPB/NRPTT</label>
                                <input type="text" class="form-control" id="nip_nipb_nrptt" name="nip_nipb_nrptt"
                                    value="{{ old('nip_nipb_nrptt', $anggota->nip_nipb_nrptt) }}" required>
                                <div class="mt-2 form-check">
                                    <input class="form-check-input" type="checkbox" id="generate_code">
                                    <label class="form-check-label" for="generate_code">
                                        Jika Tidak Memiliki NIP/NIPB/NRPTT
                                    </label>
                                </div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                                <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir"
                                    value="{{ $anggota->tempat_lahir }}" required>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir"
                                    value="{{ $anggota->tanggal_lahir }}" required>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="umur" class="form-label">Umur</label>
                                <input type="number" class="form-control" id="umur" name="umur"
                                    value="{{ $anggota->umur }}" required readonly>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="nik" class="form-label">NIK</label>
                                <input type="text" class="form-control" id="nik" name="nik"
                                    value="{{ $anggota->nik }}" required>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="no_hp" class="form-label">No HP</label>
                                <input type="text" class="form-control" id="no_hp" name="no_hp"
                                    value="{{ $anggota->no_hp }}" required>
                            </div>
                        </div>
                    </div>

                    <!-- Data Kepegawaian -->
                    <div class="mb-4">
                        <h5 class="card-title">Data Kepegawaian </h5>
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="alamat" class="form-label">Alamat</label>
                                <input type="text" class="form-control" id="alamat" name="alamat"
                                    value="{{ $anggota->alamat }}" required>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="unit_kerja" class="form-label">Unit Kerja</label>

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
                                </select>
                                <small class="form-text text-muted">
                                    Jika unit kerja Anda tidak ada dalam daftar, silakan pilih <strong>"Lainnya"</strong>.
                                    Jika Anda bekerja di luar rumah sakit, pilih <strong>"Luar Rumah Sakit"</strong>.
                                </small>

                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="status_kepegawaian" class="form-label">Status Kepegawaian</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status_kepegawaian"
                                        id="pns" value="PNS"
                                        {{ $anggota->status_kepegawaian == 'PNS' ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="pns">
                                        PNS
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status_kepegawaian"
                                        id="blud" value="BLUD"
                                        {{ $anggota->status_kepegawaian == 'BLUD' ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="blud">
                                        BLUD
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status_kepegawaian"
                                        id="ptt" value="PTT"
                                        {{ $anggota->status_kepegawaian == 'PTT' ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="ptt">
                                        PTT
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status_kepegawaian"
                                        id="ppk" value="PPK"
                                        {{ $anggota->status_kepegawaian == 'PPK' ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="ppk">
                                        PPK
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status_kepegawaian"
                                        id="lainnya" value="Lainnya"
                                        {{ $anggota->status_kepegawaian == 'Lainnya' ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="lainnya">
                                        Lainnya
                                    </label>
                                </div>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="status_pernikahan" class="form-label">Status Pernikahan</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status_pernikahan"
                                        id="belum_menikah" value="Belum Menikah"
                                        {{ $anggota->status_pernikahan == 'Belum Menikah' ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="belum_menikah">
                                        Belum Menikah
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status_pernikahan"
                                        id="menikah" value="Menikah"
                                        {{ $anggota->status_pernikahan == 'Menikah' ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="menikah">
                                        Menikah
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status_pernikahan"
                                        id="cerai_hidup" value="Cerai Hidup"
                                        {{ $anggota->status_pernikahan == 'Cerai Hidup' ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="cerai_hidup">
                                        Cerai Hidup
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status_pernikahan"
                                        id="cerai_mati" value="Cerai Mati"
                                        {{ $anggota->status_pernikahan == 'Cerai Mati' ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="cerai_mati">
                                        Cerai Mati
                                    </label>
                                </div>
                            </div>

                        </div>
                    </div>



                    <!-- Data Keuangan -->

                    <div class="mb-4">
                        <h5 class="card-title">Data Keuangan</h5>
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="simpanan_pokok" class="form-label">Simpanan Pokok</label>
                                <input type="text" class="form-control" id="simpanan_pokok_display"
                                    value="Rp {{ number_format($anggota->simpanan_pokok, 0, ',', '.') }}" readonly>
                                <input type="hidden" id="simpanan_pokok" name="simpanan_pokok"
                                    value="{{ $anggota->simpanan_pokok }}" required>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="waktu_pembayaran" class="form-label">Waktu Pembayaran</label>

                                <!-- Cek apakah waktu_pembayaran sudah ada, jika ada tampilkan sebagai readonly -->
                                @if (is_null($anggota->waktu_pembayaran))
                                    <select class="form-select" id="waktu_pembayaran" name="waktu_pembayaran">
                                        <option value="" disabled
                                            {{ is_null($anggota->waktu_pembayaran) ? 'selected' : '' }}>Pilih Waktu
                                            Pembayaran</option>
                                        <option value="1"
                                            {{ old('waktu_pembayaran', $anggota->waktu_pembayaran) == 1 ? 'selected' : '' }}>
                                            Rp 200.000 (bayar 1X)</option>
                                        <option value="2"
                                            {{ old('waktu_pembayaran', $anggota->waktu_pembayaran) == 2 ? 'selected' : '' }}>
                                            Rp 100.000 (bayar 2X)</option>
                                        <option value="4"
                                            {{ old('waktu_pembayaran', $anggota->waktu_pembayaran) == 4 ? 'selected' : '' }}>
                                            Rp 50.000 (bayar 4X)</option>
                                    </select>
                                @else
                                    <!-- Jika waktu_pembayaran sudah ada, tampilkan sebagai readonly -->
                                    <input type="text" class="form-control"
                                        value="Rp
                                        @if ($anggota->waktu_pembayaran == 1) 200.000 (bayar 1X)
                                        @elseif($anggota->waktu_pembayaran == 2)
                                            100.000 (bayar 2X)
                                        @elseif($anggota->waktu_pembayaran == 4)
                                            50.000 (bayar 4X) @endif"
                                        readonly>
                                @endif

                                <div class="mb-3">
                                    <label for="pembayaran" class="form-label">Pembayaran</label>
                                    <input type="text" class="form-control" id="pembayaran" name="pembayaran"
                                        value="{{ old('pembayaran', $anggota->pembayaran) }}">
                                </div>
                            </div>


                            <div class="mb-3 col-md-6">
                                <label for="simpanan_wajib" class="form-label">Simpanan Wajib</label>
                                <input type="text" class="form-control" id="simpanan_wajib_display"
                                    value="Rp {{ number_format(30000, 0, ',', '.') }}" readonly>
                                <input type="hidden" id="simpanan_wajib" name="simpanan_wajib" value="30000" required>
                            </div>

                           

                        </div>
                    </div>

                    <!-- Upload Files -->
                    <div class="mb-4">
                        <h5 class="card-title">Upload Dokumen</h5>
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="upload_ktp" class="form-label">Upload KTP</label>
                                <input type="file" class="form-control" id="upload_ktp" name="upload_ktp">
                                <img src="{{ asset('storage/' . $anggota->upload_ktp) }}" alt="KTP"
                                    class="mt-2 img-thumbnail" style="width: 150px;">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="upload_foto_diri" class="form-label">Upload Foto Diri</label>
                                <input type="file" class="form-control" id="upload_foto_diri"
                                    name="upload_foto_diri">
                                <img src="{{ asset('storage/' . $anggota->upload_foto_diri) }}" alt="Foto Diri"
                                    class="mt-2 img-thumbnail" style="width: 150px;">
                            </div>
                        </div>
                    </div>

                    <!-- Pernyataan dan Persetujuan -->
                    <div class="mb-4">
                        <h5 class="card-title">Pernyataan</h5>

                        <p>
                            Pemotongan akan dilakukan setiap pembagian JP setiap bulan (terhitung dari pengajuan menjadi
                            anggota). Demikian surat pernyataan ini saya buat dengan sebenar-benarnya tanpa ada paksaan dari
                            pihak manapun.
                        </p>
                    </div>

                    <!-- Checkbox Setuju -->
                    <div class="mb-4 form-check">
                        <input type="checkbox" class="form-check-input" id="setuju" required>
                        <label class="form-check-label" for="setuju">Saya Setuju</label>
                    </div>

                    <!-- Submit Button -->
                    @if ($anggota->status == 'aktif')
                        <button type="submit" class="btn btn-primary">Update</button>
                    @elseif($anggota->status == 'pending')
                        <button type="submit" class="btn btn-primary">Pendaftran</button>
                    @endif
                </form>
            </div>
        </div>

    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkbox = document.getElementById('generate_code');
            const nipInput = document.getElementById('nip_nipb_nrptt');

            checkbox.addEventListener('change', function() {
                if (this.checked) {
                    // Generate a random 10 digit code
                    nipInput.value = generateRandomCode();
                    nipInput.setAttribute('readonly', true); // Make it readonly if needed
                } else {
                    nipInput.value = ''; // Clear the field if checkbox is unchecked
                    nipInput.removeAttribute('readonly'); // Allow editing if needed
                }
            });

            function generateRandomCode() {
                let code = '';
                for (let i = 0; i < 10; i++) {
                    code += Math.floor(Math.random() * 10);
                }
                return code;
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tanggalLahirInput = document.getElementById('tanggal_lahir');
            const umurInput = document.getElementById('umur');

            tanggalLahirInput.addEventListener('change', function() {
                const tanggalLahir = new Date(tanggalLahirInput.value);
                const umur = calculateAge(tanggalLahir);
                umurInput.value = umur;
            });

            function calculateAge(birthDate) {
                const today = new Date();
                let age = today.getFullYear() - birthDate.getFullYear();
                const month = today.getMonth() - birthDate.getMonth();

                // Adjust age if the birth date hasn't occurred yet this year
                if (month < 0 || (month === 0 && today.getDate() < birthDate.getDate())) {
                    age--;
                }

                return age;
            }
        });
    </script>

    <script src="{{ asset('assets/vendor/select2/js/select2.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('.select2').select2(); // Inisialisasi Select2
        });
    </script>
@endpush
