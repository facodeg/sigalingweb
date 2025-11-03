<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Permohonan Surat Keterangan Kerja</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 2cm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 11.5pt;
            line-height: 1.5;
            /* sedikit lebih renggang */
            color: #000;
            margin: 0;
        }

        .right {
            text-align: right;
        }

        .center {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        .justify {
            text-align: justify;
            text-justify: inter-word;
        }

        .u {
            text-decoration: underline;
        }

        .indent {
            text-indent: 2em;
        }

        /* spacing disesuaikan (lebih alami) */
        .mt-4 {
            margin-top: 4px;
        }

        .mt-8 {
            margin-top: 8px;
        }

        .mt-12 {
            margin-top: 12px;
        }

        .mt-16 {
            margin-top: 16px;
        }

        .mt-20 {
            margin-top: 20px;
        }

        .mt-24 {
            margin-top: 24px;
        }

        .mt-28 {
            margin-top: 28px;
        }

        /* kop surat */
        .kop-wrap {
            margin-bottom: 8px;
        }

        .kop-table {
            width: 100%;
            border-collapse: collapse;
        }

        .kop-logo {
            width: 80px;
        }

        .kop-title {
            line-height: 1.25;
        }

        .hr-tipis {
            border: none;
            border-top: 1px solid #000;
            margin: 0;
        }

        .hr-tebal {
            border: none;
            border-top: 2px solid #000;
            margin-top: 1px;
        }

        .content {
            padding-top: 8px;
        }

        /* tabel data & tanda tangan */
        table {
            border-collapse: collapse;
            width: 100%;
        }

        .tbl-no-border td {
            border: none;
            padding: 3px 0;
            vertical-align: top;
        }

        .col-label {
            width: 22%;
        }

        .col-sep {
            width: 3%;
        }

        .col-val {
            width: 75%;
        }

        /* tanda tangan */
        .sign-table td {
            text-align: center;
        }

        .sign-title td {
            padding-bottom: 40px;
        }

        /* jarak nama ke judul tanda tangan */
    </style>
</head>

<body>

    {{-- KOP SURAT --}}
    <div class="kop-wrap">
        <table class="kop-table">
            <tr>
                <td class="kop-logo" style="text-align:left">
                    <img src="{{ asset('assets/images/logo-kiri.png') }}" alt="Logo Kiri" style="width:80px;height:auto;">
                </td>
                <td class="kop-title center">
                    <div class="bold" style="font-size:16pt;">PEMERINTAH KABUPATEN BOGOR</div>
                    <div class="bold" style="font-size:14pt;">RUMAH SAKIT UMUM DAERAH LEUWILIANG</div>
                    <div style="font-size:10.5pt;">
                        Jl. Raya Cibeber - Leuwiliang, Bogor 16640<br>
                        Telp. (0251) 8643290, Fax. (0251) 8643291<br>
                        Email: rsudleuwiliang@bogorkab.go.id
                    </div>
                </td>
                <td class="kop-logo" style="text-align:right">
                    <img src="{{ asset('assets/images/logo-kanan.png') }}" alt="Logo Kanan"
                        style="width:80px;height:auto;">
                </td>
            </tr>
        </table>
        <hr class="hr-tipis">
        <hr class="hr-tebal">
    </div>

    <div class="content">
        {{-- Tanggal & Tempat --}}
        <div class="right">
            {{ $surat->tempat_dikeluarkan ?? 'Leuwiliang' }},
            {{ isset($surat->tanggal_dikeluarkan) ? \Carbon\Carbon::parse($surat->tanggal_dikeluarkan)->translatedFormat('d F Y') : \Carbon\Carbon::now()->translatedFormat('d F Y') }}
        </div>

        {{-- Perihal --}}
        <div class="mt-16">
            <span class="bold">Perihal</span> : Permohonan Surat Keterangan Kerja
        </div>

        {{-- Alamat Tujuan --}}
        <div class="mt-16 justify">
            Kepada Yth.<br>
            Direktur RSUD Leuwiliang<br>
            Cq. Kepala Sub Bagian Kepegawaian<br>
            Di Tempat
        </div>

        {{-- Salam Pembuka --}}
        <div class="mt-24">Dengan hormat,</div>

        {{-- Identitas Pemohon --}}
        <div class="mt-16 justify">Saya yang bertandatangan di bawah ini:</div>

        <table style="width: 100%; font-size: 12pt; border-collapse: collapse; line-height: 2;">
            <tr>
                <td style="width: 150px;">Nama</td>
                <td style="width: 10px;">:</td>
                <td>
                    {{ $surat->praktikan_nama ?? ($surat->nama ?? '................................') }}
                </td>
            </tr>
            <tr>
                <td>NIP/NIPB</td>
                <td>:</td>
                <td>
                    {{ $surat->nip ?? ($surat->karyawan_nip ?? '................................') }}
                </td>
            </tr>
            <tr>
                <td>Jabatan</td>
                <td>:</td>
                <td>
                    {{ $surat->profesi ?? ($surat->karyawan->jabatan_terakhir ?? '................................') }}
                </td>
            </tr>
        </table>


        {{-- Isi Permohonan --}}
        <div class="mt-24 indent justify">
            Dengan ini mengajukan permohonan <span class="bold">Surat Keterangan Kerja</span> guna melengkapi
            administrasi
            pengajuan KPR{{ isset($surat->maksud_tambahan) ? ' - ' . $surat->maksud_tambahan : '' }}.
        </div>

        {{-- Penutup --}}
        <div class="mt-24 indent justify">
            Demikian surat permohonan ini saya buat. Atas perhatian dan bantuannya, diucapkan terima kasih.
        </div>

        {{-- Area Tanda Tangan --}}
        <table class="tbl-no-border sign-table mt-20">
            <tr class="sign-title">
                <td style="width:50%; text-align:center;">
                    Mengetahui,<br>
                    Kep. Ruang / Kep. Instal. / Kasubag
                </td>
                <td style="width:50%; text-align:center;">
                    Hormat saya,
                </td>
            </tr>
            <tr>
                <td style="height:35px;"></td> <!-- jarak antar judul dan nama (proporsional) -->
                <td style="height:35px;"></td>
            </tr>
            <tr>
                <td> <span class="u">...................................</span><br>
                    NIP :.......................................
                <td>
                    <span class="u">{{ $surat->nama }}</span><br>
                    NIP/NIPB: {{ $surat->karyawan_nip }}
                </td>
            </tr>
        </table>
    </div>

    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>

</html>
