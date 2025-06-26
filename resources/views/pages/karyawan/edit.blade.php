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

                    <h5 class="card-title">Data Pribadi</h5>
                    <div class="row">
                        <x-form.input col="6" label="Nama" name="nama" :value="$karyawan->nama" required />
                        <x-form.input col="6" label="NIP/NRP/NIPPPK/NIPB" name="nip_nrp_nipppk_nipb"
                            :value="$karyawan->nip_nrp_nipppk_nipb" required />
                        <x-form.input col="6" label="Tempat Lahir" name="tempat_lahir" :value="$karyawan->tempat_lahir" required />
                        <x-form.input type="date" col="6" label="Tanggal Lahir" name="tgl_lahir" :value="$karyawan->tgl_lahir"
                            required />
                        <x-form.input col="3" label="Umur (Tahun)" name="umur_tahun" :value="$karyawan->umur_tahun" required />
                        <x-form.input col="3" label="Umur (Bulan)" name="umur_bulan" :value="$karyawan->umur_bulan" required />
                        <x-form.select col="3" label="Jenis Kelamin" name="jk" :value="$karyawan->jk"
                            :options="['L' => 'Laki-laki', 'P' => 'Perempuan']" />
                        <x-form.input col="3" label="NIK" name="nik" :value="$karyawan->nik" required />
                    </div>

                    <h5 class="card-title">Data Kepegawaian</h5>
                    <div class="row">
                        <x-form.input col="6" label="Status Kepegawaian" name="status_kepegawaian" :value="$karyawan->status_kepegawaian"
                            required />
                        <x-form.input col="6" label="Jabatan Terakhir" name="jabatan_terakhir" :value="$karyawan->jabatan_terakhir"
                            required />
                        <x-form.input type="date" col="4" label="TMT Jabatan" name="tmt_jabatan"
                            :value="$karyawan->tmt_jabatan" />
                        <x-form.input type="date" col="4" label="TMT Kerja di RSUD" name="tmt_kerja_di_rsud"
                            :value="$karyawan->tmt_kerja_di_rsud" />
                        <x-form.input col="2" label="Lama Kerja (Tahun)" name="lama_kerja_tahun"
                            :value="$karyawan->lama_kerja_tahun" />
                        <x-form.input col="2" label="Lama Kerja (Bulan)" name="lama_kerja_bulan"
                            :value="$karyawan->lama_kerja_bulan" />
                        <x-form.input col="3" label="Golongan" name="gol" :value="$karyawan->gol" />
                        <x-form.input col="3" label="Pangkat Golongan" name="pangkat_gol" :value="$karyawan->pangkat_gol" />
                        <x-form.input type="date" col="3" label="TMT Golongan" name="tmt_gol"
                            :value="$karyawan->tmt_gol" />
                        <x-form.input col="3" label="No SK" name="no_sk" :value="$karyawan->no_sk" />
                        <x-form.input type="date" col="3" label="Tanggal SK" name="tgl_sk" :value="$karyawan->tgl_sk" />
                    </div>

                    <h5 class="card-title">Data Pendidikan</h5>
                    <div class="row">
                        <x-form.input col="6" label="Jenjang Pendidikan" name="jenjang_pendidikan"
                            :value="$karyawan->jenjang_pendidikan" />
                        <x-form.input col="6" label="Pendidikan Terakhir" name="pendidikan_terakhir"
                            :value="$karyawan->pendidikan_terakhir" />
                    </div>

                    <h5 class="card-title">Data Alamat</h5>
                    <div class="row">
                        <x-form.input col="6" label="Alamat KTP" name="alamat_ktp" :value="$karyawan->alamat_ktp" />
                        <x-form.input col="3" label="Desa" name="desa" :value="$karyawan->desa" />
                        <x-form.input col="3" label="Kecamatan" name="kecamatan" :value="$karyawan->kecamatan" />
                        <x-form.input col="3" label="Kabupaten" name="kabupaten" :value="$karyawan->kabupaten" />
                        <x-form.input col="3" label="Agama" name="agama" :value="$karyawan->agama" />
                    </div>

                    <h5 class="card-title">Lainnya</h5>
                    <div class="row">
                        <x-form.input col="6" label="NPWP" name="npwp" :value="$karyawan->npwp" />
                        <x-form.input col="6" label="Ruangan" name="ruangan" :value="$karyawan->ruangan" />
                        <x-form.input col="6" label="Status" name="status" :value="$karyawan->status" />
                        <x-form.input col="6" label="Status Nakes" name="status_nakes" :value="$karyawan->status_nakes" />
                        <x-form.input col="12" label="Keterangan" name="keterangan" :value="$karyawan->keterangan" />
                    </div>

                    <button type="submit" class="btn btn-primary">Update Data</button>
                </form>
            </div>
        </div>
    </div>
@endsection
