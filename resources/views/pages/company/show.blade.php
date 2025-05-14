@extends('layouts.app')

@section('title', 'Users')


@section('main')

    <div class="page-wrapper">
        <div class="page-content">
            <div class="card">

                <div class="card-body p-4">
                    <h5 class="mb-3">Users</h5>
                    <div class="row mb-3">
                        <label for="input49" class="col-sm-3 col-form-label">Name</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <span class="input-group-text"><i class='bx bx-user'></i></span>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" value="{{ $company->name }}" disabled>
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="input51" class="col-sm-3 col-form-label">Email Address</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <span class="input-group-text"><i class='bx bx-envelope'></i></span>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ $company->email }}" disabled>
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="input51" class="col-sm-3 col-form-label">Address</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <span class="input-group-text"><i class='bx bx-map'></i></span>
                                <input type="text" class="form-control @error('address') is-invalid @enderror"
                                    name="address" value="{{ $company->address }}" disabled>
                                @error('address')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="input51" class="col-sm-3 col-form-label">Latitude</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <span class="input-group-text"><i class='bx bx-map-pin'></i></span>
                                <input type="text" class="form-control @error('latitude') is-invalid @enderror"
                                    name="latitude" value="{{ $company->latitude }}" disabled>
                                @error('latitude')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="input51" class="col-sm-3 col-form-label">Longitude</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <span class="input-group-text"><i class='bx bx-map-pin'></i></span>
                                <input type="text" class="form-control @error('longitude') is-invalid @enderror"
                                    name="longitude" value="{{ $company->longitude }}" disabled>
                                @error('longitude')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="input51" class="col-sm-3 col-form-label">Radius (in km)</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <span class="input-group-text"><i class='bx bx-map-pin'></i></span>
                                <input type="number" class="form-control @error('radius_km') is-invalid @enderror"
                                    name="radius_km" value="{{ $company->radius_km }}" disabled>
                                @error('radius_km')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="input51" class="col-sm-3 col-form-label">Time In</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <span class="input-group-text"><i class='bx bx-time'></i></span>
                                <input type="time" class="form-control @error('time_in') is-invalid @enderror"
                                    name="time_in" value="{{ $company->time_in }}" disabled>
                                @error('time_in')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="input51" class="col-sm-3 col-form-label">Time Out</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <span class="input-group-text"><i class='bx bx-time'></i></span>
                                <input type="time" class="form-control @error('time_out') is-invalid @enderror"
                                    name="time_out" value="{{ $company->time_out }}" disabled>
                                @error('time_out')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <label class="col-sm-3 col-form-label"></label>
                        <div class="col-sm-9">
                            <div class="d-md-flex d-grid align-items-center gap-3">
                                <button class="btn btn-primary px-4"
                                    onclick="window.location.href='{{ route('companies.edit', $company->id) }}'">Edit</button>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>




@endsection
