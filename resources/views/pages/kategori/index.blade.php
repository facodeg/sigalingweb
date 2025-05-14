@extends('layouts.app')

@section('title', 'Kategori')

@section('main')
    <div class="page-wrapper">
        <div class="page-content">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif


            <h6 class="mb-0 text-uppercase">DataTable Kategori</h6>
            <hr />
            <a href="{{ route('kategori.create') }}" class="btn btn-primary mb-3">Tambah Kategori</a>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example2" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Nama Kategori</th>
                                    <th>Kategori Slug</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kategori as $kategoris)
                                    <tr>
                                        <td>{{ $kategoris->nama_kategori }}</td>
                                        <td>{{ $kategoris->kategori_slug }}</td>
                                        <td>
                                            @if ($kategoris->status == 0)
                                                Inactive
                                            @elseif($kategoris->status == 1)
                                                Active
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <a href='{{ route('kategori.edit', $kategoris->id) }}'
                                                    class="btn btn-sm btn-info btn-icon">
                                                    <i class='fadeIn animated bx bx-comment-edit'></i> Edit
                                                </a>
                                                <form action="{{ route('kategori.destroy', $kategoris->id) }}"
                                                    method="POST" class="ml-2">
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
                                    <th>Nama Kategori</th>
                                    <th>Kategori Slug</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
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
