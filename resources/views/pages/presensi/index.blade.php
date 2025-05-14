@extends('layouts.app')

@section('title', 'Attendance')

@section('main')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="card">
                <div class="card-body p-3">
                    <!--breadcrumb-->
                    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                        <div class="breadcrumb-title pe-3 mb-3">Attendance</div>
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
                    <div class="col">
                        <a href="{{ route('attendances.create') }}" class="btn btn-primary px-3 ml-3">Tambah Attendance</a>
                    </div>
                </div>
            </div>

            <h6 class="mb-0 text-uppercase">Data Attendance</h6>
            <hr />
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example2" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Time In</th>
                                    <th>Time In Status</th>
                                    <th>Time Out</th>
                                    <th>Time Out Status</th>
                                    <th>Date</th>

                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($attendance as $item)
                                    <tr>
                                        <td>{{ $item->user->name }}</td>
                                        <td>{{ $item->time_in }}</td>
                                        <td class="{{ Carbon\Carbon::parse($item->time_in)->gt(Carbon\Carbon::parse($company->time_in)) ? 'bg-danger text-white' : 'bg-success text-white' }}">
                                            <span class=" {{ Carbon\Carbon::parse($item->time_in)->gt(Carbon\Carbon::parse($company->time_in)) ? 'bg-danger' : 'bg-success' }}">
                                                {{ Carbon\Carbon::parse($item->time_in)->gt(Carbon\Carbon::parse($company->time_in)) ? 'Terlambat' : 'Sesuai' }}
                                            </span>
                                        </td>
                                        <td>{{ $item->time_out }}</td>
                                        <td class="{{ Carbon\Carbon::parse($item->time_out)->lt(Carbon\Carbon::parse($company->time_out)) ? 'bg-warning text-dark' : 'bg-success text-white' }}">
                                            <span class=" {{ Carbon\Carbon::parse($item->time_out)->lt(Carbon\Carbon::parse($company->time_out)) ? 'bg-warning text-dark' : 'bg-success' }}">
                                                {{ Carbon\Carbon::parse($item->time_out)->lt(Carbon\Carbon::parse($company->time_out)) ? 'Pulang Cepat' : 'Sesuai' }}
                                            </span>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($item->date)->format('d-m-Y') }}</td>

                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <a href="{{ route('attendances.edit', $item->id) }}"
                                                    class="btn btn-sm btn-info btn-icon">
                                                    <i class='fadeIn animated bx bx-comment-edit'></i> Edit
                                                </a>
                                                <form action="{{ route('attendances.destroy', $item->id) }}" method="POST"
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
                                    <th>Nama</th>
                                    <th>Time In</th>
                                    <th>Time In Status</th>
                                    <th>Time Out</th>
                                    <th>Time Out Status</th>
                                    <th>Date</th>

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
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#example2').DataTable({
                lengthChange: true,
                buttons: ['copy', 'excel', 'pdf', 'print']
            });
        });
    </script>
@endpush
