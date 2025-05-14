@extends('layouts.app')

@section('title', 'Tambah Angsuran')

@section('main')

    <div class="container-fluid">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Tambah Angsuran</h5>
                <form action="{{ route('angsuran.store') }}" method="POST" id="angsuran-form">
                    @csrf
                    <div class="mb-3">
                        <label for="no_angsuran" class="form-label">No Angsuran</label>
                        <input type="text" class="form-control" id="no_angsuran" name="no_angsuran"
                            value="{{ $no_angsuran }}" readonly required>
                    </div>

                    <div class="mb-3">
                        <label for="no_pinjaman" class="form-label">No Pinjaman</label>
                        <select name="no_pinjaman" id="no_pinjaman" class="form-select" required>
                            <option value="">Pilih No Pinjaman</option>
                            @foreach ($pinjamans as $pinjaman)
                                <option value="{{ $pinjaman->no_pinjaman }}"
                                    data-nama-anggota="{{ $pinjaman->anggota->nama }}"
                                    data-unit-kerja="{{ $pinjaman->anggota->unit_kerja }}"
                                    data-nominal="{{ $pinjaman->bayar_perbulan }}"
                                    data-tgl-selesai="{{ $pinjaman->tgl_selesai }}" data-tenor="{{ $pinjaman->tenor }}"
                                    data-nominal-pinjaman="{{ $pinjaman->nominal }}">{{ $pinjaman->no_pinjaman }} -
                                    {{ $pinjaman->anggota->nama }} ({{ $pinjaman->anggota->unit_kerja }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="unit_bagian" class="form-label">Unit Bagian</label>
                        <input type="text" class="form-control" id="unit_bagian" name="unit_bagian" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="tgl_angsuran" class="form-label">Tanggal Angsuran</label>
                        <input type="date" class="form-control" id="tgl_angsuran" name="tgl_angsuran"
                            value="{{ old('tgl_angsuran') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="tgl_selesai" class="form-label">Tanggal Selesai</label>
                        <input type="text" class="form-control" id="tgl_selesai" name="tgl_selesai" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="nominal" class="form-label">Nominal Cicilan</label>
                        <input type="text" class="form-control" id="nominal" name="nominal"
                            value="{{ old('nominal') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="nominal_pinjaman" class="form-label">Nominal Pinjaman</label>
                        <input type="text" class="form-control" id="nominal_pinjaman" name="nominal_pinjaman" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="sisa_pinjaman" class="form-label">Sisa Pinjaman</label>
                        <input type="text" class="form-control" id="sisa_pinjaman" name="sisa_pinjaman"
                            value="{{ isset($initialSisaPinjaman[$pinjaman->no_pinjaman]) ? 'Rp. ' . number_format($initialSisaPinjaman[$pinjaman->no_pinjaman], 0, ',', '.') : 'Rp. 0' }}"
                            readonly>
                    </div>

                    <div class="mb-3">
                        <label for="tenor" class="form-label">Tenor</label>
                        <input type="text" class="form-control" id="tenor" name="tenor" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="angsuran_ke" class="form-label">Angsuran Ke</label>
                        <input type="text" class="form-control" id="angsuran_ke" name="angsuranke" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="status1" class="form-label">Status</label>
                        <input type="text" class="form-control" id="status1" name="status" readonly>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('angsuran.index') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>


    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const nominalInput = document.getElementById('nominal');
                const angsurankeInput = document.getElementById('angsuran_ke'); // Pastikan ID ini benar
                const noPinjamanSelect = document.getElementById('no_pinjaman');
                const namaInput = document.getElementById('nama');
                const unitBagianInput = document.getElementById('unit_bagian');
                const tglSelesaiInput = document.getElementById('tgl_selesai');
                const tenorInput = document.getElementById('tenor');
                const nominalPinjamanInput = document.getElementById('nominal_pinjaman');
                const sisaPinjamanInput = document.getElementById('sisa_pinjaman');
                const statusInput = document.getElementById('status1');

                nominalInput.addEventListener('input', function() {
                    let value = nominalInput.value.replace(/[^0-9]/g, '');
                    nominalInput.value = formatRupiah(value, 'Rp. ');
                    updateSisaPinjaman();
                });

                nominalInput.addEventListener('blur', function() {
                    let value = nominalInput.value.replace(/[^0-9]/g, '');
                    nominalInput.value = formatRupiah(value, 'Rp. ');
                    updateSisaPinjaman();
                });

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

                function updateSisaPinjaman() {
                    const nominalPinjamanValue = parseInt(nominalPinjamanInput.value.replace(/[^0-9]/g, '')) || 0;
                    const nominalAngsuranValue = parseInt(nominalInput.value.replace(/[^0-9]/g, '')) || 0;
                    let sisaPinjamanValue = nominalPinjamanValue - nominalAngsuranValue;

                    // Cek jika ada sisa pinjaman yang sudah ada
                    const currentSisaPinjaman = parseInt(sisaPinjamanInput.getAttribute('data-sisa-pinjaman')) || null;

                    if (currentSisaPinjaman !== null) {
                        sisaPinjamanValue = currentSisaPinjaman - nominalAngsuranValue;
                    }

                    sisaPinjamanInput.value = formatRupiah(sisaPinjamanValue.toString(), 'Rp. ');

                    if (sisaPinjamanValue <= 0) {
                        statusInput.value = 'lunas';
                    } else {
                        statusInput.value = 'belum';
                    }
                }

                function updateAngsuranKe(noPinjamanValue) {
                    fetch(`/angsuran/ke/${noPinjamanValue}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.angsuran_ke !== undefined) {
                                angsurankeInput.value = data.angsuran_ke;
                            } else {
                                angsurankeInput.value = ''; // Clear value if no data
                            }
                        })
                        .catch(error => console.error('Error:', error));
                }

                noPinjamanSelect.addEventListener('change', function() {
                    const selectedOption = noPinjamanSelect.options[noPinjamanSelect.selectedIndex];
                    const namaAnggota = selectedOption.getAttribute('data-nama-anggota');
                    const unitKerja = selectedOption.getAttribute('data-unit-kerja');
                    const nominal = selectedOption.getAttribute('data-nominal');
                    const tglSelesai = selectedOption.getAttribute('data-tgl-selesai');
                    const tenor = selectedOption.getAttribute('data-tenor');
                    const nominalPinjaman = selectedOption.getAttribute('data-nominal-pinjaman');

                    namaInput.value = namaAnggota;
                    unitBagianInput.value = unitKerja;
                    tglSelesaiInput.value = tglSelesai;
                    tenorInput.value = tenor;
                    nominalPinjamanInput.value = formatRupiah(nominalPinjaman, 'Rp. ');

                    nominalInput.value = formatRupiah(nominal, 'Rp. ');

                    // Fetch sisa pinjaman from the server
                    const noPinjamanValue = noPinjamanSelect.value;

                    fetch(`/angsuran/angsuran-sisa/${noPinjamanValue}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.sisa_pinjaman !== undefined) {
                                sisaPinjamanInput.setAttribute('data-sisa-pinjaman', data.sisa_pinjaman);
                                updateSisaPinjaman(); // Update sisa pinjaman berdasarkan data yang diterima
                            }
                        })
                        .catch(error => console.error('Error:', error));

                    // Fetch angsuran ke from the server
                    updateAngsuranKe(noPinjamanValue);
                });
            });
        </script>
    @endpush
@endsection
