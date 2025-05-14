@extends('layouts.app')

@section('title', 'Daftar Merek')

@section('main')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box justify-content-between d-flex align-items-md-center flex-md-row flex-column">
                    <h4 class="page-title">Daftar Merek</h4>
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


                <!-- Tombol untuk membuka modal tambah merek -->
                <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addMerekModal">Tambah
                    Merek</button>

                <div class="table-responsive">
                    <table id="example2" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Nama Merek</th>
                                <th>Slug</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mereks as $merek)
                                <tr>
                                    <td>{{ $merek->nama }}</td>
                                    <td>{{ $merek->slug_merek }}</td>
                                    <td>
                                        <span class="badge badge-{{ $merek->status == '1' ? 'success' : 'danger' }}">
                                            {{ ucfirst($merek->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <!-- Tombol untuk mengubah status -->
                                        @if ($merek->status == 'active')
                                            <form action="{{ route('merek.updateStatus', $merek->id) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Yakin ingin menonaktifkan merek ini?')">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="0">
                                                <button type="submit" class="btn btn-warning btn-sm">Nonaktifkan</button>
                                            </form>
                                        @else
                                            <form action="{{ route('merek.updateStatus', $merek->id) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Yakin ingin mengaktifkan merek ini?')">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="active">
                                                <button type="submit" class="btn btn-success btn-sm">Aktifkan</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal untuk menambah merek -->
    <div class="modal fade" id="addMerekModal" tabindex="-1" aria-labelledby="addMerekModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addMerekModalLabel">Tambah Merek Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addMerekForm" method="POST" action="{{ route('merek.store') }}">
                        @csrf

                        <!-- Nama Merek -->
                        <div class="form-group mb-3">
                            <label for="nama">Nama Merek</label>
                            <input type="text" name="nama" id="nama" class="form-control" required>
                        </div>

                        <!-- Slug Merek -->
                        <div class="form-group mb-3">
                            <label for="slug_merek">Slug</label>
                            <input type="text" name="slug_merek" id="slug_merek" class="form-control" required readonly>
                        </div>

                        <!-- Status -->
                        <div class="form-group mb-3">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="1">Aktif</option>
                                <option value="0">Tidak Aktif</option>
                            </select>
                        </div>

                        <!-- Tombol Submit -->
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk mengedit merek -->
    <div class="modal fade" id="editMerekModal" tabindex="-1" aria-labelledby="editMerekModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editMerekModalLabel">Edit Merek</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editMerekForm" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Nama Merek -->
                        <div class="form-group mb-3">
                            <label for="edit_nama">Nama Merek</label>
                            <input type="text" name="nama" id="edit_nama" class="form-control" required>
                        </div>

                        <!-- Slug Merek -->
                        <div class="form-group mb-3">
                            <label for="edit_slug_merek">Slug</label>
                            <input type="text" name="slug_merek" id="edit_slug_merek" class="form-control" required
                                readonly>
                        </div>

                        <!-- Status -->
                        <div class="form-group mb-3">
                            <label for="edit_status">Status</label>
                            <select name="status" id="edit_status" class="form-control" required>
                                <option value="1">Aktif</option>
                                <option value="0">Tidak Aktif</option>
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
    <script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jszip/jszip.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            // Initialize DataTable
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
                $('#slug_merek').val(slugValue);
            });

            // Form submission with AJAX
            $('#addMerekForm').on('submit', function(event) {
                event.preventDefault();
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        // Handle success
                        $('#addMerekModal').modal('hide');
                        location.reload();
                    },
                    error: function(xhr) {
                        // Handle error
                        alert('Terjadi kesalahan: ' + xhr.responseText);
                    }
                });
            });

            // Open edit modal and populate fields
            $(document).on('click', '.btn-edit', function() {
                var id = $(this).data('id');
                $.ajax({
                    url: '/merek/' + id + '/edit',
                    method: 'GET',
                    success: function(response) {
                        $('#edit_nama').val(response.nama);
                        $('#edit_slug_merek').val(response.slug_merek);
                        $('#edit_status').val(response.status);
                        $('#editMerekForm').attr('action', '/merek/' + id);
                        $('#editMerekModal').modal('show');
                    }
                });
            });

            // Edit form submission with AJAX
            $('#editMerekForm').on('submit', function(event) {
                event.preventDefault();
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        // Handle success
                        $('#editMerekModal').modal('hide');
                        location.reload();
                    },
                    error: function(xhr) {
                        // Handle error
                        alert('Terjadi kesalahan: ' + xhr.responseText);
                    }
                });
            });
        });
    </script>
@endpush
