@extends('layouts.app')

@section('title', 'Edit WhatsApp Data')

@section('main')

    <div class="page-wrapper">
        <div class="page-content">

            <div class="card">
                <form action="{{ route('apiwhatsapp.update', $apiwhatsapp->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="p-4 card-body">
                        <h5 class="mb-3">Edit Data WhatsApp API</h5>

                        <!-- Nama -->
                        <div class="mb-3 row">
                            <label for="inputName" class="col-sm-3 col-form-label">Nama</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <select name="name" id="name" class="form-control select2" required>
                                        <option disabled>Pilih Nama</option>
                                        @foreach ($anggota as $data)
                                            <option value="{{ $data->nama }}"
                                                {{ $data->nama == $apiwhatsapp->name ? 'selected' : '' }}>
                                                {{ $data->nama }}
                                            </option>
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
                                        name="phone" value="{{ old('phone', $apiwhatsapp->phone) }}"
                                        placeholder="Masukkan nomor WhatsApp">
                                    @error('phone')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Authorization Token -->
                        <div class="mb-3 row">
                            <label for="inputAuthorization" class="col-sm-3 col-form-label">Authorization Token</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <input type="text" class="form-control @error('authorization') is-invalid @enderror"
                                        name="authorization" value="{{ old('authorization', $apiwhatsapp->authorization) }}"
                                        placeholder="Masukkan Authorization Token">
                                    @error('authorization')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Link -->
                        <div class="mb-3 row">
                            <label for="inputLinks" class="col-sm-3 col-form-label">Link</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <input type="text" class="form-control @error('links') is-invalid @enderror"
                                        name="links" value="{{ old('links', $apiwhatsapp->links) }}"
                                        placeholder="Masukkan Link">
                                    @error('links')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Kondisi -->
                        <div class="mb-3 row">
                            <label for="inputstatus" class="col-sm-3 col-form-label">Kondisi</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <span class="input-group-text"><i class='bx bx-briefcase'></i></span>
                                    <select id="inputstatus" class="form-select @error('status') is-invalid @enderror"
                                        name="status">
                                        <option selected disabled>Pilih Kondisi</option>
                                        <option value="aktif"
                                            {{ old('status', $apiwhatsapp->status) == 'aktif' ? 'selected' : '' }}>
                                            Aktif
                                        </option>
                                        <option value="non_aktif"
                                            {{ old('status', $apiwhatsapp->status) == 'non_aktif' ? 'selected' : '' }}>
                                            Non Aktif
                                        </option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Key -->
                        <div class="mb-3 row">
                            <label for="inputKey" class="col-sm-3 col-form-label">Key</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <input type="text" class="form-control @error('key') is-invalid @enderror"
                                        id="key" name="key" value="{{ old('key', $apiwhatsapp->key) }}"
                                        placeholder="Masukkan Key" required>
                                    @error('key')
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
                                    <button class="px-4 btn btn-primary">Update</button>
                                    <a href="{{ route('apiwhatsapp.index') }}" class="px-4 btn btn-light">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/select2/js/select2.min.js') }}"></script>
        <script src="{{ asset('assets/js/app.min.js') }}"></script>

        <script type="text/javascript">
            $(document).ready(function() {
                $('.select2').select2({
                    placeholder: "Pilih Nama",
                    allowClear: true
                });
            });
        </script>
    @endpush

@endsection
