@extends('layouts.app')

@section('title', 'Data Karyawan')

@section('main')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box justify-content-between d-flex align-items-md-center flex-md-row flex-column">
                    <h4 class="page-title">Daftar Data Karyawan</h4>
                    <ol class="m-0 breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Data</a></li>
                        <li class="breadcrumb-item active">Karyawan</li>
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

                        <a href="{{ route('karyawan.create') }}" class="btn btn-primary mb-3">Tambah Data Karyawan</a>

                        {{-- Tombol Filter Status --}}
                        <div class="mb-3">
                            <button class="btn btn-success filter-status" data-status="Aktif">
                                Aktif (<span
                                    id="count-aktif">{{ $karyawans->where('status_nakes', 'Aktif')->count() }}</span>)
                            </button>
                            <button class="btn btn-warning filter-status" data-status="Pensiun">
                                Pensiun (<span
                                    id="count-pensiun">{{ $karyawans->where('status_nakes', 'Pensiun')->count() }}</span>)
                            </button>
                            <button class="btn btn-danger filter-status" data-status="Resign">
                                Resign (<span
                                    id="count-resign">{{ $karyawans->where('status_nakes', 'Resign')->count() }}</span>)
                            </button>
                        </div>

                        <table id="example2" class="table table-bordered table-striped dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama</th>
                                    <th>NIP/NIPPPK</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Status Kepegawaian</th>
                                    <th>Status Nakes</th>
                                    <th>Pendidikan</th>
                                    <th>Jabatan Terakhir</th>
                                    <th>Golongan</th>
                                    <th>TMT Jabatan</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                    <th style="display: none;">StatusNakesFilter</th> {{-- Kolom tersembunyi untuk filter --}}
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama</th>
                                    <th>NIP/NIPPPK</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Status Kepegawaian</th>
                                    <th>Status Nakes</th>
                                    <th>Pendidikan</th>
                                    <th>Jabatan Terakhir</th>
                                    <th>Golongan</th>
                                    <th>TMT Jabatan</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                    <th style="display: none;">StatusNakesFilter</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($karyawans as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <a href="{{ route('karyawan.rincian', $item->id) }}" class="text-blue"
                                                    style="text-decoration: none;">
                                                    @if (empty($item->upload_foto_diri))
                                                        @php
                                                            $avatarIndex = ($loop->iteration % 4) + 1;
                                                            $avatarFile =
                                                                $item->jk == 'L'
                                                                    ? "avatar-{$avatarIndex}.jpg"
                                                                    : 'avatar-' . ($avatarIndex + 4) . '.jpg';
                                                        @endphp
                                                        <img src="{{ asset('assets/images/users/' . $avatarFile) }}"
                                                            alt="user-image" width="42" class="rounded-circle me-2">
                                                    @else
                                                        <img src="{{ asset('storage/' . $item->upload_foto_diri) }}"
                                                            class="shadow rounded-circle me-2" height="42"
                                                            alt="User Avatar">
                                                    @endif
                                                </a>
                                                <span>{{ $item->nama }}</span>
                                            </div>
                                        </td>

                                        <td>{{ $item->nip_nrp_nipppk_nipb }}</td>
                                        <td>{{ $item->jk == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                        <td>{{ $item->status_kepegawaian }}</td>
                                        <td>
                                            <select
                                                class="form-select form-select-sm status-nakes-dropdown
                                        {{ $item->status_nakes == 'Aktif' ? 'bg-success text-white' : ($item->status_nakes == 'Pensiun' ? 'bg-warning text-dark' : 'bg-danger text-white') }}"
                                                data-id="{{ $item->id }}">
                                                <option value="Aktif"
                                                    {{ $item->status_nakes == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                                <option value="Pensiun"
                                                    {{ $item->status_nakes == 'Pensiun' ? 'selected' : '' }}>Pensiun
                                                </option>
                                                <option value="Resign"
                                                    {{ $item->status_nakes == 'Resign' ? 'selected' : '' }}>Resign</option>
                                            </select>
                                        </td>
                                        <td>{{ $item->pendidikan_terakhir }}</td>
                                        <td>{{ $item->jabatan_terakhir }}</td>
                                        <td>{{ $item->gol }}</td>
                                        <td>{{ $item->tmt_kerja_di_rsud }}</td>
                                        <td>{{ $item->status }}</td>
                                        <td>
                                            <a href="{{ route('karyawan.edit', $item->id) }}"
                                                class="btn btn-sm btn-warning">Edit</a>
                                            <form action="{{ route('karyawan.destroy', $item->id) }}" method="POST"
                                                style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</button>
                                            </form>
                                        </td>
                                        <td style="display: none;">{{ $item->status_nakes }}</td>
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
        function updateDropdownColor(selectElement, status) {
            $(selectElement).removeClass('bg-success bg-warning bg-danger text-white text-dark');

            if (status === 'Aktif') {
                $(selectElement).addClass('bg-success text-white');
            } else if (status === 'Pensiun') {
                $(selectElement).addClass('bg-warning text-dark');
            } else if (status === 'Resign') {
                $(selectElement).addClass('bg-danger text-white');
            }
        }

        $(document).ready(function() {
            var table = $('#example2').DataTable({
                responsive: true,
                dom: 'Blfrtip',
                buttons: ['copy', 'excel', 'pdf', 'print'],
                lengthMenu: [
                    [5, 10, 25, 50, -1],
                    [5, 10, 25, 50, "All"]
                ],
                order: [
                    [0, 'asc']
                ],
                pageLength: 10,
                initComplete: function() {
                    this.api().columns().every(function() {
                        var column = this;
                        if (column.index() === 11) return; // Kolom Aksi

                        var input = document.createElement("input");
                        input.style.width = '100%';
                        $(input).appendTo($(column.footer()).empty())
                            .on('keyup change', function() {
                                if (column.search() !== this.value) {
                                    column.search(this.value).draw();
                                }
                            });
                    });
                }
            });

            // Filter awal tampilkan hanya status "Aktif"
            table.column(12).search('Aktif').draw();

            // Filter berdasarkan tombol status
            $('.filter-status').on('click', function() {
                const status = $(this).data('status');
                table.column(12).search(status).draw();
            });

            // Handle perubahan dropdown status-nakes
            $(document).on('change', '.status-nakes-dropdown', function() {
                const selectedValue = $(this).val();
                const karyawanId = $(this).data('id');
                const selectElement = this;

                $.ajax({
                    url: "{{ route('karyawan.updateStatusNakes') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: karyawanId,
                        status_nakes: selectedValue
                    },
                    success: function(response) {
                        updateDropdownColor(selectElement, selectedValue);
                        console.log(response.message);
                    },
                    error: function() {
                        alert('Gagal memperbarui status');
                    }
                });
            });
        });
    </script>
@endpush
