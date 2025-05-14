@extends('layouts.app')

@section('title', 'Edit Barang')

@section('main')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex justify-content-between align-items-md-center flex-md-row flex-column">
                    <h4 class="page-title">Edit Barang</h4>
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

                <form action="{{ route('barang.update', $barang->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="Kode_produk" class="form-label">Kode Produk</label>
                        <input type="text" class="form-control" id="Kode_produk" name="Kode_produk"
                            value="{{ $barang->Kode_produk }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="Nama" class="form-label">Nama Barang</label>
                        <input type="text" class="form-control" id="Nama" name="Nama" value="{{ $barang->Nama }}"
                            required>
                    </div>

                    <!-- Input untuk Barcode -->
                    <!-- Misalnya jika ingin menambahkan barcode, tambahkan input di sini -->
                    <!-- <div class="mb-3">
                                    <label for="Barcode" class="form-label">Barcode</label>
                                    <input type="text" class="form-control" id="Barcode" name="Barcode" value="{{ $barang->Barcode }}">
                                </div> -->

                    <div class="mb-3">
                        <label for="id_kategori" class="form-label">Kategori</label>
                        <select class="form-control" id="id_kategori" name="id_kategori" required>
                            @foreach ($kategori as $kat)
                                <option value="{{ $kat->id }}"
                                    {{ $kat->id == $barang->id_kategori ? 'selected' : '' }}>
                                    {{ $kat->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="id_pemasok" class="form-label">Pemasok</label>
                        <select class="form-control" id="id_pemasok" name="id_pemasok" required>
                            @foreach ($pemasok as $sup)
                                <option value="{{ $sup->id }}"
                                    {{ $sup->id == $barang->id_pemasok ? 'selected' : '' }}>
                                    {{ $sup->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="id_merek" class="form-label">Merek</label>
                        <select class="form-control" id="id_merek" name="id_merek" required>
                            @foreach ($merek as $brand)
                                <option value="{{ $brand->id }}"
                                    {{ $brand->id == $barang->id_merek ? 'selected' : '' }}>
                                    {{ $brand->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="id_units" class="form-label">Satuan</label>
                        <select class="form-control" id="id_units" name="id_units" required>
                            @foreach ($satuan as $unit)
                                <option value="{{ $unit->id }}"
                                    {{ $unit->id == $barang->id_satuan ? 'selected' : '' }}>
                                    {{ $unit->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="Harga" class="form-label">Harga</label>
                        <input type="number" class="form-control" id="Harga" name="Harga"
                            value="{{ $barang->Harga }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="Jml_Peringatan" class="form-label">Jumlah Peringatan</label>
                        <input type="number" class="form-control" id="Jml_Peringatan" name="Jml_Peringatan"
                            value="{{ $barang->Jml_Peringatan }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="Deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="Deskripsi" name="Deskripsi" rows="3">{{ $barang->Deskripsi }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="Status" class="form-label">Status</label>
                        <select class="form-control" id="Status" name="Status" required>
                            <option value="1" {{ $barang->Status == 1 ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ $barang->Status == 0 ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="Gambar" class="form-label">Gambar</label>
                        <input type="file" class="form-control" id="Gambar" name="Gambar" accept="image/*">
                        @if ($barang->Gambar)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $barang->Gambar) }}" alt="Gambar Barang"
                                    style="width: 100px; height: auto;">
                            </div>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>

@endsection
