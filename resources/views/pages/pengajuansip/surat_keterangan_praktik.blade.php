<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Keterangan Tempat Praktik</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 2cm;
        }

        body {
            font-family: "Arial", sans-serif;
            font-size: 11pt;
            line-height: 1.45;
            color: #000;
            margin: 0;
        }

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        .bold {
            font-weight: 700;
        }

        .u {
            text-decoration: underline;
        }

        .justify {
            text-align: justify;
            text-justify: inter-word;
        }

        .indent {
            text-indent: 2em;
        }

        /* Kop surat */
        .kop {
            margin-bottom: 6px;
        }

        .kop-table {
            width: 100%;
            border-collapse: collapse;
        }

        .kop-logo {
            width: 80px;
            vertical-align: top;
        }

        .kop-title {
            line-height: 1.1;
        }

        .hr-thin {
            border: none;
            border-top: 1px solid #000;
            margin: 0;
        }

        .hr-thick {
            border: none;
            border-top: 2px solid #000;
            margin-top: 2px;
        }

        /* Judul surat */
        .judul {
            margin-top: 6px;
            margin-bottom: 8px;
            font-weight: 700;
        }

        .judul-underline {
            display: inline-block;
            border-bottom: 2px solid #000;
            padding-bottom: 4px;
        }

        /* tabel data identitas */
        .data-table {
            width: 100%;
            margin-top: 8px;
            border-collapse: collapse;
            font-size: 11pt;
        }

        .data-table td {
            vertical-align: top;
            padding: 4px 0;
        }

        .label {
            width: 28%;
        }

        .sep {
            width: 3%;
        }

        .value {
            width: 69%;
        }

        /* paragraf akhir dan tanda tangan */
        .ttd-table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        .ttd-table td {
            vertical-align: top;
        }

        .ttd-left {
            width: 50%;
            text-align: left;
            padding-right: 8px;
        }

        .ttd-right {
            width: 50%;
            text-align: center;
            padding-left: 8px;
        }

        /* spacing helper */
        .mt-6 {
            margin-top: 6px;
        }

        .mt-12 {
            margin-top: 12px;
        }

        .mt-18 {
            margin-top: 18px;
        }
    </style>
</head>

<body>
    {{-- Kop surat --}}
    <div class="kop">
        <table class="kop-table">
            <tr>
                <td class="kop-logo" style="text-align:left;">
                    @if (!empty($logoKiri))
                        <img src="data:image/png;base64,{{ $logoKiri }}" alt="Logo Kiri"
                            style="width:80px; height:auto;">
                    @endif
                </td>

                <td class="kop-title center">
                    <div class="bold" style="font-size:14pt;">PEMERINTAH KABUPATEN BOGOR</div>
                    <div class="bold" style="font-size:13pt;">RUMAH SAKIT UMUM DAERAH LEUWILIANG</div>
                    <div style="font-size:10pt; margin-top:4px;">
                        Jl. Raya Cibeber - Leuwiliang Bogor KodePos 16640<br>
                        Telp. (0251) 8643290, Fax. (0251) 8643291<br>
                        Email: rsudleuwiliang@bogorkab.go.id
                    </div>
                </td>

                <td class="kop-logo" style="text-align:right;">
                    @if (!empty($logoKanan))
                        <img src="data:image/png;base64,{{ $logoKanan }}" alt="Logo Kanan"
                            style="width:80px; height:auto;">
                    @endif
                </td>
            </tr>
        </table>

        <hr class="hr-thin">
        <hr class="hr-thick">
    </div>

    {{-- Tanggal dan tempat dikeluarkan --}}

    <div style="height:10px;"></div>
    {{-- Judul surat --}}
    <div class="center judul">
        <span class="judul-underline">SURAT KETERANGAN TEMPAT PRAKTIK</span>
    </div>
    <div style="height:22px;"></div>

    {{-- Pembuka --}}
    <div style="margin-top:8px; font-size:11pt;">
        Yang bertanda tangan di bawah ini,
    </div>

    {{-- Tabel identitas --}}
    <table class="data-table" role="presentation">
        <tr>
            <td class="label">Nama Lengkap</td>
            <td class="sep">:</td>
            <td class="value">{{ $sip->nama ?? '........................................................' }}</td>
        </tr>
        <tr>
            <td class="label">Profesi</td>
            <td class="sep">:</td>
            <td class="value">{{ $sip->profesi ?? '........................................................' }}</td>
        </tr>
        <tr>
            <td class="label">Tempat, tanggal lahir</td>
            <td class="sep">:</td>
            <td class="value">
                {{ $sip->tempat_lahir ?? '...' }},
                {{ isset($sip->tanggal_lahir) ? \Carbon\Carbon::parse($sip->tanggal_lahir)->translatedFormat('d F Y') : '...' }}
            </td>
        </tr>
        <tr>
            <td class="label">NIK</td>
            <td class="sep">:</td>
            <td class="value">{{ $sip->nik ?? '........................................................' }}</td>
        </tr>
        <tr>
            <td class="label">Nomor STR</td>
            <td class="sep">:</td>
            <td class="value">{{ $sip->no_str ?? '........................................................' }}</td>
        </tr>
        <tr>
            <td class="label">Masa Berlaku STR</td>
            <td class="sep">:</td>
            <td class="value">
                {{ isset($sip->str_berlaku_sampai) ? \Carbon\Carbon::parse($sip->str_berlaku_sampai)->translatedFormat('d F Y') : '................................' }}
            </td>
        </tr>
        <tr>
            <td class="label">Alamat Rumah</td>
            <td class="sep">:</td>
            <td class="value">{{ $sip->alamat_rumah ?? '........................................................' }}
            </td>
        </tr>
        <tr>
            <td class="label">Nomor Handphone</td>
            <td class="sep">:</td>
            <td class="value">{{ $sip->no_hp ?? '........................................................' }}</td>
        </tr>
        <tr>
            <td class="label">Lulusan dari, Tahun</td>
            <td class="sep">:</td>
            <td class="value">
                {{ $sip->tahun_lulus ?? '....' }}
            </td>
        </tr>
    </table>

    {{-- Pernyataan --}}
    <div class="mt-12 justify" style="font-size:11pt;">
        Menyatakan dengan sungguh-sungguh bahwa data saya sebagaimana tercantum di atas adalah benar dan saya
        berpraktik di <span class="bold">RSUD Leuwiliang</span> yang beralamat di Jl. Raya Cibeber Kp. Hegarsari RT
        01/01,
        Desa Cibeber I, Kecamatan Leuwiliang, Kabupaten Bogor.
    </div>

    <div class="mt-12 justify" style="font-size:11pt;">
        Demikian surat keterangan ini dibuat untuk dipergunakan sebagai persyaratan administrasi perizinan
        Surat Izin Praktik (SIP) ke-1.
    </div>

    {{-- Tanda tangan --}}
    <table class="ttd-table" role="presentation">
        <tr>
            <td class="ttd-left" style="padding-top:36px;">
                <div style="font-size:11pt;">
                    Mengetahui,<br>
                    Direktur
                </div>

                <div style="height:68px;"></div>

                <div style="font-size:11pt;">
                    <span class="u">dr. Vitrie Winastri, S.H., MARS</span><br>
                    NIP. 196710192002122002
                </div>
            </td>

            <td class="ttd-right" style="padding-top:36px;">

                <div style="font-size:11pt;">
                    Bogor,
                    {{ isset($sip->tanggal_dikeluarkan) ? \Carbon\Carbon::parse($sip->tanggal_dikeluarkan)->translatedFormat('d F Y') : \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br>
                    Yang membuat pernyataan,
                </div>

                <div style="height:68px;"></div>

                @if (!empty($fileSigned))
                    <div style="margin-bottom:6px;">
                        <img src="data:image/png;base64,{{ $fileSigned }}" alt="TTD"
                            style="max-height:90px; display:block; margin:0 auto;">
                    </div>
                @endif

                <div style="font-size:11pt;">
                    <span class="u">{{ $sip->nama ?? '................................' }}</span><br>
                    NIP/NIPB: {{ $sip->karyawan_nip ?? '................................' }}
                </div>
            </td>
        </tr>
    </table>

</body>

</html>
