@extends('layouts.app')

@section('title', 'Tambah Surat Praktek')

@section('main')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex justify-content-between align-items-md-center flex-md-row flex-column">
                    <h4 class="page-title">Tambah Surat Keterangan Praktek rsud</h4>
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
            $dataPendidikan = \App\Models\Pendidikan::select('nama', 'jabatan')->get();
        @endphp

        <div class="card">
            <div class="card-body">
                <form action="{{ route('surat_praktek_satu.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="no_surat" class="form-label">Nomor Surat</label>
                            <input type="text" name="no_surat" id="no_surat" class="form-control"
                                placeholder="Contoh: 445.1/PK-RSUD/{{ date('Y') }}">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="praktikan_nama" class="form-label">Nama Praktikan</label>
                            <input list="list-nama" name="praktikan_nama" id="praktikan_nama" class="form-control" required>
                            <datalist id="list-nama">
                                @foreach ($dataPendidikan as $p)
                                    <option value="{{ $p->nama }}" data-jabatan="{{ $p->jabatan }}"></option>
                                @endforeach
                            </datalist>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="profesi" class="form-label">Profesi</label>
                            <input type="text" name="profesi" id="profesi" class="form-control" readonly>
                        </div>

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

                        <div class="mb-3 col-md-6">
                            <label for="jam_efektif_mingguan" class="form-label">Jam Efektif / Minggu</label>
                            <input type="number" name="jam_efektif_mingguan" id="jam_efektif_mingguan" class="form-control"
                                value="37.5" step="0.1">
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

                        <div class="mb-3 col-md-6">
                            <label for="tempat_dikeluarkan" class="form-label">Tempat Dikeluarkan</label>
                            <input type="text" name="tempat_dikeluarkan" id="tempat_dikeluarkan" class="form-control"
                                value="Leuwiliang">
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="tanggal_dikeluarkan" class="form-label">Tanggal Dikeluarkan</label>
                            <input type="date" name="tanggal_dikeluarkan" id="tanggal_dikeluarkan"
                                class="form-control">
                        </div>

                        {{-- Penandatangan --}}
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputNama = document.getElementById('praktikan_nama');
            const inputProfesi = document.getElementById('profesi');
            const datalist = document.getElementById('list-nama');

            inputNama.addEventListener('input', function() {
                const val = inputNama.value;
                const options = datalist.options;
                let found = false;

                for (let i = 0; i < options.length; i++) {
                    if (options[i].value === val) {
                        const jabatan = options[i].getAttribute('data-jabatan');
                        inputProfesi.value = jabatan;
                        found = true;
                        break;
                    }
                }

                if (!found) {
                    inputProfesi.value = '';
                }
            });
        });
    </script>
@endpush
