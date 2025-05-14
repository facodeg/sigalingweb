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
                                    <th>Nama Praktikan</th>
                                    <th>Alamat Praktek</th>
                                    <th>Hari Praktek</th>
                                    <th>Jam Efektif</th>
                                    <th>Shift Pagi</th>
                                    <th>Shift Sore</th>
                                    <th>Tanggal Dikeluarkan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                    <tr>
                                        <td>{{ $item->praktikan_nama }}</td>
                                        <td>{{ $item->alamat_praktek }}</td>
                                        <td>{{ $item->hari_praktek }}</td>
                                        <td>{{ $item->jam_efektif_mingguan }} jam</td>
                                        <td>{{ $item->shift_pagi }}</td>
                                        <td>{{ $item->shift_sore }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->tanggal_dikeluarkan)->format('d-m-Y') }}</td>
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
@endpush
