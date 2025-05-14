@extends('layouts.app')

@section('title', 'WhatsApp')

@section('main')

    <div class="page-wrapper">
        <div class="page-content">

            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div
                            class="page-title-box justify-content-between d-flex align-items-md-center flex-md-row flex-column">
                            <h4 class="page-title">Daftar Limit Pinjaman</h4>
                            <ol class="m-0 breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
                                <li class="breadcrumb-item active">Data Tables</li>
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
            </div>

            <div class="card">
                <form action="{{ route('whatsapp.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="p-4 card-body">
                        <h5 class="mb-3">Data Pegawai</h5>

                        <!-- Nama -->
                        <div class="mb-3 row">
                            <label for="inputName" class="col-sm-3 col-form-label">Nama</label>
                            <div class="col-sm-9">
                                <div class="input-group">

                                    <select name="name" id="no_anggota" class="form-control select2"
                                        data-toggle="select2" required>
                                        <option selected disabled>Pilih Nama Pegawai</option>
                                        @foreach ($anggota as $data)
                                            <option value="{{ $data->nama }}">{{ $data->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Nomor WhatsApp -->
                        <div class="mb-3 row">
                            <label for="inputPhone" class="col-sm-3 col-form-label">Nomor WhatsApp</label>
                            <div class="col-sm-9">
                                <div class="input-group">

                                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                        name="phone" placeholder="Masukkan nomor WhatsApp">
                                    @error('phone')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Jabatan (Position) -->
                        <div class="mb-3 row">
                            <label for="inputPosition" class="col-sm-3 col-form-label">Kondisi</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <span class="input-group-text"><i class='bx bx-briefcase'></i></span>
                                    <select class="form-select @error('position') is-invalid @enderror" name="position">
                                        <option selected disabled>Pilih Kondisi</option>
                                        <option value="Pendaftaran">Pendaftaran</option>
                                        <option value="Pinjaman">Pinjaman</option>
                                    </select>
                                    @error('position')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Submit dan Reset -->
                        <div class="row">
                            <label class="col-sm-3 col-form-label"></label>
                            <div class="col-sm-9">
                                <div class="gap-3 d-md-flex d-grid align-items-center">
                                    <button class="px-4 btn btn-primary">Submit</button>
                                    <button type="reset" class="px-4 btn btn-light">Reset</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <!-- Vendor js -->
        <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/select2/js/select2.min.js') }}"></script>
        <script src="{{ asset('assets/js/app.min.js') }}"></script>

        <script type="text/javascript">
            $(document).ready(function() {
                $('.select2').select2({
                    placeholder: "Pilih Nama Pegawai",
                    allowClear: true
                });
            });
        </script>
    @endpush

@endsection
