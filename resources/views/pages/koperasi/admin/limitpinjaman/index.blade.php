@extends('layouts.app')

@section('title', 'Limit Pinjaman')

@section('main')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box justify-content-between d-flex align-items-md-center flex-md-row flex-column">
                    <h4 class="page-title">Daftar Limit Pinjaman</h4>
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

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body p-3">
                        <h6 class="mb-0 text-uppercase">Limit Pinjaman DataTable</h6>
                        <hr />
                        <!-- Tombol Tambah Limit Pinjaman -->
                        <div class="mb-3">
                            <a href="{{ route('limitpinjaman.create') }}" class="btn btn-primary">
                                <i class="bx bx-plus"></i> Tambah Limit Pinjaman
                            </a>
                        </div>
                        <div class="table-responsive">
                            <table id="example2" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Limit</th>
                                        <th>Status</th>
                                        <th>User ID</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($limitPinjaman as $limit)
                                        <tr>
                                            <td>{{ $limit->limit }}</td>
                                            <td>{{ $limit->status }}</td>
                                            <td>{{ $limit->user_id }}</td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    <!-- Tombol Edit Limit Pinjaman -->
                                                    <a href="{{ route('limitpinjaman.edit', $limit->id) }}"
                                                        class="btn btn-sm btn-warning me-2">
                                                        <i class="fadeIn animated bx bx-edit"></i> Edit
                                                    </a>

                                                    <!-- Tombol Hapus Limit Pinjaman -->
                                                    <form action="{{ route('limitpinjaman.destroy', $limit->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus limit pinjaman ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">
                                                            <i class="fadeIn animated bx bx-trash"></i> Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Limit</th>
                                        <th>Status</th>
                                        <th>User ID</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
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
