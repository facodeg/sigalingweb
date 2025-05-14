<!DOCTYPE html>
<html>
<head>
    <title>Laporan Presensi Bulanan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    @php
    $month = (int) request('month', now()->month); // Pastikan ini di-cast ke integer
    $monthName = \Carbon\Carbon::create()->month($month)->format('F');
    $year = request('year', now()->year);
    @endphp

    <h3>Laporan Presensi Bulanan</h3>
    <p>Laporan Presensi Bulan {{ $monthName }} {{ $year }} - Mitra Husada Mandiri</p>
    
    <table>
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
</body>
</html>
