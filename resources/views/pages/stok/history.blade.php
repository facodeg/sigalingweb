@extends('layouts.app')

@section('title', 'Riwayat Stok - ' . $barang->nama)

@section('main')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="card">
                <div class="card-body p-3">
                    <!-- Breadcrumb -->
                    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                        <div class="breadcrumb-title pe-3">Barang</div>
                        <div class="ps-3">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0 p-0">
                                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Riwayat Stok</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <h6 class="mb-0 text-uppercase">Riwayat Perubahan Stok - {{ $barang->nama }}</h6>
            <hr />
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="stokLogTable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Tanggal Perubahan</th>
                                    <th>Nama Barang</th>
                                    <th>Tipe Transaksi</th>
                                    <th>Stok Sebelumnya</th>
                                    <th>Jumlah Perubahan</th>
                                    <th>Stok Sesudah</th>
                                    <th>Transaksi ID</th>
                                    <th>Pengguna</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($stokLogs as $log)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($log->tanggal_perubahan)->format('d M Y') }}</td>
                                        <td>{{ $barang->nama }}</td>
                                        <td>{{ ucfirst($log->tipe) }}</td>
                                        <td>{{ $log->stok_sebelumnya }}</td>
                                        <td>{{ $log->jumlah_perubahan }}</td>
                                        <td>{{ $log->stok_sesudah }}</td>
                                        <td>{{ $log->transaksi_id ?? '-' }}</td>
                                        <td>{{ optional($log->user)->name ?? 'Pengguna Tidak Ditemukan' }}</td>
                                        <!-- Tampilkan nama pengguna -->
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Tanggal Perubahan</th>
                                    <th>Nama Barang</th>
                                    <th>Tipe Transaksi</th>
                                    <th>Stok Sebelumnya</th>
                                    <th>Jumlah Perubahan</th>
                                    <th>Stok Sesudah</th>
                                    <th>Transaksi ID</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#stokLogTable').DataTable({
                lengthChange: true,
                buttons: ['copy', 'excel', 'pdf', 'print']
            });
        });
    </script>
@endpush
