<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Permohonan Surat Keterangan Kerja</title>
    <style>
        @page { size: A4 portrait; margin: 2.5cm 2.5cm 2.5cm 2.5cm; }
        body { font-family: Arial, sans-serif; font-size: 12pt; line-height: 1.6; color: #000; }
        .right     { text-align: right; }
        .bold      { font-weight: bold; }
        .mt-8      { margin-top: 8px; }
        .mt-16     { margin-top: 16px; }
        .mt-24     { margin-top: 24px; }
        .mt-32     { margin-top: 32px; }
        .mt-48     { margin-top: 48px; }
        .indent    { text-indent: 2.5em; }
        .block     { display: block; }
        .row       { display: flex; }
        .row > div { padding: 0; }
        .w-20      { width: 20%; }
        .w-2       { width: 2%; }
        .w-78      { width: 78%; }
        .signature-area { margin-top: 48px; display: flex; justify-content: space-between; }
        .sig-col   { width: 48%; text-align: center; }
        .u         { text-decoration: underline; }
    </style>
</head>
<body>

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
    <div class="mt-16">
        Kepada Yth.<br>
        Direktur RSUD Leuwiliang<br>
        Cq. Kepala Sub Bagian Kepegawaian<br>
        Di Tempat
    </div>

    {{-- Salam Pembuka --}}
    <div class="mt-24">
        Dengan hormat,
    </div>

    {{-- Identitas Pemohon --}}
    <div class="mt-16">
        Saya yang bertandatangan di bawah ini:
    </div>

    <div class="mt-8">
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
    <div class="mt-24 indent">
        Dengan ini mengajukan permohonan <span class="bold">Surat Keterangan Kerja</span> guna melengkapi administrasi
        pengajuan KPR{{ isset($surat->maksud_tambahan) ? ' - ' . $surat->maksud_tambahan : '' }}.
    </div>

    {{-- Penutup --}}
    <div class="mt-24 indent">
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

    <script>
        window.onload = function () {
            window.print();
        };
    </script>
</body>
</html>
