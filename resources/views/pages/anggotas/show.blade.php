<!-- resources/views/anggotas/show.blade.php -->

@extends('layouts.app')

@section('title', 'Detail Anggota')

@section('main')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Detail Anggota</h5>
                    <div class="mb-3">
                        <label for="no_anggota" class="form-label">No Anggota</label>
                        <input type="text" class="form-control" id="no_anggota" value="{{ $anggota->no_anggota }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" value="{{ $anggota->nama }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="nip_nipb_nrptt" class="form-label">NIP/NIPB/NRPTT</label>
                        <input type="text" class="form-control" id="nip_nipb_nrptt" value="{{ $anggota->nip_nipb_nrptt }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                        <input type="text" class="form-control" id="tempat_lahir" value="{{ $anggota->tempat_lahir }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                        <input type="text" class="form-control" id="tanggal_lahir" value="{{ $anggota->tanggal_lahir }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="umur" class="form-label">Umur</label>
                        <input type="text" class="form-control" id="umur" value="{{ $anggota->umur }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="nik" class="form-label">NIK</label>
                        <input type="text" class="form-control" id="nik" value="{{ $anggota->nik }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <input type="text" class="form-control" id="alamat" value="{{ $anggota->alamat }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="unit_kerja" class="form-label">Unit Kerja</label>
                        <input type="text" class="form-control" id="unit_kerja" value="{{ $anggota->unit_kerja }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="status_kepegawaian" class="form-label">Status Kepegawaian</label>
                        <input type="text" class="form-control" id="status_kepegawaian" value="{{ $anggota->status_kepegawaian }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="status_pernikahan" class="form-label">Status Pernikahan</label>
                        <input type="text" class="form-control" id="status_pernikahan" value="{{ $anggota->status_pernikahan }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="simpanan_pokok" class="form-label">Simpanan Pokok</label>
                        <input type="text" class="form-control" id="simpanan_pokok" value="{{ $anggota->simpanan_pokok }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="simpanan_wajib" class="form-label">Simpanan Wajib</label>
                        <input type="text" class="form-control" id="simpanan_wajib" value="{{ $anggota->simpanan_wajib }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="no_hp" class="form-label">No HP</label>
                        <input type="text" class="form-control" id="no_hp" value="{{ $anggota->no_hp }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="upload_ktp" class="form-label">Upload KTP</label>
                        <div>
                            @if ($anggota->upload_ktp)
                                <img src="{{ asset('storage/'.$anggota->upload_ktp) }}" alt="KTP" class="img-thumbnail" style="width: 150px;">
                            @else
                                <p>Belum ada KTP yang diunggah.</p>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="upload_foto_diri" class="form-label">Upload Foto Diri</label>
                        <div>
                            @if ($anggota->upload_foto_diri)
                                <img src="{{ asset('storage/'.$anggota->upload_foto_diri) }}" alt="Foto Diri" class="img-thumbnail" style="width: 150px;">
                            @else
                                <p>Belum ada foto diri yang diunggah.</p>
                            @endif
                        </div>
                    </div>
                    <a href="{{ route('anggotas.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
@endsection
