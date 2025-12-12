<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Pernyataan Kebenaran dan Keabsahan Data</title>
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

        /* Kop */
        .kop {
            margin-bottom: 8px;
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
            line-height: 1.05;
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

        /* judul */
        .judul {
            margin-top: 8px;
            margin-bottom: 8px;
            font-weight: 700;
        }

        .judul-underline {
            display: inline-block;
            padding-bottom: 4px;
        }

        /* data table */
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

        /* tanda tangan */
        .ttd {
            width: 100%;
            margin-top: 22px;
        }

        .ttd td {
            vertical-align: top;
        }

        .ttd-left {
            width: 55%;
            text-align: left;
            padding-right: 8px;
        }

        .ttd-right {
            width: 45%;
            text-align: center;
            padding-left: 8px;
        }

        .materai-box {
            width: 95px;
            height: 55px;
            border: 1px solid #000;
            display: inline-block;
            text-align: center;
            vertical-align: middle;
            font-size: 10pt;
            padding-top: 6px;
        }

        .small-note {
            font-size: 10pt;
            color: #333;
            margin-top: 6px;
        }
    </style>
</head>

<body>
    {{-- Kop --}}
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
                        Jl. Raya Cibeber - Leuwiliang Bogor Kode Pos 16640<br>
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

    {{-- Judul --}}
    <div class="center judul">
        <span class="judul-underline">SURAT PERNYATAAN KEBENARAN DAN KEABSAHAN DATA</span>
    </div>

    <div style="height:22px;"></div>

    {{-- Isi --}}
    <div style="margin-top:6px; font-size:11pt;">
        Yang bertandatangan di bawah ini :
    </div>

    <table class="data-table" role="presentation">
        <tr>
            <td class="label">Nama Lengkap dan Gelar Akademik*</td>
            <td class="sep">:</td>
            <td class="value">{{ $sip->nama ?? '................................' }} {{ $sip->gelar ?? '' }}</td>
        </tr>
        <tr>
            <td class="label">No. KTP</td>
            <td class="sep">:</td>
            <td class="value">{{ $sip->nik ?? '................................' }}</td>
        </tr>
        <tr>
            <td class="label">Jabatan</td>
            <td class="sep">:</td>
            <td class="value">{{ $sip->profesi ?? '................................' }}</td>
        </tr>
        <tr>
            <td class="label">Nama Instansi</td>
            <td class="sep">:</td>
            <td class="value">RSUD Leuwiliang</td>
        </tr>
        <tr>
            <td class="label">Alamat Instansi</td>
            <td class="sep">:</td>
            <td class="value">Jl. Raya Cibeber – Leuwiliang Bogor</td>
        </tr>
        <tr>
            <td class="label">Telepon / Fax.</td>
            <td class="sep">:</td>
            <td class="value">(0251) 8643291</td>
        </tr>
    </table>

    <div class="mt-12 justify" style="font-size:11pt; margin-top:14px;">
        Dengan ini menyatakan dengan sesungguhnya bahwa semua informasi yang disampaikan dalam seluruh dokumen serta
        lampiran-lampirannya ini adalah <strong>benar dan sah</strong> serta merupakan kesatuan yang tidak dapat
        dipisahkan.
    </div>

    <div class="mt-12 justify" style="font-size:11pt; margin-top:10px;">
        Apabila dikemudian hari ditemukan dan/atau dibuktikan adanya penipuan/pemalsuan atas informasi yang disampaikan,
        maka saya bersedia dikenakan sanksi sesuai dengan peraturan dan ketentuan yang berlaku.
    </div>

    <div class="mt-12 justify" style="font-size:11pt; margin-top:10px;">
        Demikian surat pernyataan kebenaran dan keabsahan data ini dibuat dengan sebenarnya, tanpa ada paksaan dari
        pihak manapun, dan untuk digunakan sebagaimana mestinya.
    </div>

    {{-- Tanggal & tanda tangan --}}
    <table class="ttd" role="presentation">
        <tr>
            <td class="ttd-left">
                <div style="font-size:11pt;">
                    Bogor,
                    {{ isset($sip->tanggal_dikeluarkan) ? \Carbon\Carbon::parse($sip->tanggal_dikeluarkan)->translatedFormat('d F Y') : \Carbon\Carbon::now()->translatedFormat('d F Y') }}
                </div>

                <div style="height:22px;"></div>

                <div style="font-size:11pt;">
                    <div class="materai-box">Materai<br>10000</div>
                </div>
                <div style="height:22px;"></div>
                <div style="font-size:11pt; margin-top:6px;">
                    <span class="u">{{ $sip->nama ?? '................................' }}</span><br>

                </div>
            </td>

            <td class="ttd-right">


            </td>
        </tr>
    </table>


    <div class="small-note">
        *) Gelar Akademik wajib diisi untuk izin-izin yang memerlukan gelar akademik.
    </div>
</body>

</html>
