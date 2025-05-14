@extends('layouts.app')

@section('title', 'Daftar Simpanan Wajib')

@section('main')


    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box justify-content-between d-flex align-items-md-center flex-md-row flex-column">
                    <h4 class="page-title">Daftar Simpanan Wajib Koperasi</h4>
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

        <!-- Display simpanan yang belum diupdate using cards -->
        <div class="row mb-3">
            <div class="col">
                <div class="card widget-icon-box text-bg-success">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="overflow-hidden flex-grow-1">
                                <h5 class="mt-0 text-uppercase fs-13" title="Simpanan Belum Update">Simpanan Belum Update
                                </h5>
                                <h3 class="my-3">{{ $simpananBelumUpdate->count() }}</h3>
                                <p class="mb-0 text-white text-opacity-75 text-truncate">
                                    <span class="bg-white bg-opacity-25 badge me-1"><i class="ri-time-line"></i></span>
                                    <span>Jumlah Simpanan Belum Update</span>
                                </p>
                            </div>
                            <div class="flex-shrink-0 avatar-sm">
                                <span
                                    class="text-white bg-white bg-opacity-25 rounded shadow avatar-title rounded-3 fs-3 widget-icon-box-avatar">
                                    <i class="ri-time-line"></i>
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

                        <form action="{{ route('simpanan_wajib.updateSimpanan') }}" method="POST">
                            @csrf
                            <button type="submit" class="mb-2 btn btn-success btn-sm">Perbarui</button>
                        </form>

                        <!-- Spinner dan Progress Bar -->
                        <div id="loading-spinner" class="d-none text-center my-3">
                            <div class="spinner-border text-primary m-2" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p><span id="progress-percentage">0</span>%</p>
                        </div>

                        <form id="sendMessageForm" action="{{ route('simpanan_wajib.kirimPesanSemua') }}" method="POST">
                            @csrf
                            <button type="submit" id="sendButton" class="btn btn-primary">Kirim Pesan ke Semua
                                Anggota</button>
                        </form>




                        <table id="example2" class="table table-striped dt-responsive nowrap w-100 text-muted fs-14">
                            <thead>
                                <tr>
                                    <th>No Anggota</th>
                                    <th>Nama Anggota</th> <!-- Kolom Nama Anggota -->
                                    <th>Unit Kerja</th> <!-- Kolom Unit Kerja -->
                                    <th>Tanggal Simpanan</th>
                                    <th>Nominal</th>
                                    <th>Jumlah</th>
                                    <th>Aksi</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($simpananWajib as $simpanan)
                                    <tr>


                                        <td>{{ $simpanan->no_anggota ?? 'N/A' }}</td>

                                        <td>
                                            <a href="{{ route('anggotas.rincian', $simpanan->anggota->id) }}">
                                                {{ $simpanan->anggota->nama }}
                                            </a>
                                        </td>
                                        <!-- Menampilkan Nama Anggota -->
                                        <td>{{ $simpanan->anggota->unit_kerja ?? 'N/A' }}</td>
                                        <!-- Menampilkan Unit Kerja -->
                                        <td>{{ $simpanan->tgl_tampil }}</td>
                                        <td>{{ 'Rp ' . number_format($simpanan->total_nominal, 0, ',', '.') }}</td>
                                        <!-- Format Nominal sebagai Rupiah -->
                                        <td>{{ $simpanan->jumlah_simpanan }}</td>
                                        <td>
                                            <form action="{{ route('simpanan_wajib.destroy', $simpanan->no_anggota) }}"
                                                method="POST"
                                                onsubmit="return confirm('Apakah anda yakin ingin menghapus semua data ini?');">
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
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#sendMessageForm').on('submit', function(e) {
                // Hilangkan e.preventDefault() untuk memastikan form dikirim
                $('#loading-spinner').removeClass('d-none');
                $('#sendButton').prop('disabled', true); // Disable tombol Kirim saat proses berlangsung

                // Simulasi Proses Pengiriman dengan Persentase
                let totalMessages =
                    {{ $simpananWajib->filter(function ($item) {return $item->anggota->no_hp != '';})->count() }};
                let sentMessages = 0; // Inisialisasi pesan terkirim

                function updateProgress() {
                    sentMessages++; // Increment pesan terkirim
                    let progress = Math.round((sentMessages / totalMessages) * 100); // Hitung persentase
                    $('#progress-percentage').text(progress); // Update persentase pada UI
                }

                updateProgress();
            });
        });
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
@endpush
