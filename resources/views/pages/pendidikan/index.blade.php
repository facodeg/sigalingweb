@extends('layouts.app')

@section('title', 'Data Pendidikan')

@section('main')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box justify-content-between d-flex align-items-md-center flex-md-row flex-column">
                    <h4 class="page-title">Daftar Riwayat Pendidikan</h4>
                    <ol class="m-0 breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Data</a></li>
                        <li class="breadcrumb-item active">Pendidikan</li>
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
                    <div class="card-body">
                        <a href="{{ route('pendidikan.create') }}" class="btn btn-primary mb-3">Tambah Data Pendidikan</a>

                        <table id="example2" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>NIP</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Jabatan</th>
                                    <th>Pendidikan</th>
                                    <th>Nama Sekolah</th>
                                    <th>Status</th>
                                    <th>Tahun</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Nama</th>
                                    <th>NIP</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Jabatan</th>
                                    <th>Pendidikan</th>
                                    <th>Nama Sekolah</th>
                                    <th>Status</th>
                                    <th>Tahun</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($pendidikan as $item)
                                    <tr>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->nip }}</td>
                                        <td>{{ $item->jk }}</td>
                                        <td>{{ $item->jabatan }}</td>
                                        <td>{{ $item->pendidikan }}</td>
                                        <td>{{ $item->nama_sekolah }}</td>
                                        <td>{{ $item->status_pg }}</td>
                                        <td>{{ $item->Tahun }}</td>
                                        <td>
                                            <a href="{{ route('pendidikan.edit', $item->id_pendidikan) }}"
                                                class="btn btn-sm btn-warning">Edit</a>
                                            <form action="{{ route('pendidikan.destroy', $item->id_pendidikan) }}"
                                                method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</button>
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
            $('#example2').DataTable({
                responsive: true,
                dom: 'Blfrtip',
                buttons: ['copy', 'excel', 'pdf', 'print'],
                lengthMenu: [
                    [5, 10, 25, 50, -1],
                    [5, 10, 25, 50, "All"]
                ],
                pageLength: 10,
                initComplete: function() {
                    this.api().columns().every(function() {
                        var column = this;
                        if (column.index() === 8) return; // Skip "Aksi" column

                        var input = document.createElement("input");
                        input.style.width = '100%';
                        $(input).appendTo($(column.footer()).empty())
                            .on('keyup change', function() {
                                if (column.search() !== this.value) {
                                    column.search(this.value).draw();
                                }
                            });
                    });
                }
            });

            // Tambahkan margin agar tombol & dropdown tidak saling berhimpit
            $('.dt-buttons').addClass('mb-3');
            $('.dataTables_length').css('margin-right', '20px');
        });
    </script>
@endpush
