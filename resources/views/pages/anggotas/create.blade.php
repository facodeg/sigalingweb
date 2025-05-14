@extends('layouts.app')

@section('title', 'Tambah Anggota')

@section('main')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex justify-content-between align-items-md-center flex-md-row flex-column">
                    <h4 class="page-title">Tambah Anggota</h4>
                    <ol class="m-0 breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
                        <li class="breadcrumb-item active">Data Tables</li>
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
            <div class="col-xl-12 col-lg-7">
                <form action="{{ route('anggotas.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="container">
                        <!-- Bagian 1: Identitas Diri -->
                        <div class="mb-4 card">
                            <div class="card-header">
                                Identitas Diri
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="nip_nipb_nrptt" class="form-label">NIP/NIPB/NRPTT</label>
                                            <input type="text" class="form-control" id="nip_nipb_nrptt"
                                                name="nip_nipb_nrptt" required>
                                            <div class="mt-2 form-check">
                                                <input class="form-check-input" type="checkbox" id="generate_code">
                                                <label class="form-check-label" for="generate_code">
                                                    Jika Tidak Memiliki NIP/NIPB/NRPTT
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="no_anggota" class="form-label">No Anggota</label>
                                            <input type="text" class="form-control" id="no_anggota" name="no_anggota"
                                                required readonly>
                                        </div>
                                    </div>

                                    <script>
                                        // Mengambil tanggal dan waktu saat ini
                                        const now = new Date();
                                        // Format sesuai ketentuan (ddmmyyyy-HHMMSS)
                                        const formattedNoAnggota =
                                            `${String(now.getDate()).padStart(2, '0')}${String(now.getMonth() + 1).padStart(2, '0')}${now.getFullYear()}-${String(now.getHours()).padStart(2, '0')}${String(now.getMinutes()).padStart(2, '0')}${String(now.getSeconds()).padStart(2, '0')}`;

                                        // Mengisi input dengan nilai yang telah diformat
                                        document.getElementById('no_anggota').value = formattedNoAnggota;
                                    </script>

                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="nik" class="form-label">NIK</label>
                                            <input type="text" class="form-control" id="nik" name="nik"
                                                required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="mb-3">
                                            <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                                            <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir"
                                                required>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="mb-3">
                                            <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                            <input type="date" class="form-control" id="tanggal_lahir"
                                                name="tanggal_lahir" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="mb-3">
                                            <label for="umur" class="form-label">Umur</label>
                                            <input type="number" class="form-control" id="umur" name="umur"
                                                required>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="no_hp" class="form-label">No HP</label>
                                            <input type="text" class="form-control" id="no_hp" name="no_hp"
                                                required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="nama" class="form-label">Nama</label>
                                            <input type="text" class="form-control" id="nama" name="nama"
                                                required>
                                        </div>
                                    </div>

                                    <div class="col-lg-8">
                                        <div class="mb-3">
                                            <label for="alamat" class="form-label">Alamat</label>
                                            <textarea class="form-control" id="alamat" name="alamat" required rows="3"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Bagian 2: Keanggotaan dan Dokumen -->
                        <div class="mb-4 card">
                            <div class="card-header">
                                Keanggotaan dan Dokumen
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="mb-3">
                                            <label for="status_kepegawaian" class="form-label">Status
                                                Unit Kerja</label>

                                            <select class="form-control select2" data-toggle="select2" name="unit_kerja">
                                                <option value="">Pilih Unit Kerja</option>
                                                <option value="Lainya">Laianya</option>
                                                <option value="Pejabat Struktural Eselon III">Pejabat Struktural Eselon III
                                                </option>
                                                <option value="Pejabat Struktural Eselon IV">Pejabat Struktural Eselon IV
                                                </option>
                                                <option value="Sub Bagian Kepegawaian">Sub Bagian Kepegawaian</option>
                                                <option value="Sub Bag. Rekam Medik">Sub Bag. Rekam Medik</option>
                                                <option value="Sub Bagian Umum">Sub Bagian Umum</option>
                                                <option value="UPBJ">UPBJ</option>
                                                <option value="Sub Bagian Anggaran">Sub Bagian Anggaran</option>
                                                <option value="Sub Bagian Perbendaharaan">Sub Bagian Perbendaharaan
                                                </option>
                                                <option value="Sub Bagian Verifikasi & Pelaporan">Sub Bagian Verifikasi &
                                                    Pelaporan
                                                </option>
                                                <option value="Ketua Tim Pelayanan & Pengembang Medik">Ketua Tim Pelayanan
                                                    &
                                                    Pengembang
                                                    Medik
                                                </option>
                                                <option value="Ketua Tim Penunjang Medik">Ketua Tim Penunjang Medik
                                                </option>
                                                <option value="MPP">MPP</option>
                                                <option value="Ketua Tim Penunjang Keperawatan">Ketua Tim Penunjang
                                                    Keperawatan
                                                </option>
                                                <option value="Ketua Tim Asuhan & Mutu Keperawatan">Ketua Tim Asuhan & Mutu
                                                    Keperawatan
                                                </option>
                                                <option value="Kepala Ruangan">Kepala Ruangan</option>
                                                <option value="R. I Lily">R. I Lily</option>
                                                <option value="R. Teratai">R. Teratai</option>
                                                <option value="R. Matahari">R. Matahari</option>
                                                <option value="Instalasi IT & SIMRS">Instalasi IT & SIMRS</option>
                                                <option value="R. Catleya Magnolia">R. Catleya Magnolia</option>
                                                <option value="R. Perinatologi">R. Perinatologi</option>
                                                <option value="R. Bougenvile 2">R. Bougenvile 2</option>
                                                <option value="R.I PICU">R.I PICU</option>
                                                <option value="Instalasi Laboratorium">Instalasi Laboratorium</option>
                                                <option value="Rawat Jalan Poliklinik">Rawat Jalan Poliklinik</option>
                                                <option value="Instalasi Gizi">Instalasi Gizi</option>
                                                <option value="Instalasi Laundry">Instalasi Laundry</option>
                                                <option value="R.I NICU">R.I NICU</option>
                                                <option value="R. Alamanda">R. Alamanda</option>
                                                <option value="R. Tulip">R. Tulip</option>
                                                <option value="Instalasi Bank Darah">Instalasi Bank Darah</option>
                                                <option value="Instalasi CSSD">Instalasi CSSD</option>
                                                <option value="IPSRS">IPSRS</option>
                                                <option value="R. Bougenvile 1">R. Bougenvile 1</option>
                                                <option value="Instalasi Rekam Medik">Instalasi Rekam Medik</option>
                                                <option value="Instalasi Dialisis">Instalasi Dialisis</option>
                                                <option value="IGD">IGD</option>
                                                <option value="PPI">PPI</option>
                                                <option value="R. Ponek">R. Ponek</option>
                                                <option value="R. Anyelir">R. Anyelir</option>
                                                <option value="Instalasi Gas Medik">Instalasi Gas Medik</option>
                                                <option value="Instalasi Kedokteran Forensik">Instalasi Kedokteran Forensik
                                                </option>
                                                <option value="Cleaning Service">Cleaning Service</option>
                                                <option value="Petugas Taman">Petugas Taman</option>
                                                <option value="R. VK">R. VK</option>
                                                <option value="Instalasi Radiologi">Instalasi Radiologi</option>
                                                <option value="Instalasi Rehabilitasi Medik">Instalasi Rehabilitasi Medik
                                                </option>
                                                <option value="Instalasi Casemix">Instalasi Casemix</option>
                                                <option value="Driver">Driver</option>
                                                <option value="Security">Security</option>
                                                <option value="ICU">ICU</option>
                                                <option value="Instalasi PKRS">Instalasi PKRS</option>
                                                <option value="Instalasi K3L">Instalasi K3L</option>
                                                <option value="IBS">IBS</option>
                                                <option value="Dokter Umum">Dokter Umum</option>
                                                <option value="Dokter Spesialis">Dokter Spesialis</option>
                                                <option value="Instalasi Farmasi">Instalasi Farmasi</option>
                                                <option value="Instalasi Diklat">Instalasi Diklat</option>
                                                <option value="Luar Rumah Sakit">Luar Rumah Sakit</option>
                                            </select>
                                            <small class="form-text text-muted">
                                                Jika unit kerja Anda tidak ada dalam daftar, silakan pilih
                                                <strong>"Lainnya"</strong>.
                                                Jika Anda bekerja di luar rumah sakit, pilih <strong>"Luar Rumah
                                                    Sakit"</strong>.
                                            </small>


                                        </div>
                                    </div>
                                    <div class="mb-3 col-md-8">
                                        <label for="status_kepegawaian" class="form-label">Status Kepegawaian</label>
                                        <select class="form-select" name="status_kepegawaian" id="status_kepegawaian"
                                            required>
                                            <option value="" disabled selected>Pilih Status Kepegawaian</option>
                                            <option value="PNS">PNS</option>
                                            <option value="BLUD">BLUD</option>
                                            <option value="PTT">PTT</option>
                                            <option value="PPK">PPK</option>
                                            <option value="Lainnya">Lainnya</option>
                                        </select>
                                    </div>


                                    <div class="mb-3 col-md-8">
                                        <label for="status_pernikahan" class="form-label">Status Pernikahan</label>
                                        <select class="form-select" id="status_pernikahan" name="status_pernikahan"
                                            required>
                                            <option value="" disabled>
                                                Pilih Status Pernikahan
                                            </option>
                                            <option value="Belum Menikah">
                                                Belum Menikah
                                            </option>
                                            <option value="Menikah">
                                                Menikah
                                            </option>
                                            <option value="Cerai Hidup">
                                                Cerai Hidup
                                            </option>
                                            <option value="Cerai Mati">
                                                Cerai Mati
                                            </option>
                                        </select>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="mb-3">
                                            <label for="simpanan_pokok" class="form-label">Simpanan Pokok</label>
                                            <input type="number" class="form-control" id="simpanan_pokok"
                                                name="simpanan_pokok" value="200000" required>
                                        </div>
                                    </div>
                                    <div class="mb-3 col-md-3">
                                        <label for="waktu_pembayaran" class="form-label">Waktu Pembayaran</label>
                                        <select class="form-select" id="waktu_pembayaran" name="waktu_pembayaran"
                                            required>
                                            <option value="" disabled>Pilih Waktu
                                                Pembayaran
                                            </option>
                                            <option value="1">Rp
                                                200.000 (bayar 1X)</option>
                                            <option value="2">Rp
                                                100.000 (bayar 2X)</option>
                                            <option value="4">Rp
                                                50.000 (bayar 4X)</option>
                                        </select>
                                    </div>
                                    <div class="mb-3 col-md-3">
                                        <div class="mb-3">
                                            <label for="simpanan_wajib" class="form-label">Simpanan Wajib</label>
                                            <input type="number" class="form-control" id="simpanan_wajib"
                                                name="simpanan_wajib" value="30000" required>
                                        </div>
                                    </div>
                                </div>



                                <div class="row">

                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="upload_ktp" class="form-label">Upload KTP</label>
                                            <input type="file" class="form-control" id="upload_ktp"
                                                name="upload_ktp">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="upload_foto_diri" class="form-label">Upload Foto Diri</label>
                                            <input type="file" class="form-control" id="upload_foto_diri"
                                                name="upload_foto_diri">
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary tn-lg">Simpan</button>
                            </div>

                        </div>

                    </div>

                </form>
            </div>


        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('assets/vendor/select2/js/select2.min.js') }}"></script>

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

        <script>
            $(document).ready(function() {
                $('.select2').select2(); // Inisialisasi Select2
            });
        </script>
    @endpush

@endsection
