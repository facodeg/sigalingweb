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
                <div class="table-responsive">
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
                            @foreach ($alamatList as $alamat)
                                <tr>
                                    <td>{{ $alamat->jenis }}</td>
                                    <td>{{ $alamat->provinsi }}</td>
                                    <td>{{ $alamat->kota }}</td>
                                    <td>{{ $alamat->kecamatan }}</td>
                                    <td>{{ $alamat->kelurahan }}</td>
                                    <td>{{ $alamat->alamat_lengkap }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-warning btn-edit-alamat"
                                            data-bs-toggle="modal" data-bs-target="#modalEditAlamat"
                                            data-id="{{ $alamat->id }}" data-provinsi="{{ $alamat->province_code }}"
                                            data-kota="{{ $alamat->city_code }}"
                                            data-kecamatan="{{ $alamat->district_code }}"
                                            data-kelurahan="{{ $alamat->village_code }}"
                                            data-alamat_lengkap="{{ $alamat->alamat_lengkap }}"
                                            data-jenis="{{ $alamat->jenis }}">
                                            <i class="ri-edit-line"></i>
                                        </button>

                                        <form action="{{ route('alamat.destroy', $alamat->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Tabel Riwayat Pendidikan -->
        <div class="card mt-4">
            <div class="card-header bg-light fw-semibold">
                <strong>Riwayat Pendidikan</strong>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
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
                                        <a href="javascript:void(0);" class="btn btn-sm btn-info btn-edit-pendidikan"
                                            data-bs-toggle="modal" data-bs-target="#modalEditPendidikan"
                                            data-id="{{ $pendidikan->id }}" data-jenjang="{{ $pendidikan->jenjang }}"
                                            data-institusi="{{ $pendidikan->institusi }}"
                                            data-program_studi="{{ $pendidikan->program_studi }}"
                                            data-tahun_lulus="{{ $pendidikan->tahun_lulus }}"
                                            data-keterangan="{{ $pendidikan->keterangan }}">
                                            <i class="ri-pencil-line"></i>
                                        </a>

                                        <form action="{{ route('pendidikanuser.destroy', $pendidikan->id) }}"
                                            method="POST" class="d-inline">

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

        <!-- Modal Edit Pendidikan -->
        <!-- Modal Edit Pendidikan -->
        <div class="modal fade" id="modalEditPendidikan" tabindex="-1" aria-labelledby="modalEditPendidikanLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow">
                    <form id="formEditPendidikan" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="pegawai_id" value="{{ $karyawan->id }}">

                        <div class="modal-header bg-warning text-white">
                            <h5 class="modal-title">
                                <i class="ri-edit-box-line me-2"></i>Edit Riwayat Pendidikan
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body" style="max-height: 75vh; overflow-y: auto;">
                            <div class="mb-3">
                                <label for="edit-jenjang" class="form-label">Jenjang <span
                                        class="text-danger">*</span></label>
                                <select name="jenjang" id="edit-jenjang" class="form-select select2" required>
                                    <option value="">-- Pilih Jenjang --</option>
                                    @foreach (['SD', 'SMP', 'SMA', 'D1', 'D2', 'D3', 'S1', 'S2', 'S3'] as $jenjang)
                                        <option value="{{ $jenjang }}">{{ $jenjang }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="edit-institusi" class="form-label">Institusi <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="institusi" id="edit-institusi" class="form-control"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="edit-program_studi" class="form-label">Program Studi</label>
                                <input type="text" name="program_studi" id="edit-program_studi" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label for="edit-tahun_lulus" class="form-label">Tahun Lulus <span
                                        class="text-danger">*</span></label>
                                <input type="number" name="tahun_lulus" id="edit-tahun_lulus" class="form-control"
                                    min="1950" max="{{ date('Y') }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="edit-keterangan" class="form-label">Keterangan <span
                                        class="text-danger">*</span></label>
                                <select name="keterangan" id="edit-keterangan" class="form-select" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="Terdata">Terdata</option>
                                    <option value="Tidak Terdata">Tidak Terdata</option>
                                </select>
                            </div>
                        </div>

                        <div class="modal-footer bg-light border-top-0">
                            <button type="submit" class="btn btn-warning">
                                <i class="ri-save-3-line me-1"></i> Simpan Perubahan
                            </button>
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                <i class="ri-close-line me-1"></i> Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <script>
            document.addEventListener('DOMContentLoaded', function() {
                $('.btn-edit-pendidikan').on('click', function() {
                    let id = $(this).data('id');
                    let jenjang = $(this).data('jenjang');
                    let institusi = $(this).data('institusi');
                    let program_studi = $(this).data('program_studi');
                    let tahun_lulus = $(this).data('tahun_lulus');
                    let keterangan = $(this).data('keterangan');

                    // Set action ke route update yang sesuai
                    let updateUrl = `{{ url('/pendidikanuser') }}/${id}`;
                    $('#formEditPendidikan').attr('action', updateUrl);

                    // Set value ke form input
                    $('#edit-jenjang').val(jenjang).trigger('change');
                    $('#edit-institusi').val(institusi);
                    $('#edit-program_studi').val(program_studi);
                    $('#edit-tahun_lulus').val(tahun_lulus);
                    $('#edit-keterangan').val(keterangan).trigger('change');
                });

                // Select2 Init untuk dalam modal
                $('#modalEditPendidikan .select2').select2({
                    dropdownParent: $('#modalEditPendidikan')
                });

                // Batas tahun maksimal 4 digit
                const tahunEdit = document.querySelector('#edit-tahun_lulus');
                if (tahunEdit) {
                    tahunEdit.addEventListener('input', function() {
                        if (this.value.length > 4) {
                            this.value = this.value.slice(0, 4);
                        }
                    });
                }
            });
        </script>

        <div class="modal fade" id="modalEditAlamat" tabindex="-1" aria-labelledby="modalEditAlamatLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content border-0 shadow">
                    <form id="formEditAlamat" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="karyawan_id" value="{{ $karyawan->id }}">

                        <div class="modal-header bg-warning text-white">
                            <h5 class="modal-title"><i class="ri-map-pin-edit-line me-2"></i> Edit Alamat</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body" style="max-height: 75vh; overflow-y: auto;">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Jenis Alamat</label>
                                    <input type="text" name="keterangan" id="edit-jenis"
                                        class="form-control bg-light" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Provinsi</label>
                                    <select name="province_code" id="edit-provinsi" class="form-select select2"
                                        required></select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Kabupaten/Kota</label>
                                    <select name="city_code" id="edit-kota" class="form-select select2"
                                        required></select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Kecamatan</label>
                                    <select name="district_code" id="edit-kecamatan" class="form-select select2"
                                        required></select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Kelurahan</label>
                                    <select name="village_code" id="edit-kelurahan" class="form-select select2"
                                        required></select>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Alamat Lengkap</label>
                                    <textarea name="alamat_lengkap" id="edit-alamat_lengkap" class="form-control" rows="2" required></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer bg-light border-top-0">
                            <button type="submit" class="btn btn-warning"><i class="ri-save-line me-1"></i>
                                Simpan</button>
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><i
                                    class="ri-close-line me-1"></i> Batal</button>
                        </div>
                    </form>
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
            $('.btn-edit-alamat').on('click', function() {
                let id = $(this).data('id');
                let jenis = $(this).data('jenis');
                let alamat = $(this).data('alamat_lengkap');

                let provinceCode = $(this).data('provinsi');
                let cityCode = $(this).data('kota');
                let districtCode = $(this).data('kecamatan');
                let villageCode = $(this).data('kelurahan');

                $('#edit-jenis').val(jenis);
                $('#edit-alamat_lengkap').val(alamat);

                // Atur action
                let updateUrl = `/alamat/${id}`;
                $('#formEditAlamat').attr('action', updateUrl);

                // Load provinsi
                fetch(`/api/indonesia/provinces`)
                    .then(res => res.json())
                    .then(data => {
                        let select = $('#edit-provinsi');
                        select.empty().append('<option value="">-- Pilih Provinsi --</option>');
                        data.forEach(item => {
                            select.append(`<option value="${item.code}">${item.name}</option>`);
                        });
                        select.val(provinceCode).trigger('change');
                    });

                // Load city, district, village secara berantai
                setTimeout(() => {
                    fetch(`/api/indonesia/cities/${provinceCode}`)
                        .then(res => res.json())
                        .then(data => {
                            let select = $('#edit-kota');
                            select.empty().append('<option value="">-- Pilih Kota --</option>');
                            data.forEach(item => {
                                select.append(
                                    `<option value="${item.code}">${item.name}</option>`
                                );
                            });
                            select.val(cityCode).trigger('change');
                        });
                }, 300);

                setTimeout(() => {
                    fetch(`/api/indonesia/districts/${cityCode}`)
                        .then(res => res.json())
                        .then(data => {
                            let select = $('#edit-kecamatan');
                            select.empty().append(
                                '<option value="">-- Pilih Kecamatan --</option>');
                            data.forEach(item => {
                                select.append(
                                    `<option value="${item.code}">${item.name}</option>`
                                );
                            });
                            select.val(districtCode).trigger('change');
                        });
                }, 600);

                setTimeout(() => {
                    fetch(`/api/indonesia/villages/${districtCode}`)
                        .then(res => res.json())
                        .then(data => {
                            let select = $('#edit-kelurahan');
                            select.empty().append(
                                '<option value="">-- Pilih Kelurahan --</option>');
                            data.forEach(item => {
                                select.append(
                                    `<option value="${item.code}">${item.name}</option>`
                                );
                            });
                            select.val(villageCode).trigger('change');
                        });
                }, 900);

                // Select2 init
                $('#modalEditAlamat .select2').select2({
                    dropdownParent: $('#modalEditAlamat')
                });
            });
        });


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
