@extends('layouts.app')

@section('title', 'Create Attendance')

@section('main')

    <div class="page-wrapper">
        <div class="page-content">
            <div class="card">
                <form action="{{ route('attendances.store') }}" enctype="multipart/form-data" method="POST"
                    class="dropzone needsclick" id="dropzone-basic">
                    @csrf

                    <div class="card-body p-4">
                        <h5 class="mb-3">Create Attendance</h5>
                        <div class="row mb-3">
                            <label for="inputUser" class="col-sm-3 col-form-label">Nama</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <span class="input-group-text"><i class='bx bx-user'></i></span>
                                    <select class="form-select" name="user_id" required>
                                        <option value="">Pilih User</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputDate" class="col-sm-3 col-form-label">Date</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <span class="input-group-text"><i class='bx bx-calendar'></i></span>
                                    <input type="date" class="form-control" name="date" required>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputTimeIn" class="col-sm-3 col-form-label">Time In</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <span class="input-group-text"><i class='bx bx-time'></i></span>
                                    <input type="time" class="form-control" name="time_in" required>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputTimeOut" class="col-sm-3 col-form-label">Time Out</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <span class="input-group-text"><i class='bx bx-time'></i></span>
                                    <input type="time" class="form-control" name="time_out" required>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputLatLonIn" class="col-sm-3 col-form-label">Latitude & Longitude In</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <span class="input-group-text"><i class='bx bx-map'></i></span>
                                    <input type="text" class="form-control" name="latlon_in" placeholder="Lat, Lon" required>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputLatLonOut" class="col-sm-3 col-form-label">Latitude & Longitude Out</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <span class="input-group-text"><i class='bx bx-map'></i></span>
                                    <input type="text" class="form-control" name="latlon_out" placeholder="Lat, Lon" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-sm-3 col-form-label"></label>
                            <div class="col-sm-9">
                                <div class="d-md-flex d-grid align-items-center gap-3">
                                    <button type="submit" class="btn btn-primary px-4">Save Attendance</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection
