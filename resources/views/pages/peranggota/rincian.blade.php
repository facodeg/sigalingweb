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
                    <h4 class="page-title">Rincian Data Pegawai</h4>
                    <ol class="m-0 breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Rincian</a></li>
                        <li class="breadcrumb-item active">{{ $karyawan->nama }}</li>
                    </ol>
                </div>
            </div>
        </div>

        @if (auth()->user()->phone == null)
            <!-- Modal Lengkapi Nomor WhatsApp -->
            <div class="modal fade" id="modalWhatsapp" tabindex="-1" aria-labelledby="modalWhatsappLabel"
                aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 shadow">
                        <form method="POST" action="{{ route('user.updatePhone') }}">
                            @csrf
                            <div class="modal-header bg-info text-white">
                                <h5 class="modal-title">
                                    <i class="ri-phone-line me-2"></i>Lengkapi Nomor WhatsApp
                                </h5>
                            </div>
                            <div class="modal-body">
                                <p class="mb-3 text-muted">
                                    Silakan lengkapi nomor WhatsApp Anda untuk melanjutkan.
                                </p>
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Nomor WhatsApp Aktif</label>
                                    <input type="text" class="form-control" name="phone" id="phone" required
                                        placeholder="Contoh: 081234567890">
                                </div>
                            </div>
                            <div class="modal-footer bg-light">
                                <button type="submit" class="btn btn-info">
                                    <i class="ri-check-line me-1"></i> Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            @push('scripts')
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        let modal = new bootstrap.Modal(document.getElementById('modalWhatsapp'));
                        modal.show();
                    });
                </script>
            @endpush
        @endif



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
            <div class="col-12 col-lg-3">
                <div class="card shadow ">
                    <div class="card-body">
                        <!-- Avatar dan Nama -->
                        <div class="d-flex flex-column align-items-center ">
                            @if (empty($karyawan->upload_foto_diri))
                                @php
                                    $avatarIndex = ($karyawan->id % 4) + 1;
                                    $avatarFile =
                                        $karyawan->jk == 'L'
                                            ? "avatar-{$avatarIndex}.jpg"
                                            : 'avatar-' . ($avatarIndex + 4) . '.jpg';
                                @endphp
                                <img src="{{ asset('assets/images/users/' . $avatarFile) }}" alt="user-image" width="130"
                                    class="rounded-circle border shadow-sm mb-2">
                            @else
                                <img src="{{ asset('storage/' . $karyawan->upload_foto_diri) }}"
                                    class="shadow rounded-circle border mb-2" width="130" alt="User Avatar">
                            @endif
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

                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-9">
                <div class="card">
                    <div class="card-body">
                        <div class="fm-search">
                            <div class="mb-0">
                                {{-- <div class="input-group input-group-lg"> <span class="bg-transparent input-group-text"><i
                                            class='ri-search-line'></i></span>
                                    <input type="text" class="form-control" placeholder="Search the files">
                                </div> --}}
                            </div>
                        </div>
                        <div class="mt-3 row">
                            <!-- Card Belanja -->
                            <div class="col-12 col-lg-4">
                                <div class="border shadow-none card radius-15">
                                    <div class="card widget-icon-box text-bg-pink">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <!-- Kolom Kiri: Teks dan Nilai Simpanan -->
                                                <div>
                                                    <!-- Judul Kartu -->
                                                    <h5 class="mb-0">Data Keluarga</h5>
                                                    <!-- Teks Nilai Simpanan -->

                                                </div>

                                                <!-- Kolom Kanan: Ikon -->
                                                <div class="flex-shrink-0 avatar-sm">
                                                    <span
                                                        class="text-white bg-white bg-opacity-25 rounded shadow avatar-title rounded-3 fs-3 widget-icon-box-avatar">
                                                        <i class="ri-wallet-3-line"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <p class="mt-2 mb-0">
                                                <span></span>
                                            </p>

                                            <!-- Progress Bar -->
                                            <div class="mt-3">
                                                <div class="progress" style="height: 7px;">

                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <!-- Card Simpanan Wajib -->
                            <div class="col-12 col-lg-4">
                                <div class="border shadow-none card radius-15">
                                    <div class="card widget-icon-box text-bg-purple">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <!-- Ganti Ikon Dropbox dengan Ikon Baru -->

                                                <div>
                                                    <h5 class="mb-0 ">Data Pendidikan</h5>
                                                </div>

                                                <!-- Ganti Teks "Simpanan Wajib" dengan Teks Baru -->

                                                <!-- Ganti Teks dengan Data Dinamis -->



                                                <div class="flex-shrink-0 avatar-sm">
                                                    <span
                                                        class="text-white bg-white bg-opacity-25 rounded shadow avatar-title rounded-3 fs-3 widget-icon-box-avatar">
                                                        <i class="ri-group-line"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <p class="mt-2 mb-0">

                                            </p>
                                            <div class="mt-3">
                                                <div class="progress" style="height: 7px;">

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Pinjaman -->
                            <div class="col-12 col-lg-4">

                                <div class="border shadow-none card radius-15">
                                    <div class="card widget-icon-box text-bg-success">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <!-- Kolom Kiri: Judul dan Teks Data Angsuran -->
                                                <div>
                                                    <!-- Judul Kartu -->
                                                    <h5 class="mb-0">Data Jabatan</h5>
                                                    <!-- Teks Data Angsuran -->

                                                </div>

                                                <!-- Kolom Kanan: Ikon -->
                                                <div class="flex-shrink-0 avatar-sm">
                                                    <span
                                                        class="text-white bg-white bg-opacity-25 rounded shadow avatar-title rounded-3 fs-3 widget-icon-box-avatar">
                                                        <i class="ri-money-dollar-circle-line"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <p class="mt-2 mb-0">

                                            </p>

                                            <!-- Progress Bar -->
                                            <div class="mt-3">
                                                <div class="progress" style="height: 7px;">

                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>

                        <!--end row-->

                        <!--end row-->
                        <!-- Tab Navigation -->
                        <ul class="nav nav-tabs nav-primary" role="tablist">
                            {{-- <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="simpanan-tab" data-bs-toggle="tab" href="#simpanan"
                                    role="tab" aria-selected="true">
                                    <div class="d-flex align-items-center">
                                        <div class="tab-icon"><i class='bx bx-wallet font-18 me-1'></i></div>
                                        <div class="tab-title">Data Keluarga</div>
                                    </div>
                                </a>
                            </li> --}}
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="pinjaman-tab" data-bs-toggle="tab" href="#pinjaman"
                                    role="tab" aria-selected="false">
                                    <div class="d-flex align-items-center">
                                        <div class="tab-icon"><i class='bx bx-credit-card font-18 me-1'></i></div>
                                        <div class="tab-title">Data Pendidikan</div>
                                    </div>
                                </a>
                            </li>
                            {{-- <li class="nav-item" role="presentation">
                                <a class="nav-link" id="angsuran-tab" data-bs-toggle="tab" href="#angsuran"
                                    role="tab" aria-selected="false">
                                    <div class="d-flex align-items-center">
                                        <div class="tab-icon"><i class='bx bx-calendar-check font-18 me-1'></i></div>
                                        <div class="tab-title">Data Jabatan</div>
                                    </div>
                                </a>
                            </li> --}}
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="str-tab" data-bs-toggle="tab" href="#str" role="tab"
                                    aria-selected="false">
                                    <div class="d-flex align-items-center">
                                        <div class="tab-icon"><i class='bx bx-id-card font-18 me-1'></i></div>
                                        <div class="tab-title">Data STR</div>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="sip-tab" data-bs-toggle="tab" href="#sip" role="tab"
                                    aria-selected="false">
                                    <div class="d-flex align-items-center">
                                        <div class="tab-icon"><i class='bx bx-shield font-18 me-1'></i></div>
                                        <div class="tab-title">Data SIP</div>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="spkrkk-tab" data-bs-toggle="tab" href="#spkrkk" role="tab"
                                    aria-selected="false">
                                    <div class="d-flex align-items-center">
                                        <div class="tab-icon"><i class='bx bx-file font-18 me-1'></i></div>
                                        <div class="tab-title">Data SPK & RKK </div>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="alamat-tab" data-bs-toggle="tab" href="#alamat" role="tab"
                                    aria-selected="false">
                                    <div class="d-flex align-items-center">
                                        <div class="tab-icon"><i class='bx bx-map-alt font-18 me-1'></i></div>
                                        <div class="tab-title">Data Alamat</div>
                                    </div>
                                </a>
                            </li>
                        </ul>



                        <!-- Tab Content -->
                        <div class="mt-3 tab-content">
                            <!-- Tab: Data Keluarga -->
                            {{-- <div class="tab-pane fade show active" id="simpanan" role="tabpanel"
                                aria-labelledby="simpanan-tab">
                                <div class="mb-3 d-flex align-items-center">
                                    <button type="button" class="btn btn-success me-3" data-bs-toggle="modal"
                                        data-bs-target="#tambahModalKeluarga">
                                        Tambah Data Keluarga
                                    </button>
                                    <div class="ms-auto">
                                        <a href="javascript:;" class="btn btn-sm btn-outline-secondary">View all</a>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table id="example2" class="table mb-0 table-striped table-hover table-sm">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>Hubungan</th>
                                                <th>Tanggal Lahir</th>
                                                <th>Pekerjaan</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($karyawan->keluarga ?? [] as $index => $keluarga)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $keluarga->nama }}</td>
                                                    <td>{{ $keluarga->hubungan }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($keluarga->tgl_lahir)->format('d-m-Y') }}
                                                    </td>
                                                    <td>{{ $keluarga->pekerjaan }}</td>
                                                    <td>
                                                        <a href="#" class="btn btn-sm btn-warning">Edit</a>
                                                        <a href="#" class="btn btn-sm btn-danger">Hapus</a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center text-muted">Belum ada data
                                                        keluarga</td>
                                                </tr>
                                            @endforelse
                                        </tbody>

                                    </table>
                                </div>
                            </div> --}}

                            <!-- Tab: Data Pendidikan -->
                            <!-- Tab: Data Pendidikan -->
                            <div class="tab-pane fade" id="pinjaman" role="tabpanel" aria-labelledby="pinjaman-tab">
                                <div class="mb-3 d-flex align-items-center">
                                    <button type="button" class="btn btn-success me-3" data-bs-toggle="modal"
                                        data-bs-target="#modalPendidikan">
                                        Tambah Data Pendidikan
                                    </button>
                                    <div class="ms-auto">
                                        <a href="javascript:;" class="btn btn-sm btn-outline-secondary">View all</a>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table id="example3" class="table mb-0 table-striped table-hover table-sm">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Jenjang</th>
                                                <th>Institusi</th>
                                                <th>Program Studi</th>
                                                <th>Tahun Lulus</th>
                                                <th>Keterangan</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($pendidikanList as $index => $pendidikan)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $pendidikan->jenjang }}</td>
                                                    <td>{{ $pendidikan->institusi }}</td>
                                                    <td>{{ $pendidikan->program_studi }}</td>
                                                    <td>{{ $pendidikan->tahun_lulus }}</td>
                                                    <td>{{ $pendidikan->keterangan }}</td>
                                                    <td>
                                                        <a href="javascript:void(0);"
                                                            class="btn btn-sm btn-info btn-edit-pendidikan"
                                                            data-bs-toggle="modal" data-bs-target="#modalEditPendidikan"
                                                            data-id="{{ $pendidikan->id }}"
                                                            data-jenjang="{{ $pendidikan->jenjang }}"
                                                            data-institusi="{{ $pendidikan->institusi }}"
                                                            data-program_studi="{{ $pendidikan->program_studi }}"
                                                            data-tahun_lulus="{{ $pendidikan->tahun_lulus }}"
                                                            data-keterangan="{{ $pendidikan->keterangan }}">
                                                            <i class="ri-pencil-line"></i>
                                                        </a>

                                                        <form
                                                            action="{{ route('pendidikanuser.destroy', $pendidikan->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf @method('DELETE')
                                                            <button class="btn btn-sm btn-danger"
                                                                onclick="return confirm('Yakin ingin menghapus?')">
                                                                <i class="ri-delete-bin-line"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="7" class="text-center text-muted">Belum ada data
                                                        pendidikan</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>


                            <!-- Tab: Data Jabatan -->
                            <div class="tab-pane fade" id="angsuran" role="tabpanel" aria-labelledby="angsuran-tab">
                                <div class="mb-3 d-flex align-items-center">
                                    <button type="button" class="btn btn-success me-3" data-bs-toggle="modal"
                                        data-bs-target="#tambahModalJabatan">
                                        Tambah Data Jabatan
                                    </button>
                                    <div class="ms-auto">
                                        <a href="javascript:;" class="btn btn-sm btn-outline-secondary">View all</a>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <!-- Tombol Tambah -->


                                    <!-- Modal Tambah -->


                                    <table id="example4" class="table mb-0 table-striped table-hover table-sm">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Jabatan</th>
                                                <th>Unit Kerja</th>
                                                <th>Mulai</th>
                                                <th>Selesai</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($karyawan->jabatan ?? [] as $index => $jabatan)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $jabatan->nama_jabatan }}</td>
                                                    <td>{{ $jabatan->unit_kerja }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($jabatan->mulai)->format('d-m-Y') }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($jabatan->selesai)->format('d-m-Y') }}
                                                    </td>
                                                    <td>
                                                        <a href="#" class="btn btn-sm btn-warning">Edit</a>
                                                        <a href="#" class="btn btn-sm btn-danger">Hapus</a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center text-muted">Belum ada data
                                                        jabatan</td>
                                                </tr>
                                            @endforelse
                                        </tbody>

                                    </table>
                                </div>

                            </div>
                            <div class="tab-pane fade" id="str" role="tabpanel" aria-labelledby="str-tab">
                                <div class="mb-3 d-flex align-items-center">
                                    <button type="button" class="btn btn-success me-3" data-bs-toggle="modal"
                                        data-bs-target="#tambahModalSTR">
                                        Tambah Data STR
                                    </button>
                                    <div class="ms-auto">
                                        <a href="javascript:;" class="btn btn-sm btn-outline-secondary">View all</a>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table id="example5" class="table mb-0 table-striped table-hover table-sm">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>No STR</th>
                                                <th>Tanggal Terbit</th>
                                                <th>Tanggal Expired</th>
                                                <th>File</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($karyawan->str ?? [] as $index => $str)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $str->nomor }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($str->tgl_terbit)->format('d-m-Y') }}</td>
                                                    <td>
                                                        {{ $str->tgl_expired === '2060-12-31' ? 'Seumur Hidup' : \Carbon\Carbon::parse($str->tgl_expired)->format('d-m-Y') }}
                                                    </td>
                                                    <td>
                                                        @if ($str->file)
                                                            @if (Str::startsWith($str->file, 'http'))
                                                                <a href="{{ $str->file }}" target="_blank"
                                                                    class="btn btn-sm btn-info">Lihat Link</a>
                                                            @else
                                                                <a href="{{ asset('storage/' . $str->file) }}"
                                                                    target="_blank" class="btn btn-sm btn-info">Lihat
                                                                    File</a>
                                                            @endif
                                                        @else
                                                            <span class="text-muted">Tidak ada file</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <!-- Tombol Edit Modal -->
                                                        <button type="button" class="btn btn-sm btn-warning"
                                                            onclick='openEditModalSTR(@json($str))'>
                                                            Edit
                                                        </button>

                                                        <!-- Tombol Hapus -->
                                                        <form action="{{ route('str.destroy', $str->id) }}"
                                                            method="POST" style="display:inline-block;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger"
                                                                onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                                Hapus
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center text-muted">Belum ada data STR
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                            </div>

                            <div class="tab-pane fade" id="sip" role="tabpanel" aria-labelledby="sip-tab">
                                <div class="mb-3 d-flex align-items-center">
                                    <button type="button" class="btn btn-success me-3" data-bs-toggle="modal"
                                        data-bs-target="#tambahModalSIP">
                                        Tambah Data SIP
                                    </button>
                                    <div class="ms-auto">
                                        <a href="javascript:;" class="btn btn-sm btn-outline-secondary">View all</a>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table id="example6" class="table mb-0 table-striped table-hover table-sm">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>No SIP</th>
                                                <th>Tanggal Terbit</th>
                                                <th>Tanggal Expired</th>
                                                <th>Masa Aktif</th>
                                                <th>File</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($karyawan->sip ?? [] as $index => $sip)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $sip->nomor }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($sip->tgl_terbit)->format('d-m-Y') }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($sip->tgl_expired)->format('d-m-Y') }}
                                                    </td>
                                                    <td>{{ \Carbon\Carbon::parse($sip->tgl_terbit)->diffInDays($sip->tgl_expired) }}
                                                        hari</td>
                                                    <td>
                                                        @if ($sip->file && Str::startsWith($sip->file, 'http'))
                                                            <a href="{{ $sip->file }}" target="_blank"
                                                                class="btn btn-sm btn-info">Lihat Link</a>
                                                        @elseif ($sip->file)
                                                            <a href="{{ asset('storage/' . $sip->file) }}"
                                                                target="_blank" class="btn btn-sm btn-info">Lihat File</a>
                                                        @else
                                                            <span class="text-muted">Tidak ada file</span>
                                                        @endif
                                                    </td>

                                                    <td>
                                                        <a href="javascript:;"
                                                            onclick='openEditModalSIP(@json($sip))'
                                                            class="btn btn-sm btn-warning">Edit</a>
                                                        <form action="{{ route('sip.destroy', $sip->id) }}"
                                                            method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger"
                                                                onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="7" class="text-center">Belum ada data SIP</td>
                                                </tr>
                                            @endforelse
                                        </tbody>

                                    </table>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="spkrkk" role="tabpanel" aria-labelledby="spkrkk-tab">
                                <div class="mb-3 d-flex align-items-center">
                                    <button type="button" class="btn btn-success me-3" data-bs-toggle="modal"
                                        data-bs-target="#tambahModalSPKRKK">
                                        Tambah Data SPKRKK
                                    </button>
                                </div>

                                <!-- Form Input SPKRKK -->


                                <!-- Tabel Data SPKRKK -->

                                <div class="table-responsive mt-4">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Ruang Klinis</th>
                                                <th>Kualifikasi</th>
                                                <th>Masa Berlaku</th>
                                                <th>File</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($karyawan->spkrkk ?? [] as $spkrkk)
                                                <tr>
                                                    <td>{{ $spkrkk->ruang_klinis }}</td>
                                                    <td>{{ $spkrkk->kualifikasi }}</td>
                                                    <td>
                                                        {{ \Carbon\Carbon::parse($spkrkk->masa_berlaku_dari)->format('d-m-Y') }}
                                                        s/d
                                                        {{ \Carbon\Carbon::parse($spkrkk->masa_berlaku_sampai)->format('d-m-Y') }}
                                                    </td>
                                                    <td>
                                                        @php
                                                            $files = is_array($spkrkk->file_paths)
                                                                ? $spkrkk->file_paths
                                                                : json_decode($spkrkk->file_paths, true);
                                                        @endphp

                                                        @if (!empty($files))
                                                            @foreach ($files as $file)
                                                                @php
                                                                    $filename = basename($file);
                                                                    $url = route('preview.pdf', [
                                                                        'filename' => $filename,
                                                                    ]);
                                                                @endphp
                                                                <button type="button"
                                                                    class="btn btn-sm btn-outline-primary mb-1"
                                                                    onclick="showPdfModal('{{ $url }}', '{{ $filename }}')">
                                                                    {{ $filename }}
                                                                </button><br>
                                                            @endforeach
                                                        @else
                                                            <span class="text-danger">File tidak ditemukan</span>
                                                        @endif
                                                    </td>
                                                    <td class="d-flex gap-2">
                                                        {{-- Tombol Edit --}}
                                                        <button type="button"
                                                            class="btn btn-sm btn-warning btn-edit-spkrkk"
                                                            data-bs-toggle="modal" data-bs-target="#editModalSPKRKK"
                                                            data-id="{{ $spkrkk->id }}"
                                                            data-nomor_surat="{{ $spkrkk->nomor_surat }}"
                                                            data-ruang_klinis="{{ $spkrkk->ruang_klinis }}"
                                                            data-kualifikasi="{{ $spkrkk->kualifikasi }}"
                                                            data-masa_berlaku_dari="{{ \Carbon\Carbon::parse($spkrkk->masa_berlaku_dari)->format('Y-m-d') }}"
                                                            data-masa_berlaku_sampai="{{ \Carbon\Carbon::parse($spkrkk->masa_berlaku_sampai)->format('Y-m-d') }}">
                                                            <i class="ri-edit-line"></i>
                                                        </button>

                                                        {{-- Tombol Hapus --}}
                                                        <form action="{{ route('spkrkk.destroy', $spkrkk->id) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger">
                                                                <i class="ri-delete-bin-line"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>


                                    <!-- Modal PDF -->
                                    <!-- Modal -->
                                    <div class="modal fade" id="pdfModal" tabindex="-1"
                                        aria-labelledby="pdfModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-xl modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="pdfModalLabel">Lihat File PDF</h5>
                                                    <div class="d-flex gap-2">
                                                        <a id="downloadPdfBtn" href="#" class="btn btn-primary"
                                                            download target="_blank">Download PDF</a>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Tutup"></button>
                                                    </div>
                                                </div>
                                                <div class="modal-body p-0" style="height: 80vh;">
                                                    <div id="pdf-viewer" style="height: 100%; width: 100%;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- CDN PDFObject -->
                                    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.2.11/pdfobject.min.js"
                                        integrity="sha512-AHnNAB5vEtHYolDa1Jmn9f4zKDIkXeBeazb4tiP2R3ej6VVaKx5RxZXTp0MkcqY1w+GyxBLPfrGtxsyMF7XKLg=="
                                        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

                                    <!-- Script untuk membuka PDF di modal -->
                                    <script>
                                        function showPdfModal(pdfUrl, filename = "dokumen.pdf") {
                                            // Tampilkan file ke dalam elemen #pdf-viewer
                                            PDFObject.embed(pdfUrl, "#pdf-viewer", {
                                                height: "100%",
                                                pdfOpenParams: {
                                                    view: 'FitH',
                                                    toolbar: '1',
                                                    navpanes: '1',
                                                    statusbar: '1'
                                                }
                                            });

                                            // Set tautan download
                                            document.getElementById('downloadPdfBtn').href = pdfUrl;
                                            document.getElementById('downloadPdfBtn').download = filename;

                                            // Tampilkan modal
                                            const modal = new bootstrap.Modal(document.getElementById('pdfModal'));
                                            modal.show();
                                        }
                                    </script>

                                </div>

                                <div class="modal fade" id="editModalSPKRKK" tabindex="-1"
                                    aria-labelledby="editModalSPKRKKLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <form method="POST" enctype="multipart/form-data" class="modal-content"
                                            id="formEditSPKRKK">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="id" id="edit-id">

                                            <div class="modal-header bg-warning text-white">
                                                <h5 class="modal-title" id="editModalSPKRKKLabel">Edit Data SPKRKK</h5>
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="modal" aria-label="Tutup"></button>
                                            </div>

                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="mb-3 col-md-6">
                                                        <label class="form-label">Nomor Surat</label>
                                                        <input type="text" class="form-control" name="nomor_surat"
                                                            id="edit-nomor_surat" required>
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <label class="form-label">Ruang Klinis</label>
                                                        <input type="text" class="form-control" name="ruang_klinis"
                                                            id="edit-ruang_klinis" required>
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <label class="form-label">Kualifikasi</label>
                                                        <input type="text" class="form-control" name="kualifikasi"
                                                            id="edit-kualifikasi" required>
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <label class="form-label">Masa Berlaku Dari</label>
                                                        <input type="date" class="form-control"
                                                            name="masa_berlaku_dari" id="edit-masa_dari" required>
                                                    </div>
                                                    <div class="mb-3 col-md-6">
                                                        <label class="form-label">Masa Berlaku Sampai</label>
                                                        <input type="date" class="form-control"
                                                            name="masa_berlaku_sampai" id="edit-masa_sampai" required>
                                                    </div>
                                                    <hr class="my-4">

                                                    <div class="card border">
                                                        <div class="card-header bg-light fw-bold">Ganti Dokumen SPKRKK
                                                            (Opsional)</div>
                                                        <div class="card-body">
                                                            @php
                                                                $documents = [
                                                                    'Surat Penugasan Klinis',
                                                                    'Rincian Kewenangan Klinis',
                                                                    'Uraian Tugas',
                                                                ];
                                                            @endphp

                                                            @foreach ($documents as $doc)
                                                                <div class="row mb-3 align-items-center">
                                                                    <div class="col-md-6">
                                                                        <label
                                                                            class="form-label mb-0">{{ $doc }}</label>
                                                                        <input type="hidden" name="file_names[]"
                                                                            value="{{ $doc }}">
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <input type="file" name="files[]"
                                                                            accept="application/pdf" class="form-control">
                                                                        <small class="text-muted">Kosongkan jika tidak
                                                                            ingin mengganti</small>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-warning">Simpan Perubahan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>



                            </div>
                            @push('scripts')
                                <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.2.11/pdfobject.min.js"></script>
                                <script>
                                    function showPdfModal(pdfUrl, filename) {
                                        const isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);

                                        // Ambil elemen viewer
                                        const viewer = document.getElementById('pdf-viewer');

                                        if (isMobile) {
                                            // Fallback untuk perangkat mobile → gunakan Google Docs Viewer
                                            const googleViewerUrl = "https://docs.google.com/gview?embedded=true&url=" + encodeURIComponent(pdfUrl);
                                            viewer.innerHTML = `<iframe src="${googleViewerUrl}" style="width:100%;height:100%;border:none;"></iframe>`;
                                        } else {
                                            // Desktop → tampilkan dengan PDFObject
                                            PDFObject.embed(pdfUrl, "#pdf-viewer", {
                                                height: "100%",
                                                pdfOpenParams: {
                                                    view: 'FitH',
                                                    toolbar: '1',
                                                    navpanes: '1',
                                                    statusbar: '1'
                                                }
                                            });
                                        }

                                        // Update tombol download
                                        document.getElementById('downloadPdfBtn').href = pdfUrl;

                                        // Tampilkan modal
                                        const modal = new bootstrap.Modal(document.getElementById('pdfModal'));
                                        modal.show();
                                    }
                                </script>

                                <script>
                                    document.querySelectorAll('.btn-edit-spkrkk').forEach(button => {
                                        button.addEventListener('click', function() {
                                            const id = this.dataset.id;
                                            const nomorSurat = this.dataset.nomor_surat;
                                            const ruangKlinis = this.dataset.ruang_klinis;
                                            const kualifikasi = this.dataset.kualifikasi;
                                            const masaDari = this.dataset.masa_berlaku_dari;
                                            const masaSampai = this.dataset.masa_berlaku_sampai;

                                            document.getElementById('edit-id').value = id;
                                            document.getElementById('edit-nomor_surat').value = nomorSurat;
                                            document.getElementById('edit-ruang_klinis').value = ruangKlinis;
                                            document.getElementById('edit-kualifikasi').value = kualifikasi;
                                            document.getElementById('edit-masa_dari').value = masaDari;
                                            document.getElementById('edit-masa_sampai').value = masaSampai;

                                            // Ganti action form ke route update
                                            document.getElementById('formEditSPKRKK').action = `/spkrkk/${id}`;
                                        });
                                    });
                                </script>
                            @endpush


                            <!-- Modal Tambah SPKRKK -->
                            <div class="tab-pane fade" id="alamat" role="tabpanel" aria-labelledby="alamat-tab">
                                <div class="mb-3 d-flex align-items-center">
                                    <button type="button" class="btn btn-success me-3" data-bs-toggle="modal"
                                        data-bs-target="#modalDomisili">
                                        Tambah Alamat Domisili
                                    </button>
                                </div>

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
                                                        <button type="button"
                                                            class="btn btn-sm btn-warning btn-edit-alamat"
                                                            data-bs-toggle="modal" data-bs-target="#modalEditAlamat"
                                                            data-id="{{ $alamat->id }}"
                                                            data-provinsi="{{ $alamat->province_code }}"
                                                            data-kota="{{ $alamat->city_code }}"
                                                            data-kecamatan="{{ $alamat->district_code }}"
                                                            data-kelurahan="{{ $alamat->village_code }}"
                                                            data-alamat_lengkap="{{ $alamat->alamat_lengkap }}"
                                                            data-jenis="{{ $alamat->jenis }}">
                                                            <i class="ri-edit-line"></i>
                                                        </button>

                                                        <form action="{{ route('alamat.destroy', $alamat->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf @method('DELETE')
                                                            <button class="btn btn-sm btn-danger"
                                                                onclick="return confirm('Yakin hapus?')">
                                                                <i class="ri-delete-bin-line"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach

                                            @if ($alamatList->isEmpty())
                                                <tr>
                                                    <td colspan="7" class="text-center text-muted">Belum ada data
                                                        alamat</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>


                            <div class="modal fade" id="tambahModalSPKRKK" tabindex="-1"
                                aria-labelledby="tambahModalSPKRKKLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <form action="{{ route('spkrkk.store') }}" method="POST"
                                        enctype="multipart/form-data" class="modal-content">
                                        @csrf
                                        <input type="hidden" name="karyawan_id" value="{{ $karyawan->id }}">

                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title" id="tambahModalSPKRKKLabel">Tambah Data SPKRKK</h5>
                                            <button type="button" class="btn-close btn-close-white"
                                                data-bs-dismiss="modal" aria-label="Tutup"></button>
                                        </div>

                                        <div class="modal-body">
                                            {{-- Informasi Umum --}}
                                            <div class="row">
                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label">Nomor Surat</label>
                                                    <input type="text" class="form-control" name="nomor_surat"
                                                        required>
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label">Ruang Klinis</label>
                                                    <input type="text" class="form-control" name="ruang_klinis"
                                                        required>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label">Kualifikasi</label>
                                                    <input type="text" class="form-control" name="kualifikasi"
                                                        required>
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label">Masa Berlaku Dari</label>
                                                    <input type="date" class="form-control" name="masa_berlaku_dari"
                                                        required>
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label">Masa Berlaku Sampai</label>
                                                    <input type="date" class="form-control" name="masa_berlaku_sampai"
                                                        required>
                                                </div>
                                            </div>

                                            <hr class="my-4">

                                            {{-- Upload Dokumen --}}
                                            <div class="card border">
                                                <div class="card-header bg-light fw-bold">Upload Dokumen SPKRKK (PDF)</div>
                                                <div class="card-body">
                                                    @php
                                                        $documents = [
                                                            'Surat Penugasan Klinis',
                                                            'Rincian Kewenangan Klinis',
                                                            'Uraian Tugas',
                                                        ];
                                                    @endphp

                                                    @foreach ($documents as $doc)
                                                        <div class="row mb-3 align-items-center">
                                                            <div class="col-md-6">
                                                                <label class="form-label mb-0">{{ $doc }}</label>
                                                                <input type="hidden" name="file_names[]"
                                                                    value="{{ $doc }}">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <input type="file" name="files[]"
                                                                    accept="application/pdf" class="form-control"
                                                                    required>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>




        <!-- Tabel Riwayat Pendidikan -->


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

    <script>
        // Tambah Data STR Modal
        const tambahSTRModal = document.createElement('div');
        tambahSTRModal.innerHTML = `
    <div class="modal fade" id="tambahModalSTR" tabindex="-1" aria-labelledby="modalLabelSTR" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('str.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabelSTR">Tambah Data STR</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="karyawan_id" value="{{ $karyawan->id }}">
                        <div class="mb-3">
                            <label class="form-label">Nomor STR</label>
                            <input type="text" name="nomor" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Terbit</label>
                            <input type="date" name="tgl_terbit" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Expired</label>
                            <input type="date" name="tgl_expired" class="form-control">
                            <small class="form-text text-muted">Kosongkan jika seumur hidup</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Upload File STR (PDF/JPG/PNG)</label>
                            <input type="file" name="file" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Atau Link Google Drive</label>
                            <input type="url" name="file_url" class="form-control" placeholder="https://drive.google.com/....">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>`;
        document.body.appendChild(tambahSTRModal);

        // Tambah Data SIP Modal
        const tambahSIPModal = document.createElement('div');
        tambahSIPModal.innerHTML = `
    <div class="modal fade" id="tambahModalSIP" tabindex="-1" aria-labelledby="modalLabelSIP" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('sip.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabelSIP">Tambah Data SIP</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="karyawan_id" value="{{ $karyawan->id }}">
                        <div class="mb-3">
                            <label class="form-label">Nomor SIP</label>
                            <input type="text" name="nomor" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Terbit</label>
                            <input type="date" name="tgl_terbit" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Expired</label>
                            <input type="date" name="tgl_expired" class="form-control">
                            <small class="form-text text-muted">Kosongkan jika seumur hidup</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Upload File SIP (PDF/JPG/PNG)</label>
                            <input type="file" name="file" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Atau Link Google Drive</label>
                            <input type="url" name="file_url" class="form-control" placeholder="https://drive.google.com/....">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>`;
        document.body.appendChild(tambahSIPModal);
    </script>


    <script>
        function openEditModalSTR(str) {
            // Hapus modal lama jika ada
            const existingModal = document.getElementById('editModalSTR');
            if (existingModal) existingModal.remove();

            // Fungsi format tanggal YYYY-MM-DD
            const formatDate = (dateString) => {
                if (!dateString) return '';
                const d = new Date(dateString);
                const month = ('0' + (d.getMonth() + 1)).slice(-2);
                const day = ('0' + d.getDate()).slice(-2);
                return `${d.getFullYear()}-${month}-${day}`;
            };

            const modalEdit = document.createElement('div');
            modalEdit.innerHTML = `
        <div class="modal fade" id="editModalSTR" tabindex="-1" aria-labelledby="modalEditLabelSTR" aria-hidden="true">
            <div class="modal-dialog">
                <form method="POST" action="/str/${str.id}" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" value="PUT">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalEditLabelSTR">Edit Data STR</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="karyawan_id" value="${str.karyawan_id}">
                            <div class="mb-3">
                                <label class="form-label">Nomor STR</label>
                                <input type="text" name="nomor" class="form-control" value="${str.nomor ?? ''}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tanggal Terbit</label>
                                <input type="date" name="tgl_terbit" class="form-control" value="${formatDate(str.tgl_terbit)}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tanggal Expired</label>
                                <input type="date" name="tgl_expired" class="form-control" value="${str.tgl_expired !== '2060-12-31' ? formatDate(str.tgl_expired) : ''}">
                                <small class="form-text text-muted">Kosongkan jika seumur hidup</small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Upload File STR (PDF/JPG/PNG)</label>
                                <input type="file" name="file" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Atau Link Google Drive</label>
                                <input type="url" name="file_url" class="form-control" placeholder="https://drive.google.com/..." value="${str.file && str.file.startsWith('http') ? str.file : ''}">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>`;

            document.body.appendChild(modalEdit);
            const modal = new bootstrap.Modal(document.getElementById('editModalSTR'));
            modal.show();
        }
    </script>


    <script>
        function openEditModalSIP(sip) {
            // Hapus modal lama jika ada
            const existingModal = document.getElementById('editModalSIP');
            if (existingModal) existingModal.remove();

            const modalEdit = document.createElement('div');
            modalEdit.innerHTML = `
        <div class="modal fade" id="editModalSIP" tabindex="-1" aria-labelledby="modalEditLabelSIP" aria-hidden="true">
            <div class="modal-dialog">
                <form method="POST" action="/sip/${sip.id}" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" value="PUT">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalEditLabelSIP">Edit Data SIP</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="karyawan_id" value="${sip.karyawan_id}">
                            <div class="mb-3">
                                <label class="form-label">Nomor SIP</label>
                                <input type="text" name="nomor" class="form-control" value="${sip.nomor ?? ''}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tanggal Terbit</label>
                                <input type="date" name="tgl_terbit" class="form-control" value="${sip.tgl_terbit ?? ''}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tanggal Expired</label>
                                <input type="date" name="tgl_expired" class="form-control" value="${sip.tgl_expired ?? ''}">
                                <small class="form-text text-muted">Kosongkan jika seumur hidup</small>
                            </div>
                           <div class="mb-3">
                                <label class="form-label">File (opsional, upload atau link)</label>
                                <input type="file" name="file" class="form-control mb-2">
                                <input type="url" name="file_url" class="form-control" placeholder="https://drive.google.com/..." />
                                <small class="form-text text-muted">Pilih salah satu: upload file ATAU masukkan link Google Drive</small>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>`;

            document.body.appendChild(modalEdit);
            const modal = new bootstrap.Modal(document.getElementById('editModalSIP'));
            modal.show();
        }
    </script>
@endpush
            modal.show();
        }
    </script>
@endpush
