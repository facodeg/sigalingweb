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

        .data-grid {
            margin-left: 30px;
            margin-bottom: 25px;
        }

        .data-grid p {
            margin: 5px 0;
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

    <div class="title">SURAT KETERANGAN</div>
    <div class="nomor">Nomor: {{ $surat->no_surat ?? '__________' }}</div>

    <p>Yang bertanda tangan di bawah ini:</p>
    <div class="data-grid">
        <p>a. Nama : {{ $surat->penanda_tangan_nama ?? 'dr. Ridwan' }}</p>
        <p>b. Jabatan : {{ $surat->penanda_tangan_jabatan ?? 'Kepala Sub Bagian Kepegawaian' }}</p>
    </div>

    <p>Dengan ini menerangkan bahwa:</p>
    <div class="data-grid">
        <p>a. Nama / NIP : {{ $surat->praktikan_nama ?? '' }} /
            {{ $surat->nip ?? '' }}</p>
        <p>b. Pangkat / Golongan : {{ $surat->penanda_tangan_pangkat ?? '-' }}</p>
        <p>c. Jabatan : {{ $surat->profesi ?? '' }}</p>
        <p>d. TMT : {{ $surat->tmt ?? '' }}</p>
        <p>e. Maksud : {{ $surat->maksud ?? 'Untuk melengkapi syarat administrasi pengajuan KPR Perumahan' }}</p>
    </div>

    <p>Demikian Surat Keterangan ini dibuat untuk dipergunakan seperlunya.</p>

   <div class="ttd" style="text-align: Right; margin-top: 40px;">
        <p>Dikeluarkan di : {{ $surat->tempat_dikeluarkan }}</p>
        <p><u>Tanggal : {{ \Carbon\Carbon::parse($surat->tanggal_dikeluarkan)->translatedFormat('d F Y') }}</u></p>
        <br>
    <img src="{{ asset('assets/images/ttd-vitrie.jpg') }}" style="width: 300px;" alt="Tanda Tangan Direktur">
    <br><br>

    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>

</html>
