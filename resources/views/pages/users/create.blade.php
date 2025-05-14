@extends('layouts.app')

@section('title', 'Users')


@section('main')

    <div class="page-wrapper">
        <div class="page-content">

            <div class="card">
                <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body p-4">
                        <h5 class="mb-3">Users</h5>
                        <div class="row mb-3">
                            <label for="input49" class="col-sm-3 col-form-label">Name</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <span class="input-group-text"><i class='bx bx-user'></i></span>
                                    <input type="text"
                                        class="form-control @error('name')
                                            is-invalid
                                        @enderror"
                                        name="name">
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="input51" class="col-sm-3 col-form-label">No Anggota</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <span class="input-group-text"><i class='bx bx-envelope'></i></span>
                                    <input type="text"
                                        class="form-control @error('email')
                            is-invalid
                            @enderror"
                                        name="email">
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="input52" class="col-sm-3 col-form-label">Choose Password</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <span class="input-group-text"><i class='bx bx-lock-open'></i></span>
                                    <input type="password"
                                        class="form-control @error('password')
                            is-invalid
                        @enderror"
                                        name="password">

                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="input49" class="col-sm-3 col-form-label">Position</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <span class="input-group-text"><i class='bx bx-user'></i></span>
                                    <input type="text"
                                        class="form-control @error('position')
                                            is-invalid
                                        @enderror"
                                        name="position">
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="input53" class="col-sm-3 col-form-label">Roles</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <span class="input-group-text"><i class='bx bx-flag'></i></span>
                                    <select class="form-select" id="input53" name="role">
                                        <option selected>Open this select menu</option>
                                        <option value="admin">Admin</option>
                                        <option value="user">Staff</option>
                                        <option value="anggota">anggota</option>
                                        <option value="koperasi">koperasi</option>

                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="formFile" class="col-sm-3 col-form-label">Foto</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <span class="input-group-text"><i class='bx bx-flag'></i></span>
                                    <input class="form-control" type="file" id="formFile" name ="imageUrl">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-sm-3 col-form-label"></label>
                            <div class="col-sm-9">
                                <div class="d-md-flex d-grid align-items-center gap-3">
                                    <button class="btn btn-primary px-4">Submit</button>
                                    <button type="button" class="btn btn-light px-4">Reset</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection
