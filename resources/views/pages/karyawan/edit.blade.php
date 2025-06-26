@extends('layouts.app')

@section('title', 'Edit Data Karyawan')

@section('main')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex justify-content-between align-items-md-center flex-md-row flex-column">
                    <h4 class="page-title">Edit Data Karyawan</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="#">Data</a></li>
                        <li class="breadcrumb-item active">Edit Karyawan</li>
                    </ol>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="{{ route('karyawan.update', $karyawan->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Card: Data Pribadi --}}
            <div class="card mb-4">
                <div class="card-header"><strong>Data Pribadi</strong></div>
                <div class="card-body">
                    <div class="row">
                        @foreach ([['nama', 'Nama'], ['nip_nrp_nipppk_nipb', 'NIP/NRP/NIPPPK/NIPB'], ['tempat_lahir', 'Tempat Lahir']] as $input)
                            <div class="mb-3 col-md-6">
                                <label for="{{ $input[0] }}" class="form-label">{{ $input[1] }}</label>
                                <input type="text" class="form-control" id="{{ $input[0] }}"
                                    name="{{ $input[0] }}" value="{{ $karyawan[$input[0]] ?? '' }}">
                            </div>
                        @endforeach

                        <div class="mb-3 col-md-6">
                            <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir"
                                value="{{ $karyawan->tgl_lahir }}">
                        </div>

                        <div class="mb-3 col-md-3">
                            <label for="umur_tahun" class="form-label">Umur (Tahun)</label>
                            <input type="number" class="form-control" id="umur_tahun" readonly>
                        </div>
                        <div class="mb-3 col-md-3">
                            <label for="umur_bulan" class="form-label">Umur (Bulan)</label>
                            <input type="number" class="form-control" id="umur_bulan" readonly>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="nik" class="form-label">NIK</label>
                            <input type="text" class="form-control" id="nik" name="nik"
                                value="{{ $karyawan->nik }}">
                        </div>

                        <div class="mb-3 col-md-3">
                            <label for="jk" class="form-label">Jenis Kelamin</label>
                            <select class="form-select" id="jk" name="jk">
                                <option value="L" {{ $karyawan->jk == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ $karyawan->jk == 'P' ? 'selected' : '' }}>Perempuan</option>
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
                                    name="{{ $input[0] }}" value="{{ $karyawan[$input[0]] ?? '' }}">
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
                                    name="{{ $input[0] }}" value="{{ $karyawan[$input[0]] ?? '' }}">
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
                                    name="{{ $name }}" value="{{ $karyawan[$name] ?? '' }}">
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
                            <label for="status" class="form-label">Status</label>
                            <input type="text" class="form-control" id="status" name="status"
                                value="{{ $karyawan->status ?? '' }}">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="status_nakes" class="form-label">Status Nakes</label>
                            <input type="text" class="form-control" id="status_nakes" name="status_nakes"
                                value="{{ $karyawan->status_nakes ?? '' }}">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="npwp" class="form-label">NPWP</label>
                            <input type="text" class="form-control" id="npwp" name="npwp"
                                value="{{ $karyawan->npwp ?? '' }}">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="ruangan" class="form-label">Ruangan</label>
                            <input type="text" class="form-control" id="ruangan" name="ruangan"
                                value="{{ $karyawan->ruangan ?? '' }}">
                        </div>
                        <div class="mb-3 col-md-12">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <input type="text" class="form-control" id="keterangan" name="keterangan"
                                value="{{ $karyawan->keterangan ?? '' }}">
                        </div>
                    </div>
                </div>
            </div>


            <div class="text-end">
                <button type="submit" class="btn btn-primary">Update Data</button>
            </div>
        </form>
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

            function updateUmur() {
                if (tglLahirInput.value) {
                    const {
                        tahun,
                        bulan
                    } = hitungUmur(tglLahirInput.value);
                    umurTahunInput.value = tahun;
                    umurBulanInput.value = bulan;
                }
            }

            tglLahirInput.addEventListener('change', updateUmur);
            updateUmur(); // Hitung saat pertama kali load
        });
    </script>
@endpush
