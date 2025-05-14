@extends('layouts.app')

@section('title', 'Tambah Pembelian')

@section('main')
    <!-- Start Content-->
    <div class="container-fluid">
        <!-- Start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box justify-content-between d-flex align-items-md-center flex-md-row flex-column">
                    <h4 class="page-title">Pembelian</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Jidox</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Pages</a></li>
                        <li class="breadcrumb-item active">Pembelian</li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- End page title -->

        <!-- Card untuk informasi pembelian -->
        <form id="pembelianForm" action="{{ route('pembelian.store') }}" method="POST">
            @csrf
            <div class="row">
                <!-- Card Informasi Pembelian -->
                <div class="col-lg-12">
                    <div class="card mb-3">
                        <div class="card-header bg-primary text-white">
                            <h5>Informasi Pembelian</h5>
                        </div>
                        <div class="card-body">

                            <div class="row">
                                <!-- Kode Pembelian -->
                                <div class="col-md-4 mb-3">
                                    <label for="kode_pembelian" class="form-label">Kode Pembelian</label>
                                    <input type="text" class="form-control @error('kode_pembelian') is-invalid @enderror"
                                        id="kode_pembelian" name="kode_pembelian"
                                        value="{{ old('kode_pembelian', $kodePembelian) }}" required>
                                    @error('kode_pembelian')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Tanggal Pembelian -->
                                <div class="col-md-4 mb-3">
                                    <label for="tanggal_pembelian" class="form-label">Tanggal Pembelian</label>
                                    <input type="date"
                                        class="form-control @error('tanggal_pembelian') is-invalid @enderror"
                                        id="tanggal_pembelian" name="tanggal_pembelian"
                                        value="{{ old('tanggal_pembelian') }}" required>
                                    @error('tanggal_pembelian')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Pemasok -->
                                <div class="col-md-4 mb-3">
                                    <label for="id_pemasok" class="form-label">Pemasok</label>
                                    <select class="form-control @error('id_pemasok') is-invalid @enderror" id="id_pemasok"
                                        name="id_pemasok" required>
                                        <option value="">Pilih Pemasok</option>
                                        @foreach ($pemasok as $item)
                                            <option value="{{ $item->id }}"
                                                {{ old('id_pemasok') == $item->id ? 'selected' : '' }}>{{ $item->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_pemasok')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Card Detail Barang -->
                <div class="col-lg-12">
                    <div class="card mb-3">
                        <div class="card-header bg-info text-white">
                            <h5>Detail Barang</h5>
                        </div>
                        <div class="card-body">
                            <form id="barangForm">
                                @csrf
                                <div class="row">
                                    <!-- Barang -->
                                    <div class="col-md-3 mb-3">
                                        <label for="id_barang" class="form-label">Barang</label>
                                        <select class="form-control" id="id_barang" name="id_barang">
                                            <option value="">Pilih Barang</option>
                                            @foreach ($barang as $item)
                                                <option value="{{ $item->id }}" data-harga="{{ $item->Harga }}">
                                                    {{ $item->Nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Jumlah Barang -->
                                    <div class="col-md-2 mb-3">
                                        <label for="jumlah_barang" class="form-label">Jumlah Barang</label>
                                        <input type="number" class="form-control" id="jumlah_barang" name="jumlah_barang">
                                    </div>


                                    <!-- Harga Barang -->
                                    <div class="col-md-2 mb-3">
                                        <label for="harga_barang" class="form-label">Harga Barang</label>
                                        <input type="number" class="form-control" id="harga_barang" name="harga_barang">
                                    </div>
                                    <script>
                                        // Event listener untuk mengupdate harga barang saat barang dipilih
                                        document.getElementById('id_barang').addEventListener('change', function() {
                                            const selectedOption = this.options[this.selectedIndex];
                                            const hargaBarangInput = document.getElementById('harga_barang');

                                            // Ambil harga dari atribut data-harga
                                            const hargaBarang = selectedOption.getAttribute('data-harga');

                                            // Update input harga barang dengan harga yang diambil
                                            hargaBarangInput.value = hargaBarang ? parseFloat(hargaBarang).toFixed(2) : '';
                                        });
                                    </script>


                                    <!-- Harga Jual -->
                                    <div class="col-md-2 mb-3">
                                        <label for="harga_jual" class="form-label">Harga Jual</label>
                                        <input type="number" class="form-control" id="harga_jual" name="harga_jual">
                                    </div>

                                    <!-- Tombol Tambah -->
                                    <div class="col-md-2 mb-3 d-flex align-items-end">
                                        <button type="button" class="btn btn-success" id="tambahBarang">Tambah
                                            Barang</button>
                                    </div>
                                </div>
                            </form>

                            <!-- Tabel Barang yang Ditambahkan -->
                            <table class="table table-bordered mt-3" id="barangTable">
                                <thead>
                                    <tr>
                                        <th>Barang</th>
                                        <th>Jumlah</th>
                                        <th>Harga Barang</th>
                                        <th>Harga Jual</th>
                                        <th>Subtotal</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data Barang akan ditambahkan disini -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Card Total Pembelian dan Tombol -->
                <div class="col-lg-12">
                    <div class="card mb-3">
                        <div class="card-header bg-success text-white">
                            <h5>Total Pembelian</h5>
                        </div>
                        <div class="card-body">
                            <!-- Pajak -->
                            <div class="mb-3">
                                <label for="pajak" class="form-label">Pajak</label>
                                <input type="number" step="0.01" class="form-control" id="pajak" name="pajak"
                                    required>
                            </div>

                            <!-- Total Pembelian -->
                            <div class="mb-3">
                                <label for="total_pembelian" class="form-label">Total Pembelian</label>
                                <input type="number" step="0.01" class="form-control" id="total_pembelian"
                                    name="total_pembelian" readonly>
                            </div>

                            <!-- Tombol Submit -->
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary" id="simpanPembelian">Simpan
                                    Pembelian</button>
                                <a href="{{ route('pembelian.index') }}" class="btn btn-secondary">Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!-- End row -->
    </div>
    <!-- End container -->

    @push('scripts')
        <!-- Custom Script -->

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const barangTableBody = document.querySelector("#barangTable tbody");
                const totalPembelianInput = document.getElementById('total_pembelian');
                const pembelianForm = document.getElementById('pembelianForm');
                let totalPembelian = 0;
                let barangCounter = 0; // Counter untuk menandai item barang yang ditambahkan

                // Fungsi untuk menghitung subtotal
                function hitungSubtotal(harga, jumlah) {
                    return parseFloat(harga) * parseFloat(jumlah);
                }

                // Event ketika tombol "Tambah Barang" diklik
                document.getElementById('tambahBarang').addEventListener('click', function() {
                    // Ambil nilai input dari form barang
                    const barangSelect = document.getElementById('id_barang');
                    const barangId = barangSelect.value;
                    const barang = barangSelect.options[barangSelect.selectedIndex].text;
                    const jumlah = parseFloat(document.getElementById('jumlah_barang').value);
                    const hargaBarang = parseFloat(document.getElementById('harga_barang').value);
                    const hargaJual = parseFloat(document.getElementById('harga_jual').value);
                    const subtotal = hitungSubtotal(hargaBarang, jumlah);

                    // Tambahkan data ke tabel
                    if (barangId && jumlah && hargaBarang && hargaJual) {
                        const row = barangTableBody.insertRow();

                        row.innerHTML = `
                <td>${barang}</td>
                <td>${jumlah}</td>
                <td>${hargaBarang.toFixed(2)}</td>
                <td>${hargaJual.toFixed(2)}</td>
                <td>${subtotal.toFixed(2)}</td>
                <td><button class="btn btn-danger btn-sm hapus-barang">Hapus</button></td>
            `;

                        // Tambahkan input tersembunyi ke form untuk setiap barang
                        const hiddenInputs = `
                <input type="hidden" name="barang[${barangCounter}][id_barang]" value="${barangId}">
                <input type="hidden" name="barang[${barangCounter}][jumlah_barang]" value="${jumlah}">
                <input type="hidden" name="barang[${barangCounter}][harga_barang]" value="${hargaBarang}">
                <input type="hidden" name="barang[${barangCounter}][harga_jual]" value="${hargaJual}">
            `;
                        pembelianForm.insertAdjacentHTML('beforeend', hiddenInputs);
                        barangCounter++;

                        // Update total pembelian
                        totalPembelian += subtotal;
                        totalPembelianInput.value = totalPembelian.toFixed(2);

                        // Kosongkan input
                        barangSelect.selectedIndex = 0;
                        document.getElementById('jumlah_barang').value = '';
                        document.getElementById('harga_barang').value = '';
                        document.getElementById('harga_jual').value = '';
                    } else {
                        alert('Silakan lengkapi semua data barang.');
                    }
                });

                // Event delegasi untuk menghapus barang dari tabel
                barangTableBody.addEventListener('click', function(event) {
                    if (event.target.classList.contains('hapus-barang')) {
                        const row = event.target.closest('tr');
                        const subtotal = parseFloat(row.cells[4].innerText);
                        totalPembelian -= subtotal;
                        totalPembelianInput.value = totalPembelian.toFixed(2);
                        row.remove();
                    }
                });
            });
        </script>
    @endpush
@endsection
