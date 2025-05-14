@extends('layouts.app')

@section('title', 'Tambah Barang')

@section('main')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex justify-content-between align-items-md-center flex-md-row flex-column">
                    <h4 class="page-title">Tambah Barang</h4>
                    <ol class="m-0 breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Tambah</a></li>
                        <li class="breadcrumb-item active">Data Barang</li>
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

                <form action="{{ route('barang.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="Kode_produk" class="form-label">Kode Produk</label>
                        <input type="text" class="form-control" id="Kode_produk" name="Kode_produk"
                            value="{{ $newCode }}">
                    </div>



                    <div class="mb-3">
                        <label for="Nama" class="form-label">Nama Barang</label>
                        <input type="text" class="form-control" id="Nama" name="Nama" required>
                    </div>

                    <!-- Input untuk Barcode -->


                    <div class="mb-3">
                        <label for="id_kategori" class="form-label">Kategori</label>
                        <select class="form-control" id="id_kategori" name="id_kategori" required>
                            @foreach ($kategori as $kat)
                                <option value="{{ $kat->id }}">{{ $kat->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="id_pemasok" class="form-label">Pemasok</label>
                        <select class="form-control" id="id_pemasok" name="id_pemasok" required>
                            @foreach ($pemasok as $sup)
                                <option value="{{ $sup->id }}">{{ $sup->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="id_merek" class="form-label">Merek</label>
                        <select class="form-control" id="id_merek" name="id_merek" required>
                            @foreach ($merek as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="id_units" class="form-label">Satuan</label>
                        <select class="form-control" id="id_units" name="id_units" required>
                            @foreach ($satuan as $unit)
                                <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="Harga" class="form-label">Harga</label>
                        <input type="number" class="form-control" id="Harga" name="Harga" required>
                    </div>

                    <div class="mb-3">
                        <label for="Jml_Peringatan" class="form-label">Jumlah Peringatan</label>
                        <input type="number" class="form-control" id="Jml_Peringatan" name="Jml_Peringatan" required>
                    </div>

                    <div class="mb-3">
                        <label for="Deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="Deskripsi" name="Deskripsi" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="Status" class="form-label">Status</label>
                        <select class="form-control" id="Status" name="Status" required>
                            <option value="1">Aktif</option>
                            <option value="0">Tidak Aktif</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="Gambar" class="form-label">Gambar</label>
                        <input type="file" class="form-control" id="Gambar" name="Gambar" accept="image/*">
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>

@endsection
