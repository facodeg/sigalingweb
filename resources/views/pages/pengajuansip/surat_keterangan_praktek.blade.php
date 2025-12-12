<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Surat Keterangan Hari dan Jam Praktek</title>

    <style>
        @page {
            size: A4 portrait;
            margin: 1.6cm 2cm;
        }

        body {
            font-family: "Arial", sans-serif;
            font-size: 11pt;
            color: #000;
            margin: 0;
        }

        .kop-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 4px;
        }

        .kop-table td {
            vertical-align: middle;
            padding: 0;
        }

        .kop-logo {
            width: 92px;
            text-align: center;
            padding: 0 6px;
        }

        .kop-logo img {
            max-width: 84px;
            max-height: 84px;
            width: auto;
            height: auto;
            display: inline-block;
        }

        .kop-center {
            text-align: center;
            line-height: 1.05;
            padding: 0 6px;
        }

        .kop-center .line1 {
            font-weight: 700;
            font-size: 15pt;
            margin-bottom: 2px;
        }

        .kop-center .line2 {
            font-weight: 700;
            font-size: 13pt;
            margin-bottom: 2px;
        }

        .kop-center .addr {
            font-size: 9pt;
            margin-top: 2px;
        }

        hr.thin {
            border: none;
            border-top: 1px solid #000;
            margin: 6px 0 2px;
        }

        hr.thick {
            border: none;
            border-top: 3px solid #000;
            margin: 0 0 8px;
        }

        .title-wrap {
            text-align: center;
            margin-top: 8px;
        }

        .title {
            font-weight: 700;
            text-transform: uppercase;
            font-size: 11pt;
            border-bottom: 2px solid #000;
        }

        .nomor {
            text-align: center;
            margin-top: 2px;
            margin-bottom: 10px;
            font-size: 10 pt;
        }

        .container {
            padding: 6px;
        }

        .lead {
            margin-bottom: 8px;
        }

        table.data-table {
            width: 100%;
            border-collapse: collapse;
        }

        table.data-table td {
            padding: 4px 6px;
            vertical-align: top;
            font-size: 11pt;
        }

        .label {
            width: 150px;

        }

        .sep {
            width: 6px;
        }

        .paragraph {
            line-height: 1.40;
            text-align: justify;
        }

        .sign-row {
            width: 100%;
            margin-top: 26px;
        }

        .sign-right {
            width: 260px;
            float: right;
            text-align: center;
            font-size: 11pt;
        }

        .ttd-img {
            width: 180px;
            margin: 5px auto 0 auto;
            display: block;
        }
    </style>
</head>

<body>

    <!-- HEADER -->
    <table class="kop-table" role="presentation">
        <tr>
            <td class="kop-logo" style="text-align:left;">
                @if (!empty($logoKiri))
                    <img src="data:image/png;base64,{{ $logoKiri }}" alt="logo kiri">
                @else
                    <img src="{{ asset('assets/images/logo-kiri.png') }}" alt="logo kiri">
                @endif
            </td>

            <td class="kop-center">
                <div class="line1">PEMERINTAH KABUPATEN BOGOR</div>
                <div class="line2">RUMAH SAKIT UMUM DAERAH LEUWILIANG</div>
                <div class="addr">
                    Jl. Raya Cibeber - Leuwiliang Bogor Kode Pos 16640<br>
                    Telp. (0251) 8643290, Fax. (0251) 8643291<br>
                    Email: rsudleuwiliang@bogorkab.go.id
                </div>
            </td>

            <td class="kop-logo" style="text-align:right;">
                @if (!empty($logoKanan))
                    <img src="data:image/png;base64,{{ $logoKanan }}" alt="logo kanan">
                @else
                    <img src="{{ asset('assets/images/logo-kanan.png') }}" alt="logo kanan">
                @endif
            </td>
        </tr>
    </table>

    <hr class="thin">
    <hr class="thick">

    <div class="title-wrap">
        <span class="title">Surat Keterangan Hari dan Jam Praktek</span>
    </div>

    <div class="nomor">
        Nomor: <b>{{ $sip->no_surat ?? '' }}</b>
    </div>

    <div class="container">

        <div class="lead">Yang bertanda tangan di bawah ini:</div>

        <table class="data-table" role="presentation">
            <tr>
                <td class="label">Nama</td>
                <td class="sep">:</td>
                <td><b>dr. Vitrie Winastri, S.H., MARS</b></td>
            </tr>
            <tr>
                <td class="label">NIP</td>
                <td class="sep">:</td>
                <td>196710192002122002</td>
            </tr>
            <tr>
                <td class="label">Pangkat/Gol</td>
                <td class="sep">:</td>
                <td>Pembina Utama Muda, IV/c</td>
            </tr>
            <tr>
                <td class="label">Jabatan</td>
                <td class="sep">:</td>
                <td>Direktur RSUD Leuwiliang</td>
            </tr>
        </table>

        <div class="lead" style="margin-top:10px;">Dengan ini menerangkan bahwa:</div>

        <table class="data-table" role="presentation">
            <tr>
                <td class="label">Nama</td>
                <td class="sep">:</td>
                <td><b>{{ $sip->nama }}</b></td>
            </tr>
            <tr>
                <td class="label">Alamat Praktek</td>
                <td class="sep">:</td>
                <td>{{ $sip->alamat_praktek ?? 'RSUD Leuwiliang' }}</td>
            </tr>
            <tr>
                <td class="label">Profesi</td>
                <td class="sep">:</td>
                <td>{{ $sip->profesi }}</td>
            </tr>
        </table>

        <!-- >>> BAGIAN YANG DIHARD-CODE (TIDAK AMBIL DARI DB) <<< -->
        <p class="paragraph" style="margin-top:12px;">
            Adalah benar pernah berpraktek di RSUD Leuwiliang dengan jadwal sebagai berikut:
        </p>

        <table class="data-table" style="margin-left:6px;" role="presentation">
            <tr>
                <td class="label">Hari Praktek</td>
                <td class="sep">:</td>
                <td>Senin s.d Minggu, dengan mempertimbangkan jam efektif 37.5 jam dalam 1 minggu</td>
            </tr>

            <tr>
                <td class="label">Jam Praktek</td>
                <td class="sep">:</td>
                <td>
                    Sistem kerja <em>Shifting</em>, waktu sebagai berikut:
                    <div style="margin-top:6px;">
                        <table class="schedule-table" role="presentation">
                            <tr>
                                <td style="width:130px;">Shift Pagi</td>
                                <td class="sep">:</td>
                                <td>07.30 s.d 14.30 WIB</td>
                            </tr>
                            <tr>
                                <td>Shift Sore</td>
                                <td class="sep">:</td>
                                <td>14.00 s.d 21.00 WIB</td>
                            </tr>
                            <tr>
                                <td>Shift Malam</td>
                                <td class="sep">:</td>
                                <td>21.00 s.d 07.30 WIB</td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
        </table>
        <!-- >>> END HARDCODED SECTION <<< -->

        <p class="paragraph" style="margin-top:14px;">
            Demikian surat keterangan ini dibuat untuk dipergunakan sebagaimana mestinya. Atas perhatiannya diucapkan
            terima kasih.
        </p>

        <!-- SIGNATURE (kanan) -->
        <div class="sign-row">
            <div class="sign-right">
                <div style="margin-bottom:14px; line-height:1.4;">
                    Dikeluarkan di : {{ $sip->tempat_dikeluarkan ?? 'Leuwiliang' }}</><br>
                    Tanggal :
                    {{ isset($sip->tanggal_dikeluarkan) ? \Carbon\Carbon::parse($sip->tanggal_dikeluarkan)->translatedFormat('d F Y') : \Carbon\Carbon::now()->translatedFormat('d F Y') }}
                    </>
                </div>

                @php
                    $ttdBase64 = $fileSigned ?? null;
                    if (!$ttdBase64) {
                        $localTtd = public_path('assets/images/ttd-vitrie.jpg');
                        if (file_exists($localTtd)) {
                            $ttdBase64 = base64_encode(file_get_contents($localTtd));
                        }
                    }
                @endphp

                @if ($ttdBase64)
                    <img src="data:image/jpeg;base64,{{ $ttdBase64 }}" class="ttd-img" alt="TTD">
                @else
                    <div style="height:90px;"></div>
                @endif

                {{-- sesuai permintaan: TIDAK menampilkan nama/nip di bawah ttd --}}
            </div>
        </div>

    </div>

</body>

</html>
