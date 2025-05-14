@extends('layouts.app')

@section('title', 'Dashboard Koperasi')

@section('main')

    <div class="container-fluid">
        <div class="row">

            <div class="col-12">
                <div class="page-title-box justify-content-between d-flex align-items-md-center flex-md-row flex-column">
                    <h2 class="page-title">Dashboard Koperasi </h2>

                </div>
            </div>
        </div>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-4"> <!-- Mengubah menjadi 4 kolom -->
            <div class="col">
                <div class="card widget-icon-box text-bg-success">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="overflow-hidden flex-grow-1">
                                <h5 class="mt-0 text-uppercase fs-13" title="Total Simpanan Wajib">Total Simpanan Wajib</h5>
                                <h3 class="my-3">Rp {{ number_format($totalSimpananWajib, 0, ',', '.') }}</h3>
                                <p class="mb-0 text-white text-opacity-75 text-truncate">
                                    <span class="bg-white bg-opacity-25 badge me-1"><i class="ri-arrow-up-line"></i>
                                        {{ $changeSimpananWajib }}</span>
                                    <span>Since last week</span>
                                </p>
                            </div>
                            <div class="flex-shrink-0 avatar-sm">
                                <span
                                    class="text-white bg-white bg-opacity-25 rounded shadow avatar-title rounded-3 fs-3 widget-icon-box-avatar">
                                    <i class="ri-wallet-3-line"></i>
                                </span>
                            </div>
                        </div>
                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col-->

            <div class="col">
                <div class="card widget-icon-box text-bg-warning">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="overflow-hidden flex-grow-1">
                                <h5 class="mt-0 text-uppercase fs-13" title="Total Pinjaman">Total Pinjaman</h5>
                                <h3 class="my-3">Rp {{ number_format($totalPinjaman, 0, ',', '.') }}</h3>
                                <p class="mb-0 text-white text-opacity-75 text-truncate">
                                    <span class="bg-white bg-opacity-25 badge me-1"><i class="ri-arrow-up-line"></i>
                                        {{ $changePinjaman }}</span>
                                    <span>Since last week</span>
                                </p>
                            </div>
                            <div class="flex-shrink-0 avatar-sm">
                                <span
                                    class="text-white bg-white bg-opacity-25 rounded shadow avatar-title rounded-3 fs-3 widget-icon-box-avatar">
                                    <i class="ri-pages-line"></i>
                                </span>
                            </div>
                        </div>
                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col-->

            <div class="col">
                <div class="card widget-icon-box text-bg-danger">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="overflow-hidden flex-grow-1">
                                <h5 class="mt-0 text-uppercase fs-13" title="Total Angsuran">Total Angsuran</h5>
                                <h3 class="my-3">Rp {{ number_format($totalAngsuran, 0, ',', '.') }}</h3>
                                <p class="mb-0 text-white text-opacity-75 text-truncate">
                                    <span class="bg-white bg-opacity-25 badge me-1"><i class="ri-arrow-down-line"></i>
                                        {{ $changeAngsuran }}</span>
                                    <span>Since last week</span>
                                </p>
                            </div>
                            <div class="flex-shrink-0 avatar-sm">
                                <span
                                    class="text-white bg-white bg-opacity-25 rounded shadow avatar-title rounded-3 fs-3 widget-icon-box-avatar">
                                    <i class="ri-file-paper-line"></i>
                                </span>
                            </div>
                        </div>
                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col-->

            <div class="col">
                <div class="card widget-icon-box text-bg-primary">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="overflow-hidden flex-grow-1">
                                <h5 class="mt-0 text-uppercase fs-13" title="Total Simpanan Pokok">Total Simpanan Pokok</h5>
                                <h3 class="my-3">Rp {{ number_format($totalSimpananPokok, 0, ',', '.') }}</h3>
                                <p class="mb-0 text-white text-opacity-75 text-truncate">
                                    <span class="bg-white bg-opacity-25 badge me-1"><i class="ri-bank-line"></i></span>
                                    <span>Current Savings</span>
                                </p>
                            </div>
                            <div class="flex-shrink-0 avatar-sm">
                                <span
                                    class="text-white bg-white bg-opacity-25 rounded shadow avatar-title rounded-3 fs-3 widget-icon-box-avatar">
                                    <i class="ri-bank-line"></i>
                                </span>
                            </div>
                        </div>
                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col-->


        </div> <!-- end row -->

        <!-- Tambahan kolom Total Simpanan Pokok -->
        <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-2">

            <!-- Tambahan kolom Total Anggota -->
            <div class="col">
                <div class="card widget-icon-box " style="background-color: #6f42c1;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="overflow-hidden flex-grow-1">
                                <h5 class="mt-0 text-white text-uppercase fs-13" title="Total Anggota">Total Anggota</h5>
                                <h3 class="my-3 text-white">{{ $totalAnggota }}</h3>
                                <p class="mb-0 text-white text-opacity-75 text-truncate">
                                    <span class="bg-white bg-opacity-25 badge me-1"><i class="ri-group-line"></i></span>
                                    <span>Current Members</span>
                                </p>
                            </div>
                            <div class="flex-shrink-0 avatar-sm">
                                <span
                                    class="text-white bg-white bg-opacity-25 rounded shadow avatar-title rounded-3 fs-3 widget-icon-box-avatar">
                                    <i class="ri-user-line"></i>
                                </span>
                            </div>
                        </div>
                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col-->
            <div class="col">
                <div class="card widget-icon-box text-bg-info">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="overflow-hidden flex-grow-1">
                                <h5 class="mt-0 text-uppercase fs-13" title="Total Anggota Tidak Aktif">Total Anggota Tidak
                                    Aktif</h5>
                                <h3 class="my-3">{{ $totalAnggotaStatusTidak }}</h3>
                                <p class="mb-0 text-white text-opacity-75 text-truncate">
                                    <span class="bg-white bg-opacity-25 badge me-1"><i
                                            class="ri-close-circle-line"></i></span>
                                    <span>Inactive Members</span>
                                </p>
                            </div>
                            <div class="flex-shrink-0 avatar-sm">
                                <span
                                    class="text-white bg-white bg-opacity-25 rounded shadow avatar-title rounded-3 fs-3 widget-icon-box-avatar">
                                    <i class="ri-close-circle-line"></i>
                                </span>
                            </div>
                        </div>
                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col-->
        </div>

        <div class="card">
            <div class="card-body">
                <h5 class="mb-3">Dashboard Koperasi </h5>

                <div id="chart22"></div>


            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <table class="table mt-5 table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Bulan</th>
                            <th>Total Pinjaman</th>
                            <th>Total Angsuran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($chartData['months'] as $index => $month)
                            <tr>
                                <td>{{ $month }}</td>
                                <td>Rp {{ number_format($chartData['pinjaman_totals'][$index], 2, ',', '.') }}</td>
                                <td>Rp {{ number_format($chartData['angsuran_totals'][$index], 2, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <th></th>
                            <th>Jumlah Pinjaman</th>
                            <th>Jumlah Angsuran dan Total Sisa Angsuran</th>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Rp {{ number_format(array_sum($chartData['pinjaman_totals']), 2, ',', '.') }}</td>
                            <td>
                                Rp {{ number_format(array_sum($chartData['angsuran_totals']), 2, ',', '.') }}<br>
                                Total Sisa Angsuran: Rp {{ number_format($chartData['totalSisaAngsuran'], 2, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-2">
            <div class="col">
                <div class="card radius-10">
                    <div class="card-body">
                        <div id="chart23" class="apex-charts"></div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10">
                    <div class="card-body">
                        <div id="chart24" class="apex-charts"></div>
                    </div>
                </div>
            </div>
        </div>



        <div class="row">
            <div class="col-xl-12 d-flex">
                <div class="card radius-10 w-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <h5 class="mb-1">Riwayat Transaksi</h5>
                                <p class="mb-0 font-13 text-secondary"><i class='bx bxs-calendar'></i> dalam 30 hari
                                    terakhir</p>
                            </div>
                            <div class="dropdown ms-auto">
                                <a class="dropdown-toggle dropdown-toggle-nocaret" href="#"
                                    data-bs-toggle="dropdown">
                                    <i class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="javascript:;">Aksi</a></li>
                                    <li><a class="dropdown-item" href="javascript:;">Aksi lainnya</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="javascript:;">Lainnya</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="mt-4 table-responsive">
                            <table id="example2" class="table table-striped table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nama</th>
                                        <th>Pinjaman</th>
                                        <th>Angsuran Terakhir</th>
                                        <th>Jumlah Angsuran</th>
                                        <th>Sisa Pinjaman</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pinjamans as $pinjaman)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <a href="{{ route('anggotas.rincian', $pinjaman->anggota->id) }}">
                                                            @if (empty($pinjaman->anggota->upload_foto_diri))
                                                                {{-- Use a static number or generate a random number between 1 and 14 --}}
                                                                @php
                                                                    $avatarIndex = rand(1, 10);
                                                                @endphp
                                                                <img src="{{ asset('assets/images/users/avatar-' . $avatarIndex . '.jpg') }}"
                                                                    alt="user-image" width="45"
                                                                    class="rounded-circle">
                                                            @else
                                                                <img src="{{ asset('storage/' . $pinjaman->anggota->upload_foto_diri) }}"
                                                                    class="shadow rounded-circle" height="45"
                                                                    alt="User Avatar" />
                                                            @endif
                                                        </a>
                                                    </div>
                                                    <div class="ms-2">
                                                        <h6 class="mb-1 font-14">{{ $pinjaman->anggota->nama }}</h6>
                                                        <p class="mb-0 font-13 text-secondary">No Anggota:
                                                            {{ $pinjaman->anggota->no_anggota }}</p>
                                                        <p class="mb-0 font-13 text-secondary">Tanggal Pinjaman:
                                                            {{ \Carbon\Carbon::parse($pinjaman->tgl_pinjaman)->format('d-m-Y') }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>

                                            <td data-order="{{ $pinjaman->nominal }}">
                                                Rp {{ number_format($pinjaman->nominal, 0, ',', '.') }}
                                            </td>
                                            <td data-order="{{ $pinjaman->tanggal_angsuran_terakhir }}">
                                                {{ $pinjaman->tanggal_angsuran_terakhir ? \Carbon\Carbon::parse($pinjaman->tanggal_angsuran_terakhir)->format('d-m-Y') : '-' }}
                                            </td>
                                            <td data-order="{{ $pinjaman->total_angsuran }}">
                                                Rp {{ number_format($pinjaman->total_angsuran, 0, ',', '.') }}
                                            </td>
                                            <td data-order="{{ $pinjaman->sisa_pinjaman }}">
                                                Rp {{ number_format($pinjaman->sisa_pinjaman, 0, ',', '.') }}
                                            </td>
                                            <td>
                                                @if ($pinjaman->sisa_pinjaman == 0)
                                                    <div class="badge rounded-pill bg-success text-dark w-100">Lunas
                                                    </div>
                                                @elseif ($pinjaman->tanggal_angsuran_terakhir)
                                                    <div class="badge rounded-pill bg-info text-dark w-100">Angsuran
                                                        Berjalan</div>
                                                @else
                                                    <div class="badge rounded-pill bg-danger text-dark w-100">Belum
                                                        Bayar</div>
                                                @endif
                                            </td>
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

@endsection

@push('scripts')
    <!-- CSS and JS Libraries -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>

    <!-- DataTables Initialization -->
    <script>
        $(document).ready(function() {
            var table = $('#example2').DataTable({
                lengthChange: true,
                order: [
                    [2, 'desc'] // Urutkan berdasarkan kolom Angsuran Terakhir secara menurun
                ],
                columnDefs: [{
                    targets: [2, 4, 5],
                    type: 'num'
                }],
                buttons: ['copy', 'excel', 'pdf', 'print']
            });

            table.buttons().container()
                .appendTo('#example2_wrapper .col-md-6:eq(0)');
        });
    </script>

    <!-- Chart Initialization -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var chartData = @json($chartData);

            var options = {
                series: [{
                        name: 'Total Pinjaman',
                        data: chartData.pinjaman_totals
                    },
                    {
                        name: 'Total Angsuran (Tanpa Diskon)',
                        data: chartData.angsuran_totals
                    }
                ],
                chart: {
                    foreColor: '#9ba7b2',
                    height: 360,
                    type: 'line',
                    zoom: {
                        enabled: false
                    },
                    toolbar: {
                        show: true
                    },
                    dropShadow: {
                        enabled: true,
                        top: 3,
                        left: 14,
                        blur: 4,
                        opacity: 0.10,
                    }
                },
                stroke: {
                    width: 5,
                    curve: 'smooth'
                },
                xaxis: {
                    type: 'category',
                    categories: chartData.months,
                },
                title: {
                    text: 'Total Pinjaman dan Total Angsuran Per Bulan',
                    align: 'left',
                    style: {
                        fontSize: "16px",
                        color: '#666'
                    }
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shade: 'light',
                        gradientToColors: ['#0d6efd', '#00c3ff', '#ff5f6d'],
                        shadeIntensity: 1,
                        type: 'horizontal',
                        opacityFrom: 0.7,
                        opacityTo: 0.9,
                        stops: [0, 100, 100, 100]
                    }
                },
                markers: {
                    size: 4,
                    colors: ["#0d6efd", "#00c3ff", "#ff5f6d"],
                    strokeColors: "#ffffff",
                    strokeWidth: 2,
                    hover: {
                        size: 7,
                    }
                },
                yaxis: {
                    title: {
                        text: 'Jumlah (Rp)'
                    }
                },
                responsive: [{
                    breakpoint: 1000,
                    options: {
                        plotOptions: {
                            bar: {
                                horizontal: false
                            }
                        },
                        legend: {
                            position: "bottom"
                        }
                    }
                }]
            };

            var chart = new ApexCharts(document.querySelector("#chart22"), options);
            chart.render();
        });
    </script>

    <!-- Status Kepegawaian and Unit Kerja Charts Initialization -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Data untuk ApexCharts
            var statusKepegawaianData = @json($chartData['status_kepegawaian']);
            var unitKerjaData = @json($chartData['unit_kerja']);

            // Opsi untuk Status Kepegawaian
            var optionsStatusKepegawaian = {
                chart: {
                    type: 'donut',
                    height: 360,
                    dropShadow: {
                        enabled: true,
                        color: "#111",
                        top: -1,
                        left: 3,
                        blur: 3,
                        opacity: 0.2
                    },
                    stroke: {
                        show: true,
                        width: 2
                    }
                },
                title: {
                    text: 'Jumlah Anggota Berdasarkan Status Kepegawaian'
                },
                series: Object.values(statusKepegawaianData),
                labels: Object.keys(statusKepegawaianData),
                colors: ['#00c3ff', '#ff5f6d', '#0d6efd'],
                dataLabels: {
                    dropShadow: {
                        blur: 3,
                        opacity: 0.8
                    }
                },
                fill: {
                    type: "pattern",
                    opacity: 1,
                    pattern: {
                        enabled: true,
                        style: ["verticalLines", "squares", "horizontalLines", "circles", "slantedLines"]
                    }
                },
                states: {
                    hover: {
                        enabled: false
                    }
                },
                legend: {
                    show: true,
                    position: "bottom",
                    horizontalAlign: "center",
                    verticalAlign: "middle",
                    floating: false,
                    fontSize: "14px",
                    offsetX: 0,
                    offsetY: 7
                },
                responsive: [{
                    breakpoint: 600,
                    options: {
                        chart: {
                            height: 240
                        },
                        legend: {
                            show: false
                        }
                    }
                }]
            };

            // Opsi untuk Unit Kerja
            var optionsUnitKerja = {
                chart: {
                    type: 'donut',
                    height: 360,
                    dropShadow: {
                        enabled: true,
                        color: "#111",
                        top: -1,
                        left: 3,
                        blur: 3,
                        opacity: 0.2
                    },
                    stroke: {
                        show: true,
                        width: 2
                    }
                },
                title: {
                    text: 'Jumlah Anggota Berdasarkan Unit Kerja'
                },
                series: Object.values(unitKerjaData),
                // Menambahkan angka di bagian nama unit kerja
                labels: Object.keys(unitKerjaData).map(function(unitKerja, index) {
                    return unitKerja + ' (' + unitKerjaData[unitKerja] + ')';
                }),
                colors: ['#00c3ff', '#ff5f6d', '#0d6efd'],
                dataLabels: {
                    dropShadow: {
                        blur: 3,
                        opacity: 0.8
                    }
                },
                fill: {
                    type: "pattern",
                    opacity: 1,
                    pattern: {
                        enabled: true,
                        style: ["verticalLines", "squares", "horizontalLines", "circles", "slantedLines"]
                    }
                },
                states: {
                    hover: {
                        enabled: false
                    }
                },
                legend: {
                    show: true,
                    position: "bottom",
                    horizontalAlign: "center",
                    verticalAlign: "middle",
                    floating: false,
                    fontSize: "14px",
                    offsetX: 0,
                    offsetY: 7
                },
                responsive: [{
                    breakpoint: 600,
                    options: {
                        chart: {
                            height: 240
                        },
                        legend: {
                            show: false
                        }
                    }
                }]
            };

            // Render chart untuk Status Kepegawaian
            var chartStatusKepegawaian = new ApexCharts(document.querySelector("#chart23"),
                optionsStatusKepegawaian);
            chartStatusKepegawaian.render();

            // Render chart untuk Unit Kerja
            var chartUnitKerja = new ApexCharts(document.querySelector("#chart24"), optionsUnitKerja);
            chartUnitKerja.render();
        });
    </script>
@endpush
