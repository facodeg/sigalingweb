@extends('layouts.app')

@section('title', 'Data Surat Praktek')

@section('main')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box justify-content-between d-flex align-items-md-center flex-md-row flex-column">
                    <h4 class="page-title">Daftar Surat Keterangan Praktek</h4>
                    <ol class="m-0 breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Data</a></li>
                        <li class="breadcrumb-item active">Surat Praktek</li>
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
                        <a href="{{ route('surat_praktek_satu.create') }}" class="mb-3 btn btn-primary">Tambah Surat
                            Praktek</a>

                        <table id="example2" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Nomor Surat</th>
                                    <th>Nama Praktikan</th>

                                    <th>Profesi</th>
                                    <th>Unit</th>
                                    <th>Status Surat</th>
                                    <th>Tanggal Dikeluarkan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                    <tr>
                                        <td>{{ $item->no_surat }}</td>
                                        <td>{{ $item->praktikan_nama }}</td>
                                        <td>{{ $item->profesi }}</td>
                                        <td>{{ $item->unit }}</td>
                                        @php
                                            $statusClass = match ($item->status_surat) {
                                                'proses' => 'bg-danger text-white',
                                                'pengajuan' => 'bg-warning text-dark',
                                                'selesai' => 'bg-success text-white',
                                                default => '',
                                            };
                                        @endphp

                                        <td>
                                            <select class="form-select form-select-sm status-surat {{ $statusClass }}"
                                                data-id="{{ $item->id }}">
                                                <option value="proses"
                                                    {{ $item->status_surat == 'proses' ? 'selected' : '' }}>Proses</option>
                                                <option value="pengajuan"
                                                    {{ $item->status_surat == 'pengajuan' ? 'selected' : '' }}>Pengajuan
                                                </option>
                                                <option value="selesai"
                                                    {{ $item->status_surat == 'selesai' ? 'selected' : '' }}>Selesai
                                                </option>
                                            </select>
                                        </td>

                                        {{-- <td>{{ $item->tempat_dikeluarkan }}</td> --}}
                                        {{-- <td>{{ \Carbon\Carbon::parse($item->tanggal_dikeluarkan)->translatedFormat('d F Y') }}</td> --}}

                                        <td>
                                            <input type="date" class="form-control form-control-sm tanggal-dikeluarkan"
                                                data-id="{{ $item->id }}"
                                                value="{{ \Carbon\Carbon::parse($item->tanggal_dikeluarkan)->format('Y-m-d') }}">
                                        </td>

                                        <td>
                                            <a href="{{ route('surat_praktek_satu.edit', $item->id) }}"
                                                class="btn btn-sm btn-warning">Edit</a>
                                            <form action="{{ route('surat_praktek_satu.destroy', $item->id) }}"
                                                method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</button>
                                            </form>
                                            @php
                                                $countSurat = \App\Models\SuratPraktekSatu::where(
                                                    'no_surat',
                                                    $item->no_surat,
                                                )->count();
                                            @endphp

                                            @if ($countSurat > 1)
                                                <a href="{{ route('surat_praktek_satu.cetak2', $item->id) }}"
                                                    class="btn btn-sm btn-info" target="_blank">
                                                    <i class="ri-printer-line"></i> Cetak
                                                </a>
                                            @else
                                                <a href="{{ route('surat_praktek_satu.cetak', $item) }}"
                                                    class="btn btn-sm btn-secondary" target="_blank">
                                                    <i class="ri-printer-line"></i> Cetak
                                                </a>
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
                dom: 'Bfrtip',
                buttons: ['copy', 'excel', 'pdf', 'print']
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.status-surat').on('change', function() {
                let suratId = $(this).data('id');
                let newStatus = $(this).val();

                $.ajax({
                    url: '{{ route('surat_praktek_satu.updateStatus') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: suratId,
                        status: newStatus
                    },
                    success: function(res) {
                        console.log(res.message);
                    },
                    error: function() {
                        alert('Gagal memperbarui status.');
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.tanggal-dikeluarkan').on('change', function() {
                let suratId = $(this).data('id');
                let newTanggal = $(this).val();

                $.ajax({
                    url: '{{ route('surat_praktek_satu.updateTanggal') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: suratId,
                        tanggal: newTanggal
                    },
                    success: function(res) {
                        console.log(res.message);
                    },
                    error: function() {
                        alert('Gagal memperbarui tanggal.');
                    }
                });
            });
        });
    </script>
@endpush
