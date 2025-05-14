@extends('layouts.app')

@section('title', 'Daftar Pegawai')

@section('main')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="card">
                <div class="card-body p-3">
                    <h5 class="mb-3">Daftar Pegawai</h5>
                    <a href="{{ route('pegawais.create') }}" class="btn btn-primary mb-3">Tambah Pegawai</a>
                    <div class="table-responsive">
                        <table id="example2" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Foto</th>
                                    <th>NIP</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>No Telepon</th>
                                    <th>Alamat</th>
                                    <th>Position</th>
                                    <th>Tanggal Lahir</th>
                                    <th>Pendidikan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pegawais as $pegawai)
                                    <tr>
                                        <td>
                                            <img src="{{ asset('storage/' . $pegawai->user->imageUrl) }}"
                                                 class="rounded-circle"
                                                 width="46"
                                                 height="46"
                                                 alt="Foto {{ $pegawai->user->name }}" />
                                        </td>
                                        <td>{{ $pegawai->nip }}</td>
                                        <td>{{ $pegawai->user->name }}</td>
                                        <td>{{ $pegawai->user->email }}</td>
                                        <td>{{ $pegawai->user->phone }}</td>
                                        <td>{{ $pegawai->alamat }}</td>
                                        <td>{{ $pegawai->user->position }}</td>
                                        <td>{{ $pegawai->tanggal_lahir }}</td>
                                        <td>{{ $pegawai->pendidikan }}</td>
                                        <td>
                                            <a href="{{ route('pegawais.edit', $pegawai->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                            <form action="{{ route('pegawais.destroy', $pegawai->id) }}" method="POST" class="d-inline">
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
