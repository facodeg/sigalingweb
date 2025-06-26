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

        <div class="card">
            <div class="card-body">
                <form action="{{ route('karyawan.update', $karyawan->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Data Pribadi --}}
                    <h5 class="card-title">Data Pribadi</h5>
                    <div class="row">
                        @foreach ([['nama', 'Nama'], ['nip_nrp_nipppk_nipb', 'NIP/NRP/NIPPPK/NIPB'], ['tempat_lahir', 'Tempat Lahir'], ['tgl_lahir', 'Tanggal Lahir', 'date'], ['umur_tahun', 'Umur (Tahun)', 'number'], ['umur_bulan', 'Umur (Bulan)', 'number'], ['nik', 'NIK']] as $input)
                            <div
                                class="mb-3 col-md-{{ in_array($input[0], ['umur_tahun', 'umur_bulan', 'nik']) ? '3' : '6' }}">
                                <label for="{{ $input[0] }}" class="form-label">{{ $input[1] }}</label>
                                <input type="{{ $input[2] ?? 'text' }}" class="form-control" id="{{ $input[0] }}"
                                    name="{{ $input[0] }}" value="{{ $karyawan[$input[0]] ?? '' }}">
                            </div>
                        @endforeach

                        <div class="mb-3 col-md-3">
                            <label for="jk" class="form-label">Jenis Kelamin</label>
                            <select class="form-select" id="jk" name="jk">
                                <option value="L" {{ $karyawan->jk == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ $karyawan->jk == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                    </div>

                    {{-- Data Kepegawaian --}}
                    <h5 class="card-title">Data Kepegawaian</h5>
                    <div class="row">
                        @foreach ([['status_kepegawaian', 'Status Kepegawaian'], ['jabatan_terakhir', 'Jabatan Terakhir'], ['tmt_jabatan', 'TMT Jabatan', 'date'], ['tmt_kerja_di_rsud', 'TMT Kerja di RSUD', 'date'], ['lama_kerja_tahun', 'Lama Kerja (Tahun)', 'number'], ['lama_kerja_bulan', 'Lama Kerja (Bulan)', 'number'], ['gol', 'Golongan'], ['pangkat_gol', 'Pangkat Golongan'], ['tmt_gol', 'TMT Golongan', 'date'], ['no_sk', 'No SK'], ['tgl_sk', 'Tanggal SK', 'date']] as $input)
                            <div
                                class="mb-3 col-md-{{ in_array($input[0], ['lama_kerja_tahun', 'lama_kerja_bulan', 'gol', 'pangkat_gol']) ? '3' : '6' }}">
                                <label for="{{ $input[0] }}" class="form-label">{{ $input[1] }}</label>
                                <input type="{{ $input[2] ?? 'text' }}" class="form-control" id="{{ $input[0] }}"
                                    name="{{ $input[0] }}" value="{{ $karyawan[$input[0]] ?? '' }}">
                            </div>
                        @endforeach
                    </div>

                    {{-- Data Pendidikan --}}
                    <h5 class="card-title">Data Pendidikan</h5>
                    <div class="row">
                        @foreach ([['jenjang_pendidikan', 'Jenjang Pendidikan'], ['pendidikan_terakhir', 'Pendidikan Terakhir']] as $input)
                            <div class="mb-3 col-md-6">
                                <label for="{{ $input[0] }}" class="form-label">{{ $input[1] }}</label>
                                <input type="text" class="form-control" id="{{ $input[0] }}"
                                    name="{{ $input[0] }}" value="{{ $karyawan[$input[0]] ?? '' }}">
                            </div>
                        @endforeach
                    </div>

                    {{-- Data Alamat --}}
                    <h5 class="card-title">Data Alamat</h5>
                    <div class="row">
                        @foreach ([['alamat_ktp', 'Alamat KTP', 6], ['desa', 'Desa', 3], ['kecamatan', 'Kecamatan', 3], ['kabupaten', 'Kabupaten', 3], ['agama', 'Agama', 3]] as [$name, $label, $col])
                            <div class="mb-3 col-md-{{ $col }}">
                                <label for="{{ $name }}" class="form-label">{{ $label }}</label>
                                <input type="text" class="form-control" id="{{ $name }}"
                                    name="{{ $name }}" value="{{ $karyawan[$name] ?? '' }}">
                            </div>
                        @endforeach
                    </div>

                    {{-- Lainnya --}}
                    <h5 class="card-title">Lainnya</h5>
                    <div class="row">
                        @foreach ([['npwp', 'NPWP'], ['ruangan', 'Ruangan'], ['status', 'Status'], ['status_nakes', 'Status Nakes'], ['keterangan', 'Keterangan', 12]] as $input)
                            <div class="mb-3 col-md-{{ $input[2] ?? 6 }}">
                                <label for="{{ $input[0] }}" class="form-label">{{ $input[1] }}</label>
                                <input type="text" class="form-control" id="{{ $input[0] }}"
                                    name="{{ $input[0] }}" value="{{ $karyawan[$input[0]] ?? '' }}">
                            </div>
                        @endforeach
                    </div>

                    <button type="submit" class="btn btn-primary">Update Data</button>
                </form>
            </div>
        </div>
    </div>
@endsection
