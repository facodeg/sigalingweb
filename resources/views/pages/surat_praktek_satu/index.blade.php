@extends('layouts.app')

@section('title', 'Data Surat ')

@section('main')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box justify-content-between d-flex align-items-md-center flex-md-row flex-column">
                    <h4 class="page-title">Daftar Surat Keterangan </h4>
                    <ol class="m-0 breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Data</a></li>
                        <li class="breadcrumb-item active">Surat </li>
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
                        @php
                            $kategori = [
                                'SURAT KETERANGAN',
                                'SURAT IZIN ATASAN',
                                'SURAT KETERANGAN HARI DAN JAM PRAKTEK',
                                'SURAT KETERANGAN KERJA',
                            ];
                        @endphp

                        <ul class="nav nav-pills nav-justified mb-3">
                            @foreach ($kategori as $index => $jenis)
                                @php
                                    $colorClass = match ($jenis) {
                                        'SURAT KETERANGAN' => 'nav-keterangan',
                                        'SURAT IZIN ATASAN' => 'nav-izin',
                                        'SURAT KETERANGAN HARI DAN JAM PRAKTEK' => 'nav-jam',
                                        'SURAT KETERANGAN KERJA' => 'nav-kerja',
                                        default => '',
                                    };
                                @endphp
                                <li class="nav-item">
                                    <a href="#tab-{{ $index }}" data-bs-toggle="tab"
                                        class="nav-link rounded-0 {{ $colorClass }} {{ $index == 0 ? 'active' : '' }}">
                                        {{ $jenis }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>

                        <!-- Tabs Content -->
                        <div class="tab-content">
                            @foreach ($kategori as $index => $jenis)
                                <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}"
                                    id="tab-{{ $index }}" role="tabpanel">
                                    <div class="table-responsive">
                                        <table id="example21-{{ $index }}"
                                            class="table table-bordered table-striped dt-responsive nowrap w-100">
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
                                                @foreach ($data->where('nama_surat', $jenis) as $item)
                                                    @php
                                                        $statusClass = match ($item->status_surat) {
                                                            'proses' => 'bg-danger text-white',
                                                            'pengajuan' => 'bg-warning text-dark',
                                                            'selesai' => 'bg-success text-white',
                                                            default => '',
                                                        };
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $item->no_surat }}</td>
                                                        <td>{{ $item->praktikan_nama }}</td>
                                                        <td>{{ $item->profesi }}</td>
                                                        <td>{{ $item->unit }}</td>
                                                        <td>
                                                            <select
                                                                class="form-select form-select-sm status-surat {{ $statusClass }}"
                                                                data-id="{{ $item->id }}">
                                                                <option value="proses"
                                                                    {{ $item->status_surat === 'proses' ? 'selected' : '' }}>
                                                                    Proses</option>
                                                                <option value="pengajuan"
                                                                    {{ $item->status_surat === 'pengajuan' ? 'selected' : '' }}>
                                                                    Pengajuan</option>
                                                                <option value="selesai"
                                                                    {{ $item->status_surat === 'selesai' ? 'selected' : '' }}>
                                                                    Selesai</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="date"
                                                                class="form-control form-control-sm tanggal-dikeluarkan"
                                                                data-id="{{ $item->id }}"
                                                                value="{{ \Carbon\Carbon::parse($item->tanggal_dikeluarkan)->format('Y-m-d') }}">
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('surat_praktek_satu.edit', $item->id) }}"
                                                                class="btn btn-sm btn-warning">Edit</a>
                                                            <form
                                                                action="{{ route('surat_praktek_satu.destroy', $item->id) }}"
                                                                method="POST" style="display:inline-block;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-danger"
                                                                    onclick="return confirm('Yakin?')">Hapus</button>
                                                            </form>
                                                            @php
                                                                $countSurat = \App\Models\SuratPraktekSatu::where(
                                                                    'no_surat',
                                                                    $item->no_surat,
                                                                )->count();
                                                            @endphp
                                                            @if ($countSurat > 1)
                                                                <a href="{{ route('surat_praktek_satu.cetak2', $item->id) }}"
                                                                    class="btn btn-sm btn-info" target="_blank">Cetak</a>
                                                            @elseif ($item->nama_surat === 'SURAT IZIN ATASAN')
                                                                <a href="{{ route('surat_praktek_satu.cetak_izin_atasan', $item->id) }}"
                                                                    class="btn btn-sm btn-dark" target="_blank">Cetak</a>
                                                            @elseif ($item->nama_surat === 'SURAT KETERANGAN HARI DAN JAM PRAKTEK')
                                                                <a href="{{ route('surat_praktek_satu.cetak', $item->id) }}"
                                                                    class="btn btn-sm btn-primary" target="_blank">Cetak</a>
                                                            @elseif ($item->nama_surat === 'SURAT KETERANGAN')
                                                                <a href="{{ route('surat_praktek_satu.cetak_keterangan', $item->id) }}"
                                                                    class="btn btn-sm btn-success" target="_blank">Cetak</a>
                                                            @else
                                                                <a href="{{ route('surat_praktek_satu.cetak', $item) }}"
                                                                    class="btn btn-sm btn-secondary"
                                                                    target="_blank">Cetak</a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endforeach
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
        $(document).ready(function() {
            // Inisialisasi semua tabel di awal
            @foreach ($kategori as $index => $jenis)
                $('#example21-{{ $index }}').DataTable({
                    responsive: true,
                    dom: 'Blfrtip',
                    buttons: ['copy', 'excel', 'pdf', 'print'],
                    lengthMenu: [
                        [5, 10, 25, 50, -1],
                        [5, 10, 25, 50, "All"]
                    ],
                    pageLength: 10
                });
            @endforeach

            // Saat tab diklik, redraw datatable di dalamnya agar responsif
            $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
                let target = $(e.target).attr('href'); // ex: #tab-1
                let table = $(target).find('table').attr('id'); // get table ID
                if ($.fn.DataTable.isDataTable('#' + table)) {
                    $('#' + table).DataTable().columns.adjust().responsive.recalc();
                }
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            // Event delegation untuk dropdown status
            $(document).on('change', '.status-surat', function() {
                let suratId = $(this).data('id');
                let newStatus = $(this).val();

                updateSelectClass(this, newStatus); // update warna class dropdown

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

            // Event delegation untuk input tanggal
            $(document).on('change', '.tanggal-dikeluarkan', function() {
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

            // Fungsi untuk update warna class berdasarkan status
            function updateSelectClass(selectElement, status) {
                $(selectElement).removeClass('bg-danger bg-warning bg-success text-white text-dark');

                switch (status) {
                    case 'proses':
                        $(selectElement).addClass('bg-danger text-white');
                        break;
                    case 'pengajuan':
                        $(selectElement).addClass('bg-warning text-dark');
                        break;
                    case 'selesai':
                        $(selectElement).addClass('bg-success text-white');
                        break;
                }
            }

            // Set warna saat pertama load
            $(document).ready(function() {
                $('.status-surat').each(function() {
                    updateSelectClass(this, $(this).val());
                });
            });
        });
    </script>
@endpush
