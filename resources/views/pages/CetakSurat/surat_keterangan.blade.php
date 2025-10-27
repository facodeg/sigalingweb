<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Permohonan Surat Keterangan Kerja</title>
    <style>
        /* Ukuran A4 + margin default printer */
        @page { size: A4 portrait; margin: 2.54cm; }

        body {
            font-family: Arial, sans-serif;
            font-size: 12pt;
            line-height: 1.6;
            color: #000;
            margin: 0;
        }

        .right     { text-align: right; }
        .center    { text-align: center; }
        .bold      { font-weight: bold; }
        .justify   { text-align: justify; text-justify: inter-word; }
        .mt-8      { margin-top: 8px; }
        .mt-12     { margin-top: 12px; }
        .mt-16     { margin-top: 16px; }
        .mt-24     { margin-top: 24px; }
        .mt-32     { margin-top: 32px; }
        .mt-48     { margin-top: 48px; }
        .indent    { text-indent: 2.5em; }
        .row       { display: flex; }
        .row > div { padding: 0; }
        .w-20      { width: 20%; }
        .w-2       { width: 2%; }
        .w-78      { width: 78%; }
        .signature-area { margin-top: 48px; display: flex; justify-content: space-between; }
        .sig-col   { width: 48%; text-align: center; }
        .u         { text-decoration: underline; }

        /* KOP SURAT */
        .kop-wrap { margin-bottom: 8px; }
        .kop-table { width: 100%; border-collapse: collapse; }
        .kop-logo { width: 90px; }
        .kop-title { line-height: 1.3; }
        .hr-tipis { border: none; border-top: 1px solid #000; margin: 0; }
        .hr-tebal { border: none; border-top: 3px solid #000; margin-top: 2px; }
        .content { padding-top: 12px; }
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
                    <img src="{{ asset('assets/images/logo-kanan.png') }}" alt="Logo Kanan" style="width:80px;height:auto;">
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

        <div class="mt-8 justify">
            <div class="row">
                <div class="w-20">Nama</div>
                <div class="w-2">:</div>
                <div class="w-78">{{ $surat->praktikan_nama ?? $surat->nama ?? '................................' }}</div>
            </div>
            <div class="row">
                <div class="w-20">NIP/NIPB</div>
                <div class="w-2">:</div>
                <div class="w-78">{{ $surat->nip ?? $surat->karyawan_nip ?? '................................' }}</div>
            </div>
            <div class="row">
                <div class="w-20">Jabatan</div>
                <div class="w-2">:</div>
                <div class="w-78">{{ $surat->profesi ?? $surat->jabatan ?? '................................' }}</div>
            </div>
        </div>

        {{-- Isi Permohonan --}}
        <div class="mt-24 indent justify">
            Dengan ini mengajukan permohonan <span class="bold">Surat Keterangan Kerja</span> guna melengkapi administrasi
            pengajuan KPR{{ isset($surat->maksud_tambahan) ? ' - ' . $surat->maksud_tambahan : '' }}.
        </div>

        {{-- Penutup --}}
        <div class="mt-24 indent justify">
            Demikian surat permohonan ini saya buat. Atas perhatian dan bantuannya, diucapkan terima kasih.
        </div>

        {{-- Area Tanda Tangan --}}
        <div class="signature-area">
            <div class="sig-col">
                Mengetahui,<br>
                Kepala Ruangan<br><br><br><br><br>
                <span class="u">{{ $surat->kepala_ruangan ?? '................................' }}</span><br>
            </div>

            <div class="sig-col">
                Hormat saya,<br><br><br><br><br>
                <span class="u">{{ $surat->praktikan_nama ?? $surat->nama ?? '................................' }}</span><br>
                NIP/NIPB: {{ $surat->nip ?? $surat->karyawan_nip ?? '........................' }}
            </div>
        </div>
    </div>

    <script>
        window.onload = function () { window.print(); };
    </script>
</body>
</html>
