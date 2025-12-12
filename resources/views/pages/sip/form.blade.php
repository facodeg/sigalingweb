{{-- resources/views/sip/form.blade.php --}}
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Form Pengajuan SIP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        :root {
            --card-w: 720px;
            --gap: 12px;
            --radius: 12px;
            --border: #e5e7eb;
            --muted: #f3f4f6;
            --primary: #2563eb;
            --danger-bg: #fee2e2;
            --danger: #991b1b;
            --ok-bg: #ecfdf5;
            --ok: #065f46;
        }

        * {
            box-sizing: border-box
        }

        body {
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, Arial, sans-serif;
            margin: 0;
            background: #fff;
            color: #111827
        }

        .wrap {
            padding: 24px
        }

        .card {
            max-width: var(--card-w);
            margin: auto;
            background: #fff;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 24px
        }

        .card h2 {
            margin: 0 0 8px
        }

        .card p.desc {
            margin: 0 0 18px;
            color: #374151
        }

        .row {
            display: grid;
            grid-template-columns: 180px 1fr;
            gap: 10px var(--gap);
            margin-bottom: 10px;
            align-items: center
        }

        label {
            font-weight: 600
        }

        input,
        textarea,
        select {
            width: 100%;
            padding: 12px 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font: inherit;
            background: #fff
        }

        textarea {
            resize: vertical;
            min-height: 96px
        }

        input[readonly] {
            background: #fafafa;
            color: #6b7280
        }

        .actions {
            display: flex;
            gap: var(--gap);
            margin-top: 16px
        }

        .btn {
            appearance: none;
            padding: 12px 16px;
            border-radius: 10px;
            border: 0;
            cursor: pointer;
            font-weight: 600
        }

        .primary {
            background: var(--primary);
            color: #fff
        }

        .muted {
            background: var(--muted)
        }

        .error {
            background: var(--danger-bg);
            color: var(--danger);
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 12px
        }

        .ok {
            background: var(--ok-bg);
            color: var(--ok);
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 12px
        }

        /* ====== RESPONSIVE ====== */
        @media (max-width: 640px) {
            .wrap {
                padding: 16px
            }

            .card {
                padding: 18px;
                border-radius: 10px
            }

            .row {
                grid-template-columns: 1fr;
                gap: 6px;
                margin-bottom: 14px
            }

            label {
                font-size: 14px
            }

            .actions {
                flex-direction: column
            }

            .btn {
                width: 100%
            }
        }

        /* Hindari zoom saat fokus di iOS */
        @supports (-webkit-touch-callout: none) {

            input,
            select,
            textarea {
                font-size: 16px
            }
        }
    </style>
</head>

<body>
    <div class="wrap">
        <div class="card">
            <h2>Pengajuan Surat Izin Praktik (SIP)</h2>
            <p class="desc">Isi data berikut dengan benar. Link ini sekali pakai dan akan tertutup setelah dikirim.</p>

            @if ($errors->any())
                <div class="error">
                    <strong>Periksa kembali:</strong>
                    <ul style="margin:6px 0 0 18px">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('ok'))
                <div class="ok">{{ session('ok') }}</div>
            @endif

            <form method="POST" action="{{ route('sip.submit', $token) }}" autocomplete="on">
                @csrf

                <div class="row">
                    <label>ID Pengajuan</label>
                    <div><input value="{{ $sip->id }}" readonly></div>
                </div>

                <div class="row">
                    <label>NIP</label>
                    <div>
                        <input name="karyawan_nip" value="{{ old('karyawan_nip', $sip->karyawan_nip) }}" readonly
                            inputmode="numeric" autocomplete="off">
                    </div>
                </div>

                <div class="row">
                    <label>Nama</label>
                    <div>
                        <input name="nama" value="{{ old('nama', $sip->nama) }}" readonly autocomplete="name">
                    </div>
                </div>

                <div class="row">
                    <label>Profesi</label>
                    <div><input name="profesi" value="{{ old('profesi', $sip->profesi) }}" required></div>
                </div>

                <div class="row">
                    <label>Tempat Lahir</label>
                    <div><input name="tempat_lahir" value="{{ old('tempat_lahir') }}" required></div>
                </div>

                <div class="row">
                    <label>Tanggal Lahir</label>
                    <div><input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required></div>
                </div>

                <div class="row">
                    <label>NIK</label>
                    <div><input name="nik" value="{{ old('nik') }}" required inputmode="numeric" maxlength="16">
                    </div>
                </div>

                <div class="row">
                    <label>No. STR</label>
                    <div><input name="no_str" value="{{ old('no_str') }}" required></div>
                </div>

                <div class="row">
                    <label>Masa Berlaku STR</label>
                    <div><input type="date" name="str_berlaku_sampai" value="{{ old('str_berlaku_sampai') }}"
                            required></div>
                </div>

                <div class="row">
                    <label>Alamat Rumah</label>
                    <div>
                        <textarea name="alamat_rumah" rows="3" required>{{ old('alamat_rumah') }}</textarea>
                    </div>
                </div>

                <div class="row">
                    <label>No. HP</label>
                    <div><input name="no_hp" value="{{ old('no_hp') }}" required inputmode="tel" autocomplete="tel">
                    </div>
                </div>



                <div class="row">
                    <label>Tahun Lulus</label>
                    <div><input name="tahun_lulus" value="{{ old('tahun_lulus') }}" required inputmode="numeric"
                            maxlength="4"></div>
                </div>

                <input type="hidden" name="lulusan" value="{{ old('lulusan', $sip->lulusan) }}">

                <div class="actions">
                    <button class="btn primary" type="submit">Kirim Pengajuan</button>
                    <button class="btn muted" type="reset">Reset</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
