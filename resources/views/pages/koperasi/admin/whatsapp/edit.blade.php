@extends('layouts.app')

@section('title', 'Edit WhatsApp Contact')

@section('main')
    <div class="page-wrapper">
        <div class="page-content">

            <div class="card">
                <div class="p-3 card-body">
                    <!--breadcrumb-->
                    <div class="mb-3 page-breadcrumb d-none d-sm-flex align-items-center">
                        <div class="mb-3 breadcrumb-title pe-3">Edit Contact</div>
                        <div class="ps-3">
                            <nav aria-label="breadcrumb">
                                <ol class="p-0 mb-0 breadcrumb">
                                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Edit WhatsApp Contact</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="p-4 card-body">
                    <form action="{{ route('whatsapp.update', $whatsapp->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Nama -->
                        <div class="mb-3 row">
                            <label for="name" class="col-sm-3 col-form-label">Nama</label>
                            <div class="col-sm-9">
                                <select name="name" id="name" class="form-control select2" required>
                                    <option disabled>Pilih Nama</option>
                                    @foreach ($anggota as $data)
                                        <option value="{{ $data->nama }}"
                                            {{ $data->nama == $whatsapp->name ? 'selected' : '' }}>
                                            {{ $data->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Nomor WhatsApp -->
                        <div class="mb-3 row">
                            <label for="phone" class="col-sm-3 col-form-label">Nomor WhatsApp</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                    name="phone" value="{{ old('phone', $whatsapp->phone) }}"
                                    placeholder="Masukkan Nomor WhatsApp">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Kondisi (Position) -->
                        <div class="mb-3 row">
                            <label for="position" class="col-sm-3 col-form-label">Kondisi</label>
                            <div class="col-sm-9">
                                <select class="form-control @error('position') is-invalid @enderror" name="position">
                                    <option disabled>Pilih Kondisi</option>
                                    <option value="Pendaftaran"
                                        {{ $whatsapp->position == 'Pendaftaran' ? 'selected' : '' }}>Pendaftaran</option>
                                    <option value="Pinjaman" {{ $whatsapp->position == 'Pinjaman' ? 'selected' : '' }}>
                                        Pinjaman</option>
                                </select>
                                @error('position')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Tombol Submit -->
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label"></label>
                            <div class="col-sm-9">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="{{ route('whatsapp.index') }}" class="btn btn-light">Cancel</a>
                            </div>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('assets/vendor/select2/js/select2.min.js') }}"></script>
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
