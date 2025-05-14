<!-- resources/views/pemasok/index.blade.php -->

@extends('layouts.app')

@section('title', 'Daftar Pemasok')

@section('main')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box justify-content-between d-flex align-items-md-center flex-md-row flex-column">
                    <h4 class="page-title">Daftar Unit</h4>
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
            <div class="card-body p-3">
                <h5 class="mb-3">Daftar Pemasok</h5>

                <!-- Tombol untuk membuka modal tambah pemasok -->
                <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addPemasokModal">Tambah
                    Pemasok</button>

                <div class="table-responsive">
                    <table id="example2" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Nama Pemasok</th>
                                <th>Slug</th>
                                <th>Email</th>
                                <th>No HP</th>
                                <th>Alamat</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pemasoks as $pemasok)
                                <tr>
                                    <td>{{ $pemasok->nama }}</td>
                                    <td>{{ $pemasok->slug_pemasok }}</td>
                                    <td>{{ $pemasok->email }}</td>
                                    <td>{{ $pemasok->nohp }}</td>
                                    <td>{{ $pemasok->alamat }}</td>
                                    <td>{{ $pemasok->status == '1' ? 'Aktif' : 'Non-Aktif' }}</td>
                                    <td>
                                        <button class="btn btn-warning btn-sm mb-1 btn-edit"
                                            data-id="{{ $pemasok->id }}">Edit</button>
                                        <form action="{{ route('pemasok.destroy', $pemasok->id) }}" method="POST"
                                            class="d-inline" onsubmit="return confirmDelete(event)">
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


    <!-- Modal untuk menambah pemasok -->
    <div class="modal fade" id="addPemasokModal" tabindex="-1" aria-labelledby="addPemasokModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPemasokModalLabel">Tambah Pemasok Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addPemasokForm">
                        @csrf

                        <!-- Nama Pemasok -->
                        <div class="form-group mb-3">
                            <label for="nama">Nama Pemasok</label>
                            <input type="text" name="nama" id="nama" class="form-control" required>
                        </div>

                        <!-- Slug Pemasok -->
                        <div class="form-group mb-3">
                            <label for="slug_pemasok">Slug</label>
                            <input type="text" name="slug_pemasok" id="slug_pemasok" class="form-control" required
                                readonly>
                        </div>

                        <!-- Email Pemasok -->
                        <div class="form-group mb-3">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>

                        <!-- No HP Pemasok -->
                        <div class="form-group mb-3">
                            <label for="nohp">No HP</label>
                            <input type="text" name="nohp" id="nohp" class="form-control" required>
                        </div>

                        <!-- Alamat Pemasok -->
                        <div class="form-group mb-3">
                            <label for="alamat">Alamat</label>
                            <textarea name="alamat" id="alamat" class="form-control" rows="4"></textarea>
                        </div>

                        <!-- Status Pemasok -->
                        <div class="form-group mb-3">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="1">Aktif</option>
                                <option value="0">Non-Aktif</option>
                            </select>
                        </div>

                        <!-- Tombol Submit -->
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk mengedit pemasok -->
    <div class="modal fade" id="editPemasokModal" tabindex="-1" aria-labelledby="editPemasokModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPemasokModalLabel">Edit Pemasok</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editPemasokForm">
                        @csrf
                        @method('PUT')

                        <!-- Nama Pemasok -->
                        <div class="form-group mb-3">
                            <label for="edit_nama">Nama Pemasok</label>
                            <input type="text" name="nama" id="edit_nama" class="form-control" required>
                        </div>

                        <!-- Slug Pemasok -->
                        <div class="form-group mb-3">
                            <label for="edit_slug_pemasok">Slug</label>
                            <input type="text" name="slug_pemasok" id="edit_slug_pemasok" class="form-control"
                                required readonly>
                        </div>

                        <!-- Email Pemasok -->
                        <div class="form-group mb-3">
                            <label for="edit_email">Email</label>
                            <input type="email" name="email" id="edit_email" class="form-control" required>
                        </div>

                        <!-- No HP Pemasok -->
                        <div class="form-group mb-3">
                            <label for="edit_nohp">No HP</label>
                            <input type="text" name="nohp" id="edit_nohp" class="form-control" required>
                        </div>

                        <!-- Alamat Pemasok -->
                        <div class="form-group mb-3">
                            <label for="edit_alamat">Alamat</label>
                            <textarea name="alamat" id="edit_alamat" class="form-control" rows="4"></textarea>
                        </div>

                        <!-- Status Pemasok -->
                        <div class="form-group mb-3">
                            <label for="edit_status">Status</label>
                            <select name="status" id="edit_status" class="form-control" required>
                                <option value="1">Aktif</option>
                                <option value="0">Non-Aktif</option>
                            </select>
                        </div>

                        <!-- Tombol Submit -->
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
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

            // Function to generate slug from name
            function generateSlug(value) {
                return value.toLowerCase().replace(/ /g, '-').replace(/[^\w-]+/g, '');
            }

            // Generate slug automatically when name is changed
            $('#nama').on('input', function() {
                var nameValue = $(this).val();
                var slugValue = generateSlug(nameValue);
                $('#slug_pemasok').val(slugValue);
            });

            // Handle form submit untuk tambah pemasok
            $('#addPemasokForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('pemasok.store') }}',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#addPemasokModal').modal('hide');
                        location.reload();
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                    }
                });
            });

            // Menangani tombol edit
            $('.btn-edit').on('click', function() {
                var id = $(this).data('id');
                $.ajax({
                    type: 'GET',
                    url: '/pemasok/' + id + '/edit',
                    success: function(data) {
                        $('#editPemasokModal').modal('show');
                        $('#editPemasokForm').attr('action', '/pemasok/' + id);
                        $('#edit_nama').val(data.nama);
                        $('#edit_slug_pemasok').val(data.slug_pemasok);
                        $('#edit_email').val(data.email);
                        $('#edit_nohp').val(data.nohp);
                        $('#edit_alamat').val(data.alamat);
                        $('#edit_status').val(data.status);
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                    }
                });
            });

            // Handle form submit untuk edit pemasok
            $('#editPemasokForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    type: 'PUT',
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#editPemasokModal').modal('hide');
                        location.reload();
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                    }
                });
            });
        });

        // Fungsi untuk konfirmasi penghapusan
        function confirmDelete(event) {
            if (!confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                event.preventDefault();
            }
        }
    </script>
@endpush
