@extends('layouts.app')

@section('title', 'Rincian Karyawan')

@push('styles')
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('main')
    <div class="container-fluid">
        <!-- Page Title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex justify-content-between align-items-md-center flex-md-row flex-column">
                    <h4 class="page-title">Rincian Data Karyawan</h4>
                    <ol class="m-0 breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Rincian</a></li>
                        <li class="breadcrumb-item active">{{ $karyawan->nama }}</li>
                    </ol>
                </div>
            </div>
        </div>

        <!-- Alert -->
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <!-- Data Karyawan -->
        <div class="row">
            <div class="col-12 ">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-column align-items-center">
                            @php $avatar = rand(1, 10); @endphp
                            <img src="{{ asset('assets/images/users/avatar-' . $avatar . '.jpg') }}" alt="user-image"
                                width="150" class="rounded-circle mb-3">
                            <h5 class="my-2">{{ $karyawan->nama }}</h5>
                        </div>
                        <div class="fm-menu">
                            <div class="list-group list-group-flush">
                                <a href="javascript:;" class="py-1 list-group-item"><i
                                        class="ri-user-star-line me-2"></i><span>{{ $karyawan->jabatan_terakhir }}</span></a>
                                <a href="javascript:;" class="py-1 list-group-item"><i
                                        class="ri-id-card-line me-2"></i><span>{{ $karyawan->nip_nrp_nipppk_nipb }}</span></a>
                                <a href="javascript:;" class="py-1 list-group-item"><i
                                        class="ri-briefcase-4-line me-2"></i><span>{{ $karyawan->status_kepegawaian }}</span></a>
                                <a href="javascript:;" class="py-1 list-group-item"><i
                                        class="ri-calendar-event-line me-2"></i><span>{{ \Carbon\Carbon::parse($karyawan->tgl_lahir)->format('d-m-Y') }}</span></a>
                                <a href="javascript:;" class="py-1 list-group-item"><i
                                        class="ri-user-2-line me-2"></i><span>{{ $karyawan->jk }}</span></a>
                                <a href="javascript:;" class="py-1 list-group-item"><i
                                        class="ri-home-3-line me-2"></i><span>{{ $karyawan->alamat_ktp }},
                                        {{ $karyawan->desa }}, {{ $karyawan->kecamatan }},
                                        {{ $karyawan->kabupaten }}</span></a>
                                <a href="javascript:;" class="py-1 list-group-item"><i
                                        class="ri-graduation-cap-line me-2"></i><span>{{ $karyawan->pendidikan_terakhir }}</span></a>
                                <a href="javascript:;" class="py-1 list-group-item"><i
                                        class="ri-building-line me-2"></i><span>{{ $karyawan->ruangan }}</span></a>
                                <a href="javascript:;" class="py-1 list-group-item"><i
                                        class="ri-heart-line me-2"></i><span>{{ $karyawan->agama }}</span></a>
                                <a href="javascript:;" class="py-1 list-group-item"><i
                                        class="ri-stethoscope-line me-2"></i><span>{{ $karyawan->status_nakes }}</span></a>
                            </div>
                        </div>

                        <!-- Tombol Edit dan Tambah -->
                        <div class="mt-4 text-center">
                            <a href="{{ route('karyawan.edit', $karyawan->id) }}" class="btn btn-primary">Edit Data</a>
                            <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                data-bs-target="#modalDomisili">+ Tambah Domisili</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Domisili -->
    <div class="modal fade" id="modalDomisili" tabindex="-1" aria-labelledby="modalDomisiliLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('domisili.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="karyawan_id" value="{{ $karyawan->id }}">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Alamat Domisili</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <!-- Provinsi -->
                            <div class="col-md-6 mb-2">
                                <label>Provinsi</label>
                                <select name="province_code" id="province" class="form-control select2" required>
                                    <option value="">-- Pilih Provinsi --</option>
                                    @foreach ($provinsiList as $provinsi)
                                        <option value="{{ $provinsi->code }}">{{ $provinsi->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Kabupaten -->
                            <div class="col-md-6 mb-2">
                                <label>Kabupaten/Kota</label>
                                <select name="city_code" id="city" class="form-control select2" required>
                                    <option value="">-- Pilih Kabupaten/Kota --</option>
                                </select>
                            </div>

                            <!-- Kecamatan -->
                            <div class="col-md-6 mb-2">
                                <label>Kecamatan</label>
                                <select name="district_code" id="district" class="form-control select2" required>
                                    <option value="">-- Pilih Kecamatan --</option>
                                </select>
                            </div>

                            <!-- Desa -->
                            <div class="col-md-6 mb-2">
                                <label>Kelurahan/Desa</label>
                                <select name="village_code" id="village" class="form-control select2" required>
                                    <option value="">-- Pilih Kelurahan/Desa --</option>
                                </select>
                            </div>

                            <!-- Alamat Lengkap -->
                            <div class="col-md-12 mb-2">
                                <label>Alamat Lengkap</label>
                                <textarea name="alamat_lengkap" class="form-control" required></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inisialisasi Select2 di semua dropdown dalam modal
            $('.select2').select2({
                dropdownParent: $('#modalDomisili')
            });

            const province = $('#province');
            const city = $('#city');
            const district = $('#district');
            const village = $('#village');

            province.on('change', function() {
                const code = $(this).val();
                city.empty().append('<option value="">-- Pilih Kabupaten/Kota --</option>');
                district.empty().append('<option value="">-- Pilih Kecamatan --</option>');
                village.empty().append('<option value="">-- Pilih Kelurahan/Desa --</option>');

                if (!code) return;
                fetch(`/api/indonesia/cities/${code}`)
                    .then(res => res.json())
                    .then(data => {
                        data.forEach(item => {
                            city.append(`<option value="${item.code}">${item.name}</option>`);
                        });
                        city.trigger('change.select2');
                    });
            });

            city.on('change', function() {
                const code = $(this).val();
                district.empty().append('<option value="">-- Pilih Kecamatan --</option>');
                village.empty().append('<option value="">-- Pilih Kelurahan/Desa --</option>');

                if (!code) return;
                fetch(`/api/indonesia/districts/${code}`)
                    .then(res => res.json())
                    .then(data => {
                        data.forEach(item => {
                            district.append(
                                `<option value="${item.code}">${item.name}</option>`);
                        });
                        district.trigger('change.select2');
                    });
            });

            district.on('change', function() {
                const code = $(this).val();
                village.empty().append('<option value="">-- Pilih Kelurahan/Desa --</option>');

                if (!code) return;
                fetch(`/api/indonesia/villages/${code}`)
                    .then(res => res.json())
                    .then(data => {
                        data.forEach(item => {
                            village.append(
                                `<option value="${item.code}">${item.name}</option>`);
                        });
                        village.trigger('change.select2');
                    });
            });
        });
    </script>
@endpush
