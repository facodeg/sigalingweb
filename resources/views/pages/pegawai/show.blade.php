<!-- resources/views/pegawais/show.blade.php -->

@extends('layouts.app')

@section('title', 'Detail Pegawai')

@section('main')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Detail Pegawai</h5>
                    <div class="mb-3">
                        <label for="user_name" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="user_name" value="{{ $pegawai->user->name }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="user_email" class="form-label">Email</label>
                        <input type="text" class="form-control" id="user_email" value="{{ $pegawai->user->email }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="nip" class="form-label">NIP</label>
                        <input type="text" class="form-control" id="nip" value="{{ $pegawai->nip }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <input type="text" class="form-control" id="alamat" value="{{ $pegawai->alamat }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="jabatan" class="form-label">Jabatan</label>
                        <input type="text" class="form-control" id="jabatan" value="{{ $pegawai->jabatan }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                        <input type="text" class="form-control" id="tanggal_lahir" value="{{ $pegawai->tanggal_lahir }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="pendidikan" class="form-label">Pendidikan</label>
                        <input type="text" class="form-control" id="pendidikan" value="{{ $pegawai->pendidikan }}" readonly>
                    </div>
                    <a href="{{ route('pegawais.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
@endsection
