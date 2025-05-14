@extends('layouts.app')

@section('title', 'Daftar Angsuran')

@section('main')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box justify-content-between d-flex align-items-md-center flex-md-row flex-column">
                    <h4 class="page-title">Daftar Angsuran</h4>
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
            <div class="p-3 card-body">

                <a href="{{ route('angsuran.create') }}" class="mb-3 btn btn-primary">Tambah Angsuran</a>
                <div class="table-responsive">
                    <table id="example2" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No Angsuran</th>
                                <th>No Pinjaman</th>
                                <th>Nama Anggota</th>
                                <th>Tanggal Angsuran</th>
                                <th>Nominal</th>
                                <th>Angsuran</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($angsurans as $angsuran)
                                <tr>
                                    <td>{{ $angsuran->no_angsuran }}</td>
                                    <td>{{ $angsuran->no_pinjaman }}</td>
                                    <td>{{ $angsuran->pinjaman->anggota->nama }}</td> <!-- Menampilkan Nama Anggota -->
                                    <td>{{ \Carbon\Carbon::parse($angsuran->tgl_angsuran)->format('d-m-Y') }}</td>
                                    <td>Rp {{ number_format($angsuran->nominal, 0, ',', '.') }}</td>
                                    <td>{{ $angsuran->angsuranke }}</td>
                                    <td>{{ $angsuran->status }}</td>
                                    <td>
                                        <a href="{{ route('angsuran.edit', $angsuran->id) }}"
                                            class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('angsuran.destroy', $angsuran->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
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
