@extends('layouts.app')

@section('title', 'Daftar Anggota')

@section('main')


    <div class="container-fluid">
        <div class="row">

            <div class="col-12">
                <div class="page-title-box justify-content-between d-flex align-items-md-center flex-md-row flex-column">
                    <h4 class="page-title">Daftar Anggota Koperasi</h4>
                    <ol class="m-0 breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
                        <li class="breadcrumb-item active">Data Tables</li>
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



        <!-- Display total pembayaran manual and otomatis using cards -->
        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-2 mb-3">
            <div class="col">
                <div class="card widget-icon-box text-bg-danger">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="overflow-hidden flex-grow-1">
                                <h5 class="mt-0 text-uppercase fs-13" title="Total Pembayaran Manual">Total Pembayaran
                                    Manual</h5>
                                <h3 class="my-3">{{ $totalManual }}</h3>
                                <p class="mb-0 text-white text-opacity-75 text-truncate">
                                    <span class="bg-white bg-opacity-25 badge me-1"><i
                                            class="ri-close-circle-line"></i></span>
                                    <span>Manual Payments</span>
                                </p>
                            </div>
                            <div class="flex-shrink-0 avatar-sm">
                                <span
                                    class="text-white bg-white bg-opacity-25 rounded shadow avatar-title rounded-3 fs-3 widget-icon-box-avatar">
                                    <i class="ri-close-circle-line"></i>
                                </span>
                            </div>
                        </div>
                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col-->
            <div class="col">
                <div class="card widget-icon-box text-bg-success">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="overflow-hidden flex-grow-1">
                                <h5 class="mt-0 text-uppercase fs-13" title="Total Pembayaran Otomatis">Total Pembayaran
                                    Otomatis</h5>
                                <h3 class="my-3">{{ $totalOtomatis }}</h3>
                                <p class="mb-0 text-white text-opacity-75 text-truncate">
                                    <span class="bg-white bg-opacity-25 badge me-1"><i class="ri-check-line"></i></span>
                                    <span>Automatic Payments</span>
                                </p>
                            </div>
                            <div class="flex-shrink-0 avatar-sm">
                                <span
                                    class="text-white bg-white bg-opacity-25 rounded shadow avatar-title rounded-3 fs-3 widget-icon-box-avatar">
                                    <i class="ri-check-line"></i>
                                </span>
                            </div>
                        </div>
                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col-->
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <a href="{{ route('anggotas.create') }}" class="mb-3 btn btn-primary">Tambah Anggota</a>

                        <table id="example2" class="table table-striped dt-responsive nowrap w-100 text-muted fs-14">
                            <thead>
                                <tr>

                                    <th>Anggota</th>
                                    <th>Detail</th>
                                    <th>Data</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($anggotas as $anggota)
                                    <tr>


                                        <td>
                                            <a href="{{ route('anggotas.rincian', $anggota->id) }}" class="text-blue"
                                                style="text-decoration: none;">
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        @if (empty($anggota->upload_foto_diri))
                                                            <img src="assets/images/users/avatar-{{ ($loop->iteration % 10) + 1 }}.jpg"
                                                                alt="user-image" width="42" class="rounded-circle">
                                                        @else
                                                            <img src="{{ asset('storage/' . $anggota->upload_foto_diri) }}"
                                                                class="shadow rounded-circle" height="42"
                                                                alt="User Avatar" />
                                                        @endif
                                                    </div>
                                                    <div class="ms-2">
                                                        <h6 class="mb-1 font-14">{{ $anggota->tanggal }}</h6>
                                                        <h6 class="mb-1 font-14">{{ $anggota->nama }}</h6>
                                                        <p class="mb-0 font-13 text-secondary">No Anggota:
                                                            {{ $anggota->no_anggota }}</p>
                                                        <p class="mb-0 font-13 text-secondary">Unit Kerja:
                                                            {{ $anggota->unit_kerja }}</p>
                                                        <p class="mb-0 font-13 text-secondary">Status:
                                                            {{ $anggota->status_kepegawaian }}</p>
                                                    </div>
                                                </div>
                                            </a>
                                        </td>
                                        <td>
                                            <div class="ms-2" style="display: flex; flex-direction: column;">
                                                <p class="mb-0 font-13 text-secondary">Tempat Lahir:
                                                    {{ $anggota->tempat_lahir }}</p>
                                                <p class="mb-0 font-13 text-secondary">Tanggal Lahir:
                                                    {{ $anggota->tanggal_lahir }}</p>
                                                <p class="mb-0 font-13 text-secondary">Umur: <span>
                                                        @php
                                                            $tanggalLahir = \Carbon\Carbon::parse(
                                                                $anggota->tanggal_lahir,
                                                            );
                                                            $umur = abs(
                                                                (int) \Carbon\Carbon::now()->diffInYears($tanggalLahir),
                                                            );
                                                        @endphp
                                                        {{ $umur }} tahun
                                                    </span></p>
                                            </div>
                                        </td>
                                        <!-- Kolom baru untuk Data -->
                                        <td>
                                            <div class="ms-2" style="display: flex; flex-direction: column;">
                                                <p class="mb-0 font-13 text-secondary">NIK: {{ $anggota->nik }}
                                                </p>

                                                <p class="mb-0 font-13 text-secondary">Status Pernikahan:
                                                    {{ $anggota->status_pernikahan }}</p>
                                                <p class="mb-0 font-13 text-secondary">No HP:
                                                    {{ $anggota->no_hp }}</p>
                                                <p class="mb-0 font-13 text-secondary">
                                                    Pembayaran:
                                                    <span
                                                        class="badge bg-{{ $anggota->pembayaran == '1' ? 'danger' : 'success' }}">
                                                        {{ $anggota->pembayaran == '1' ? 'Manual' : 'Otomatis' }}
                                                    </span>
                                                </p>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="ms-2" style="display: flex; flex-direction: column;">


                                                <span
                                                    class="badge bg-{{ $anggota->status == 'aktif' ? 'success' : 'danger' }}">
                                                    {{ $anggota->status }}
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{ route('anggotas.edit', $anggota->id) }}"
                                                class="mb-1 btn btn-warning btn-sm">Edit</a>
                                            <button type="button" class="mb-1 btn btn-danger btn-sm"
                                                onclick="showDeleteModal('{{ route('anggotas.destroy', $anggota->id) }}')">Hapus</button>

                                            <button type="button" class="mb-1 btn btn-info btn-sm"
                                                onclick="showStatusModal('{{ $anggota->id }}', '{{ $anggota->status }}')">Proses</button>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div id="status-confirmation-modal" class="modal fade" tabindex="-1" role="dialog"
                            aria-hidden="true">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                    <div class="p-4 modal-body">
                                        <div class="text-center">
                                            <i class="ri-question-line h1"></i>
                                            <h4 class="mt-2">Konfirmasi Status</h4>
                                            <p class="mt-3">Pilih status baru untuk anggota:</p>
                                            <form id="status-form" method="POST" action="">
                                                @csrf
                                                @method('PATCH')
                                                <div class="mb-3">
                                                    <select name="status" id="status-select" class="form-select">
                                                        <option value="aktif">aktif</option>
                                                        <option value="tidak">tidak</option>
                                                    </select>
                                                </div>
                                                <button type="button" class="my-2 btn btn-light"
                                                    data-bs-dismiss="modal">Tidak</button>
                                                <button type="submit" class="my-2 btn btn-success">Iya, Ubah</button>
                                            </form>
                                        </div>
                                    </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->
                        <!-- Modal Konfirmasi Penghapusan -->
                        <div id="delete-confirmation-modal" class="modal fade" tabindex="-1" role="dialog"
                            aria-hidden="true">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                    <div class="p-4 modal-body">
                                        <div class="text-center">
                                            <i class="ri-close-circle-line h1"></i>
                                            <h4 class="mt-2">Konfirmasi Hapus</h4>
                                            <p class="mt-3">Apakah Anda yakin ingin menghapus data ini?</p>
                                            <form id="delete-form" method="POST" action="">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="my-2 btn btn-light"
                                                    data-bs-dismiss="modal">Tidak</button>
                                                <button type="submit" class="my-2 btn btn-danger">Iya,
                                                    Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->

                    </div>
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
        function showDeleteModal(actionUrl) {
            // Set action URL form ke URL yang sesuai
            $('#delete-form').attr('action', actionUrl);
            // Tampilkan modal konfirmasi penghapusan
            $('#delete-confirmation-modal').modal('show');
        }
    </script>
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
    <script>
        function showStatusModal(anggotaId, currentStatus) {
            // Set URL form action ke URL yang sesuai dengan rute Laravel
            document.getElementById('status-form').action = "{{ route('pages.konfirmasi.updateStatus', ':id') }}".replace(
                ':id', anggotaId);

            // Set nilai default untuk select box
            document.getElementById('status-select').value = currentStatus;

            // Tampilkan modal konfirmasi status
            $('#status-confirmation-modal').modal('show');
        }
    </script>
@endpush
