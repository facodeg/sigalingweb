@extends('layouts.app')

@section('title', 'Users')


@section('main')

    <div class="page-wrapper">
        <div class="page-content">

            <div class="card">
                <form action="{{ route('users.update', $user->id) }}" enctype="multipart/form-data" method="POST"
                    class="dropzone needsclick" id="dropzone-basic">
                    @csrf
                    @method('PUT')
                    <div class="card-body p-4">
                        <h5 class="mb-3">Users</h5>

                        @if (session('success'))
                            <div class="alert alert-primary border-0 bg-primary alert-dismissible fade show py-2">
                                <div class="d-flex align-items-center">
                                    <div class="font-35 text-white"><i class='bx bx-bookmark-heart'></i></div>
                                    <div class="ms-3">
                                        <h6 class="mb-0 text-white">Success</h6>
                                        <div class="text-white">{{ session('success') }}</div>
                                    </div>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger border-0 bg-danger alert-dismissible fade show py-2">
                                <div class="d-flex align-items-center">
                                    <div class="font-35 text-white"><i class='bx bx-error'></i></div>
                                    <div class="ms-3">
                                        <h6 class="mb-0 text-white">Error</h6>
                                        <div class="text-white">
                                            <ul class="mb-0">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        <div class="row mb-3">
                            <label for="input49" class="col-sm-3 col-form-label">Name</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <span class="input-group-text"><i class='bx bx-user'></i></span>
                                    <input type="text"
                                        class="form-control @error('name')
                            is-invalid
                        @enderror"
                                        name="name" value="{{ $user->name }}">
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
                                        name="email" value="{{ $user->email }}">
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
                                </div>
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
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
                                        name="position" value="{{ $user->position }}">
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>



                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Roles</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <span class="input-group-text"><i class='bx bx-flag'></i></span>
                                    <select class="form-select" id="input53" name="role">
                                        <option selected>Open this select menu</option>
                                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin
                                        </option>
                                        <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>Staff
                                        </option>
                                        <option value="anggota" {{ $user->role == 'anggota' ? 'selected' : '' }}>anggota
                                        </option>
                                        <option value="koperasi" {{ $user->role == 'koperasi' ? 'selected' : '' }}>
                                            koperasi</option>
                                    </select>
                                </div>
                            </div>
                        </div>


                        <div class="row mb-3">
                            <label for="formFile" class="col-sm-3 col-form-label">Default file input example</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <span class="input-group-text"><i class='bx bx-flag'></i></span>
                                    <input type="file" class="form-control" name="imageUrl"
                                        value="{{ $user->file }}">
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
