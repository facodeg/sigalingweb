@extends('layouts.app')

@section('title', 'Dashboard')

@section('main')
    
        
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div
                            class="page-title-box justify-content-between d-flex align-items-lg-center flex-lg-row flex-column">
                            <h4 class="page-title">Dashboard</h4>
                            <form class="mb-2 d-flex mb-xxl-0">
                                <div class="input-group">
                                    <input type="text" class="border-0 shadow form-control" id="dash-daterange">
                                    <span class="text-white input-group-text bg-primary border-primary">
                                        <i class="ri-calendar-todo-fill fs-13"></i>
                                    </span>
                                </div>
                                <a href="javascript: void(0);" class="btn btn-primary ms-2">
                                    <i class="ri-refresh-line"></i>
                                </a>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h5 class="mb-3">Presensi</h5>



                        <table class="table table-striped table-bordered" id="example2">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Nama</th>
                                    <th>Time In</th>
                                    <th>Time In Status</th>
                                    <th>Time Out</th>
                                    <th>Time Out Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($attendances as $item)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($item->date)->format('d-m-Y') }}</td>
                                        <td>{{ $item->user->name }}</td>
                                        <td>{{ $item->time_in }}</td>
                                        <td
                                            class="{{ Carbon\Carbon::parse($item->time_in)->gt(Carbon\Carbon::parse($company->time_in)) ? 'bg-danger text-white' : 'bg-success text-white' }}">
                                            <span
                                                class=" {{ Carbon\Carbon::parse($item->time_in)->gt(Carbon\Carbon::parse($company->time_in)) ? 'bg-danger' : 'bg-success' }}">
                                                {{ Carbon\Carbon::parse($item->time_in)->gt(Carbon\Carbon::parse($company->time_in)) ? 'Terlambat' : 'Sesuai' }}
                                            </span>
                                        </td>
                                        <td>{{ $item->time_out }}</td>
                                        <td
                                            class="{{ Carbon\Carbon::parse($item->time_out)->lt(Carbon\Carbon::parse($company->time_out)) ? 'bg-warning text-dark' : 'bg-success text-white' }}">
                                            <span
                                                class=" {{ Carbon\Carbon::parse($item->time_out)->lt(Carbon\Carbon::parse($company->time_out)) ? 'bg-warning text-dark' : 'bg-success' }}">
                                                {{ Carbon\Carbon::parse($item->time_out)->lt(Carbon\Carbon::parse($company->time_out)) ? 'Pulang Cepat' : 'Sesuai' }}
                                            </span>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row row-cols-1 row-cols-md-2 row-cols-xl-2">
                    <div class="col">
                        <div class="card radius-10">
                            <div class="card-body">
                                <div id="lateEarlyChart"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card radius-10">
                            <div class="card-body">
                                <div id="attendanceChart"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="izinChart"></div>
            </div>
        

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="{{ asset('assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            var table = $('#example2').DataTable({
                lengthChange: true,
                order: [
                    [2, 'desc']
                ], // Order by Date descending
                columnDefs: [{
                        targets: [3, 4],
                        type: 'num'
                    }, // Ensure numeric sorting on these columns
                ],
                buttons: ['copy', 'excel', 'pdf', 'print']
            });

            table.buttons().container()
                .appendTo('#example2_wrapper .col-md-6:eq(0)');
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Data for izin chart
            var izinChartData = @json($izinChartData);

            Highcharts.chart('izinChart', {
                chart: {
                    type: 'pie',
                    height: 350
                },
                title: {
                    text: 'Distribusi Izin'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                },
                accessibility: {
                    point: {
                        valueSuffix: '%'
                    }
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                        }
                    }
                },
                series: [{
                    name: 'Jumlah Izin',
                    colorByPoint: true,
                    data: Object.keys(izinChartData).map(function(key) {
                        return {
                            name: key,
                            y: izinChartData[key]
                        };
                    })
                }]
            });

            // Data for attendance (late, early leave, and on-time)
            var attendanceData = @json($attendances);

            var lateCount = @json($lateCount);
            var earlyLeaveCount = @json($earlyLeaveCount);
            var onTimeCount = @json($onTimeCount);

            var attendanceOptions = {
                series: [{
                    name: 'Jumlah',
                    data: [lateCount, earlyLeaveCount, onTimeCount]
                }],
                chart: {
                    type: 'bar',
                    height: 350
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        endingShape: 'rounded'
                    },
                },
                dataLabels: {
                    enabled: false
                },
                xaxis: {
                    categories: ['Terlambat', 'Pulang Cepat', 'Sesuai'],
                }
            };

            var attendanceChart = new ApexCharts(document.querySelector("#attendanceChart"), attendanceOptions);
            attendanceChart.render();

            // Highcharts Pie Chart for Late, Early Leave, and On-Time
            Highcharts.chart('lateEarlyChart', {
                chart: {
                    type: 'pie',
                    height: 350
                },
                title: {
                    text: 'Distribusi Terlambat, Pulang Cepat, dan Sesuai'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                },
                accessibility: {
                    point: {
                        valueSuffix: '%'
                    }
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                        }
                    }
                },
                series: [{
                    name: 'Jumlah',
                    colorByPoint: true,
                    data: [{
                        name: 'Terlambat',
                        y: lateCount
                    }, {
                        name: 'Pulang Cepat',
                        y: earlyLeaveCount
                    }, {
                        name: 'Sesuai',
                        y: onTimeCount
                    }]
                }]
            });
        });
    </script>
@endpush
