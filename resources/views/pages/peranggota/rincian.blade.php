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
        @if ($anggota->status == 'aktif')
            <div class="row">

                <div class="col-12 ">
                    <div class="card">
                        <div class="card-body">

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
                                                    <div>
                                                        <h5 class="mb-0">Total Pinjaman</h5>
                                                    </div>

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
                                                        Rp
                                                        {{ number_format($limitPinjaman->limit ?? $limitSemua->limit, 0, ',', '.') }}
                                                    </span>
                                                </p>
                                                <div class="mt-3">
                                                    <div class="progress" style="height: 7px;">
                                                        @php
                                                            $maxLimit = $limitPinjaman->limit ?? $limitSemua->limit;
                                                            $progress = min(($totalPinjaman / $maxLimit) * 100, 100);
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
                                                        </td>

                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
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

                                        </div>
                                    </div>
                                </div>

                                <!-- Data Pinjaman Tab -->
                                <div class="tab-pane fade" id="pinjaman" role="tabpanel"
                                    aria-labelledby="pinjaman-tab">
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

                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Data Angsuran Tab -->
                                <div class="tab-pane fade" id="angsuran" role="tabpanel"
                                    aria-labelledby="angsuran-tab">
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
        @elseif ($anggota->status == 'pending')
            <div class="row">
                <div class="container-fluid">


                    <div class="row">
                        <div class="col-12">
                            <div class="timeline" dir="ltr">
                                <div class="mb-3 text-center timeline-show">
                                    <h5 class="m-0 time-show-name">Today</h5>
                                </div>

                                <!-- Timeline items -->
                                <div class="timeline-lg-item timeline-item-left">
                                    <div class="timeline-desk">
                                        <div class="timeline-box">
                                            <span class="arrow-alt"></span>
                                            <span class="timeline-icon bg-success-subtle"><i
                                                    class="ri-record-circle-fill text-success"></i></span>
                                            <h4 class="mt-0 mb-1 fs-16">Pembuatan akun Anda telah berhasil</h4>
                                            <p class="text-muted"><small>{{ now()->format('d M, Y') }}</small></p>
                                            <p>Nama: {{ $anggota->nama }}<br>No Anggota: {{ $anggota->no_anggota }}</p>
                                            <p>Selamat! Akun Anda telah berhasil dibuat</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="timeline-lg-item timeline-item-right">
                                    <div class="timeline-desk">
                                        <div class="timeline-box">
                                            <span class="arrow-alt"></span>
                                            <span class="timeline-icon bg-danger-subtle"><i
                                                    class="ri-record-circle-fill text-danger"></i></span>

                                            <p>Tahap selanjutnya adalah melengkapi data untuk melakukan pengajuan
                                                pendaftaran anggota koperasi.</p>
                                            <a href="{{ url('/anggota/' . $anggota->no_anggota . '/edit') }}"
                                                class="btn btn-sm btn-primary">Klik di sini untuk melengkapi data</a>

                                        </div>
                                    </div>
                                </div>

                                <!-- More timeline items... -->

                            </div>
                            <!-- end timeline -->
                        </div>
                    </div>
                </div>
            </div>
        @elseif ($anggota->status == 'proses')
            <div class="row">
                <div class="container-fluid">


                    <div class="row">
                        <div class="col-12">
                            <div class="timeline" dir="ltr">
                                <div class="mb-3 text-center timeline-show">
                                    <h5 class="m-0 time-show-name">Today</h5>
                                </div>

                                <!-- Timeline items -->
                                <div class="timeline-lg-item timeline-item-left">
                                    <div class="timeline-desk">
                                        <div class="timeline-box">
                                            <span class="arrow-alt"></span>
                                            <span class="timeline-icon bg-success-subtle"><i
                                                    class="ri-record-circle-fill text-success"></i></span>
                                            <h4 class="mt-0 mb-1 fs-16">Pembuatan akun Anda telah berhasil</h4>

                                            <p>Selamat! Akun Anda telah berhasil dibuat</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="timeline-lg-item timeline-item-right">
                                    <div class="timeline-desk">
                                        <div class="timeline-box">
                                            <span class="arrow-alt"></span>
                                            <span class="timeline-icon bg-success-subtle"><i
                                                    class="ri-record-circle-fill text-success"></i></span>
                                            <p class="text-muted"><small>{{ now()->format('d M, Y') }}</small></p>
                                            <p>Tahap selanjutnya adalah melengkapi data untuk melakukan pengajuan
                                                pendaftaran anggota koperasi.</p>

                                        </div>
                                    </div>
                                </div>

                                <div class="timeline-lg-item timeline-item-left">
                                    <div class="timeline-desk">
                                        <div class="timeline-box">
                                            <span class="arrow-alt"></span>
                                            <span class="timeline-icon bg-success-subtle"><i
                                                    class="ri-record-circle-fill text-success"></i></span>
                                            <p class="text-muted"><small>{{ now()->format('d M, Y') }}</small></p>
                                            <h4 class="mt-0 mb-1 fs-16">Pengajuan pendaftaran anggota koperasi Berhasil
                                            </h4>
                                            <p class="text-muted"><small>{{ now()->format('d M, Y') }}</small></p>
                                            <p>Nama: {{ $anggota->nama }}<br>No Anggota: {{ $anggota->no_anggota }}</p>


                                        </div>
                                    </div>
                                </div>

                                <!-- More timeline items... -->

                            </div>
                            <!-- end timeline -->
                        </div>
                    </div>
                </div>
            </div>
        @endif
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
    {{-- <script src="{{ asset('assets/js/app.min.js') }}"></script> --}}


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
@endpush
