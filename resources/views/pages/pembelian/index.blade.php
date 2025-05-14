@extends('layouts.app')

@section('title', 'Daftar Pembelian')

@section('main')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex justify-content-between align-items-md-center flex-md-row flex-column">
                    <h4 class="page-title">Tambah Pembelian</h4>
                    <ol class="m-0 breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Tambah</a></li>
                        <li class="breadcrumb-item active">Data Pembelian</li>
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
                <a href="{{ route('pembelian.create') }}" class="btn btn-primary mb-3">Tambah Pembelian</a>
                <div class="table-responsive">
                    <table id="pembelian-table" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Kode Pembelian</th>
                                <th>Tanggal Pembelian</th>
                                <th>Pemasok</th>
                                <th>User</th>
                                <th>Barang</th>
                                <th>Jumlah Barang</th>
                                <th>Harga Barang</th>
                                <th>Harga Jual</th>
                                <th>Total Harga</th>
                                <th>Pajak</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <!-- Include DataTables JavaScript library -->
        <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>

        <!-- Initialize DataTable -->
        <script>
            $(document).ready(function() {
                $('#pembelian-table').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": "{{ route('pembelian.index') }}",
                    "columns": [{
                            "data": "kode_pembelian"
                        },
                        {
                            "data": "tanggal_pembelian"
                        },
                        {
                            "data": "pemasok.nama"
                        },
                        {
                            "data": "user.name"
                        },
                        {
                            "data": "barang",
                            "orderable": false,
                            "searchable": false
                        },
                        {
                            "data": "jumlah_barang",
                            "orderable": false,
                            "searchable": false
                        },
                        {
                            "data": "harga_barang",
                            "orderable": false,
                            "searchable": false
                        },
                        {
                            "data": "harga_jual",
                            "orderable": false,
                            "searchable": false
                        },

                        {
                            "data": "total_harga"
                        },
                        {
                            "data": "pajak"
                        },
                        {
                            "data": "status"
                        },
                        {
                            "data": "action",
                            "orderable": false,
                            "searchable": false
                        }
                    ]
                });
            });
        </script>
    @endpush
@endsection
