@extends('layouts.app')

@section('title', 'Edit Limit Pinjaman')

@section('main')
    <div class="container-fluid">

        <div class="row">

            <div class="col-12">
                <div class="page-title-box justify-content-between d-flex align-items-md-center flex-md-row flex-column">
                    <h4 class="page-title">Daftar Anggota Koperasi</h4>
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

        <div class="row">
            <div class="col-12">

                <div class="card">
                    <div class="card-body">

                        <h5 class="card-title">Edit Limit Pinjaman</h5>
                        <form action="{{ route('limitpinjaman.update', $limitPinjaman->id) }}" method="POST">
                            @csrf
                            @method('PUT') <!-- Menggunakan method PUT untuk update -->

                            <div class="mb-3">
                                <label for="user_id" class="form-label">User</label>
                                <select name="user_id" id="user_id" class="form-select select2" data-toggle="select2">
                                    <option value="">Kosong</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ $user->id == $limitPinjaman->user_id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="limit" class="form-label">Limit Pinjaman</label>
                                <input type="number" class="form-control" id="limit" name="limit"
                                    value="{{ $limitPinjaman->limit }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" id="status_active"
                                            value="semua" {{ $limitPinjaman->status == 'semua' ? 'checked' : '' }}
                                            required>
                                        <label class="form-check-label" for="status_active">
                                            Semua
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" id="status_inactive"
                                            value="perorangan"
                                            {{ $limitPinjaman->status == 'perorangan' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="status_inactive">
                                            Perorangan
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

    @push('scripts')
        <!-- Vendor js -->
        <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/select2/js/select2.min.js') }}"></script>
        <script src="{{ asset('assets/js/app.min.js') }}"></script>
    @endpush
@endsection
