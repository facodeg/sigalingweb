@extends('layouts.app')

@section('title', 'Edit Pinjaman')

@section('main')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex justify-content-between align-items-md-center flex-md-row flex-column">
                    <h4 class="page-title">Edit Pinjaman</h4>
                    <ol class="m-0 breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Tambah</a></li>
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
                            value="{{ old('no_pinjaman', $pinjaman->no_pinjaman) }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="no_anggota" class="form-label">No Anggota</label>
                        <!-- Dropdown disabled -->
                        <select name="no_anggota_disabled" id="no_anggota_disabled" class="form-control select2" disabled>
                            @foreach ($anggotas as $anggota)
                                <option value="{{ $anggota->no_anggota }}"
                                    {{ $anggota->no_anggota == $pinjaman->no_anggota ? 'selected' : '' }}>
                                    {{ $anggota->nama }} ({{ $anggota->unit_kerja }})
                                </option>
                            @endforeach
                        </select>
                        <!-- Input hidden untuk menyimpan nilai -->
                        <input type="hidden" name="no_anggota" value="{{ $pinjaman->no_anggota }}" />
                    </div>


                    <div class="mb-3">
                        <label for="tenor" class="form-label">Tenor (bulan)</label>
                        <select name="tenor" id="tenor" class="form-select" required>
                            @for ($i = 1; $i <= 6; $i++)
                                <option value="{{ $i }}" {{ $i == $pinjaman->tenor ? 'selected' : '' }}>
                                    {{ $i }} bulan
                                </option>
                            @endfor
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="tgl_pinjaman" class="form-label">Tanggal Pinjaman</label>
                        <input type="date" class="form-control" id="tgl_pinjaman" name="tgl_pinjaman"
                            value="{{ old('tgl_pinjaman', $pinjaman->tgl_pinjaman) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="nominal" class="form-label">Nominal</label>
                        <input type="text" class="form-control" id="nominal" name="nominal"
                            value="{{ old('nominal', $pinjaman->nominal) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="bayar_perbulan" class="form-label">Bayar Per Bulan</label>
                        <input type="text" class="form-control" id="bayar_perbulan" name="bayar_perbulan"
                            value="{{ old('bayar_perbulan', $pinjaman->bayar_perbulan) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="tgl_selesai" class="form-label">Tanggal Selesai</label>
                        <input type="date" class="form-control" id="tgl_selesai" name="tgl_selesai"
                            value="{{ old('tgl_selesai', $pinjaman->tgl_selesai) }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="biaya_admin" class="form-label">Biaya Admin</label>
                        <input type="text" class="form-control" id="biaya_admin" name="biaya_admin"
                            value="{{ old('biaya_admin', $pinjaman->biaya_admin) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="alasan_pinjam" class="form-label">Alasan Pinjam</label>
                        <textarea id="alasan_pinjam" name="alasan_pinjam" class="form-control" rows="3" required>
                                {{ old('alasan_pinjam', $pinjaman->alasan_pinjam) }}
                            </textarea>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select id="status" name="status" class="form-control select2" data-toggle="select2" required>
                            <option value="pending" {{ $pinjaman->status == 'pending' ? 'selected' : '' }}>
                                Pending
                            </option>
                            <option value="approved" {{ $pinjaman->status == 'approved' ? 'selected' : '' }}>
                                Approved
                            </option>
                            <option value="rejected" {{ $pinjaman->status == 'rejected' ? 'selected' : '' }}>
                                Rejected
                            </option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('pinjaman.index') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>


    @push('scripts')
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

        <!-- Bootstrap Maxlength Plugin js -->
        <script src="{{ asset('assets/vendor/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>

        <!-- Typeahead Plugin js -->
        <script src="{{ asset('assets/vendor/handlebars/handlebars.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/typeahead.js/typeahead.bundle.min.js') }}"></script>

        <!-- Flatpickr Timepicker Plugin js -->
        <script src="{{ asset('assets/vendor/flatpickr/flatpickr.min.js') }}"></script>

        <!-- Typeahead Demo js -->
        <script src="{{ asset('assets/js/pages/demo.typehead.js') }}"></script>

        <!-- Timepicker Demo js -->
        <script src="{{ asset('assets/js/pages/demo.flatpickr.js') }}"></script>

        <!-- App js -->
        <script src="{{ asset('assets/js/app.min.js') }}"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                function formatRupiah(angka, prefix = 'Rp. ') {
                    let number_string = angka.replace(/[^,\d]/g, '').toString();
                    let split = number_string.split(',');
                    let sisa = split[0].length % 3;
                    let rupiah = split[0].substr(0, sisa);
                    let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                    if (ribuan) {
                        let separator = sisa ? '.' : '';
                        rupiah += separator + ribuan.join('.');
                    }

                    rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
                    return prefix === undefined ? rupiah : (rupiah ? prefix + rupiah : '');
                }

                const nominalInput = document.getElementById('nominal');
                const bayarPerBulanInput = document.getElementById('bayar_perbulan');
                const biayaAdminInput = document.getElementById('biaya_admin');

                nominalInput.addEventListener('input', function() {
                    let value = nominalInput.value.replace(/[^0-9]/g, ''); // Hapus semua karakter non-digit
                    nominalInput.value = formatRupiah(value, 'Rp. '); // Format sebagai Rupiah
                });

                bayarPerBulanInput.addEventListener('input', function() {
                    let value = bayarPerBulanInput.value.replace(/[^0-9]/g,
                        ''); // Hapus semua karakter non-digit
                    bayarPerBulanInput.value = formatRupiah(value, 'Rp. '); // Format sebagai Rupiah
                });

                biayaAdminInput.addEventListener('input', function() {
                    let value = biayaAdminInput.value.replace(/[^0-9]/g, ''); // Hapus semua karakter non-digit
                    biayaAdminInput.value = formatRupiah(value, 'Rp. '); // Format sebagai Rupiah
                });
            });
        </script>
    @endpush
@endsection
