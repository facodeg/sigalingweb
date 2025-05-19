<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Izin Atasan</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 1cm 2.25cm 0.3cm 2.54cm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12pt;
            margin: 1cm 2.25cm 0.3cm 2.54cm;
            line-height: 1.15;
        }

        .title {
            text-align: center;
            font-weight: bold;
            text-decoration: underline;
            margin-top: 20px;
            margin-bottom: 5px;
        }

        .nomor {
            text-align: center;
            margin-bottom: 20px;
        }

        .isi {
            line-height: 1.15;
        }

        .data-grid {
            display: grid;
            grid-template-columns: 140px 10px auto;
            row-gap: 6px;
            margin: 10px 0 20px 0;
        }

        .ttd {
            margin-top: 40px;
            text-align: right;
        }

        .ttd p {
            margin: 4px 0;
        }

        .ttd img {
            width: 180px;
            height: auto;
        }

        ul {
            margin-top: 4px;
        }
    </style>
</head>

<body>
    <table style="width: 100%; text-align: center;">
        <tr>
            <td style="width: 80px;">
                <img src="{{ asset('assets/images/logo-kiri.png') }}" style="width: 80px;" alt="Logo Kiri">
            </td>
            <td style="text-align: center;">
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

    <div class="title">SURAT IZIN ATASAN</div>
    <div class="nomor">Nomor: {{ $surat->no_surat ?? '__________' }}</div>

    <div class="isi">
        <p>Yang bertanda tangan di bawah ini:</p>
        <div class="data-grid">
            <div>Nama</div>
            <div>:</div>
            <div><strong>{{ $surat->penanda_tangan_nama }}</strong></div>
            <div>NIP</div>
            <div>:</div>
            <div>{{ $surat->penanda_tangan_nip }}</div>
            <div>Pangkat/Gol</div>
            <div>:</div>
            <div>{{ $surat->penanda_tangan_pangkat }}</div>
            <div>Jabatan</div>
            <div>:</div>
            <div>{{ $surat->penanda_tangan_jabatan }}</div>
        </div>

        <p>Dengan ini memberikan izin pada :</p>
        <div class="data-grid">
            <div>Nama</div>
            <div>:</div>
            <div><strong>{{ $surat->praktikan_nama }}</strong></div>
            <div>NIP</div>
            <div>:</div>
            <div>{{ $surat->nip ?? '-' }}</div>
            <div>Jabatan</div>
            <div>:</div>
            <div>{{ $surat->profesi }}</div>
        </div>

        <p>Untuk berpraktik pada :</p>
        <div class="data-grid">
            <div>Nama Fasilitas</div>
            <div>:</div>
            <div>{{ $surat->alamat_praktek }}</div>
            <div>Alamat</div>
            <div>:</div>
            <div>Jl. Raya Cibeber – Leuwiliang Bogor</div>
        </div>

        <p>Dengan ketentuan :</p>
        <ol>
            <li>Tidak mengganggu kegiatan tugas rutin kedinasan jam kerja pada hari kerja sebagai ASN;</li>
            <li>Hal-hal yang menyangkut urusan kegiatan pada sarana/tempat praktik tersebut menjadi tanggung jawab yang
                bersangkutan.</li>
        </ol>

        <p>Demikian Surat Izin Atasan ini dibuat agar dapat dipergunakan sebagaimana mestinya.</p>
    </div>

    <div class="ttd">
        <p>Dikeluarkan di: {{ $surat->tempat_dikeluarkan }}</p>
        <u>
            <p>Tanggal: {{ \Carbon\Carbon::parse($surat->tanggal_dikeluarkan)->translatedFormat('d F Y') }}</p>
        </u>
        <br>
        <img src="{{ asset('assets/images/ttd-vitrie.jpg') }}" alt="Tanda Tangan Direktur">
    </div>

    <script>
        window.onload = function() {
            window.print();
        };
    </script>

    

</body>

</html>
