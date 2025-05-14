@extends('layouts.app')

@section('title', 'Laporan Presensi Bulanan')

@section('main')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="card">
                <div class="card-body">
                    @php
                    $month = (int) request('month', now()->month); // Pastikan ini di-cast ke integer
                    $monthName = \Carbon\Carbon::create()->month($month)->format('F');
                    $year = request('year', now()->year);
                @endphp
                    <h5 class="mb-3">Laporan Presensi Bulan {{ $monthName }} {{ $year }} - Mitra Husada Mandiri</h5>

                    <!-- Form untuk memilih bulan dan tahun -->
                    <form method="GET" action="{{ route('reports.monthly') }}">
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <select name="month" class="form-select">
                                    @foreach(range(1, 12) as $month)
                                        <option value="{{ $month }}" {{ request('month') == $month ? 'selected' : '' }}>
                                            {{ \Carbon\Carbon::create()->month($month)->format('F') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="year" class="form-select">
                                    @for($year = now()->year; $year >= 2000; $year--)
                                        <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary">Tampilkan</button>
                            </div>
                        </div>
                    </form>

                    <!-- Menu cetak PDF dan Excel -->
                    <div class="mb-3">
                        <a href="{{ route('reports.exportPdf', ['month' => request('month'), 'year' => request('year')]) }}" class="btn btn-danger">
                            Cetak PDF
                        </a>
                    </div>

                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Total Kehadiran</th>
                                <th>Keterlambatan</th>
                                <th>Pulang Cepat</th>
                                <th>Sesuai</th>
                                <th>Jumlah Izin</th>
                                <th>Tidak Hadir</th>
                                 <th>Wajib Hadir</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($report as $userId => $data)
                                <tr>
                                    <td>{{ $data['user_name'] }}</td>
                                    <td>{{ $data['total'] }}</td>
                                    <td>{{ $data['late'] }}</td>
                                    <td>{{ $data['early_leave'] }}</td>
                                    <td>{{ $data['on_time'] }}</td>
                                    <td>{{ $data['izin'] }}</td>
                                    <td>{{ $data['ketidakhadiran'] }}</td>
                                    <td>{{ $data['wajib_hadir'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
@endsection
