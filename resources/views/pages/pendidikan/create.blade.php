@extends('layouts.app')

@section('title', 'Tambah Data Pendidikan')

@section('main')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex justify-content-between align-items-md-center flex-md-row flex-column">
                    <h4 class="page-title">Tambah Data Pendidikan</h4>
                    <ol class="m-0 breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Pendidikan</a></li>
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

        <div class="card">
            <div class="card-body">
                <form action="{{ route('pendidikan.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" name="nama" id="nama" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="nip" class="form-label">NIP</label>
                            <input type="text" name="nip" id="nip" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="jk" class="form-label">Jenis Kelamin</label>
                            <select name="jk" id="jk" class="form-select" required>
                                <option value="" disabled selected>Pilih Jenis Kelamin</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="jp" class="form-label">Jenis Pegawai</label>
                            <input type="text" name="jp" id="jp" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="pendidikan" class="form-label">Pendidikan Terakhir</label>
                            <input type="text" name="pendidikan" id="pendidikan" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="jb" class="form-label">Jenis Jabatan</label>
                            <input type="text" name="jb" id="jb" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="jabatan" class="form-label">Jabatan</label>
                            <input type="text" name="jabatan" id="jabatan" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="status_pg" class="form-label">Status Pegawai</label>
                            <input type="text" name="status_pg" id="status_pg" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="nama_sekolah" class="form-label">Nama Sekolah</label>
                            <input type="text" name="nama_sekolah" id="nama_sekolah" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="Tahun" class="form-label">Tahun Lulus</label>
                            <input type="number" name="Tahun" id="Tahun" class="form-control" maxlength="4"
                                required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                    <a href="{{ route('pendidikan.index') }}" class="btn btn-secondary mt-3">Kembali</a>
                </form>
            </div>
        </div>
    </div>

@endsection
