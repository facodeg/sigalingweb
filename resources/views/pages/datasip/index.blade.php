@extends('layouts.app')

@section('title', 'Data Surat Izin Praktik (SIP)')

@section('main')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box justify-content-between d-flex align-items-md-center flex-md-row flex-column">
                    <h4 class="page-title">Data Surat Izin Praktik (SIP)</h4>
                    <ol class="m-0 breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Surat</a></li>
                        <li class="breadcrumb-item active">Data SIP</li>
                    </ol>
                </div>
            </div>
        </div>

        {{-- ===== Ringkasan bucket (server side) ===== --}}
        @php
            $today = \Carbon\Carbon::today('Asia/Jakarta');
            $bucket = ['lte1m' => 0, 'lte3m' => 0, 'lte6m' => 0, 'lte12m' => 0, 'gt12m' => 0];
            foreach ($data as $sipRow) {
                if (empty($sipRow->tgl_expired)) {
                    continue;
                }
                $exp = \Carbon\Carbon::parse($sipRow->tgl_expired);
                $diff = max(0, $today->diffInDays($exp, false));
                if ($diff <= 30) {
                    $bucket['lte1m']++;
                } elseif ($diff <= 90) {
                    $bucket['lte3m']++;
                } elseif ($diff <= 180) {
                    $bucket['lte6m']++;
                } elseif ($diff <= 365) {
                    $bucket['lte12m']++;
                } else {
                    $bucket['gt12m']++;
                }
            }
        @endphp

        {{-- ===== Kartu ringkasan (klik untuk filter range) ===== --}}
        <div class="row g-3 mb-3">
            <div class="col-12 col-sm-6 col-xl-2">
                <div class="card shadow-sm h-100 border-0 bucket-card" data-range="lte1m" role="button" tabindex="0">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="rounded-circle p-3 bg-danger-subtle">
                            <i class="ri-timer-flash-line fs-4 text-danger"></i>
                        </div>
                        <div>
                            <div class="fw-bold fs-5">{{ $bucket['lte1m'] }}</div>
                            <div class="text-muted small">≤ 1 bulan</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-xl-2">
                <div class="card shadow-sm h-100 border-0 bucket-card" data-range="lte3m" role="button" tabindex="0">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="rounded-circle p-3 bg-warning-subtle">
                            <i class="ri-timer-line fs-4 text-warning"></i>
                        </div>
                        <div>
                            <div class="fw-bold fs-5">{{ $bucket['lte3m'] }}</div>
                            <div class="text-muted small">≤ 3 bulan</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-xl-2">
                <div class="card shadow-sm h-100 border-0 bucket-card" data-range="lte6m" role="button" tabindex="0">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="rounded-circle p-3 bg-warning-subtle">
                            <i class="ri-time-line fs-4 text-warning"></i>
                        </div>
                        <div>
                            <div class="fw-bold fs-5">{{ $bucket['lte6m'] }}</div>
                            <div class="text-muted small">≤ 6 bulan</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-xl-2">
                <div class="card shadow-sm h-100 border-0 bucket-card" data-range="lte12m" role="button" tabindex="0">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="rounded-circle p-3 bg-info-subtle">
                            <i class="ri-calendar-check-line fs-4 text-info"></i>
                        </div>
                        <div>
                            <div class="fw-bold fs-5">{{ $bucket['lte12m'] }}</div>
                            <div class="text-muted small">≤ 1 tahun</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-xl-2">
                <div class="card shadow-sm h-100 border-0 bucket-card" data-range="gt12m" role="button" tabindex="0">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="rounded-circle p-3 bg-success-subtle">
                            <i class="ri-calendar-line fs-4 text-success"></i>
                        </div>
                        <div>
                            <div class="fw-bold fs-5">{{ $bucket['gt12m'] }}</div>
                            <div class="text-muted small">&gt; 1 tahun</div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- tombol reset ke ALL --}}
            <div class="col-12 col-sm-6 col-xl-2">
                <div class="card shadow-sm h-100 border-0 bucket-card active" data-range="ALL" role="button" tabindex="0"
                    title="Tampilkan semua">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="rounded-circle p-3 bg-primary-subtle">
                            <i class="ri-clipboard-line fs-4 text-primary"></i>
                        </div>
                        <div>
                            <div class="fw-bold fs-5">{{ array_sum($bucket) }}</div>
                            <div class="text-muted small">Total dihitung</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== Filter pencarian global ===== --}}
        <div class="card mb-2">
            <div class="card-body">
                <form method="GET" class="row g-2 align-items-center">
                    <div class="col-md-4">
                        <input type="text" name="q" class="form-control"
                            placeholder="Cari nama / ruangan / nomor SIP..." value="{{ request('q') }}">
                    </div>
                    <div class="col-md-auto">
                        <button type="submit" class="btn btn-primary"><i class="ri-search-line"></i> Cari</button>
                        <a href="{{ route('data.sip.index') }}" class="btn btn-light"><i class="ri-refresh-line"></i>
                            Reset</a>
                    </div>
                </form>
            </div>
        </div>

        {{-- ===== Tab Jabatan + Ruangan ===== --}}
        @php
            $countAll = count($data);
            $countPerawat = 0;
            $countBidan = 0;
            $countLainnya = 0;
            foreach ($data as $sipRow) {
                $j = mb_strtolower(trim(optional($sipRow->karyawan)->jabatan_terakhir ?? ''), 'UTF-8');
                if ($j === '') {
                    $countLainnya++;
                    continue;
                }
                if (str_contains($j, 'perawat')) {
                    $countPerawat++;
                } elseif (str_contains($j, 'bidan')) {
                    $countBidan++;
                } else {
                    $countLainnya++;
                }
            }
        @endphp

        <div class="filter-bar position-sticky top-0 z-1 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body py-3">
                    <div class="d-flex flex-wrap align-items-center gap-1 mb-2">
                        <div class="me-2 fw-semibold text-muted small">Jabatan:</div>
                        <div class="nav nav-pills gap-1" id="jabatanTabs">
                            <button class="nav-link active" data-group="ALL" type="button">Semua <span
                                    class="badge bg-light text-dark ms-1">{{ $countAll }}</span></button>
                            <button class="nav-link" data-group="PERAWAT" type="button">Perawat <span
                                    class="badge bg-light text-dark ms-1">{{ $countPerawat }}</span></button>
                            <button class="nav-link" data-group="BIDAN" type="button">Bidan <span
                                    class="badge bg-light text-dark ms-1">{{ $countBidan }}</span></button>
                            <button class="nav-link" data-group="LAINNYA" type="button">Lainnya <span
                                    class="badge bg-light text-dark ms-1">{{ $countLainnya }}</span></button>
                        </div>
                    </div>

                    {{-- Ruangan pills (diisi JS berdasar pilihan jabatan & pencarian) --}}
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <div class="d-flex align-items-center gap-2">
                            <span class="ruangan-label d-inline-flex align-items-center gap-2">
                                <i class="ri-building-2-line"></i><span>Ruangan</span>
                            </span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary d-none" id="ruanganClearBtn">
                                <i class="ri-close-circle-line me-1"></i>Clear
                            </button>
                        </div>
                        <div class="ruangan-scroll fancy-pills d-flex gap-2 flex-nowrap overflow-auto w-100 mt-1"
                            id="ruanganTabs" style="scroll-behavior:smooth"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== Tabel Data SIP ===== --}}
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="table-data-sip" class="table table-striped table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Jabatan Terakhir</th>
                                <th>Ruangan</th>
                                <th>Nomor SIP</th>
                                <th>Tgl Terbit</th>
                                <th>Tgl Expired</th>
                                <th>Sisa Hari</th>
                                <th>Status Kepegawaian</th>
                                <th>Berkas</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $today = \Carbon\Carbon::today('Asia/Jakarta');
                                $mapGroup = function (?string $jabatan) {
                                    $j = mb_strtolower(trim($jabatan ?? ''), 'UTF-8');
                                    if ($j === '') {
                                        return 'LAINNYA';
                                    }
                                    if (str_contains($j, 'perawat')) {
                                        return 'PERAWAT';
                                    }
                                    if (str_contains($j, 'bidan')) {
                                        return 'BIDAN';
                                    }
                                    return 'LAINNYA';
                                };
                            @endphp

                            @forelse ($data as $i => $sip)
                                @php
                                    $tglTerbit = $sip->tgl_terbit ? \Carbon\Carbon::parse($sip->tgl_terbit) : null;
                                    $tglExpired = $sip->tgl_expired ? \Carbon\Carbon::parse($sip->tgl_expired) : null;
                                    $sisaHariRaw = $tglExpired ? $today->diffInDays($tglExpired, false) : null;
                                    $sisaHari = is_null($sisaHariRaw) ? null : max(0, $sisaHariRaw);

                                    $sisaCls = 'bg-secondary';
                                    if (!is_null($sisaHari)) {
                                        if ($sisaHari <= 7) {
                                            $sisaCls = 'bg-danger';
                                        } elseif ($sisaHari <= 30) {
                                            $sisaCls = 'bg-warning text-dark';
                                        } else {
                                            $sisaCls = 'bg-success';
                                        }
                                    }

                                    $group = $mapGroup(optional($sip->karyawan)->jabatan_terakhir);
                                    $room = trim(optional($sip->karyawan)->ruangan ?? '') ?: '(Tanpa Ruangan)';
                                @endphp

                                <tr data-group="{{ $group }}" data-room="{{ $room }}"
                                    data-left="{{ $sisaHari ?? '' }}">
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ $sip->karyawan->nama ?? '-' }}</td>
                                    <td>{{ $sip->karyawan->jabatan_terakhir ?? '-' }}</td>
                                    <td>{{ $room }}</td>
                                    <td class="fw-semibold text-primary">{{ $sip->nomor ?? '-' }}</td>
                                    <td>{{ $tglTerbit ? $tglTerbit->format('d/m/Y') : '-' }}</td>
                                    <td>{{ $tglExpired ? $tglExpired->format('d/m/Y') : '-' }}</td>
                                    <td>
                                        @if (!is_null($sisaHari))
                                            <span class="badge {{ $sisaCls }}">{{ $sisaHari }} hari</span>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td><span
                                            class="badge bg-info text-dark">{{ $sip->karyawan->status_kepegawaian ?? '-' }}</span>
                                    </td>
                                    <td>
                                        @if ($sip->file)
                                            <a href="{{ asset('storage/' . $sip->file) }}" target="_blank"
                                                class="btn btn-outline-primary btn-sm">
                                                <i class="ri-file-pdf-line"></i> Lihat
                                            </a>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-success btn-sm btn-send-wa"
                                            data-url="{{ route('datasip.sendWa', $sip->id) }}"
                                            title="Kirim pengingat WA">
                                            <i class="ri-whatsapp-line"></i> Kirim WA
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center text-muted py-3">Belum ada data SIP.</td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        {{-- ===== Tabel Perawat/Bidan TANPA SIP ===== --}}
        @if (isset($karyawanNoSip) && $karyawanNoSip->count())
            <div class="card mt-4">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class="m-0">
                            <i class="ri-user-search-line me-2"></i>
                            Perawat & Bidan tanpa Data SIP
                        </h5>
                        <span class="badge bg-warning text-dark">
                            {{ number_format($karyawanNoSip->count()) }} orang
                        </span>
                    </div>

                    <div class="table-responsive">
                        <table id="table-no-sip" class="table table-striped table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center" style="width:56px">No</th>
                                    <th>Nama</th>
                                    <th>Jabatan Terakhir</th>
                                    <th>Ruangan</th>
                                    <th>Status Kepegawaian</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($karyawanNoSip as $i => $k)
                                    @php $room = trim($k->ruangan ?? '') ?: '(Tanpa Ruangan)'; @endphp
                                    <tr>
                                        <td class="text-center">{{ $i + 1 }}</td>
                                        <td class="fw-semibold">{{ $k->nama ?? '-' }}</td>
                                        <td>{{ $k->jabatan_terakhir ?? '-' }}</td>
                                        <td>{{ $room }}</td>
                                        <td>
                                            <span
                                                class="badge bg-info text-dark">{{ $k->status_kepegawaian ?? '-' }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <p class="mt-2 text-muted small">
                        *Daftar ini menampilkan karyawan ber-jabatan Perawat/Bidan yang belum memiliki entri SIP di sistem.
                    </p>
                </div>
            </div>
        @endif


    </div>


@endsection

@push('styles')
    <style>
        .filter-bar .nav-pills .nav-link {
            border-radius: 999px;
            padding: .4rem .9rem;
            font-weight: 600
        }

        .filter-bar .nav-pills .nav-link.active {
            background: #0d6efd
        }

        .ruangan-scroll {
            scroll-behavior: smooth
        }

        .ruangan-scroll::-webkit-scrollbar {
            height: 8px
        }

        .ruangan-scroll::-webkit-scrollbar-thumb {
            background: #e5e7eb;
            border-radius: 999px
        }

        .ruangan-scroll .btn {
            border-radius: 999px
        }

        .position-sticky.z-1 {
            z-index: 1010;
            backdrop-filter: saturate(1.2) blur(4px)
        }

        /* Kartu ringkasan clickable */
        .bucket-card {
            transition: transform .12s ease, box-shadow .12s ease;
            cursor: pointer
        }

        .bucket-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .08) !important
        }

        .bucket-card.active {
            outline: 2px solid #0d6efd22;
            box-shadow: 0 .75rem 1.25rem rgba(13, 110, 253, .08) !important
        }
    </style>
@endpush

@push('scripts')
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>



    <script>
        $(function() {
            const $table = $('#table-data-sip');
            const dt = $table.DataTable({
                paging: false,
                info: false,
                order: [
                    [5, 'desc']
                ], // Tgl Terbit
                language: {
                    search: "Cari di tabel:",
                    zeroRecords: "Tidak ada hasil ditemukan."
                },
                columnDefs: [{
                    orderable: false,
                    targets: [9]
                }]
            });

            // ======= State filter =======
            let activeGroup = 'ALL';
            let activeRoom = 'ALL';
            let activeRange = 'ALL'; // 'ALL'|'lte1m'|'lte3m'|'lte6m'|'lte12m'|'gt12m'

            // Pastikan tidak dobel daftar filter
            $.fn.dataTable.ext.search = $.fn.dataTable.ext.search.filter(fn => !fn.__sipComboFilter);

            // Helper range
            function inRange(left, range) {
                if (left === '' || left === null || isNaN(left)) return false;
                left = parseInt(left, 10);
                if (left < 0) left = 0;
                switch (range) {
                    case 'lte1m':
                        return left <= 30;
                    case 'lte3m':
                        return left > 30 && left <= 90;
                    case 'lte6m':
                        return left > 90 && left <= 180;
                    case 'lte12m':
                        return left > 180 && left <= 365;
                    case 'gt12m':
                        return left > 365;
                    case 'ALL':
                        return true;
                    default:
                        return true;
                }
            }

            // Filter gabungan — hanya untuk tabel utama
            const comboFilter = function(settings, data, dataIndex) {
                if (settings.nTable !== dt.table().node()) return true; // pembatas tabel
                const $tr = $(dt.row(dataIndex).node());
                const g = $tr.attr('data-group') || 'LAINNYA';
                const r = $tr.attr('data-room') || '(Tanpa Ruangan)';
                const l = $tr.attr('data-left');
                const passGroup = (activeGroup === 'ALL') || (g === activeGroup);
                const passRoom = (activeRoom === 'ALL') || (r === activeRoom);
                const passRange = inRange(l, activeRange);
                return passGroup && passRoom && passRange;
            };
            comboFilter.__sipComboFilter = true;
            $.fn.dataTable.ext.search.push(comboFilter);

            // ===== Ruangan pills dinamis (menghormati pencarian global) =====
            function computeRoomsForGroup(group) {
                const counts = {};
                dt.rows({
                    search: 'applied'
                }).every(function() {
                    const $tr = $(this.node());
                    const g = $tr.attr('data-group') || 'LAINNYA';
                    if (group !== 'ALL' && g !== group) return;
                    const r = $tr.attr('data-room') || '(Tanpa Ruangan)';
                    counts[r] = (counts[r] || 0) + 1;
                });
                return counts;
            }

            function renderRoomPills(group) {
                const $wrap = $('#ruanganTabs').empty();
                const $clear = $('#ruanganClearBtn');
                const counts = computeRoomsForGroup(group);
                const rooms = Object.keys(counts).sort((a, b) => a.localeCompare(b, undefined, {
                    sensitivity: 'base'
                }));
                const total = rooms.reduce((s, k) => s + counts[k], 0);

                // tombol ALL
                const btnAll = $(
                    `<button class="btn btn-sm ${activeRoom==='ALL'?'btn-secondary active':'btn-outline-secondary'}" data-room="ALL">
              Semua <span class="badge bg-secondary-subtle text-dark ms-1">${total}</span>
           </button>`
                );
                $wrap.append(btnAll);

                // tombol tiap ruangan
                rooms.forEach(room => {
                    const safe = $('<div>').text(room).html();
                    const isActive = (activeRoom === room);
                    const btn = $(
                        `<button class="btn btn-sm ${isActive?'btn-secondary active':'btn-outline-secondary'}" data-room="${safe}">
                  ${safe} <span class="badge bg-secondary-subtle text-dark ms-1">${counts[room]}</span>
               </button>`
                    );
                    $wrap.append(btn);
                });

                // tampilkan/hilangkan tombol Clear
                if (activeRoom !== 'ALL') $clear.removeClass('d-none');
                else $clear.addClass('d-none');

                // fallback aktif ke ALL jika pilihan sebelumnya tidak ada
                if (activeRoom !== 'ALL' && !counts[activeRoom]) {
                    activeRoom = 'ALL';
                    $wrap.find('[data-room="ALL"]').removeClass('btn-outline-secondary').addClass(
                        'btn-secondary active');
                    $clear.addClass('d-none');
                }
            }

            // Tab Jabatan
            $('#jabatanTabs').on('click', '.nav-link', function() {
                $('#jabatanTabs .nav-link').removeClass('active');
                $(this).addClass('active');
                activeGroup = $(this).data('group') || 'ALL';
                renderRoomPills(activeGroup);
                dt.draw();
            });

            // Pills Ruangan
            $('#ruanganTabs').on('click', 'button[data-room]', function() {
                $('#ruanganTabs button').removeClass('active btn-secondary').addClass(
                    'btn-outline-secondary');
                $(this).removeClass('btn-outline-secondary').addClass('active btn-secondary');
                activeRoom = $(this).data('room') || 'ALL';
                $('#ruanganClearBtn').toggleClass('d-none', activeRoom === 'ALL');
                dt.draw();
            });

            // Tombol Clear ruangan
            $('#ruanganClearBtn').on('click', function() {
                activeRoom = 'ALL';
                $('#ruanganTabs button').removeClass('active btn-secondary').addClass(
                    'btn-outline-secondary');
                $('#ruanganTabs [data-room="ALL"]').removeClass('btn-outline-secondary').addClass(
                    'active btn-secondary');
                $(this).addClass('d-none');
                dt.draw();
            });

            // Rebuild pills saat pencarian global berubah
            dt.on('search.dt', function() {
                renderRoomPills(activeGroup);
            });

            // Kartu bucket (range sisa hari)
            $(document).on('click keydown', '.bucket-card', function(e) {
                if (e.type === 'keydown' && !(e.key === 'Enter' || e.key === ' ')) return;
                $('.bucket-card').removeClass('active');
                $(this).addClass('active');
                activeRange = $(this).data('range') || 'ALL';
                dt.draw();
                document.getElementById('table-data-sip').scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            });

            // Init awal
            renderRoomPills(activeGroup);
            dt.draw();
        });

        $(function() {
            const $noSip = $('#table-no-sip');
            if ($noSip.length) {
                $noSip.DataTable({
                    paging: false,
                    info: false,
                    order: [
                        [1, 'asc']
                    ],
                    language: {
                        search: "Cari di tabel:",
                        zeroRecords: "Tidak ada hasil ditemukan."
                    }
                });
            }
        });
    </script>

    <script>
        $(document).on('click', '.btn-send-wa', function() {
            const $btn = $(this);
            const url = $btn.data('url');

            $btn.prop('disabled', true).html(
                '<span class="spinner-border spinner-border-sm me-1"></span>Mengirim...');

            $.ajax({
                    method: 'POST',
                    url: url,
                    data: {
                        _token: '{{ csrf_token() }}'
                    }
                })
                .done(function(res) {
                    if (res && res.ok) {
                        alert('✅ ' + (res.message || 'Pesan terkirim.'));
                    } else {
                        alert(
                            '⚠️ ' + (res.message || 'Gagal mengirim pesan.') +
                            (res.status ? `\nStatus: ${res.status}` : '') +
                            (res.resp ? `\nResp: ${JSON.stringify(res.resp)}` : '')
                        );
                    }
                })
                .fail(function(xhr) {
                    const msg = (xhr.responseJSON && (xhr.responseJSON.message || xhr.responseJSON.error)) ||
                        'Terjadi kesalahan server atau jaringan.';
                    alert('❌ ' + msg);
                });


        });
    </script>
@endpush
