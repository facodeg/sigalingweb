<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Keterangan Kerja</title>
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
            margin-top: 18px;
        }

        .nomor {
            text-align: center;
            margin-bottom: 22px;
        }

        .info-table {
            margin-left: 28px;
            line-height: 1.7;
            font-size: 12pt;
        }

        .info-table td {
            vertical-align: top;
        }

        .kop td {
            text-align: center;
        }

        .kop img {
            width: 80px;
        }

        hr.line-1 {
            border: none;
            border-top: 1px solid #000;
            margin: 0;
        }

        hr.line-2 {
            border: none;
            border-top: 4px solid #000;
            margin-top: 1px;
        }

        .mt-20 {
            margin-top: 20px;
        }

        .ttd {
            margin-top: 32px;
            text-align: right;
        }

        .ttd img {
            width: 280px;
            height: auto;
        }

        .small {
            font-size: 10pt;
            color: #333;
        }
    </style>
</head>

<body>
    {{-- KOP SURAT --}}
    <table class="kop" style="width:100%;">
        <tr>
            <td style="width:80px;">
                <img src="{{ asset('assets/images/logo-kiri.png') }}" alt="Logo Kiri">
            </td>
            <td>
                <div style="line-height:1.35;">
                    <strong style="font-size:16pt;">PEMERINTAH KABUPATEN BOGOR</strong><br>
                    <span style="font-size:14pt; font-weight:bold;">RUMAH SAKIT UMUM DAERAH LEUWILIANG</span><br>
                    <span style="font-size:11pt;">
                        Jl. Raya Cibeber - Leuwiliang Bogor Kode Pos 16640<br>
                        Telp. (0251) 8643290, Fax. (0251) 8643291<br>
                        Email: rsudleuwiliang@bogorkab.go.id
                    </span>
                </div>
            </td>
            <td style="width:80px;">
                <img src="{{ asset('assets/images/logo-kanan.png') }}" alt="Logo Kanan">
            </td>
        </tr>
    </table>
    <hr class="line-1">
    <hr class="line-2">

    {{-- JUDUL --}}
    <div class="title">SURAT KETERANGAN KERJA</div>
    <div class="nomor">Nomor: {{ $surat->nomor_surat ?? '__________' }}</div>

    {{-- PENANDA TANGAN --}}
    <p>Yang bertanda tangan di bawah ini:</p>
    <table class="info-table" style="width:100%; border-collapse:collapse;">
        <tr>
            <td style="width:20px;">a.</td>
            <td style="width:220px;">Nama</td>
            <td style="width:10px;">:</td>
            <td>{{ $surat->penanda_tangan_nama ?? 'dr. Ridwan' }}</td>
        </tr>
        <tr>
            <td>b.</td>
            <td>Jabatan</td>
            <td>:</td>
            <td>{{ $surat->penanda_tangan_jabatan ?? 'Kepala Subbag Kepegawaian' }}</td>
        </tr>
    </table>

    {{-- IDENTITAS PEGAWAI --}}
    <p class="mt-20">Dengan ini menerangkan bahwa:</p>
    <table class="info-table" style="width:100%; border-collapse:collapse;">
        <tr>
            <td style="width:20px;">a.</td>
            <td style="width:220px;">Nama / NIP</td>
            <td style="width:10px;">:</td>
            <td>
                {{ $surat->nama ?? '-' }}<br>
                {{ $surat->karyawan_nip ?? '-' }}
            </td>
        </tr>
        <tr>
            <td>b.</td>
            <td>Pangkat / Golongan</td>
            <td>:</td>
            <td>{{ optional($surat->karyawan)->gol ?? '-' }}</td>
        </tr>
        <tr>
            <td>c.</td>
            <td>Jabatan</td>
            <td>:</td>
            <td>{{ optional($surat->karyawan)->jabatan_terakhir ?? ($surat->profesi ?? '-') }}</td>
        </tr>
        <tr>
            <td>d.</td>
            <td>Unit Kerja</td>
            <td>:</td>
            <td>{{ ucwords(strtolower(optional($surat->karyawan)->ruangan ?? '-')) }}</td>
        </tr>
        <tr>
            <td>e.</td>
            <td>TMT</td>
            <td>:</td>
            <td>
                @php
                    $tmt = optional($surat->karyawan)->tmt_kerja_di_rsud ?? ($surat->tmt ?? null);
                @endphp
                {{ $tmt ? \Carbon\Carbon::parse($tmt)->translatedFormat('d F Y') : '-' }}
            </td>
        </tr>
        <tr>
            <td>f.</td>
            <td>Maksud</td>
            <td>:</td>
            <td>{{ $surat->keperluan ?? 'Untuk melengkapi syarat administrasi pengajuan KPR Perumahan' }}</td>
        </tr>
    </table>

    <p>Demikian Surat Keterangan Kerja ini dibuat dengan sebenarnya untuk dipergunakan sebagaimana mestinya.</p>

    {{-- TANDA TANGAN --}}
    <div class="ttd">
        <p>Dikeluarkan di : {{ $surat->tempat_dikeluarkan ?? 'Leuwiliang' }}</p>
        <p><u>
                Tanggal :
                @php
                    $tgl = $surat->tanggal_dikeluarkan ?? ($surat->created_at ?? now());
                @endphp
                {{ \Carbon\Carbon::parse($tgl)->translatedFormat('d F Y') }}
            </u></p>

        @php
            $ttd = $surat->penanda_tangan_nama ?? 'dr. Ridwan';
        @endphp

        @if ($ttd === 'dr. Ridwan')
            <img src="{{ asset('assets/images/ttd-ridwan.jpg') }}" alt="Tanda Tangan dr. Ridwan">
            <div style="margin-top:6px;"><strong>dr. Ridwan</strong><br><span class="small">Kepala Subbag
                    Kepegawaian</span></div>
        @elseif ($ttd === 'dr. Vitrie Winastri, S.H., MARS')
            <img src="{{ asset('assets/images/ttd-vitrie.jpg') }}" alt="Tanda Tangan dr. Vitrie">
            <div style="margin-top:6px;"><strong>dr. Vitrie Winastri, S.H., MARS</strong><br><span class="small">Wadir
                    Umum & Keuangan</span></div>
        @else
            {{-- fallback tanpa gambar --}}
            <div style="height:100px;"></div>
            <div><strong>{{ $ttd }}</strong><br><span
                    class="small">{{ $surat->penanda_tangan_jabatan ?? '-' }}</span></div>
        @endif
    </div>

    {{-- OPSIONAL: QR code (jika ada file/kolomnya) --}}
    @if (!empty($surat->qrcode_path))
        <div style="position:fixed; left:2.54cm; bottom:1.1cm;">
            <img src="{{ asset($surat->qrcode_path) }}" alt="QR" style="width:90px;">
            <div class="small">Verifikasi: {{ $surat->id ?? '-' }}</div>
        </div>
    @endif

    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>

</html>
