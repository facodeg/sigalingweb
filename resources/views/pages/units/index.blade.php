<!-- resources/views/units/index.blade.php -->

@extends('layouts.app')

@section('title', 'Daftar Unit')

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

                <!-- Tombol untuk membuka modal tambah unit -->
                <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addUnitModal">Tambah
                    Unit</button>

                <div class="table-responsive">
                    <table id="example2" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Nama Unit</th>
                                <th>Slug</th>
                                <th>Detail</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($units as $unit)
                                <tr>
                                    <td>{{ $unit->name }}</td>
                                    <td>{{ $unit->slug_name }}</td>
                                    <td>{{ $unit->details }}</td>
                                    <td>{{ $unit->status == 'active' ? 'Aktif' : 'Non-Aktif' }}</td>
                                    <td>
                                        <button class="btn btn-warning btn-sm mb-1 btn-edit"
                                            data-id="{{ $unit->id }}">Edit</button>
                                        <form action="{{ route('units.destroy', $unit->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm mb-1">Hapus</button>
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


    <!-- Modal untuk menambah unit -->
    <div class="modal fade" id="addUnitModal" tabindex="-1" aria-labelledby="addUnitModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUnitModalLabel">Tambah Unit Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addUnitForm">
                        @csrf

                        <!-- Nama Unit -->
                        <div class="form-group mb-3">
                            <label for="name">Nama Unit</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>

                        <!-- Slug Unit -->
                        <div class="form-group mb-3">
                            <label for="slug_name">Slug</label>
                            <input type="text" name="slug_name" id="slug_name" class="form-control" required readonly>
                        </div>

                        <!-- Detail Unit -->
                        <div class="form-group mb-3">
                            <label for="details">Detail</label>
                            <textarea name="details" id="details" class="form-control" rows="4"></textarea>
                        </div>

                        <!-- Status Unit -->
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

    <!-- Modal untuk mengedit unit -->
    <div class="modal fade" id="editUnitModal" tabindex="-1" aria-labelledby="editUnitModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUnitModalLabel">Edit Unit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editUnitForm">
                        @csrf
                        @method('PUT')

                        <!-- Nama Unit -->
                        <div class="form-group mb-3">
                            <label for="edit_name">Nama Unit</label>
                            <input type="text" name="name" id="edit_name" class="form-control" required>
                        </div>

                        <!-- Slug Unit -->
                        <div class="form-group mb-3">
                            <label for="edit_slug_name">Slug</label>
                            <input type="text" name="slug_name" id="edit_slug_name" class="form-control" required
                                readonly>
                        </div>

                        <!-- Detail Unit -->
                        <div class="form-group mb-3">
                            <label for="edit_details">Detail</label>
                            <textarea name="details" id="edit_details" class="form-control" rows="4"></textarea>
                        </div>

                        <!-- Status Unit -->
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
            $('#name').on('input', function() {
                var nameValue = $(this).val();
                var slugValue = generateSlug(nameValue);
                $('#slug_name').val(slugValue);
            });

            // Handle form submit untuk tambah unit
            $('#addUnitForm').submit(function(e) {
                e.preventDefault();

                // Ambil data dari form
                var formData = $(this).serialize();

                // Kirim data menggunakan AJAX
                $.ajax({
                    url: "{{ route('units.store') }}",
                    type: "POST",
                    data: formData,
                    success: function(response) {
                        // Tampilkan pesan sukses
                        alert('Unit berhasil ditambahkan!');

                        // Tutup modal
                        $('#addUnitModal').modal('hide');

                        // Reload halaman untuk memperbarui daftar unit
                        location.reload();
                    },
                    error: function(xhr) {
                        // Tampilkan pesan error
                        alert('Terjadi kesalahan. Silakan coba lagi.');
                    }
                });
            });

            // Function to populate edit modal with data
            $('body').on('click', '.btn-edit', function() {
                var unitId = $(this).data('id');

                // Fetch unit details
                $.ajax({
                    url: "{{ url('units') }}/" + unitId + "/edit",
                    type: "GET",
                    success: function(response) {
                        // Populate the edit form fields
                        $('#edit_name').val(response.name);
                        $('#edit_slug_name').val(response.slug_name);
                        $('#edit_details').val(response.details);
                        $('#edit_status').val(response.status);

                        // Set form action URL
                        $('#editUnitForm').attr('action', "{{ url('units') }}/" + unitId);

                        // Show the modal
                        $('#editUnitModal').modal('show');
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan. Silakan coba lagi.');
                    }
                });
            });

            // Handle form submit untuk edit unit
            $('#editUnitForm').submit(function(e) {
                e.preventDefault();

                // Ambil data dari form
                var formData = $(this).serialize();
                var formAction = $(this).attr('action');

                // Kirim data menggunakan AJAX
                $.ajax({
                    url: formAction,
                    type: "PUT",
                    data: formData,
                    success: function(response) {
                        // Tampilkan pesan sukses
                        alert('Unit berhasil diperbarui!');

                        // Tutup modal
                        $('#editUnitModal').modal('hide');

                        // Reload halaman untuk memperbarui daftar unit
                        location.reload();
                    },
                    error: function(xhr) {
                        // Tampilkan pesan error
                        alert('Terjadi kesalahan. Silakan coba lagi.');
                    }
                });
            });
        });
    </script>
@endpush
