@extends('layouts.app')

@section('title', 'Tambah Data Karyawan')

@section('main')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex justify-content-between align-items-md-center flex-md-row flex-column">
                    <h4 class="page-title">Tambah Data Karyawan</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="#">Data</a></li>
                        <li class="breadcrumb-item active">Tambah Karyawan</li>
                    </ol>
                </div>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="{{ route('karyawan.store') }}" method="POST">
            @csrf

            {{-- Card: Data Pribadi --}}
            <div class="card mb-4">
                <div class="card-header"><strong>Data Pribadi</strong></div>
                <div class="card-body">
                    <div class="row">
                        {{-- Dropdown Jenis Identitas --}}
                        <div class="mb-3 col-md-6">
                            <label for="jenis_identitas" class="form-label">Jenis Identitas</label>
                            <select class="form-select" id="jenis_identitas" name="jenis_identitas" required>
                                <option value="">Pilih</option>
                                <option value="NIP">NIP</option>
                                <option value="NRP">NRP</option>
                                <option value="NIPPPK">NIPPPK</option>
                                <option value="NIPB">NIPB</option>
                            </select>
                        </div>

                        {{-- Nomor Identitas --}}
                        <div class="mb-3 col-md-6">
                            <label for="nip_nrp_nipppk_nipb" class="form-label">Nomor Identitas</label>
                            <input type="text" class="form-control" id="nip_nrp_nipppk_nipb" name="nip_nrp_nipppk_nipb">
                        </div>

                        {{-- Nama & Tempat Lahir --}}
                        <div class="mb-3 col-md-6">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                            <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir">
                        </div>

                        {{-- Tanggal Lahir & Umur --}}
                        <div class="mb-3 col-md-6">
                            <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir">
                        </div>
                        <div class="mb-3 col-md-3">
                            <label for="umur_tahun" class="form-label">Umur (Tahun)</label>
                            <input type="number" class="form-control" id="umur_tahun" readonly>
                        </div>
                        <div class="mb-3 col-md-3">
                            <label for="umur_bulan" class="form-label">Umur (Bulan)</label>
                            <input type="number" class="form-control" id="umur_bulan" readonly>
                        </div>

                        {{-- NIK --}}
                        <div class="mb-3 col-md-6">
                            <label for="nik" class="form-label">NIK</label>
                            <input type="text" class="form-control" id="nik" name="nik">
                        </div>

                        {{-- Jenis Kelamin --}}
                        <div class="mb-3 col-md-3">
                            <label for="jk" class="form-label">Jenis Kelamin</label>
                            <select class="form-select" id="jk" name="jk">
                                <option value="">Pilih</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card: Data Kepegawaian --}}
            <div class="card mb-4">
                <div class="card-header"><strong>Data Kepegawaian</strong></div>
                <div class="card-body">
                    <div class="row">
                        @foreach ([['status_kepegawaian', 'Status Kepegawaian'], ['jabatan_terakhir', 'Jabatan Terakhir'], ['tmt_jabatan', 'TMT Jabatan', 'date'], ['tmt_kerja_di_rsud', 'TMT Kerja di RSUD', 'date'], ['lama_kerja_tahun', 'Lama Kerja (Tahun)'], ['lama_kerja_bulan', 'Lama Kerja (Bulan)'], ['gol', 'Golongan'], ['pangkat_gol', 'Pangkat Golongan'], ['tmt_gol', 'TMT Golongan', 'date'], ['no_sk', 'No SK'], ['tgl_sk', 'Tanggal SK', 'date']] as $input)
                            <div
                                class="mb-3 col-md-{{ in_array($input[0], ['lama_kerja_tahun', 'lama_kerja_bulan', 'gol', 'pangkat_gol']) ? '3' : '6' }}">
                                <label for="{{ $input[0] }}" class="form-label">{{ $input[1] }}</label>
                                <input type="{{ $input[2] ?? 'text' }}" class="form-control" id="{{ $input[0] }}"
                                    name="{{ $input[0] }}">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Card: Data Pendidikan --}}
            <div class="card mb-4">
                <div class="card-header"><strong>Data Pendidikan</strong></div>
                <div class="card-body">
                    <div class="row">
                        @foreach ([['jenjang_pendidikan', 'Jenjang Pendidikan'], ['pendidikan_terakhir', 'Pendidikan Terakhir']] as $input)
                            <div class="mb-3 col-md-6">
                                <label for="{{ $input[0] }}" class="form-label">{{ $input[1] }}</label>
                                <input type="text" class="form-control" id="{{ $input[0] }}"
                                    name="{{ $input[0] }}">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Card: Data Alamat --}}
            <div class="card mb-4">
                <div class="card-header"><strong>Data Alamat</strong></div>
                <div class="card-body">
                    <div class="row">
                        @foreach ([['alamat_ktp', 'Alamat KTP', 6], ['desa', 'Desa', 3], ['kecamatan', 'Kecamatan', 3], ['kabupaten', 'Kabupaten', 3], ['agama', 'Agama', 3]] as [$name, $label, $col])
                            <div class="mb-3 col-md-{{ $col }}">
                                <label for="{{ $name }}" class="form-label">{{ $label }}</label>
                                <input type="text" class="form-control" id="{{ $name }}"
                                    name="{{ $name }}">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Card: Lainnya --}}
            <div class="card mb-4">
                <div class="card-header"><strong>Lainnya</strong></div>
                <div class="card-body">
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="npwp" class="form-label">NPWP</label>
                            <input type="text" class="form-control" id="npwp" name="npwp">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="ruangan" class="form-label">Ruangan</label>
                            <input type="text" class="form-control" id="ruangan" name="ruangan">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status1" name="status">
                                <option value="Nakes">Nakes</option>
                                <option value="Non Nakes">Non Nakes</option>
                            </select>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="status_nakes" class="form-label">Status Pegawai</label>
                            <select class="form-select" id="status_nakes" name="status_nakes" required>
                                <option value="">Pilih</option>
                                <option value="Aktif">Aktif</option>
                                <option value="Pensiun">Pensiun</option>
                                <option value="Resign">Resign</option>
                            </select>
                        </div>
                        <div class="mb-3 col-md-12">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <input type="text" class="form-control" id="keterangan" name="keterangan">
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-success">Simpan Data</button>
            </div>
        </form>
    </div>

    <!-- Modal ID Fingerprint -->
    <div class="modal fade" id="fingerprintModal" tabindex="-1" aria-labelledby="fingerprintModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="fingerprintModalLabel">Masukkan ID Fingerprint</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <input type="number" class="form-control" id="id_fingerprint"
                        placeholder="Masukkan ID Fingerprint">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="generateNIPB">Generate NIPB</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tglLahirInput = document.getElementById('tgl_lahir');
            const umurTahunInput = document.getElementById('umur_tahun');
            const umurBulanInput = document.getElementById('umur_bulan');

            function hitungUmur(tanggalLahir) {
                const today = new Date();
                const lahir = new Date(tanggalLahir);
                let tahun = today.getFullYear() - lahir.getFullYear();
                let bulan = today.getMonth() - lahir.getMonth();
                if (bulan < 0 || (bulan === 0 && today.getDate() < lahir.getDate())) {
                    tahun--;
                    bulan += 12;
                }
                return {
                    tahun,
                    bulan
                };
            }

            tglLahirInput.addEventListener('change', function() {
                if (tglLahirInput.value) {
                    const {
                        tahun,
                        bulan
                    } = hitungUmur(tglLahirInput.value);
                    umurTahunInput.value = tahun;
                    umurBulanInput.value = bulan;
                }
            });

            // Modal NIPB
            const jenisIdentitas = document.getElementById('jenis_identitas');
            const modalFingerprint = new bootstrap.Modal(document.getElementById('fingerprintModal'));
            const tmtKerjaInput = document.getElementById('tmt_kerja_di_rsud');
            const jkInput = document.getElementById('jk');
            const nipInput = document.getElementById('nip_nrp_nipppk_nipb');

            jenisIdentitas.addEventListener('change', function() {
                if (this.value === 'NIPB') {
                    modalFingerprint.show();
                }
            });

            document.getElementById('generateNIPB').addEventListener('click', function() {
                const idFingerprint = document.getElementById('id_fingerprint').value;
                if (!idFingerprint || idFingerprint.length < 3) {
                    alert('Masukkan minimal 3 digit terakhir ID Fingerprint');
                    return;
                }
                const tglLahir = tglLahirInput.value ? tglLahirInput.value.replace(/-/g, '') : '';
                const tmt = tmtKerjaInput.value ? tmtKerjaInput.value.substring(0, 7).replace('-', '') : '';
                const genderCode = (jkInput.value === 'L') ? '1' : (jkInput.value === 'P') ? '2' : '';
                if (!tglLahir || !tmt || !genderCode) {
                    alert('Lengkapi tanggal lahir, TMT, dan jenis kelamin terlebih dahulu.');
                    return;
                }
                const last3Digit = idFingerprint.slice(-3);
                const nipb = `${tglLahir}${tmt}${genderCode}${last3Digit}`;
                nipInput.value = nipb;
                modalFingerprint.hide();
            });
        });
    </script>
@endpush
