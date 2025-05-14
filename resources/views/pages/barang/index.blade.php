@extends('layouts.app')

@section('title', 'Barang')

@section('main')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box justify-content-between d-flex align-items-md-center flex-md-row flex-column">
                    <h4 class="page-title">Daftar Barang</h4>
                    <ol class="m-0 breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
                        <li class="breadcrumb-item active">Data Tables</li>
                    </ol>
                </div>
            </div>
        </div>
        @if (session('success'))
            <div class="border-0 alert alert-success alert-dismissible text-bg-success fade show">
                {{ session('success') }} <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                    aria-label="Close"></button></div>
        @endif

        @if (session('error'))
            <div class="border-0 alert alert-danger alert-dismissible text-bg-success fade show">
                {{ session('error') }}</div>
        @endif

        <div class="card">
            <div class="card-body">
                <a href="{{ route('barang.create') }}" class="btn btn-primary mb-3">Tambah Barang</a>
                <div class="table-responsive">
                    <table id="example2" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Kode Produk</th>
                                <th>Nama</th>
                                <th>Kategori</th>
                                <th>Pemasok</th>
                                <th>Merek</th>
                                <th>Satuan</th>
                                <th>Harga</th>
                                <th>Jml Peringatan</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($barang as $item)
                                <tr>
                                    <td>{{ $item->Kode_produk }}</td>
                                    <td>{{ $item->Nama }}</td>
                                    <td>{{ $item->kategori->nama }}</td>
                                    <td>{{ $item->pemasok->nama }}</td>
                                    <td>{{ $item->merek->nama }}</td>
                                    <td>{{ $item->units->name }}</td>
                                    <td>{{ number_format($item->Harga, 2, ',', '.') }}</td>
                                    <td>{{ $item->Jml_Peringatan }}</td>
                                    <td>
                                        @if ($item->Status == 0)
                                            Inactive
                                        @elseif($item->Status == 1)
                                            Active
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <a href='{{ route('barang.edit', $item->id) }}'
                                                class="btn btn-sm btn-info btn-icon">
                                                <i class='fadeIn animated bx bx-comment-edit'></i> Edit
                                            </a>
                                            <form action="{{ route('barang.destroy', $item->id) }}" method="POST"
                                                class="ml-2">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger btn-icon confirm-delete">
                                                    <i class="fadeIn animated bx bx-trash-alt"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Kode Produk</th>
                                <th>Nama</th>
                                <th>Kategori</th>
                                <th>Pemasok</th>
                                <th>Merek</th>
                                <th>Satuan</th>
                                <th>Harga</th>
                                <th>Jml Peringatan</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            var table = $('#example2').DataTable({
                lengthChange: true,
                buttons: ['copy', 'excel', 'pdf', 'print']
            });

            table.buttons().container()
                .appendTo('#example2_wrapper .col-md-6:eq(0)');
        });
    </script>
@endpush
