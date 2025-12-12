@extends('layouts.app')

@section('title', 'Daftar Permintaan SIP')

@push('styles')
    <style>
        .text-truncate-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden
        }

        .text-monospace {
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace
        }

        .bg-info-subtle {
            background: #e8f6ff
        }
    </style>
@endpush

@section('main')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box justify-content-between d-flex align-items-md-center flex-md-row flex-column">
                    <h4 class="page-title">Daftar Permintaan Surat Izin Praktik (SIP)</h4>
                    <ol class="m-0 breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Surat</a></li>
                        <li class="breadcrumb-item active">Permintaan SIP</li>
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

                        {{-- (Opsional) tombol buat link/form baru via WA/n8n --}}
                        @if (Route::has('sip.create'))
                            <a href="{{ route('sip.create') }}" class="mb-3 btn btn-primary">
                                <i class="ri-add-line"></i> Tambah Permintaan SIP
                            </a>
                        @endif

                        <div class="table-responsive">
                            <table id="table-sip" class="table table-hover align-middle nowrap w-100">
                                <thead class="table-light">
                                    <tr class="text-nowrap">
                                        <th class="text-center" style="width:56px;">No</th>
                                        <th>ID</th>
                                        <th>NIP</th>
                                        <th>Nama</th>
                                        <th>Profesi</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Tgl Pengajuan</th>
                                        <th class="text-center" style="width:240px;">Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($requests as $index => $req)
                                        @php
                                            $no = ($requests->firstItem() ?? 1) + $index;
                                            $statusMap = [
                                                'DRAFT' => ['bg-secondary', 'DRAFT'],
                                                'PENGAJUAN' => ['bg-info', 'PENGAJUAN'],
                                                'DITOLAK' => ['bg-danger', 'DITOLAK'],
                                                'SELESAI' => ['bg-success', 'SELESAI'],
                                            ];
                                            [$cls, $label] = $statusMap[$req->status] ?? [
                                                'bg-dark',
                                                $req->status ?? 'N/A',
                                            ];
                                        @endphp
                                        <tr>
                                            <td class="text-center">{{ $no }}</td>

                                            <td class="fw-semibold text-primary">{{ $req->id }}</td>

                                            <td class="text-monospace">{{ $req->karyawan_nip ?? '—' }}</td>

                                            <td class="fw-semibold">{{ $req->nama ?? '—' }}</td>

                                            <td>
                                                <span class="badge rounded-pill bg-info-subtle text-info fw-semibold">
                                                    {{ $req->profesi ?? '—' }}
                                                </span>
                                            </td>

                                            <td class="text-center">
                                                <span class="badge {{ $cls }} px-3">{{ $label }}</span>
                                            </td>

                                            <td class="text-center">
                                                {{ optional($req->created_at)->timezone('Asia/Jakarta')->format('d/m/Y H:i') ?? '—' }}
                                            </td>

                                            <td class="text-center">
                                                <div class="d-flex flex-wrap gap-1 justify-content-center">

                                                    {{-- Detail --}}
                                                    @if (Route::has('sip.show'))
                                                        <a href="{{ route('sip.show', $req->id) }}"
                                                            class="btn btn-outline-primary btn-sm" data-bs-toggle="tooltip"
                                                            title="Detail Pengajuan">
                                                            <i class="ri-eye-line"></i>
                                                        </a>
                                                    @endif

                                                    {{-- Cetak permohonan --}}
                                                    @if (Route::has('sip.cetak.pengajuan'))
                                                        <a href="{{ route('sip.cetak.pengajuan', $req->id) }}"
                                                            target="_blank" class="btn btn-secondary btn-sm"
                                                            data-bs-toggle="tooltip" title="Cetak Permohonan">
                                                            <i class="ri-printer-line"></i>
                                                        </a>
                                                    @endif

                                                    {{-- Download Surat Keterangan Praktik --}}
                                                    @if (Route::has('pengajuansip.cetak-pdf'))
                                                        <a href="{{ route('pengajuansip.cetak-pdf', $req->id) }}"
                                                            target="_blank" class="btn btn-primary btn-sm"
                                                            data-bs-toggle="tooltip"
                                                            title="Download Surat Keterangan Praktik (PDF)">
                                                            <i class="ri-file-download-line"></i>
                                                        </a>
                                                    @endif

                                                    {{-- Download Surat Keabsahan --}}
                                                    @if (Route::has('pengajuansip.cetak-keabsahan'))
                                                        <a href="{{ route('pengajuansip.cetak-keabsahan', $req->id) }}"
                                                            target="_blank" class="btn btn-info btn-sm text-white"
                                                            data-bs-toggle="tooltip"
                                                            title="Download Surat Keabsahan Data (PDF)">
                                                            <i class="ri-file-list-3-line"></i>
                                                        </a>
                                                    @endif

                                                    {{-- Download Surat Praktek --}}
                                                    @if (Route::has('pengajuansip.cetak-praktek'))
                                                        <a href="{{ route('pengajuansip.cetak-praktek', $req->id) }}"
                                                            target="_blank" class="btn btn-secondary btn-sm"
                                                            data-bs-toggle="tooltip" title="Download Surat Praktek">
                                                            <i class="ri-file-text-line"></i>
                                                        </a>
                                                    @endif

                                                    {{-- 🔥 Generate Nomor Surat (POST) --}}
                                                    @if (Route::has('sip.generate.nomor'))
                                                        @if (empty($req->no_surat))
                                                            {{-- Jika nomor surat masih kosong → tombol tampil --}}
                                                            <form action="{{ route('sip.generate.nomor', $req->id) }}"
                                                                method="POST" class="d-inline">
                                                                @csrf
                                                                <button type="submit" class="btn btn-warning btn-sm"
                                                                    data-bs-toggle="tooltip" title="Generate Nomor Surat"
                                                                    onclick="return confirm('Generate nomor surat untuk {{ $req->nama }} ?');">
                                                                    <i class="ri-hashtag"></i>
                                                                </button>
                                                            </form>
                                                        @endif
                                                    @endif


                                                    {{-- Kirim WA --}}
                                                    @if (!empty(trim($req->no_hp)) && Route::has('sip.sendSignedWa'))
                                                        <form action="{{ route('sip.sendSignedWa', $req->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-success btn-sm"
                                                                data-bs-toggle="tooltip"
                                                                title="Kirim berkas SIP Signed ke {{ $req->no_hp }}">
                                                                <i class="ri-whatsapp-line"></i>
                                                            </button>
                                                        </form>
                                                    @else
                                                        <button class="btn btn-success btn-sm" disabled
                                                            data-bs-toggle="tooltip" title="Nomor WA belum tersedia">
                                                            <i class="ri-whatsapp-line"></i>
                                                        </button>
                                                    @endif


                                                    {{-- Hapus --}}
                                                    @if (Route::has('sip.destroy'))
                                                        <button type="button" class="btn btn-outline-danger btn-sm"
                                                            onclick="showDeleteModal('{{ route('sip.destroy', $req->id) }}')"
                                                            data-bs-toggle="tooltip" title="Hapus">
                                                            <i class="ri-delete-bin-6-line"></i>
                                                        </button>
                                                    @endif

                                                    @if (Route::has('sip.upload.signed'))
                                                        <button type="button" class="btn btn-outline-primary btn-sm"
                                                            data-bs-toggle="modal" data-bs-target="#modalUploadSigned"
                                                            data-sipid="{{ $req->id }}"
                                                            title="Upload File Permohonan Signed">
                                                            <i class="ri-upload-line"></i>
                                                        </button>
                                                    @endif

                                                </div>
                                            </td>


                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Modal Upload -->
                        <div class="modal fade" id="modalUploadSigned" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <form id="formUploadSigned" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Upload File Permohonan (Signed) - PDF</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>

                                        <div class="modal-body">
                                            <div class="mb-2">
                                                <label for="file_signed" class="form-label">Pilih file (PDF, max 5
                                                    MB)</label>
                                                <input id="file_signed" name="file_signed" accept="application/pdf"
                                                    type="file" class="form-control" required>
                                                <div id="fileHelp" class="form-text">Hanya file PDF. Maks 5 MB.</div>
                                                <div id="fileError" class="invalid-feedback d-none"></div>
                                            </div>

                                            <div id="currentFile" class="mt-2 small text-muted"></div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light"
                                                data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" id="btnUploadSigned" class="btn btn-primary">
                                                <span class="spinner-border spinner-border-sm d-none" id="uploadSpinner"
                                                    role="status" aria-hidden="true"></span>
                                                Upload
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
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

                        {{-- (Opsional) pagination server-side standar Laravel --}}
                        @if (method_exists($requests, 'links'))
                            <div class="mt-3">
                                {{ $requests->withQueryString()->links() }}
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<meta name="csrf-token" content="{{ csrf_token() }}">


@push('scripts')
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>

    <script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>

    <script>
        function showDeleteModal(actionUrl) {
            document.getElementById('delete-form').setAttribute('action', actionUrl);
            new bootstrap.Modal(document.getElementById('delete-confirmation-modal')).show();
        }

        // Init DataTable ringan + re-init tooltip ketika tabel berubah halaman/sort/search
        $(function() {
            const table = $('#table-sip').DataTable({
                lengthChange: true
            });

            const initTooltips = () => {
                document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
                    // destroy instance lama jika ada
                    if (bootstrap.Tooltip.getInstance(el)) {
                        bootstrap.Tooltip.getInstance(el).dispose();
                    }
                    new bootstrap.Tooltip(el);
                });
            };

            initTooltips();
            table.on('draw.dt', initTooltips);
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modalEl = document.getElementById('modalUploadSigned');
            const fileInput = document.getElementById('file_signed');
            const form = document.getElementById('formUploadSigned');
            const fileError = document.getElementById('fileError');
            const currentFile = document.getElementById('currentFile');
            const spinner = document.getElementById('uploadSpinner');
            const btnUpload = document.getElementById('btnUploadSigned');

            // Pastikan elemen ada
            if (!modalEl || !form) return;

            modalEl.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const sipId = button?.getAttribute('data-sipid');
                if (!sipId) return;

                // gunakan route helper jika anda render action lewat blade: contoh form.setAttribute('action', '{{ url('/sip') }}/' + sipId + '/upload-signed');
                form.action = `/sip/${sipId}/upload-signed`;

                fileInput.value = '';
                fileError.classList.add('d-none');
                fileError.textContent = '';
                currentFile.textContent = button.getAttribute('data-file') ? 'File saat ini: ' + button
                    .getAttribute('data-file') : '';
            });

            form.addEventListener('submit', async function(ev) {
                ev.preventDefault();
                fileError.classList.add('d-none');
                fileError.textContent = '';

                const f = fileInput.files[0];
                if (!f) {
                    fileError.textContent = 'Silakan pilih file PDF.';
                    fileError.classList.remove('d-none');
                    return;
                }
                if (f.type !== 'application/pdf') {
                    fileError.textContent = 'File harus PDF.';
                    fileError.classList.remove('d-none');
                    return;
                }
                const maxBytes = 5 * 1024 * 1024;
                if (f.size > maxBytes) {
                    fileError.textContent = 'Ukuran file maksimal 5 MB.';
                    fileError.classList.remove('d-none');
                    return;
                }

                // Prepare
                const action = form.action;
                const meta = document.querySelector('meta[name="csrf-token"]');
                const token = meta ? meta.getAttribute('content') : null;

                const fd = new FormData();
                fd.append('file_signed', f);

                btnUpload.setAttribute('disabled', 'disabled');
                spinner.classList.remove('d-none');

                try {
                    const resp = await fetch(action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': token || '',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: fd,
                    });

                    const text = await resp.text();
                    let json = null;
                    try {
                        json = JSON.parse(text);
                    } catch (e) {
                        /* not json */
                    }

                    if (!resp.ok) {
                        console.error('Upload failed', resp.status, text, json);
                        // tampilkan pesan dari server bila ada
                        const message = (json && (json.message || json.errors)) ? (json.message || JSON
                            .stringify(json.errors)) : `Server returned ${resp.status}`;
                        fileError.textContent = message;
                        fileError.classList.remove('d-none');
                        return;
                    }

                    // success
                    console.log('Upload success', json || text);
                    // tutup modal dan reload untuk tampilkan file baru
                    const bsModal = bootstrap.Modal.getInstance(modalEl);
                    bsModal && bsModal.hide();
                    // opsi: tampilkan toast, lalu reload
                    location.reload();
                } catch (err) {
                    console.error('Fetch error', err);
                    fileError.textContent = 'Gagal mengirim file: ' + (err.message || err);
                    fileError.classList.remove('d-none');
                } finally {
                    btnUpload.removeAttribute('disabled');
                    spinner.classList.add('d-none');
                }
            });
        });
    </script>
@endpush
