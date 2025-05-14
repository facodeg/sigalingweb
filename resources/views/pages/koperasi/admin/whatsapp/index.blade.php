@extends('layouts.app')

@section('title', 'WhatsApp Contacts')

@section('main')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box justify-content-between d-flex align-items-md-center flex-md-row flex-column">
                    <h4 class="page-title">WhatsApp Contacts</h4>
                    <ol class="m-0 breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
                        <li class="breadcrumb-item active">WhatsApp Table</li>
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
                    <div class="p-3 card-body">
                        <div class="col">
                            <a href="{{ route('whatsapp.create') }}" class="px-3 btn btn-primary">Tambah</a>
                        </div>
                    </div>
                </div>

                <h6 class="mb-0 text-uppercase">WhatsApp Contacts Table</h6>
                <hr />
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example2" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Position</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($whatsapps as $whatsapp)
                                        <tr>
                                            <td>{{ $whatsapp->name }}</td>
                                            <td>{{ $whatsapp->phone }}</td>
                                            <td>{{ $whatsapp->position }}</td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    <a href="{{ route('whatsapp.edit', $whatsapp->id) }}"
                                                        class="mx-2 btn btn-sm btn-info btn-icon">
                                                        <i class="fadeIn animated bx bx-comment-edit"></i>
                                                        Edit
                                                    </a>

                                                    <form action="{{ route('whatsapp.destroy', $whatsapp->id) }}"
                                                        method="POST" class="ml-2">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="mx-2 btn btn-sm btn-danger btn-icon confirm-delete">
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
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Position</th>
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
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
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
