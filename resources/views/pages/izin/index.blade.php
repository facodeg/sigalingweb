@extends('layouts.app')

@section('title', 'attendance')

@section('main')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="card">
                <div class="card-body p-3">
                    <!--breadcrumb-->
                    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                        <div class="breadcrumb-title pe-3 mb-3">Tables</div>
                        <div class="ps-3">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0 p-0">
                                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Data Table</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <h6 class="mb-0 text-uppercase">DataTable Import</h6>
            <hr />
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example2" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Date Izin</th>
                                    <th>Reason</th>
                                    <th>Image</th>
                                    <th>Is Approved</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($izin as $izins)
                                    <tr>
                                        <td>{{ $izins->user->name }}</td>
                                        <td>{{ $izins->date_izin }}</td>
                                        <td>{{ $izins->reason }}</td>
                                        <td>
                                            @if($izins->image)
                                                <img src="{{ asset('storage/izin/' . $izins->image) }}" alt="Image" style="max-width: 150px; max-height: 100px;">
                                            @else
                                                No Image
                                            @endif
                                        </td>
                                        <td>
                                            @if ($izins->is_approved == 0)
                                                Not Approved
                                            @elseif($izins->is_approved == 1)
                                                Approved
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <a href='{{ route('izins.edit', $izins->id) }}'
                                                    class="btn btn-sm btn-info btn-icon">
                                                    <i class='fadeIn animated bx bx-comment-edit'></i> Tindakan
                                                </a>
                                                <form action="{{ route('izins.destroy', $izins->id) }}" method="POST"
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
                                    <th>User ID</th>
                                    <th>Date Izin</th>
                                    <th>Reason</th>
                                    <th>Image</th>
                                    <th>Is Approved</th>
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
