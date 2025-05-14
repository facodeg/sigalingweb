@extends('layouts.app')

@section('title', 'Dashboard Pendidikan')

@section('main')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex justify-content-between align-items-md-center flex-md-row flex-column">
                    <h2 class="page-title">Dashboard Pendidikan</h2>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3">
            <div class="col">
                <div class="card widget-icon-box text-bg-primary">
                    <div class="card-body">
                        <h5 class="text-uppercase fs-13">Jumlah Pegawai</h5>
                        <h3 class="my-3">{{ $totalPegawai }}</h3>
                        <p class="mb-0 text-white text-opacity-75">Data keseluruhan</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card widget-icon-box text-bg-success">
                    <div class="card-body">
                        <h5 class="text-uppercase fs-13">Pendidikan Terisi</h5>
                        <h3 class="my-3">{{ $jumlahPendidikanTerisi }}</h3>
                        <p class="mb-0 text-white text-opacity-75">Nama sekolah terisi</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card widget-icon-box text-bg-danger">
                    <div class="card-body">
                        <h5 class="text-uppercase fs-13">Pendidikan Tidak Terisi</h5>
                        <h3 class="my-3">{{ $jumlahPendidikanKosong }}</h3>
                        <p class="mb-0 text-white text-opacity-75">Nama sekolah kosong</p>
                    </div>
                </div>
            </div>




        </div>

        @php
            $daftarStatus = ['PNS', 'PPPK', 'BLUD Tetap', 'BLUD Kontrak', 'TAMU', 'PTT'];
        @endphp
        <div class="flex-row flex-wrap gap-2 mt-4 d-flex">
            @foreach ($daftarStatus as $status)
                <div class="card widget-icon-box text-bg-info" style="width: 200px;">
                    <div class="text-center card-body">
                        <h5 class="text-uppercase fs-13">{{ $status }}</h5>
                        <h3 class="my-3">{{ $statusPG[$status] ?? 0 }}</h3>
                        <p class="mb-0 text-white text-opacity-75">Jumlah Pegawai</p>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="row">
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="mb-3">Chart 10 Sekolah Terbanyak</h5>
                        <div id="chart-sekolah" style="height: 350px;"></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="mb-3">Chart 10 Tahun Terbanyak</h5>
                        <div id="chart-tahun" style="height: 350px;"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-4 card">
            <div class="card-body">
                <h5 class="mb-3">Peringkat Sekolah Berdasarkan Jumlah Pegawai</h5>
                <div class="table-responsive">
                    <table id="example3" class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 20%; white-space: normal;">Nama Sekolah</th>
                                <th style="width: 20%;">Jumlah Pegawai</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sekolahTerbanyak as $sekolah => $jumlah)
                                <tr>
                                    <td>{{ $sekolah }}</td>
                                    <td>{{ $jumlah }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="mt-4 card">
            <div class="card-body">
                <h5 class="mb-3">Peringkat Sekolah Berdasarkan Jumlah Pegawai</h5>
                <div class="table-responsive">
                    <table id="example5" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>NIP</th>
                                <th>Jenis Kelamin</th>
                                <th>Jabatan</th>
                                <th>Pendidikan</th>
                                <th>Nama Sekolah</th>
                                <th>Tahun</th>
                                <th>Status</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pendidikan as $item)
                                <tr>
                                    <td>{{ $item->nama }}</td>
                                    <td>{{ $item->nip }}</td>
                                    <td>{{ $item->jk }}</td>
                                    <td>{{ $item->jabatan }}</td>
                                    <td>{{ $item->pendidikan }}</td>
                                    <td>{{ $item->nama_sekolah }}</td>
                                    <td>{{ $item->Tahun }}</td>
                                    <td>{{ $item->status_pg }}</td>


                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mt-4 card">
            <div class="card-body">
                <h5 class="mb-3">Jumlah Pegawai per Tahun Lulus</h5>
                <div class="table-responsive">
                    <table id="example2" class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Tahun</th>
                                <th>Jumlah Pegawai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tahunPendidikan as $tahun => $jumlah)
                                <tr>
                                    <td>{{ $tahun }}</td>
                                    <td>{{ $jumlah }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>



        <div class="mt-4 card">
            <div class="card-body">
                <h5 class="mb-3">Jumlah Pegawai Berdasarkan Tingkat Pendidikan</h5>
                <div class="table-responsive">
                    <table id="example4" class="table align-middle table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 20%; white-space: normal;">Tingkat Pendidikan</th>
                                <th style="width: 20%;">Jumlah Pegawai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pendidikanPerTingkat as $tingkat => $jumlah)
                                <tr>
                                    <td style="white-space: normal;">{{ $tingkat }}</td>
                                    <td>{{ $jumlah }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>







    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#example2').DataTable({
                responsive: true,
                dom: 'Bfrtip',
                buttons: ['copy', 'excel', 'pdf', 'print']
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#example3').DataTable({
                responsive: false,
                dom: 'Bfrtip',
                buttons: ['copy', 'excel', 'pdf', 'print']
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#example4').DataTable({

                dom: 'Bfrtip',
                buttons: ['copy', 'excel', 'pdf', 'print']
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#example5').DataTable({

                dom: 'Bfrtip',
                buttons: ['copy', 'excel', 'pdf', 'print']
            });
        });
    </script>
    <script>
        // Chart 10 Sekolah Terbanyak
        var sekolahChart = new ApexCharts(document.querySelector("#chart-sekolah"), {
            chart: {
                type: 'bar',
                height: 350
            },
            series: [{
                name: 'Jumlah Pegawai',
                data: {!! json_encode(array_values(array_slice($sekolahTerbanyak, 0, 10))) !!}
            }],
            xaxis: {
                categories: {!! json_encode(array_keys(array_slice($sekolahTerbanyak, 0, 10))) !!},
                labels: {
                    style: {
                        fontSize: '12px'
                    }
                }
            }
        });
        sekolahChart.render();

        // Chart 5 Tahun Terbanyak
        var top5Tahun = Object.entries(@json($tahunPendidikan))
            .sort((a, b) => b[1] - a[1])
            .slice(0, 10);

        var tahunChart = new ApexCharts(document.querySelector("#chart-tahun"), {
            chart: {
                type: 'bar',
                height: 350
            },
            series: [{
                name: 'Jumlah Pegawai',
                data: top5Tahun.map(item => item[1])
            }],
            xaxis: {
                categories: top5Tahun.map(item => item[0]),
                labels: {
                    style: {
                        fontSize: '12px'
                    }
                }
            }
        });
        tahunChart.render();
    </script>
@endpush
