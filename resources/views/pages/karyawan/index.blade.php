@extends('layouts.app')

@section('title', 'Data Karyawan')

@section('main')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box justify-content-between d-flex align-items-md-center flex-md-row flex-column">
                    <h4 class="page-title">Daftar Data Karyawan</h4>
                    <ol class="m-0 breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Data</a></li>
                        <li class="breadcrumb-item active">Karyawan</li>
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
                        <a href="{{ route('karyawan.create') }}" class="btn btn-primary mb-3">Tambah Data Karyawan</a>

                        <table id="example2" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama</th>
                                    <th>NIP/NIPPPK</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Status Kepegawaian</th>
                                    <th>Pendidikan</th>
                                    <th>Jabatan Terakhir</th>
                                    <th>Golongan</th>
                                    <th>TMT Jabatan</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama</th>
                                    <th>NIP/NIPPPK</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Status Kepegawaian</th>
                                    <th>Pendidikan</th>
                                    <th>Jabatan Terakhir</th>
                                    <th>Golongan</th>
                                    <th>TMT Jabatan</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($karyawans as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>

                                            <div class="d-flex align-items-center">
                                                <a href="{{ route('karyawan.rincian', $item->id) }}" class="text-blue"
                                                    style="text-decoration: none;">
                                                    @if (empty($item->upload_foto_diri))
                                                        @php
                                                            // Penentuan avatar default berdasarkan jenis kelamin
                                                            $avatarIndex = ($loop->iteration % 4) + 1; // 1 - 5
                                                            $avatarFile =
                                                                $item->jk == 'L'
                                                                    ? "avatar-{$avatarIndex}.jpg" // avatar-1 sampai avatar-5
                                                                    : 'avatar-' . ($avatarIndex + 4) . '.jpg'; // avatar-6 sampai avatar-10
                                                        @endphp
                                                        <img src="{{ asset('assets/images/users/' . $avatarFile) }}"
                                                            alt="user-image" width="42" class="rounded-circle me-2">
                                                    @else
                                                        <img src="{{ asset('storage/' . $item->upload_foto_diri) }}"
                                                            class="shadow rounded-circle me-2" height="42"
                                                            alt="User Avatar">
                                                    @endif
                                                </a>
                                                <span>{{ $item->nama }}</span>
                                            </div>

                                        </td>


                                        <td>{{ $item->nip_nrp_nipppk_nipb }}</td>
                                        <td>{{ $item->jk == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                        <td>{{ $item->status_kepegawaian }}</td>
                                        <td>{{ $item->pendidikan_terakhir }}</td>
                                        <td>{{ $item->jabatan_terakhir }}</td>
                                        <td>{{ $item->gol }}</td>
                                        <td>{{ $item->tmt_jabatan }}</td>
                                        <td>{{ $item->status }}</td>
                                        <td>
                                            <a href="{{ route('karyawan.edit', $item->id) }}"
                                                class="btn btn-sm btn-warning">Edit</a>
                                            <form action="{{ route('karyawan.destroy', $item->id) }}" method="POST"
                                                style="display:inline-block;">
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
                order: [
                    [0, 'asc'] // Urutkan kolom pertama (ID) secara naik
                ],
                pageLength: 10,
                initComplete: function() {
                    this.api().columns().every(function() {
                        var column = this;
                        if (column.index() === 9) return; // Skip "Aksi" column

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

            $('.dt-buttons').addClass('mb-3');
            $('.dataTables_length').css('margin-right', '20px');
        });
    </script>
@endpush
