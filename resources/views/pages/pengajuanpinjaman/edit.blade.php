@extends('layouts.app')

@section('title', 'Edit Pinjaman')

@section('main')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex justify-content-between align-items-md-center flex-md-row flex-column">
                    <h4 class="page-title">Edit Pinjaman</h4>
                    <ol class="m-0 breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Edit</a></li>
                        <li class="breadcrumb-item active">Data Pinjaman</li>
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
                <h5 class="card-title">Edit Pinjaman</h5>
                <form action="{{ route('pinjaman.update', $pinjaman->id) }}" method="POST" id="pinjaman-form">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="no_pinjaman" class="form-label">No Pinjaman</label>
                        <input type="text" class="form-control" id="no_pinjaman" name="no_pinjaman"
                            value="{{ $pinjaman->no_pinjaman }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="no_anggota" class="form-label">No Anggota</label>
                        <select name="no_anggota" id="no_anggota" class="form-control select2" data-toggle="select2"
                            required>
                            @foreach ($anggotas as $anggota)
                                <option value="{{ $anggota->no_anggota }}"
                                    {{ $pinjaman->no_anggota == $anggota->no_anggota ? 'selected' : '' }}>
                                    {{ $anggota->nama }} ({{ $anggota->unit_kerja }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="tenor" class="form-label">Tenor (bulan)</label>
                        <select name="tenor" id="tenor" class="form-select" required>
                            @for ($i = 1; $i <= 6; $i++)
                                <option value="{{ $i }}" {{ $pinjaman->tenor == $i ? 'selected' : '' }}>
                                    {{ $i }} bulan
                                </option>
                            @endfor
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="tgl_pinjaman" class="form-label">Tanggal Pinjaman</label>
                        <input type="date" class="form-control" id="tgl_pinjaman" name="tgl_pinjaman"
                            value="{{ $pinjaman->tgl_pinjaman }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="nominal" class="form-label">Nominal</label>
                        <input type="text" class="form-control" id="nominal" name="nominal"
                            value="{{ number_format($pinjaman->nominal, 0, ',', '.') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="bayar_perbulan" class="form-label">Bayar Per Bulan</label>
                        <input type="text" class="form-control" id="bayar_perbulan" name="bayar_perbulan"
                            value="{{ number_format($pinjaman->bayar_perbulan, 0, ',', '.') }}">
                    </div>

                    <div class="mb-3">
                        <label for="tgl_selesai" class="form-label">Tanggal Selesai</label>
                        <input type="date" class="form-control" id="tgl_selesai" name="tgl_selesai"
                            value="{{ $pinjaman->tgl_selesai }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="biaya_admin" class="form-label">Biaya Penanganan</label>
                        <input type="text" class="form-control" id="biaya_admin" name="biaya_admin"
                            value="{{ number_format($pinjaman->biaya_admin, 0, ',', '.') }}">
                        <p class="form-text">Isi biaya penanganan seikhlasnya</p>
                    </div>

                    <div class="mb-3">
                        <label for="alasan_pinjam" class="form-label">Alasan Pinjam</label>
                        <textarea id="alasan_pinjam" name="alasan_pinjam" class="form-control" rows="3" required>
                            {{ $pinjaman->alasan_pinjam }}
                        </textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('pengajuanpinjaman.index') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <!-- Vendor js -->
        <script src="{{ asset('assets/js/vendor.min.js') }}"></script>

        <!-- Select2 Plugin Js -->
        <script src="{{ asset('assets/vendor/select2/js/select2.min.js') }}"></script>

        <!-- Daterangepicker Plugin js -->
        <script src="{{ asset('assets/vendor/daterangepicker/moment.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/daterangepicker/daterangepicker.js') }}"></script>

        <!-- Input Mask Plugin js -->
        <script src="{{ asset('assets/vendor/jquery-mask-plugin/jquery.mask.min.js') }}"></script>

        <!-- Bootstrap Touchspin Plugin js -->
        <script src="{{ asset('assets/vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>

        <!-- Init js -->
        <script src="{{ asset('assets/js/pages/form-mask.init.js') }}"></script>
    @endpush
@endsection
