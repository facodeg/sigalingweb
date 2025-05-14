@extends('layouts.app')

@section('title', 'WhatsApp')

@section('main')

    <div class="page-wrapper">
        <div class="page-content">

            <div class="card">
                <form action="{{ route('apiwhatsapp.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="p-4 card-body">
                        <h5 class="mb-3">Data WhatsApp API</h5>

                        <!-- Nama -->
                        <div class="mb-3 row">
                            <label for="inputName" class="col-sm-3 col-form-label">Nama</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" placeholder="Masukkan Nama" required>
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

                                    <input type="text"
                                        class="form-control @error('phone')
                                            is-invalid
                                        @enderror"
                                        name="phone" placeholder="Masukkan nomor WhatsApp">
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

                                    <input type="text"
                                        class="form-control @error('authorization')
                                            is-invalid
                                        @enderror"
                                        name="authorization" placeholder="Masukkan Authorization Token">
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

                                    <input type="text"
                                        class="form-control @error('links')
                                            is-invalid
                                        @enderror"
                                        name="links" placeholder="Masukkan Link">
                                    @error('links')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Kondisi (Position) -->
                        <div class="mb-3 row">
                            <label for="inputstatus" class="col-sm-3 col-form-label">Kondisi</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <span class="input-group-text"><i class='bx bx-briefcase'></i></span>
                                    <select class="form-select @error('status') is-invalid @enderror" name="status">
                                        <option selected disabled>Pilih Kondisi</option>
                                        <option value="aktif">aktif</option>
                                        <option value="non aktif">non aktif</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Input Key -->
                        <div class="mb-3 row">
                            <label for="inputKey" class="col-sm-3 col-form-label">Key</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <input type="text" class="form-control @error('key') is-invalid @enderror"
                                        id="key" name="key" placeholder="Masukkan Key" required>
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
