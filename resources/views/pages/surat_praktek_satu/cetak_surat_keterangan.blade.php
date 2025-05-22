<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Keterangan</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 1cm 2.25cm 0.3cm 2.54cm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12pt;
            margin: 1cm 2.25cm 0.3cm 2.54cm;
            line-height: 1.5;
        }

        .title {
            text-align: center;
            font-weight: bold;
            text-decoration: underline;
            margin-top: 20px;
        }

        .nomor {
            text-align: center;
            margin-bottom: 30px;
        }

        table.info-table {
            margin-left: 30px;
            line-height: 1.7;
            font-size: 12pt;
        }

        table.info-table td {
            vertical-align: top;
        }

        .ttd {
            margin-top: 40px;
            text-align: right;
        }

        .ttd img {
            width: 180px;
            height: auto;
        }
    </style>
</head>

<body>
    <!-- Kop Surat -->
    <table style="width: 100%; text-align: center;">
        <tr>
            <td style="width: 80px;">
                <img src="{{ asset('assets/images/logo-kiri.png') }}" style="width: 80px;" alt="Logo Kiri">
            </td>
            <td>
                <div style="line-height: 1.4;">
                    <strong style="font-size: 16pt;">PEMERINTAH KABUPATEN BOGOR</strong><br>
                    <span style="font-size: 14pt; font-weight: bold;">RUMAH SAKIT UMUM DAERAH LEUWILIANG</span><br>
                    <span style="font-size: 11pt;">
                        Jl. Raya Cibeber - Leuwiliang Bogor Kode Pos 16640<br>
                        Telp. (0251) 8643290, Fax. (0251) 8643291<br>
                        Email: rsudleuwiliang@bogorkab.go.id
                    </span>
                </div>
            </td>
            <td style="width: 80px;">
                <img src="{{ asset('assets/images/logo-kanan.png') }}" style="width: 80px;" alt="Logo Kanan">
            </td>
        </tr>
    </table>

    <hr style="border: none; border-top: 1px solid black; margin: 0;">
    <hr style="border: none; border-top: 4px solid black; margin-top: 1px;">

    <!-- Judul -->
    <div class="title">SURAT KETERANGAN</div>
    <div class="nomor">Nomor: {{ $surat->no_surat ?? '__________' }}</div>

    <!-- Penandatangan -->
    <p>Yang bertanda tangan di bawah ini:</p>
    <table class="info-table" style="width: 100%; border-collapse: collapse;">
        <tr>
            <td style="width: 20px;">a.</td>
            <td style="width: 200px;">Nama</td>
            <td style="width: 10px;">:</td>
            <td>{{ $surat->penanda_tangan_nama ?? 'dr. Ridwan' }}</td>
        </tr>
        <tr>
            <td>b.</td>
            <td>Jabatan</td>
            <td>:</td>
            <td>{{ $surat->penanda_tangan_jabatan ?? 'Kepala Sub Bagian Kepegawaian' }}</td>
        </tr>
    </table>

    <p style="margin-top: 20px;">Dengan ini menerangkan bahwa:</p>
    <table class="info-table" style="width: 100%; border-collapse: collapse;">
        <tr>
            <td style="width: 20px;">a.</td>
            <td style="width: 200px;">Nama / NIP</td>
            <td style="width: 10px;">:</td>
            <td>
                {{ $surat->praktikan_nama ?? '' }}<br>
                {{ $surat->nip ?? '' }}
            </td>
        </tr>
        <tr>
            <td>b.</td>
            <td>Pangkat / Golongan</td>
            <td>:</td>
            <td>{{ $surat->praktikan_penanda_tangan ?? '-' }}</td>
        </tr>
        <tr>
            <td>c.</td>
            <td>Jabatan</td>
            <td>:</td>
            <td>{{ $surat->profesi ?? '' }}</td>
        </tr>
        <tr>
            <td>d.</td>
            <td>TMT</td>
            <td>:</td>
            <td>{{ $surat->tmt ?? '' }}</td>
        </tr>
        <tr>
            <td>e.</td>
            <td>Maksud</td>
            <td>:</td>
            <td>{{ $surat->maksud ?? 'Untuk melengkapi syarat administrasi pengajuan KPR Perumahan' }}</td>
        </tr>
    </table>


    <p>Demikian Surat Keterangan ini dibuat untuk dipergunakan seperlunya.</p>

    <!-- Tanda Tangan -->
    <div class="ttd">
        <p>Dikeluarkan di : {{ $surat->tempat_dikeluarkan ?? 'Leuwiliang' }}</p>
        <p><u>Tanggal : {{ \Carbon\Carbon::parse($surat->tanggal_dikeluarkan)->translatedFormat('d F Y') }}</u></p>

        @if ($surat->penanda_tangan_nama === 'dr. Ridwan')
            <img src="{{ asset('assets/images/ttd-ridwan.jpg') }}" style="width: 300px;" alt="Tanda Tangan dr. Ridwan">
        @elseif ($surat->penanda_tangan_nama === 'dr. Vitrie Winastri, S.H., MARS')
            <img src="{{ asset('assets/images/ttd-vitrie.jpg') }}" style="width: 300px;" alt="Tanda Tangan dr. Vitrie">
        @endif

        <br><br>
    </div>


    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>

</html>
