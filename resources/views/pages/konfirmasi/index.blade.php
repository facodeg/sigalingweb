@extends('layouts.app')

@section('title', 'Daftar Anggota')

@section('main')


    <div class="container-fluid">
        <div class="row">

            <div class="col-12">
                <div class="page-title-box justify-content-between d-flex align-items-md-center flex-md-row flex-column">
                    <h4 class="page-title">Daftar Pengajuan Anggota Koperasi</h4>
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
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <a href="{{ route('anggotas.create') }}" class="mb-3 btn btn-primary">Tambah Anggota</a>
                        <div class="table-responsive">
                            <table id="example2" class="table table-striped dt-responsive nowrap w-100 text-muted fs-14">
                                <thead>
                                    <tr>
                                        <th>Anggota</th>
                                        <th>Detail</th>
                                        <th>Data</th> <!-- Kolom baru untuk Data -->
                                        <th>Keuangan </th>
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
                                                                    (int) \Carbon\Carbon::now()->diffInYears(
                                                                        $tanggalLahir,
                                                                    ),
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
                                                        KTP:
                                                        <a href="{{ asset('storage/' . $anggota->upload_ktp) }}"
                                                            target="_blank">Lihat KTP</a>
                                                    </p>
                                                </div>
                                            </td>


                                            <td>
                                                <div class="ms-2" style="display: flex; flex-direction: column;">
                                                    <!-- Informasi Simpanan -->
                                                    <p class="mb-0 font-13 text-secondary">Simpanan Pokok: Rp
                                                        {{ number_format($anggota->simpanan_pokok, 0, ',', '.') }}
                                                    </p>
                                                    <p class="mb-0 font-13 text-secondary">Simpanan Wajib: Rp
                                                        {{ number_format($anggota->simpanan_wajib, 0, ',', '.') }}
                                                    </p>

                                                    <!-- Teks Waktu Pembayaran -->
                                                    <p class="mb-0 font-13 text-secondary">
                                                        Waktu Pembayaran:
                                                        @if ($anggota->waktu_pembayaran == 1)
                                                            Rp 200.000 (bayar 1X)
                                                        @elseif($anggota->waktu_pembayaran == 2)
                                                            Rp 100.000 (bayar 2X)
                                                        @elseif($anggota->waktu_pembayaran == 4)
                                                            Rp 50.000 (bayar 4X)
                                                        @else
                                                            Belum dipilih
                                                        @endif
                                                    </p>
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

                            <!-- Modal Konfirmasi Status -->
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
                                                            <option value="batal">batal</option>
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
