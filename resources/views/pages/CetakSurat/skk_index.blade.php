@extends('layouts.app')

@section('title', 'Daftar Permintaan SKK')

@section('main')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box justify-content-between d-flex align-items-md-center flex-md-row flex-column">
                    <h4 class="page-title">Daftar Permintaan Surat Keterangan Kerja (SKK)</h4>
                    <ol class="m-0 breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Surat</a></li>
                        <li class="breadcrumb-item active">Permintaan SKK</li>
                    </ol>
                </div>
            </div>
        </div>

        {{-- Alert sukses / error --}}
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

                        <a href="{{ route('skk.create') }}" class="mb-3 btn btn-primary">
                            <i class="ri-add-line"></i> Tambah Permintaan SKK
                        </a>

                        <div class="table-responsive">
                            <table id="example2" class="table table-bordered table-striped dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>ID</th>
                                        <th>NIP</th>
                                        <th>Nomor Surat</th>
                                        <th>Nama</th>
                                        <th>Jenis Permintaan</th>
                                        <th>Keperluan</th>
                                        <th>Status</th>
                                        <th>Tanggal Pengajuan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($requests as $index => $req)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $req->id }}</td>
                                            <td>{{ $req->karyawan_nip }}</td>
                                            <td>{{ $req->nomor_surat ?? '-' }}</td>
                                            <td>{{ $req->nama }}</td>
                                            <td>{{ $req->request_type ?? 'SKK KPR' }}</td>
                                            <td>{{ $req->keperluan }}</td>
                                            <td>
                                                @if ($req->status == 'DRAFT')
                                                    <span class="badge bg-secondary">DRAFT</span>
                                                @elseif($req->status == 'PENGAJUAN')
                                                    <span class="badge bg-info">PENGAJUAN</span>
                                                @elseif($req->status == 'DISETUJUI')
                                                    <span class="badge bg-success">DISETUJUI</span>
                                                @else
                                                    <span class="badge bg-danger">{{ $req->status }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $req->created_at ? $req->created_at->format('d/m/Y H:i') : '-' }}</td>
                                            <td>
                                                <a href="{{ route('skk.show', $req->id) }}"
                                                    class="btn btn-sm btn-info mb-1">
                                                    <i class="ri-eye-line"></i> Lihat
                                                </a>
                                                <a href="{{ route('skk.cetak', $req->id) }}" target="_blank"
                                                    class="btn btn-sm btn-success mb-1">
                                                    <i class="ri-printer-line"></i> Cetak
                                                </a>
                                                <button type="button" class="btn btn-sm btn-danger mb-1"
                                                    onclick="showDeleteModal('{{ route('skk.destroy', $req->id) }}')">
                                                    <i class="ri-delete-bin-6-line"></i> Hapus
                                                </button>

                                                <a href="{{ route('skk.generate.nomor', $req->id) }}"
                                                    class="btn btn-sm btn-warning mb-1">
                                                    <i class="ri-hashtag"></i> Generate Nomor Surat
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Modal Hapus --}}
                        <div id="delete-confirmation-modal" class="modal fade" tabindex="-1" role="dialog"
                            aria-hidden="true">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                    <div class="p-4 modal-body">
                                        <div class="text-center">
                                            <i class="ri-close-circle-line h1"></i>
                                            <h4 class="mt-2">Konfirmasi Hapus</h4>
                                            <p class="mt-3">Apakah Anda yakin ingin menghapus permintaan ini?</p>
                                            <form id="delete-form" method="POST" action="">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="my-2 btn btn-light"
                                                    data-bs-dismiss="modal">Tidak</button>
                                                <button type="submit" class="my-2 btn btn-danger">Ya, Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end modal -->
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
            $('#delete-form').attr('action', actionUrl);
            $('#delete-confirmation-modal').modal('show');
        }

        $(document).ready(function() {
            $('#example2').DataTable({
                lengthChange: true,
                buttons: ['copy', 'excel', 'pdf', 'print']
            });
        });
    </script>
@endpush
