@extends('layouts.app')

@section('title', 'Daftar Pinjaman')

@section('main')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box justify-content-between d-flex align-items-md-center flex-md-row flex-column">
                    <h4 class="page-title">Form Pinjaman</h4>
                    <ol class="m-0 breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Jidox</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Forms</a></li>
                        <li class="breadcrumb-item active">Form Pinjaman</li>
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
            <div class="p-3 card-body">
                <h5 class="mb-3">Pinjaman</h5>
                <a href="{{ route('pengajuanpinjaman.create') }}" class="mb-3 btn btn-primary">Pengajuan Pinjaman</a>
                <div class="table-responsive">
                    <table id="example2" class="table table-striped dt-responsive nowrap w-100 text-muted fs-14">
                        <thead>
                            <tr>
                                <th>Anggota</th>
                                <th>Data Pinjaman</th>
                                <th>Data Angsuran</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pinjamans as $pinjaman)
                                <tr>

                                    <td>
                                        <div class="d-flex align-items-center">
                                            <a href="{{ route('anggotas.rincian', $pinjaman->anggota->id) }}">
                                                <div>
                                                    @if (empty($pinjaman->anggota->upload_foto_diri))
                                                        <img src="assets/images/users/avatar-{{ ($loop->iteration % 14) + 1 }}.jpg"
                                                            alt="user-image" width="42" class="rounded-circle">
                                                    @else
                                                        <img src="{{ asset('storage/' . $pinjaman->anggota->upload_foto_diri) }}"
                                                            class="shadow rounded-circle" height="42"
                                                            alt="User Avatar" />
                                                    @endif
                                                </div>
                                            </a>
                                            <div class="ms-2">
                                                <h6 class="mb-1 font-14">{{ $pinjaman->anggota->nama }}</h6>
                                                <p class="mb-0 font-13 text-secondary">No Anggota:
                                                    {{ $pinjaman->anggota->no_anggota }}</p>
                                                <p class="mb-0 font-13 text-secondary">Unit Kerja:
                                                    {{ $pinjaman->anggota->unit_kerja }}</p>
                                                <p class="mb-0 font-13 text-secondary">No Pinjaman:
                                                    {{ $pinjaman->no_pinjaman }}</p>
                                                <p class="mb-0 font-13 text-secondary">Keperluan:
                                                    {{ $pinjaman->alasan_pinjam }}</p>
                                                <p class="mb-0 font-13 text-secondary">Periode:
                                                    {{ \Carbon\Carbon::parse($pinjaman->tgl_pinjaman)->format('d-m-Y') }}
                                                    s/d
                                                    {{ \Carbon\Carbon::parse($pinjaman->tgl_selesai)->format('d-m-Y') }}
                                                </p>
                                            </div>

                                        </div>

                                    </td>

                                    <td>
                                        <div class="ms-2">
                                            <p class="mb-0 font-13 text-secondary">Nominal:
                                                Rp {{ number_format($pinjaman->nominal, 0, ',', '.') }}</p>
                                            <p class="mb-0 font-13 text-secondary">Tenor:
                                                {{ $pinjaman->tenor }}</p>
                                            <p class="mb-0 font-13 text-secondary">Bayar Perbulan:
                                                Rp {{ number_format($pinjaman->bayar_perbulan, 0, ',', '.') }}</p>
                                            <p class="mb-0 font-13 text-secondary">Biaya Admin:
                                                Rp {{ number_format($pinjaman->biaya_admin, 0, ',', '.') }}</p>
                                            <p class="mb-0 font-13 text-secondary">Status:

                                                <span
                                                    class="badge bg-{{ $pinjaman->status == 'pending' ? 'warning' : 'secondary' }}">
                                                    {{ ucfirst($pinjaman->status) }}
                                                </span>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="ms-2">
                                            @if ($pinjaman->angsuran && $pinjaman->angsuran->isNotEmpty())
                                                <p class="mb-0 font-13 text-secondary">Total Angsuran:
                                                    Rp
                                                    {{ number_format($pinjaman->angsuran->sum('nominal'), 0, ',', '.') }}
                                                </p>
                                                <p class="mb-0 font-13 text-secondary">Sisa Pinjaman:
                                                    Rp
                                                    {{ number_format($pinjaman->angsuran->last()->sisa_pinjaman, 0, ',', '.') }}
                                                </p>
                                                <p class="mb-0 font-13 text-secondary">Angsuran Ke:
                                                    {{ $pinjaman->angsuran->count() }}</p>
                                                <p class="mb-0 font-13 text-secondary">No Angsuran:
                                                    {{ $pinjaman->angsuran->last()->no_angsuran }}</p>
                                                <p class="mb-0 font-13 text-secondary">Status:
                                                    {{ $pinjaman->angsuran->last()->status }}</p>
                                                <span
                                                    class="badge bg-{{ $pinjaman->status == 'pending' ? 'warning' : 'secondary' }}">
                                                    {{ ucfirst($pinjaman->status) }}
                                                </span>
                                            @else
                                                <p class="mb-0 font-13 text-secondary">Belum ada angsuran.</p>
                                            @endif
                                        </div>
                                    </td>

                                    <td>
                                        @if ($pinjaman->status == 'pending')
                                            <a href="{{ route('pengajuanpinjaman.edit', $pinjaman->id) }}"
                                                class="btn btn-warning btn-sm">Edit</a>
                                            <form action="{{ route('pengajuanpinjaman.destroy', $pinjaman->id) }}"
                                                method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus pinjaman ini?')">Hapus</button>
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
        });
    </script>
@endpush
