@extends('layouts.app')

@section('title', 'Daftar Anggota')

@section('main')
    <!--wrapper-->



    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex justify-content-between align-items-md-center flex-md-row flex-column">
                    <h4 class="page-title">Rincian Data Pegawai</h4>
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

        <!--end breadcrumb-->
        <div class="row">
            <div class="col-12 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-column align-items-center">
                            <!-- Foto Karyawan -->
                            @if (empty($karyawan->upload_foto_diri))
                                @php
                                    $avatarIndex = rand(1, 5); // Index 1-5 untuk Laki-laki, 6-10 untuk Perempuan
                                    $avatarFile =
                                        $karyawan->jk == 'L'
                                            ? 'avatar-' . $avatarIndex . '.jpg'
                                            : 'avatar-' . ($avatarIndex + 5) . '.jpg';
                                @endphp
                                <img src="{{ asset('assets/images/users/' . $avatarFile) }}" alt="user-image" width="150"
                                    class="rounded-circle">
                            @else
                                <img src="{{ asset('storage/' . $karyawan->upload_foto_diri) }}"
                                    class="shadow rounded-circle" height="150" alt="User Avatar" />
                            @endif

                            <!-- Nama Karyawan -->
                            <h5 class="my-3">{{ $karyawan->nama }}</h5>

                            <!-- Tombol Edit -->
                            <a href="{{ route('karyawan.edit', $karyawan->id) }}" class="mb-3 btn btn-primary">Edit</a>
                        </div>


                        <div class="fm-menu">
                            <div class="list-group list-group-flush">
                                <!-- Ruangan -->
                                <a href="javascript:;" class="py-1 list-group-item">
                                    <i class='ri-first-aid-kit-line me-2'></i>
                                    <span>{{ $karyawan->ruangan }}</span>
                                </a>

                                <!-- Status Kepegawaian -->
                                <a href="javascript:;" class="py-1 list-group-item">
                                    <i class='ri-list-settings-line me-2'></i>
                                    <span>{{ $karyawan->status_kepegawaian }}</span>
                                </a>

                                <!-- Tanggal Lahir -->
                                <a href="javascript:;" class="py-1 list-group-item">
                                    <i class='ri-calendar-2-line me-2'></i>
                                    <span>
                                        @php
                                            $tanggalLahir = \Carbon\Carbon::parse($karyawan->tgl_lahir);
                                            $formattedDateLahir = $tanggalLahir->format('d-m-Y');
                                        @endphp
                                        {{ $formattedDateLahir }}
                                    </span>
                                </a>

                                <!-- Umur -->
                                <a href="javascript:;" class="py-1 list-group-item">
                                    <i class='ri-user-line me-2'></i>
                                    <span>{{ $karyawan->umur_tahun }} tahun {{ $karyawan->umur_bulan }} bulan</span>
                                </a>

                                <!-- NIK -->
                                <a href="javascript:;" class="py-1 list-group-item">
                                    <i class='ri-bank-card-line me-2'></i>
                                    <span>{{ $karyawan->nik }}</span>
                                </a>

                                <!-- Alamat -->
                                <a href="javascript:;" class="py-1 list-group-item">
                                    <i class='ri-home-line me-2'></i>
                                    <span>{{ $karyawan->alamat_ktp }}</span>
                                </a>

                                <!-- Status Pernikahan -->
                                <a href="javascript:;" class="py-1 list-group-item">
                                    <i class='ri-heart-line me-2'></i>
                                    <span>{{ $karyawan->status }}</span>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
            <div class="col-12 col-lg-9">
                <div class="card">
                    <div class="card-body">
                        <div class="fm-search">
                            <div class="mb-0">
                                <div class="input-group input-group-lg"> <span class="bg-transparent input-group-text"><i
                                            class='ri-search-line'></i></span>
                                    <input type="text" class="form-control" placeholder="Search the files">
                                </div>
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
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="simpanan-tab" data-bs-toggle="tab" href="#simpanan"
                                    role="tab" aria-selected="true">
                                    <div class="d-flex align-items-center">
                                        <div class="tab-icon"><i class='bx bx-wallet font-18 me-1'></i></div>
                                        <div class="tab-title">Data Keluarga</div>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="pinjaman-tab" data-bs-toggle="tab" href="#pinjaman"
                                    role="tab" aria-selected="false">
                                    <div class="d-flex align-items-center">
                                        <div class="tab-icon"><i class='bx bx-credit-card font-18 me-1'></i></div>
                                        <div class="tab-title">Data Pendidikan</div>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="angsuran-tab" data-bs-toggle="tab" href="#angsuran"
                                    role="tab" aria-selected="false">
                                    <div class="d-flex align-items-center">
                                        <div class="tab-icon"><i class='bx bx-calendar-check font-18 me-1'></i>
                                        </div>
                                        <div class="tab-title">Data Jabatan</div>
                                    </div>
                                </a>
                            </li>
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
                        </ul>


                        <!-- Tab Content -->
                        <div class="mt-3 tab-content">
                            <!-- Tab: Data Keluarga -->
                            <div class="tab-pane fade show active" id="simpanan" role="tabpanel"
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
                            </div>

                            <!-- Tab: Data Pendidikan -->
                            <div class="tab-pane fade" id="pinjaman" role="tabpanel" aria-labelledby="pinjaman-tab">
                                <div class="mb-3 d-flex align-items-center">
                                    <button type="button" class="btn btn-success me-3" data-bs-toggle="modal"
                                        data-bs-target="#tambahModalPendidikan">
                                        Tambah Data Pendidikan
                                    </button>

                                    <!-- Modal Tambah -->
                                    <div class="modal fade" id="tambahModalPendidikan" tabindex="-1"
                                        aria-labelledby="modalLabelPendidikan" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <form method="POST" action="{{ route('pendidikan.store') }}">
                                                @csrf
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Tambah Data Pendidikan</h5>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <input type="hidden" name="pegawai_id"
                                                            value="{{ $karyawan->id }}">
                                                        <div class="mb-3"><label>Jenjang</label><input type="text"
                                                                name="jenjang" class="form-control" required></div>
                                                        <div class="mb-3"><label>Institusi</label><input type="text"
                                                                name="institusi" class="form-control" required></div>
                                                        <div class="mb-3"><label>Program Studi</label><input
                                                                type="text" name="program_studi" class="form-control">
                                                        </div>
                                                        <div class="mb-3"><label>Tahun Lulus</label><input
                                                                type="number" name="tahun_lulus" class="form-control"
                                                                required></div>
                                                    </div>
                                                    <div class="modal-footer"><button type="submit"
                                                            class="btn btn-primary">Simpan</button></div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
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
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($karyawan->pendidikan ?? [] as $index => $pendidikan)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $pendidikan->jenjang }}</td>
                                                    <td>{{ $pendidikan->institusi }}</td>
                                                    <td>{{ $pendidikan->prodi }}</td>
                                                    <td>{{ $pendidikan->tahun_lulus }}</td>
                                                    <td>
                                                        <a href="#" class="btn btn-sm btn-warning">Edit</a>
                                                        <a href="#" class="btn btn-sm btn-danger">Hapus</a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center text-muted">Belum ada data
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
                                                        <a href="javascript:;" class="btn btn-sm btn-warning"
                                                            onclick='openEditModalPendidikan(@json($pendidikan))'>Edit</a>
                                                        <form action="{{ route('pendidikan.destroy', $pendidikan->id) }}"
                                                            method="POST" style="display:inline;">
                                                            @csrf @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger"
                                                                onclick="return confirm('Hapus data ini?')">Hapus</button>
                                                        </form>
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
    <script src="{{ asset('assets/vendor/select2/js/select2.min.js') }}"></script>

    <!-- Daterangepicker Plugin js -->
    <script src="{{ asset('assets/vendor/daterangepicker/moment.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/daterangepicker/daterangepicker.js') }}"></script>

    <!-- Input Mask Plugin js -->

    <!-- App js -->
    <script src="{{ asset('assets/js/app.min.js') }}"></script>


    <script src="{{ asset('assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            var table = $('#example2').DataTable({
                lengthChange: true,
                buttons: ['copy', 'excel', 'pdf', 'print']
            });

            table.buttons().container()
                .appendTo('#example2_wrapper .col-md-6:eq(0)');
        });

        $(document).ready(function() {
            var table = $('#example3').DataTable({
                lengthChange: true,
                buttons: ['copy', 'excel', 'pdf', 'print']
            });

            table.buttons().container()
                .appendTo('#example3_wrapper .col-md-6:eq(0)');
        });
        $(document).ready(function() {
            var table = $('#example4').DataTable({
                lengthChange: true,
                buttons: ['copy', 'excel', 'pdf', 'print']
            });

            table.buttons().container()
                .appendTo('#example4_wrapper .col-md-6:eq(0)');
        });
        $(document).ready(function() {
            $('#example5').DataTable({
                lengthChange: true,
                buttons: ['copy', 'excel', 'pdf', 'print']
            }).
            table.buttons().container()
                .appendTo('#example5_wrapper .col-md-6:eq(0)');
        });
        $(document).ready(function() {
            $('#example6').DataTable({
                lengthChange: true,
                buttons: ['copy', 'excel', 'pdf', 'print']
            })
            table.buttons().container()
                .appendTo('#example6_wrapper .col-md-6:eq(0)');
        });
    </script>

    <script>
        function openEditModalPendidikan(pendidikan) {
            const existing = document.getElementById('editModalPendidikan');
            if (existing) existing.remove();

            const modal = document.createElement('div');
            modal.innerHTML = `
        <div class="modal fade" id="editModalPendidikan" tabindex="-1">
            <div class="modal-dialog">
                <form method="POST" action="/pendidikan/${pendidikan.id}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" value="PUT">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Data Pendidikan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="pegawai_id" value="${pendidikan.pegawai_id}">
                            <div class="mb-3"><label>Jenjang</label><input type="text" name="jenjang" class="form-control" value="${pendidikan.jenjang}" required></div>
                            <div class="mb-3"><label>Institusi</label><input type="text" name="institusi" class="form-control" value="${pendidikan.institusi}" required></div>
                            <div class="mb-3"><label>Program Studi</label><input type="text" name="program_studi" class="form-control" value="${pendidikan.program_studi ?? ''}"></div>
                            <div class="mb-3"><label>Tahun Lulus</label><input type="number" name="tahun_lulus" class="form-control" value="${pendidikan.tahun_lulus}" required></div>
                        </div>
                        <div class="modal-footer"><button type="submit" class="btn btn-primary">Simpan Perubahan</button></div>
                    </div>
                </form>
            </div>
        </div>`;
            document.body.appendChild(modal);
            new bootstrap.Modal(document.getElementById('editModalPendidikan')).show();
        }
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
