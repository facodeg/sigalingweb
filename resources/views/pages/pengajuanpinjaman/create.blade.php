@extends('layouts.app')

@section('title', 'Tambah Pinjaman')

@section('main')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex justify-content-between align-items-md-center flex-md-row flex-column">
                    <h4 class="page-title">Tambah Pinjaman</h4>
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
                <h5 class="card-title">Tambah Pinjaman</h5>
                <form action="{{ route('pengajuanpinjaman.store') }}" method="POST" id="pinjaman-form">
                    @csrf
                    <div class="mb-3">
                        <label for="no_pinjaman" class="form-label">No Pinjaman</label>
                        <input type="text" class="form-control" id="no_pinjaman" name="no_pinjaman"
                            value="{{ $no_pinjaman }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="no_anggota" class="form-label">No Anggota</label>
                        <select name="no_anggota" id="no_anggota" class="form-control select2" data-toggle="select2"
                            required>
                            @foreach ($anggotas as $anggota)
                                <option value="{{ $anggota->no_anggota }}">{{ $anggota->nama }} ({{ $anggota->unit_kerja }})
                                </option>
                            @endforeach
                        </select>
                    </div>



                    <div class="mb-3">
                        <label for="tenor" class="form-label">Tenor (bulan)</label>
                        <select name="tenor" id="tenor" class="form-select" required>
                            @for ($i = 1; $i <= 6; $i++)
                                <option value="{{ $i }}">{{ $i }} bulan</option>
                            @endfor
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="tgl_pinjaman" class="form-label">Tanggal Pinjaman</label>
                        <input type="date" class="form-control" id="tgl_pinjaman" name="tgl_pinjaman" required>
                    </div>

                    <div class="mb-3">
                        <label for="nominal" class="form-label">Nominal</label>
                        <input type="text" class="form-control" id="nominal" name="nominal" required>
                    </div>

                    <div class="mb-3">
                        <label for="bayar_perbulan" class="form-label">Bayar Per Bulan</label>
                        <input type="text" class="form-control" id="bayar_perbulan" name="bayar_perbulan">
                    </div>

                    <div class="mb-3">
                        <label for="tgl_selesai" class="form-label">Tanggal Selesai</label>
                        <input type="date" class="form-control" id="tgl_selesai" name="tgl_selesai" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="biaya_admin" class="form-label">Biaya Penanganan</label>
                        <input type="text" class="form-control" id="biaya_admin" name="biaya_admin">
                        <p class="form-text">Isi biaya penanganan seikhlasnya</p>
                    </div>

                    <div class="mb-3">
                        <label for="alasan_pinjam" class="form-label">Alasan Pinjam</label>
                        <textarea id="alasan_pinjam" name="alasan_pinjam" class="form-control" rows="3" required></textarea>
                    </div>



                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('pinjaman.index') }}" class="btn btn-secondary">Kembali</a>
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
                const nominalInput = document.getElementById('nominal');
                const bayarPerBulanInput = document.getElementById('bayar_perbulan');
                const tenorSelect = document.getElementById('tenor');
                const tglPinjamanInput = document.getElementById('tgl_pinjaman');
                const tglSelesaiInput = document.getElementById('tgl_selesai');
                const biayaAdminInput = document.getElementById('biaya_admin');

                // Format Rupiah untuk input nominal
                nominalInput.addEventListener('input', function() {
                    let value = nominalInput.value.replace(/[^0-9]/g, ''); // Hapus semua karakter non-digit
                    nominalInput.value = formatRupiah(value, 'Rp. '); // Format sebagai Rupiah
                    calculateBayarPerBulan(); // Update bayar per bulan saat nominal berubah
                });

                nominalInput.addEventListener('blur', function() {
                    let value = nominalInput.value.replace(/[^0-9]/g, ''); // Hapus semua karakter non-digit
                    nominalInput.value = formatRupiah(value, 'Rp. '); // Format sebagai Rupiah
                });

                biayaAdminInput.addEventListener('input', function() {
                    let value = biayaAdminInput.value.replace(/[^0-9]/g, ''); // Hapus semua karakter non-digit
                    biayaAdminInput.value = formatRupiah(value, 'Rp. '); // Format sebagai Rupiah
                });

                biayaAdminInput.addEventListener('blur', function() {
                    let value = biayaAdminInput.value.replace(/[^0-9]/g, ''); // Hapus semua karakter non-digit
                    biayaAdminInput.value = formatRupiah(value, 'Rp. '); // Format sebagai Rupiah
                });

                tenorSelect.addEventListener('change', function() {
                    calculateBayarPerBulan();
                    calculateTglSelesai();
                });

                tglPinjamanInput.addEventListener('change', calculateTglSelesai);

                function formatRupiah(angka, prefix) {
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

                function calculateBayarPerBulan() {
                    // Menghapus prefix dan format Rupiah, lalu mengonversi ke angka
                    const nominal = parseFloat(nominalInput.value.replace(/[^0-9]/g, ''));
                    const tenor = parseInt(tenorSelect.value);

                    if (!isNaN(nominal) && !isNaN(tenor) && tenor > 0) {
                        const bayarPerBulan = nominal / tenor;
                        bayarPerBulanInput.value = formatRupiah(Math.round(bayarPerBulan).toString(), '');
                    } else {
                        bayarPerBulanInput.value = '';
                    }
                }

                function calculateTglSelesai() {
                    const tglPinjaman = new Date(tglPinjamanInput.value);
                    const tenor = parseInt(tenorSelect.value);

                    if (!isNaN(tglPinjaman.getTime()) && !isNaN(tenor) && tenor > 0) {
                        const tglSelesai = new Date(tglPinjaman.setMonth(tglPinjaman.getMonth() + tenor));
                        tglSelesaiInput.value = tglSelesai.toISOString().split('T')[0];
                    } else {
                        tglSelesaiInput.value = '';
                    }
                }
            });
        </script>
    @endpush
@endsection
