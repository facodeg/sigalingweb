@extends('layouts.app')

@section('title', 'Tambah Surat Praktek')

@section('main')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex justify-content-between align-items-md-center flex-md-row flex-column">
                    <h4 class="page-title">Tambah Surat Keterangan Praktek </h4>
                    <ol class="m-0 breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Surat Praktek</a></li>
                        <li class="breadcrumb-item active">Tambah</li>
                    </ol>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @php
            $dataPendidikan = \App\Models\Pendidikan::select('nama', 'jabatan', 'nip')->get();
        @endphp

        <div class="card">
            <div class="card-body">
                <form action="{{ route('surat_praktek_satu.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="nama_surat" class="form-label">Nama Surat</label>
                            <select name="nama_surat" id="nama_surat" class="form-select" required>
                                <option value="" disabled selected>Pilih Jenis Surat</option>
                                <option value="SURAT KETERANGAN">SURAT KETERANGAN</option>
                                <option value="SURAT IZIN ATASAN">SURAT IZIN ATASAN</option>
                                <option value="SURAT KETERANGAN HARI DAN JAM PRAKTEK">SURAT KETERANGAN HARI DAN JAM PRAKTEK
                                </option>
                                <option value="SURAT KETERANGAN KERJA">SURAT KETERANGAN KERJA</option>
                            </select>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="tanggal_dikeluarkan" class="form-label">Tanggal Dikeluarkan</label>
                            <input type="date" name="tanggal_dikeluarkan" id="tanggal_dikeluarkan" class="form-control">
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="no_surat" class="form-label">Nomor Surat</label>
                            <input type="text" name="no_surat" id="no_surat" class="form-control"
                                placeholder="Contoh: 445.1/PK-RSUD/{{ date('Y') }}">
                        </div>

                        <div class="mb-3 col-md-6 d-none" id="maksud-section">
                            <label for="maksud" class="form-label">Keperluan / Maksud</label>
                            <input type="text" name="maksud" id="maksud" class="form-control"
                                placeholder="Contoh: Untuk keperluan pengajuan KPR">
                        </div>

                        <div class="mb-3 col-md-6 d-none" id="tmt-section">
                            <label for="tmt" class="form-label">TMT</label>
                            <input type="text" name="tmt" id="tmt" class="form-control"
                                placeholder="Contoh: 01 Januari 2020">
                        </div>
                    </div>

                    {{-- Praktikan --}}
                    <div id="praktikan-wrapper">
                        <div class="praktikan-entry">
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Nama Praktikan</label>
                                    <input list="list-nama" name="praktikan_nama[]" class="form-control praktikan-nama"
                                        required>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">NIP</label>
                                    <input type="text" name="nip[]" class="form-control nip" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Profesi</label>
                                    <input type="text" name="profesi[]" class="form-control profesi" readonly>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Unit</label>
                                    <input type="text" name="unit[]" class="form-control">
                                </div>
                            </div>
                            <hr>
                        </div>
                    </div>

                    <div class="col-12 mb-3" id="tambah-btn-wrapper">
                        <button type="button" class="btn btn-sm btn-secondary" id="tambah-praktikan">+ Tambah
                            Praktikan</button>
                    </div>

                    {{-- Jadwal Praktek --}}
                    <div id="jadwal-praktek">
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="alamat_praktek" class="form-label">Alamat Praktek</label>
                                <input type="text" name="alamat_praktek" id="alamat_praktek" class="form-control"
                                    value="RSUD Leuwiliang" readonly>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="hari_praktek" class="form-label">Hari Praktek</label>
                                <input type="text" name="hari_praktek" id="hari_praktek" class="form-control"
                                    value="Senin s.d Minggu">
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="jam_efektif_mingguan" class="form-label">Jam Efektif / Minggu</label>
                                <input type="number" name="jam_efektif_mingguan" id="jam_efektif_mingguan"
                                    class="form-control" value="37.5" step="0.1">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="shift_pagi" class="form-label">Shift Pagi</label>
                                <input type="text" name="shift_pagi" id="shift_pagi" class="form-control"
                                    value="07.30 s.d 14.30 WIB">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="shift_sore" class="form-label">Shift Sore</label>
                                <input type="text" name="shift_sore" id="shift_sore" class="form-control"
                                    value="14.00 s.d 21.00 WIB">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="shift_malam" class="form-label">Shift Malam</label>
                                <input type="text" name="shift_malam" id="shift_malam" class="form-control"
                                    value="21.00 s.d 07.30 WIB">
                            </div>
                        </div>
                    </div>

                    {{-- Penandatangan --}}
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="tempat_dikeluarkan" class="form-label">Tempat Dikeluarkan</label>
                            <input type="text" name="tempat_dikeluarkan" id="tempat_dikeluarkan" class="form-control"
                                value="Leuwiliang">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="penanda_tangan_nama" class="form-label">Nama Penandatangan</label>
                            <input type="text" name="penanda_tangan_nama" id="penanda_tangan_nama"
                                class="form-control" value="dr. Vitrie Winastri, S.H., MARS">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="penanda_tangan_nip" class="form-label">NIP</label>
                            <input type="text" name="penanda_tangan_nip" id="penanda_tangan_nip" class="form-control"
                                value="196710192002122002">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="penanda_tangan_pangkat" class="form-label">Pangkat / Golongan</label>
                            <input type="text" name="penanda_tangan_pangkat" id="penanda_tangan_pangkat"
                                class="form-control" value="Pembina Utama Muda, IV/c">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="penanda_tangan_jabatan" class="form-label">Jabatan</label>
                            <input type="text" name="penanda_tangan_jabatan" id="penanda_tangan_jabatan"
                                class="form-control" value="Direktur RSUD Leuwiliang">
                        </div>
                    </div>

                    <button type="submit" class="mt-3 btn btn-primary">Simpan</button>
                    <a href="{{ route('surat_praktek_satu.index') }}" class="mt-3 btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <datalist id="list-nama">
        @foreach ($dataPendidikan as $p)
            <option value="{{ $p->nama }}" data-jabatan="{{ $p->jabatan }}" data-nip="{{ $p->nip }}">
            </option>
        @endforeach
    </datalist>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function bindAutoFill(container) {
                const inputNama = container.querySelector('.praktikan-nama');
                const inputProfesi = container.querySelector('.profesi');
                const inputNip = container.querySelector('.nip');
                const datalist = document.getElementById('list-nama');

                inputNama.addEventListener('input', function() {
                    const val = inputNama.value;
                    const options = datalist.options;
                    inputProfesi.value = '';
                    inputNip.value = '';
                    for (let i = 0; i < options.length; i++) {
                        if (options[i].value === val) {
                            inputProfesi.value = options[i].dataset.jabatan || '';
                            inputNip.value = options[i].dataset.nip || '';
                            break;
                        }
                    }
                });
            }

            document.querySelectorAll('.praktikan-entry').forEach(bindAutoFill);

            document.getElementById('tambah-praktikan').addEventListener('click', function() {
                const wrapper = document.getElementById('praktikan-wrapper');
                const entry = wrapper.querySelector('.praktikan-entry');
                const clone = entry.cloneNode(true);
                clone.querySelectorAll('input').forEach(input => input.value = '');
                wrapper.appendChild(clone);
                bindAutoFill(clone);
            });

            const suratSelect = document.getElementById('nama_surat');
            const jadwalSection = document.getElementById('jadwal-praktek');
            const tambahBtnWrapper = document.getElementById('tambah-btn-wrapper');
            const praktikanWrapper = document.getElementById('praktikan-wrapper');
            const tmtSection = document.getElementById('tmt-section');
            const maksudSection = document.getElementById('maksud-section');

            suratSelect.addEventListener('change', function() {
                const value = this.value;
                const isIzinAtasan = value === 'SURAT IZIN ATASAN';
                const isKeterangan = value === 'SURAT KETERANGAN';

                jadwalSection.style.display = isIzinAtasan ? 'none' : 'block';
                tambahBtnWrapper.style.display = isIzinAtasan ? 'none' : 'block';
                tmtSection.classList.toggle('d-none', !isKeterangan);
                maksudSection.classList.toggle('d-none', !isKeterangan);

                const entries = praktikanWrapper.querySelectorAll('.praktikan-entry');
                if (isIzinAtasan && entries.length > 1) {
                    entries.forEach((entry, index) => {
                        if (index > 0) entry.remove();
                    });
                }
            });
        });
    </script>
@endpush
