@extends('layouts.app')

@section('title', 'Rincian Karyawan')

@push('styles')
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
@endpush

@section('main')
    <div class="container-fluid">
        <!-- Page Title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex justify-content-between align-items-md-center flex-md-row flex-column">
                    <h4 class="page-title">Rincian Data Karyawan</h4>
                    <ol class="m-0 breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Rincian</a></li>
                        <li class="breadcrumb-item active">{{ $karyawan->nama }}</li>
                    </ol>
                </div>
            </div>
        </div>

        <!-- Alert -->
        {{-- Alert Sukses --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="ri-check-line me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Alert Error --}}
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="ri-error-warning-line me-2"></i>
                <strong>Terjadi kesalahan:</strong>
                <ul class="mb-0 mt-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif


        <!-- Data Karyawan -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow border-0">
                    <div class="card-body">
                        <!-- Avatar dan Nama -->
                        <div class="d-flex flex-column align-items-center mb-4">
                            @php $avatar = rand(1, 10); @endphp
                            <img src="{{ asset('assets/images/users/avatar-' . $avatar . '.jpg') }}" alt="user-image"
                                width="130" class="rounded-circle border shadow-sm mb-2">
                            <h4 class="fw-semibold text-primary">{{ $karyawan->nama }}</h4>
                            <span class="text-muted">{{ $karyawan->jabatan_terakhir }}</span>
                        </div>

                        <!-- Informasi Karyawan -->
                        <div class="row g-2 mb-3">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center bg-light p-2 rounded">
                                    <i class="ri-id-card-line text-primary fs-5 me-2"></i>
                                    <span>{{ $karyawan->nip_nrp_nipppk_nipb }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center bg-light p-2 rounded">
                                    <i class="ri-briefcase-4-line text-success fs-5 me-2"></i>
                                    <span>{{ $karyawan->status_kepegawaian }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center bg-light p-2 rounded">
                                    <i class="ri-calendar-event-line text-info fs-5 me-2"></i>
                                    <span>{{ \Carbon\Carbon::parse($karyawan->tgl_lahir)->format('d-m-Y') }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center bg-light p-2 rounded">
                                    <i class="ri-user-2-line text-warning fs-5 me-2"></i>
                                    <span>{{ $karyawan->jk }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center bg-light p-2 rounded">
                                    <i class="ri-graduation-cap-line text-purple fs-5 me-2"></i>
                                    <span>{{ $karyawan->pendidikan_terakhir }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center bg-light p-2 rounded">
                                    <i class="ri-building-line text-secondary fs-5 me-2"></i>
                                    <span>{{ $karyawan->ruangan }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center bg-light p-2 rounded">
                                    <i class="ri-heart-line text-danger fs-5 me-2"></i>
                                    <span>{{ $karyawan->agama }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center bg-light p-2 rounded">
                                    <i class="ri-stethoscope-line text-dark fs-5 me-2"></i>
                                    <span>{{ $karyawan->status_nakes }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="text-center mt-4">

                            <button type="button" class="btn btn-outline-success me-2" data-bs-toggle="modal"
                                data-bs-target="#modalDomisili">
                                <i class="ri-map-pin-add-line me-1"></i> Tambah Domisili
                            </button>
                            <button type="button" class="btn btn-outline-info" data-bs-toggle="modal"
                                data-bs-target="#modalPendidikan">
                                <i class="ri-book-2-line me-1"></i> Tambah Pendidikan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Data Alamat -->
        <div class="card mt-4">
            <div class="card-header bg-light fw-semibold">
                <i class="ri-map-pin-line me-1"></i> Data Alamat
            </div>
            <div class="card-body p-0">
                <div class="table table-bordered table-striped dt-responsive nowrap w-100">
                    <table class="table table-bordered table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Jenis</th>
                                <th>Provinsi</th>
                                <th>Kota/Kab</th>
                                <th>Kecamatan</th>
                                <th>Kelurahan</th>
                                <th>Alamat Lengkap</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($alamatList as $alamat)
                                <tr>
                                    <td>{{ $alamat->jenis }}</td>
                                    <td>{{ $alamat->provinsi }}</td>
                                    <td>{{ $alamat->kota }}</td>
                                    <td>{{ $alamat->kecamatan }}</td>
                                    <td>{{ $alamat->kelurahan }}</td>
                                    <td>{{ $alamat->alamat_lengkap }}</td>
                                    <td>
                                        <a href="{{ route('alamat.edit', $alamat->id) }}" class="btn btn-sm btn-warning">
                                            <i class="ri-edit-line"></i>
                                        </a>
                                        <form action="{{ route('alamat.destroy', $alamat->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        <i class="ri-information-line me-1"></i> Belum ada data alamat yang tersedia.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <!-- Tabel Riwayat Pendidikan -->
        <div class="card mt-4">
            <div class="card-header bg-light">
                <strong>Riwayat Pendidikan</strong>
            </div>
            <div class="card-body p-0">
                <div class="table table-bordered table-striped dt-responsive nowrap w-100">
                    <table class="table table-bordered table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Jenjang</th>
                                <th>Institusi</th>
                                <th>Program Studi</th>
                                <th>Tahun Lulus</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pendidikanList as $pendidikan)
                                <tr>
                                    <td>{{ $pendidikan->jenjang }}</td>
                                    <td>{{ $pendidikan->institusi }}</td>
                                    <td>{{ $pendidikan->program_studi }}</td>
                                    <td>{{ $pendidikan->tahun_lulus }}</td>
                                    <td>{{ $pendidikan->keterangan }}</td>
                                    <td>
                                        <a href="{{ route('pendidikan.edit', $pendidikan->id) }}"
                                            class="btn btn-sm btn-warning">
                                            <i class="ri-edit-line"></i>
                                        </a>
                                        <form action="{{ route('pendidikan.destroy', $pendidikan->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-danger"
                                                onclick="return confirm('Yakin ingin menghapus?')">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            @if ($pendidikanList->isEmpty())
                                <tr>
                                    <td colspan="6" class="text-center">Belum ada data pendidikan.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>



    </div>

    <!-- Modal Domisili -->
    <div class="modal fade" id="modalDomisili" tabindex="-1" aria-labelledby="modalDomisiliLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content border-0 shadow-lg rounded-3">
                <form action="{{ route('domisili.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="karyawan_id" value="{{ $karyawan->id }}">
                    <input type="hidden" name="is_ktp_juga" id="is_ktp_juga" value="0">

                    <!-- Header -->
                    <div class="modal-header bg-gradient-primary text-white">
                        <h5 class="modal-title">
                            <i class="ri-home-smile-line me-2"></i>Tambah Alamat Domisili & KTP
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>

                    <!-- Body -->
                    <div class="modal-body px-4 py-3"class="modal-body px-4 py-3"
                        style="max-height: 75vh; overflow-y: auto;">
                        <div class="alert alert-info border border-primary-subtle shadow-sm small" role="alert">
                            <strong><i class="ri-information-line"></i> Petunjuk:</strong><br>
                            Centang checkbox <strong>"Alamat Domisili sama dengan alamat KTP"</strong> jika alamat sama.
                            Jika tidak, hilangkan centang dan isi alamat KTP secara manual.
                        </div>

                        <!-- Checkbox -->
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="samaDenganDomisili" checked>
                            <label class="form-check-label fw-semibold" for="samaDenganDomisili">
                                Alamat Domisili sama dengan alamat KTP
                            </label>
                            <input type="hidden" name="is_ktp_juga" id="is_ktp_juga" value="0">
                        </div>

                        <!-- Alamat Domisili -->
                        <div id="formDomisili">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Jenis Alamat</label>
                                    <input type="text" class="form-control bg-light" name="keterangan"
                                        value="Domisili" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Provinsi</label>
                                    <select name="province_code" id="province" class="form-select select2" required>
                                        <option value="">-- Pilih Provinsi --</option>
                                        @foreach ($provinsiList as $provinsi)
                                            <option value="{{ $provinsi->code }}">{{ $provinsi->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Kabupaten/Kota</label>
                                    <select name="city_code" id="city" class="form-select select2" required>
                                        <option value="">-- Pilih Kabupaten/Kota --</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Kecamatan</label>
                                    <select name="district_code" id="district" class="form-select select2" required>
                                        <option value="">-- Pilih Kecamatan --</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Kelurahan/Desa</label>
                                    <select name="village_code" id="village" class="form-select select2" required>
                                        <option value="">-- Pilih Kelurahan/Desa --</option>
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Alamat Lengkap</label>
                                    <textarea name="alamat_lengkap" class="form-control" rows="2" required></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Alamat KTP -->
                        <div id="formKTP" style="display: none;" class="mt-4">
                            <hr class="text-primary">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Jenis Alamat</label>
                                    <input type="text" class="form-control bg-light" name="keterangan_ktp"
                                        value="KTP" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Provinsi KTP</label>
                                    <select name="province_code_ktp" class="form-select select2">
                                        <option value="">-- Pilih Provinsi --</option>
                                        @foreach ($provinsiList as $provinsi)
                                            <option value="{{ $provinsi->code }}">{{ $provinsi->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Kabupaten/Kota KTP</label>
                                    <select name="city_code_ktp" class="form-select select2">
                                        <option value="">-- Pilih Kabupaten/Kota --</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Kecamatan KTP</label>
                                    <select name="district_code_ktp" class="form-select select2">
                                        <option value="">-- Pilih Kecamatan --</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Kelurahan/Desa KTP</label>
                                    <select name="village_code_ktp" class="form-select select2">
                                        <option value="">-- Pilih Kelurahan/Desa --</option>
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Alamat Lengkap KTP</label>
                                    <textarea name="alamat_lengkap_ktp" class="form-control" rows="2"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="modal-footer bg-light border-top">
                        <button type="submit" class="btn btn-primary shadow-sm">
                            <i class="ri-save-line me-1"></i> Simpan Data
                        </button>
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            <i class="ri-close-line me-1"></i> Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Modal Pendidikan -->
    <div class="modal fade" id="modalPendidikan" tabindex="-1" aria-labelledby="modalPendidikanLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <form action="{{ route('pendidikanuser.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="pegawai_id" value="{{ $karyawan->id }}">

                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">
                            <i class="ri-graduation-cap-line me-2"></i>Tambah Riwayat Pendidikan
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body" style="max-height: 75vh; overflow-y: auto;">
                        <div class="mb-3">
                            <h6 class="text-muted mb-2">Pendidikan Terakhir</h6>
                            <div class="mb-2">
                                <label for="jenjang" class="form-label">Jenjang <span
                                        class="text-danger">*</span></label>
                                <select name="jenjang" id="jenjang" class="form-select select2" required>
                                    <option value="">-- Pilih Jenjang --</option>
                                    @foreach (['SD', 'SMP', 'SMA', 'D1', 'D2', 'D3', 'S1', 'S2', 'S3'] as $jenjang)
                                        <option value="{{ $jenjang }}">{{ $jenjang }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-2">
                                <label for="institusi" class="form-label">Institusi <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="institusi" class="form-control"
                                    placeholder="Nama Universitas / Sekolah" required>
                            </div>

                            <div class="mb-2">
                                <label for="program_studi" class="form-label">Program Studi <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="program_studi" class="form-control"
                                    placeholder="Contoh: Teknik Informatika" required>
                            </div>

                            <div class="mb-2">
                                <label for="tahun_lulus" class="form-label">Tahun Lulus <span
                                        class="text-danger">*</span></label>
                                <input type="number" name="tahun_lulus" class="form-control" placeholder="Contoh: 2022"
                                    min="1950" max="{{ date('Y') }}" required>
                            </div>

                            <div class="mb-2">
                                <label for="keterangan" class="form-label">Keterangan <span
                                        class="text-danger">*</span></label>
                                <select name="keterangan" class="form-select" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="Terdata">Terdata</option>
                                    <option value="Tidak Terdata">Tidak Terdata</option>
                                </select>
                            </div>

                            <div class="alert alert-secondary small mt-3" role="alert">
                                <strong>Penjelasan Keterangan:</strong>
                                <ul class="mb-0 ps-3">
                                    <li><strong>Terdata</strong>: Pendidikan yang telah diakui oleh Rumah Sakit.</li>
                                    <li><strong>Tidak Terdata</strong>: Pendidikan tambahan yang belum tercatat resmi.</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer bg-light border-top-0">
                        <button type="submit" class="btn btn-primary">
                            <i class="ri-save-3-line me-1"></i> Simpan
                        </button>
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            <i class="ri-close-line me-1"></i> Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>





@endsection

@push('scripts')
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $('#modalPendidikan .select2').select2({
                dropdownParent: $('#modalPendidikan')
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // === Select2 Initialization ===
            $('#modalDomisili .select2').select2({
                dropdownParent: $('#modalDomisili')
            });

            // === Checkbox Logic: Alamat Domisili sama dengan KTP ===
            const checkbox = document.getElementById('samaDenganDomisili');
            const hiddenInput = document.getElementById('is_ktp_juga');
            const formKTP = document.getElementById('formKTP');

            function toggleFormKTP() {
                if (checkbox.checked) {
                    formKTP.style.display = 'none';
                    hiddenInput.value = '0'; // berarti KTP sama → tidak tampilkan form
                } else {
                    formKTP.style.display = 'block';
                    hiddenInput.value = '1'; // berarti KTP beda → tampilkan form
                }
            }

            checkbox.addEventListener('change', toggleFormKTP);
            toggleFormKTP(); // Jalankan di awal agar form sesuai kondisi awal checkbox

            // ===================== DOMISILI =====================
            const province = $('#province');
            const city = $('#city');
            const district = $('#district');
            const village = $('#village');

            province.on('change', function() {
                const code = $(this).val();
                city.empty().append('<option value="">-- Pilih Kabupaten/Kota --</option>');
                district.empty().append('<option value="">-- Pilih Kecamatan --</option>');
                village.empty().append('<option value="">-- Pilih Kelurahan/Desa --</option>');

                if (!code) return;
                fetch(`/api/indonesia/cities/${code}`)
                    .then(res => res.json())
                    .then(data => {
                        data.forEach(item => {
                            city.append(`<option value="${item.code}">${item.name}</option>`);
                        });
                        city.trigger('change.select2');
                    });
            });

            city.on('change', function() {
                const code = $(this).val();
                district.empty().append('<option value="">-- Pilih Kecamatan --</option>');
                village.empty().append('<option value="">-- Pilih Kelurahan/Desa --</option>');

                if (!code) return;
                fetch(`/api/indonesia/districts/${code}`)
                    .then(res => res.json())
                    .then(data => {
                        data.forEach(item => {
                            district.append(
                                `<option value="${item.code}">${item.name}</option>`);
                        });
                        district.trigger('change.select2');
                    });
            });

            district.on('change', function() {
                const code = $(this).val();
                village.empty().append('<option value="">-- Pilih Kelurahan/Desa --</option>');

                if (!code) return;
                fetch(`/api/indonesia/villages/${code}`)
                    .then(res => res.json())
                    .then(data => {
                        data.forEach(item => {
                            village.append(
                                `<option value="${item.code}">${item.name}</option>`);
                        });
                        village.trigger('change.select2');
                    });
            });

            // ===================== KTP =====================
            const provinceKtp = $('[name="province_code_ktp"]');
            const cityKtp = $('[name="city_code_ktp"]');
            const districtKtp = $('[name="district_code_ktp"]');
            const villageKtp = $('[name="village_code_ktp"]');

            provinceKtp.on('change', function() {
                const code = $(this).val();
                cityKtp.empty().append('<option value="">-- Pilih Kabupaten/Kota --</option>');
                districtKtp.empty().append('<option value="">-- Pilih Kecamatan --</option>');
                villageKtp.empty().append('<option value="">-- Pilih Kelurahan/Desa --</option>');

                if (!code) return;
                fetch(`/api/indonesia/cities/${code}`)
                    .then(res => res.json())
                    .then(data => {
                        data.forEach(item => {
                            cityKtp.append(
                                `<option value="${item.code}">${item.name}</option>`);
                        });
                        cityKtp.trigger('change.select2');
                    });
            });

            cityKtp.on('change', function() {
                const code = $(this).val();
                districtKtp.empty().append('<option value="">-- Pilih Kecamatan --</option>');
                villageKtp.empty().append('<option value="">-- Pilih Kelurahan/Desa --</option>');

                if (!code) return;
                fetch(`/api/indonesia/districts/${code}`)
                    .then(res => res.json())
                    .then(data => {
                        data.forEach(item => {
                            districtKtp.append(
                                `<option value="${item.code}">${item.name}</option>`);
                        });
                        districtKtp.trigger('change.select2');
                    });
            });

            districtKtp.on('change', function() {
                const code = $(this).val();
                villageKtp.empty().append('<option value="">-- Pilih Kelurahan/Desa --</option>');

                if (!code) return;
                fetch(`/api/indonesia/villages/${code}`)
                    .then(res => res.json())
                    .then(data => {
                        data.forEach(item => {
                            villageKtp.append(
                                `<option value="${item.code}">${item.name}</option>`);
                        });
                        villageKtp.trigger('change.select2');
                    });
            });
        });
    </script>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Optional: Reset form setiap kali modal dibuka
            const modalPendidikan = document.getElementById('modalPendidikan');
            modalPendidikan.addEventListener('show.bs.modal', function() {
                const form = modalPendidikan.querySelector('form');
                form.reset(); // Reset semua field
            });

            // Optional: Validasi tahun_lulus harus 4 digit
            const tahunInput = document.querySelector('#modalPendidikan input[name="tahun_lulus"]');
            if (tahunInput) {
                tahunInput.addEventListener('input', function() {
                    if (this.value.length > 4) {
                        this.value = this.value.slice(0, 4);
                    }
                });
            }
        });
    </script>
@endpush
