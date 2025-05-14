@extends('layouts.app')

@section('title', 'Tambah Kategori')

@section('main')
    <div class="row">

        <div class="col-12">
            <div class="page-title-box justify-content-between d-flex align-items-md-center flex-md-row flex-column">
                <h4 class="page-title">Daftar Kategori</h4>
                <ol class="m-0 breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
                    <li class="breadcrumb-item active">Data Tables</li>
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

            <form action="{{ route('kategori.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="nama_kategori" class="form-label">Nama Kategori</label>
                    <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" required>
                </div>



                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-control" id="status1" class="form-control select2" data-toggle="select2"
                        name="status" required>
                        <option value="1">Aktif</option>
                        <option value="0">Tidak Aktif</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
    </div>

    @push('scripts')
        <!-- Select2 Plugin Js -->
        <script src="{{ asset('assets/vendor/select2/js/select2.min.js') }}"></script>

        <!-- Input Mask Plugin js -->
        <script src="{{ asset('assets/vendor/jquery-mask-plugin/jquery.mask.min.js') }}"></script>

        <!-- Bootstrap Touchspin Plugin js -->
    @endpush
@endsection
