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
            <div class="col-12 col-lg-3">
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
                            <a href="{{ route('anggotas.edit', $anggota->id) }}" class="mb-3 btn btn-primary">Edit</a>

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


                {{-- <div class="card">
                            <div class="card-body">
                                <h5 class="mb-0 text-primary font-weight-bold">45.5 GB <span
                                        class="float-end text-secondary">50 GB</span></h5>
                                <p class="mt-2 mb-0"><span class="text-secondary">Used</span><span
                                        class="float-end text-primary">Upgrade</span>
                                </p>
                                <div class="mt-3 progress" style="height:7px;">
                                    <div class="progress-bar" role="progressbar" style="width: 15%" aria-valuenow="15"
                                        aria-valuemin="0" aria-valuemax="100"></div>
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: 30%"
                                        aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                    <div class="progress-bar bg-danger" role="progressbar" style="width: 20%"
                                        aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <div class="mt-3"></div>
                                <div class="d-flex align-items-center">
                                    <div class="fm-file-box bg-light-primary text-primary"><i class='bx bx-image'></i>
                                    </div>
                                    <div class="flex-grow-1 ms-2">
                                        <h6 class="mb-0">Images</h6>
                                        <p class="mb-0 text-secondary">1,756 files</p>
                                    </div>
                                    <h6 class="mb-0 text-primary">15.3 GB</h6>
                                </div>
                                <div class="mt-3 d-flex align-items-center">
                                    <div class="fm-file-box bg-light-success text-success"><i class='bx bxs-file-doc'></i>
                                    </div>
                                    <div class="flex-grow-1 ms-2">
                                        <h6 class="mb-0">Documents</h6>
                                        <p class="mb-0 text-secondary">123 files</p>
                                    </div>
                                    <h6 class="mb-0 text-primary">256 MB</h6>
                                </div>
                                <div class="mt-3 d-flex align-items-center">
                                    <div class="fm-file-box bg-light-danger text-danger"><i class='bx bx-video'></i>
                                    </div>
                                    <div class="flex-grow-1 ms-2">
                                        <h6 class="mb-0">Media Files</h6>
                                        <p class="mb-0 text-secondary">24 files</p>
                                    </div>
                                    <h6 class="mb-0 text-primary">3.4 GB</h6>
                                </div>
                                <div class="mt-3 d-flex align-items-center">
                                    <div class="fm-file-box bg-light-warning text-warning"><i class='bx bx-image'></i>
                                    </div>
                                    <div class="flex-grow-1 ms-2">
                                        <h6 class="mb-0">Other Files</h6>
                                        <p class="mb-0 text-secondary">458 files</p>
                                    </div>
                                    <h6 class="mb-0 text-primary">3 GB</h6>
                                </div>
                                <div class="mt-3 d-flex align-items-center">
                                    <div class="fm-file-box bg-light-info text-info"><i class='bx bx-image'></i>
                                    </div>
                                    <div class="flex-grow-1 ms-2">
                                        <h6 class="mb-0">Unknown Files</h6>
                                        <p class="mb-0 text-secondary">57 files</p>
                                    </div>
                                    <h6 class="mb-0 text-primary">178 GB</h6>
                                </div>
                            </div>
                        </div> --}}
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
                                                    <h5 class="mb-0">Total Simpanan</h5>
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
                                                <span>Rp {{ number_format($totalSimpanan, 0, ',', '.') }}</span>
                                            </p>

                                            <!-- Progress Bar -->
                                            <div class="mt-3">
                                                <div class="progress" style="height: 7px;">
                                                    @php
                                                        $progress = min(($totalSimpanan / 1500000) * 100, 100);
                                                    @endphp
                                                    <div class="progress-bar bg-warning" role="progressbar"
                                                        style="width: {{ $progress }}%;"
                                                        aria-valuenow="{{ $progress }}" aria-valuemin="0"
                                                        aria-valuemax="100"></div>
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
                                                    <h5 class="mb-0 ">Total Pinjaman</h5>
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
                                                <span>Rp {{ number_format($totalPinjaman, 0, ',', '.') }}</span>
                                                <span class="float-end">
                                                    RP 6.000.000
                                                </span>
                                            </p>
                                            <div class="mt-3">
                                                <div class="progress" style="height: 7px;">
                                                    @php
                                                        $progress = min(($totalPinjaman / 6000000) * 100, 100);
                                                    @endphp
                                                    <div class="progress-bar bg-warning" role="progressbar"
                                                        style="width: {{ $progress }}%;"
                                                        aria-valuenow="{{ $progress }}" aria-valuemin="0"
                                                        aria-valuemax="100"></div>
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
                                                    <h5 class="mb-0">Sisa Angsuran</h5>
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
                                                <span>Rp
                                                    {{ number_format($maxValue - $totalAngsuran, 0, ',', '.') }}</span>
                                                <span class="float-end">Rp
                                                    {{ number_format($totalAngsuran, 0, ',', '.') }}</span>
                                            </p>

                                            <!-- Progress Bar -->
                                            <div class="mt-3">
                                                <div class="progress" style="height: 7px;">
                                                    @php
                                                        $percentage =
                                                            $maxValue > 0
                                                                ? min(($totalAngsuran / $maxValue) * 100, 100)
                                                                : 0;
                                                    @endphp
                                                    <div class="progress-bar bg-warning" role="progressbar"
                                                        style="width: {{ $percentage }}%;" aria-valuemin="0"
                                                        aria-valuemax="100"></div>
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
                                        <div class="tab-title">Data Simpanan Wajib</div>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="pinjaman-tab" data-bs-toggle="tab" href="#pinjaman"
                                    role="tab" aria-selected="false">
                                    <div class="d-flex align-items-center">
                                        <div class="tab-icon"><i class='bx bx-credit-card font-18 me-1'></i></div>
                                        <div class="tab-title">Data Pinjaman</div>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="angsuran-tab" data-bs-toggle="tab" href="#angsuran"
                                    role="tab" aria-selected="false">
                                    <div class="d-flex align-items-center">
                                        <div class="tab-icon"><i class='bx bx-calendar-check font-18 me-1'></i>
                                        </div>
                                        <div class="tab-title">Data Angsuran</div>
                                    </div>
                                </a>
                            </li>
                        </ul>


                        <!-- Tab Content -->
                        <div class="mt-3 tab-content">
                            <!-- Data Simpanan Wajib Tab -->
                            <div class="tab-pane fade show active" id="simpanan" role="tabpanel"
                                aria-labelledby="simpanan-tab">
                                <div class="mb-3 d-flex align-items-center">
                                    <!-- Tombol Tambah Simpanan -->
                                    <button type="button" class="btn btn-success me-3" data-bs-toggle="modal"
                                        data-bs-target="#tambahModal">
                                        Tambah Simpanan
                                    </button>

                                    <!-- Tombol Perbarui -->
                                    {{-- <form action="{{ route('anggotas.updateSimpanan', $anggota->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">Perbarui</button>
                                    </form> --}}
                                    <div class="ms-auto">
                                        <a href="javascript:;" class="btn btn-sm btn-outline-secondary">View all</a>
                                    </div>
                                </div>


                                <div class="table-responsive">
                                    <table id="example2" class="table mb-0 table-striped table-hover table-sm">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>No Anggota <i class='bx bx-up-arrow-alt ms-2'></i></th>
                                                <th>Tanggal Simpanan</th>
                                                <th>Nominal</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($simpananWajib as $index => $simpanan)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $simpanan->no_anggota }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($simpanan->tgl_simpanan)->format('d M, Y') }}
                                                    </td>
                                                    <td>{{ number_format($simpanan->nominal, 2, ',', '.') }}</td>
                                                    <td>
                                                        @if ($simpanan->status == 1)
                                                            <span class="badge bg-success">Terbayarkan</span>
                                                        @else
                                                            <span class="badge bg-danger">Gagal Bayar</span>
                                                        @endif

                                                        <!-- Keterangan -->
                                                        @if (!is_null($simpanan->keterangan))
                                                            <div class="text-muted mt-1"><strong>Keterangan:</strong>
                                                                {{ $simpanan->keterangan }}</div>
                                                        @endif

                                                        <!-- Gambar Bukti -->
                                                        @if (!is_null($simpanan->bukti))
                                                            <div class="mt-1">
                                                                <a href="{{ asset('storage/' . $simpanan->bukti) }}"
                                                                    target="_blank">
                                                                    <img src="{{ asset('storage/' . $simpanan->bukti) }}"
                                                                        alt="Bukti Pembayaran"
                                                                        style="max-width: 100px; max-height: 100px;">
                                                                </a>
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <!-- Button trigger modal -->
                                                        <button type="button" class="btn btn-sm btn-primary"
                                                            data-bs-toggle="modal" data-bs-target="#editModal"
                                                            data-id="{{ $simpanan->id }}"
                                                            data-status="{{ $simpanan->status }}"
                                                            data-tgl_simpanan="{{ $simpanan->tgl_simpanan }}"
                                                            data-nominal="{{ $simpanan->nominal }}">
                                                            <i class='bx bx-edit'></i> Edit
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                </div>

                            </div>

                            <!-- Modal Tambah Simpanan -->
                            <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="tambahModalLabel">Tambah Simpanan Wajib</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('simpananwajib.baru') }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="no_anggota" class="form-label">No Anggota</label>
                                                    <input type="text" class="form-control" id="no_anggota"
                                                        name="no_anggota" value="{{ $anggota->no_anggota }}" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="tgl_simpanan" class="form-label">Tanggal Simpanan</label>
                                                    <input type="date" class="form-control" id="tgl_simpanan"
                                                        name="tgl_simpanan" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="nominal" class="form-label">Nominal</label>
                                                    <input type="number" class="form-control" id="nominal"
                                                        name="nominal" value="30000" required>
                                                </div>


                                                <div class="mb-3">
                                                    <label for="status1" class="form-label">Status Simpanan</label>
                                                    <select class="form-control select2" data-toggle="select2"
                                                        id="status1" name="status1">
                                                        <option value="" disabled selected>Pilih Data</option>
                                                        <option value="1">Terbayarkan</option>
                                                        <option value="0">Gagal Bayar</option>
                                                    </select>
                                                </div>
                                                <!-- Keterangan -->
                                                <div class="mb-3">
                                                    <label for="keterangan" class="form-label">Keterangan</label>
                                                    <input type="text" class="form-control" id="keterangan"
                                                        name="keterangan" value="{{ old('keterangan') }}">
                                                </div>

                                                <!-- Upload Bukti -->
                                                <div class="mb-3">
                                                    <label for="bukti" class="form-label">Bukti Pembayaran</label>
                                                    <input type="file" class="form-control" id="bukti"
                                                        name="bukti" accept="image/*">
                                                    <small class="form-text text-muted">Hanya file gambar yang
                                                        diperbolehkan (jpeg, png, jpg).</small>
                                                </div>


                                                <button type="submit" class="btn btn-success">Simpan</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>




                            <!-- Modal -->
                            <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel">Edit Simpanan Wajib</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="editForm" method="POST" action="">
                                                @csrf
                                                @method('PATCH')

                                                <div class="mb-3">
                                                    <label for="tgl_simpanan" class="form-label">Tanggal
                                                        Simpanan</label>
                                                    <input type="date" class="form-control" id="tgl_simpanan"
                                                        name="tgl_simpanan" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="nominal" class="form-label">Nominal</label>
                                                    <input type="number" class="form-control" id="nominal"
                                                        name="nominal" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="status" class="form-label">Status Simpanan</label>
                                                    <select class="form-control select2" data-toggle="select2"
                                                        id="status" name="status">
                                                        <option value="" disabled selected>Pilih Data</option>
                                                        <!-- Opsi default -->
                                                        <option value="1">Terbayarkan</option>
                                                        <option value="0">Gagal Bayar</option>
                                                    </select>
                                                </div>


                                                <button type="submit" class="btn btn-primary">Simpan
                                                    Perubahan</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Data Pinjaman Tab -->
                            <div class="tab-pane fade" id="pinjaman" role="tabpanel" aria-labelledby="pinjaman-tab">
                                <!-- Tambahkan tabel data pinjaman di sini -->
                                <div class="mt-3 table-responsive">
                                    <table id="example3" class="table mb-0 table-striped table-hover table-sm">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>No Pinjaman</th>
                                                <th>No Anggota</th>
                                                <th>Tanggal Pinjaman</th>
                                                <th>Nominal</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pinjaman as $index => $p)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $p->no_pinjaman }}</td>
                                                    <td>{{ $p->no_anggota }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($p->tgl_pinjaman)->format('d M, Y') }}
                                                    </td>
                                                    <td>{{ number_format($p->nominal, 2, ',', '.') }}</td>
                                                    <td>{{ $p->status }}</td>
                                                    <td><i class='bx bx-dots-horizontal-rounded font-24'></i></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Data Angsuran Tab -->
                            <div class="tab-pane fade" id="angsuran" role="tabpanel" aria-labelledby="angsuran-tab">
                                <div class="mt-3 table-responsive">
                                    <table id="example4" class="table mb-0 table-striped table-hover table-sm">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>No Angsuran</th>
                                                <th>No Pinjaman</th>
                                                <th>Tanggal Angsuran</th>
                                                <th>Nominal</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($angsuran as $index => $a)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $a->no_angsuran }}</td>
                                                    <td>{{ $a->no_pinjaman }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($a->tgl_angsuran)->format('d M, Y') }}
                                                    </td>
                                                    <td>{{ number_format($a->nominal, 2, ',', '.') }}</td>
                                                    <td>{{ $a->status }}</td>
                                                    <td><i class='bx bx-dots-horizontal-rounded font-24'></i></td>
                                                </tr>
                                            @endforeach
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
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var editModal = document.getElementById('editModal');
            editModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                var id = button.getAttribute('data-id');
                var status = button.getAttribute('data-status');
                var tgl_simpanan = button.getAttribute('data-tgl_simpanan');
                var nominal = button.getAttribute('data-nominal');

                var modalForm = editModal.querySelector('form#editForm');
                var inputTglSimpanan = editModal.querySelector('#tgl_simpanan');
                var inputNominal = editModal.querySelector('#nominal');
                var inputStatus = editModal.querySelector('#status');

                // Set the form action dynamically
                modalForm.action = '/simpanan_wajib/' + id;

                // Set the current values in the input fields
                inputTglSimpanan.value = tgl_simpanan;
                inputNominal.value = nominal;
                inputStatus.value = status;
            });
        });
    </script>

    <script>
        // Pastikan dokumen sudah dimuat sepenuhnya sebelum menjalankan JavaScript
        document.addEventListener("DOMContentLoaded", function() {
            // Ambil elemen form
            const tambahSimpananForm = document.querySelector("#tambahModal form");

            // Tambahkan event listener untuk validasi sebelum submit
            tambahSimpananForm.addEventListener("submit", function(event) {
                const noAnggota = document.querySelector("#no_anggota").value;
                const tglSimpanan = document.querySelector("#tgl_simpanan").value;
                const nominal = document.querySelector("#nominal").value;
                const status1 = document.querySelector("#status1").value; // Perbarui ID

                // Jika ada input yang kosong, cegah pengiriman form
                if (!noAnggota || !tglSimpanan || !nominal || !status1) {
                    event.preventDefault();
                    alert("Semua field harus diisi!");
                }
            });
        });
    </script>
@endpush
