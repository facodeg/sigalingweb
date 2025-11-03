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

                        @push('styles')
                            <style>
                                .text-truncate-2 {
                                    display: -webkit-box;
                                    -webkit-line-clamp: 2;
                                    -webkit-box-orient: vertical;
                                    overflow: hidden;
                                }

                                .text-monospace {
                                    font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
                                }

                                .bg-info-subtle {
                                    background: #e8f6ff;
                                }
                            </style>
                        @endpush


                        <div class="table-responsive">
                            <table id="example2" class="table table-hover align-middle nowrap w-100">
                                <thead class="table-light">
                                    <tr class="text-nowrap">
                                        <th class="text-center" style="width:56px;">No</th>
                                        <th>ID</th>
                                        <th>NIP</th>
                                        <th>Nomor Surat</th>
                                        <th>Nama</th>
                                        <th>Jenis</th>
                                        <th style="min-width:220px;">Keperluan</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Tgl Pengajuan</th>
                                        <th class="text-center" style="width:340px;">Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($requests as $index => $req)
                                        <tr>
                                            <td class="text-center">{{ $index + 1 }}</td>

                                            <td class="fw-semibold text-primary">{{ $req->id }}</td>

                                            <td class="text-monospace">{{ $req->karyawan_nip }}</td>

                                            <td>
                                                @if ($req->nomor_surat)
                                                    <span
                                                        class="badge bg-light text-dark border">{{ $req->nomor_surat }}</span>
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </td>

                                            <td class="fw-semibold">{{ $req->nama }}</td>

                                            <td>
                                                <span class="badge rounded-pill bg-info-subtle text-info fw-semibold">
                                                    {{ $req->request_type ?? 'SKK KPR' }}
                                                </span>
                                            </td>

                                            <td>
                                                <div class="text-truncate-2" title="{{ $req->keperluan }}">
                                                    {{ $req->keperluan }}
                                                </div>
                                            </td>

                                            <td class="text-center">
                                                @php
                                                    $map = [
                                                        'DRAFT' => ['bg-secondary', 'DRAFT'],
                                                        'PENGAJUAN' => ['bg-info', 'PENGAJUAN'],
                                                        'DISETUJUI' => ['bg-success', 'DISETUJUI'],
                                                    ];
                                                    [$cls, $label] = $map[$req->status] ?? ['bg-danger', $req->status];
                                                @endphp
                                                <span class="badge {{ $cls }} px-3">{{ $label }}</span>
                                            </td>

                                            <td class="text-center">
                                                {{ $req->created_at ? $req->created_at->format('d/m/Y H:i') : '—' }}
                                            </td>

                                            <td class="text-center">
                                                <div class="d-flex flex-wrap gap-1 justify-content-center">



                                                    <a href="{{ route('skk.cetak', $req->id) }}" target="_blank"
                                                        class="btn btn-success btn-sm" data-bs-toggle="tooltip"
                                                        title="Cetak Surat">
                                                        <i class="ri-printer-line"></i>
                                                    </a>

                                                    <a href="{{ route('skk.generate.nomor', $req->id) }}"
                                                        class="btn btn-warning btn-sm" data-bs-toggle="tooltip"
                                                        title="Generate Nomor Surat">
                                                        <i class="ri-hashtag"></i>
                                                    </a>

                                                    <a href="{{ url('skk-requests/' . $req->id . '/cetakajuan') }}"
                                                        target="_blank" class="btn btn-secondary btn-sm"
                                                        data-bs-toggle="tooltip" title="Cetak Permohonan">
                                                        <i class="ri-file-text-line"></i>
                                                    </a>

                                                    <button type="button" class="btn btn-primary btn-sm btn-upload-skk"
                                                        data-id="{{ $req->id }}" data-bs-toggle="modal"
                                                        data-bs-target="#modalUploadSKK"
                                                        title="Upload Surat SKK untuk {{ $req->nama }}">
                                                        <i class="ri-upload-2-line"></i>
                                                    </button>

                                                    @if ($req->file_pengajuan)
                                                        <a href="{{ $req->file_pengajuan }}" target="_blank"
                                                            class="btn btn-danger btn-sm" data-bs-toggle="tooltip"
                                                            title="Lihat File Pengajuan (PDF)">
                                                            <i class="ri-eye-line"></i>
                                                        </a>
                                                    @else
                                                        <button class="btn btn-outline-secondary btn-sm" disabled
                                                            data-bs-toggle="tooltip" title="Belum ada file pengajuan">
                                                            <i class="ri-eye-line"></i>
                                                        </button>
                                                    @endif

                                                    @if ($req->file_surat_skk)
                                                        <button type="button" class="btn btn-light btn-sm btn-preview-skk"
                                                            data-id="{{ $req->id }}" data-bs-toggle="modal"
                                                            data-bs-target="#modalPreviewPDF"
                                                            title="Download Surat SKK: {{ $req->nama }}">
                                                            <i class="ri-download-2-line"></i>
                                                        </button>
                                                    @else
                                                        <button class="btn btn-light btn-sm" disabled
                                                            data-bs-toggle="tooltip" title="Surat SKK belum diunggah">
                                                            <i class="ri-download-2-line"></i>
                                                        </button>
                                                    @endif

                                                    <button type="button" class="btn btn-outline-danger btn-sm"
                                                        onclick="showDeleteModal('{{ route('skk.destroy', $req->id) }}')"
                                                        data-bs-toggle="tooltip" title="Hapus">
                                                        <i class="ri-delete-bin-6-line"></i>
                                                    </button>

                                                    @if ($req->file_surat_skk && $req->no_wa)
                                                        <form action="{{ route('skk.sendWa', $req->id) }}" method="POST"
                                                            class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-success btn-sm"
                                                                data-bs-toggle="tooltip"
                                                                title="Kirim WA ke {{ $req->no_wa }}">
                                                                <i class="ri-whatsapp-line"></i>
                                                            </button>
                                                        </form>
                                                    @else
                                                        <button class="btn btn-success btn-sm" disabled
                                                            data-bs-toggle="tooltip"
                                                            title="Nomor WA atau file SKK belum tersedia">
                                                            <i class="ri-whatsapp-line"></i>
                                                        </button>
                                                    @endif


                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>


                        <!-- Modal Preview PDF -->
                        <div class="modal fade" id="modalPreviewPDF" tabindex="-1" aria-labelledby="previewPDFLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-xl" style="max-width:95%">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="previewPDFLabel">Preview Surat SKK</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Tutup"></button>
                                    </div>
                                    <div class="modal-body p-0" style="height:80vh">
                                        <iframe id="pdfFrame" src="" title="Preview PDF" width="100%"
                                            height="100%" style="border:0;"></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Modal Upload Surat SKK -->
                        <div class="modal fade" id="modalUploadSKK" tabindex="-1" aria-labelledby="uploadSKKLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <form id="form-upload-skk" method="POST" action="{{ url('skk-requests/upload-skk') }}"
                                    enctype="multipart/form-data" autocomplete="off">
                                    @csrf
                                    <input type="hidden" name="id" id="upload_id">

                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="uploadSKKLabel">Upload Surat SKK (PDF)</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Tutup"></button>
                                        </div>

                                        <div class="modal-body">
                                            <div class="mb-2 text-muted small" id="info-id-upload"></div>

                                            <div class="mb-3">
                                                <label class="form-label">Pilih File (PDF, maks 20MB)</label>
                                                <input type="file" name="file_surat_skk" accept="application/pdf"
                                                    class="form-control" required>
                                                <div class="form-text">Hanya format .pdf</div>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light"
                                                data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" id="btn-submit-upload" class="btn btn-primary">
                                                <i class="ri-upload-2-line"></i> Upload
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- jQuery (opsional, jika dipakai plugin lain) --}}
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>

    {{-- Bootstrap 5 bundle (WAJIB) --}}
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

    {{-- plugin lain --}}
    <script src="{{ asset('assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>

    {{-- DataTables core --}}
    <script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    {{-- Jika kamu TIDAK memuat ekstensi Buttons, biarkan kode aman di bawah yang auto-disable tombol --}}

    <script>
        // -------- Fix #1: Delete Modal pakai API Bootstrap 5 ----------
        function showDeleteModal(actionUrl) {
            document.getElementById('delete-form').setAttribute('action', actionUrl);
            new bootstrap.Modal(document.getElementById('delete-confirmation-modal')).show();
        }

        // -------- Fix #2: DataTables aman meski Buttons tidak dimuat ----------
        $(function() {
            const opts = {
                lengthChange: true
            };
            // Jika ekstensi Buttons tersedia, aktifkan
            if ($.fn.dataTable && $.fn.dataTable.Buttons) {
                opts.dom = 'Bfrtip';
                opts.buttons = ['copy', 'excel', 'pdf', 'print'];
            }
            $('#example2').DataTable(opts);
        });

        // -------- Fix #3: Set hidden id saat tombol Upload diklik ----------
        // Tidak lagi bergantung ke show.bs.modal (lebih andal)
    </script>

    <script>
        // Set hidden id saat tombol Upload diklik (lebih andal dibanding event show.bs.modal)
        document.addEventListener('click', function(e) {
            const btn = e.target.closest('.btn-upload-skk');
            if (!btn) return;

            const id = btn.getAttribute('data-id') || '';
            const hidden = document.getElementById('upload_id');
            const info = document.getElementById('info-id-upload');

            if (hidden) hidden.value = id;
            if (info) info.textContent = id ? `ID Permintaan: ${id}` : '';
        });

        // Reset form ketika modal ditutup
        const modalEl = document.getElementById('modalUploadSKK');
        if (modalEl) {
            modalEl.addEventListener('hidden.bs.modal', function() {
                const form = document.getElementById('form-upload-skk');
                if (form) form.reset();
                const hidden = document.getElementById('upload_id');
                const info = document.getElementById('info-id-upload');
                if (hidden) hidden.value = '';
                if (info) info.textContent = '';
                // re-enable tombol submit jika sebelumnya disabled
                const btn = document.getElementById('btn-submit-upload');
                if (btn) {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="ri-upload-2-line"></i> Upload';
                }
            });
        }

        // Cegah double submit + beri feedback
        const formUpload = document.getElementById('form-upload-skk');
        if (formUpload) {
            formUpload.addEventListener('submit', function() {
                const btn = document.getElementById('btn-submit-upload');
                if (btn) {
                    btn.disabled = true;
                    btn.innerHTML =
                        '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Mengunggah...';
                }
            });
        }
    </script>

    <script>
        // Set URL preview saat tombol diklik
        document.addEventListener('click', function(e) {
            const btn = e.target.closest('.btn-preview-skk');
            if (!btn) return;

            const id = btn.getAttribute('data-id');
            const frame = document.getElementById('pdfFrame');
            // cache-buster pakai timestamp supaya selalu refresh jika file habis diganti
            frame.src = "{{ route('skk.preview.surat', ':id') }}".replace(':id', id) + '?t=' + Date.now();
        });

        // Hapus src saat modal ditutup agar release memory & hentikan render
        const modal = document.getElementById('modalPreviewPDF');
        if (modal) {
            modal.addEventListener('hidden.bs.modal', function() {
                const frame = document.getElementById('pdfFrame');
                frame.src = '';
            });
        }
    </script>
    <script>
        document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
            new bootstrap.Tooltip(el);
        });

        // opsional: set judul modal dari data-bs-title
        const uploadModal = document.getElementById('modalUploadSKK');
        if (uploadModal) {
            uploadModal.addEventListener('show.bs.modal', e => {
                const title = e.relatedTarget?.getAttribute('data-bs-title') || 'Upload Surat SKK (PDF)';
                uploadModal.querySelector('.modal-title').textContent = title;
            });
        }
        const previewModal = document.getElementById('modalPreviewPDF');
        if (previewModal) {
            previewModal.addEventListener('show.bs.modal', e => {
                const title = e.relatedTarget?.getAttribute('data-bs-title') || 'Preview Surat SKK';
                previewModal.querySelector('.modal-title').textContent = title;
            });
        }
    </script>
@endpush
