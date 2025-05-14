@extends('layouts.app')

@section('title', 'Edit Attendance')

@section('main')

    <div class="page-wrapper">
        <div class="page-content">
            <div class="card">
                <form action="{{ route('attendances.update', $attendance->id) }}" enctype="multipart/form-data" method="POST"
                    class="dropzone needsclick" id="dropzone-basic">
                    @csrf
                    @method('PUT')

                    <div class="card-body p-4">
                        <h5 class="mb-3">Edit Attendance</h5>

                        <input type="hidden" name="user_id" value="{{ $attendance->user_id }}">
                        <div class="row mb-3">
                            <label for="inputUser" class="col-sm-3 col-form-label">Nama </label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <span class="input-group-text"><i class='bx bx-user'></i></span>
                                    <input type="text" class="form-control" name="name"
                                        value="{{ $attendance->user->name }}" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputDate" class="col-sm-3 col-form-label">Date</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <span class="input-group-text"><i class='bx bx-calendar'></i></span>
                                    <input type="date" class="form-control" name="date" value="{{ $attendance->date }}">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputTimeIn" class="col-sm-3 col-form-label">Time In</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <span class="input-group-text"><i class='bx bx-time'></i></span>
                                    <input type="time" class="form-control" name="time_in" value="{{ $attendance->time_in }}">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputTimeOut" class="col-sm-3 col-form-label">Time Out</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <span class="input-group-text"><i class='bx bx-time'></i></span>
                                    <input type="time" class="form-control" name="time_out" value="{{ $attendance->time_out }}">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputLatLonIn" class="col-sm-3 col-form-label">Latitude & Longitude In</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <span class="input-group-text"><i class='bx bx-map'></i></span>
                                    <input type="text" class="form-control" name="latlon_in" value="{{ $attendance->latlon_in }}">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputLatLonOut" class="col-sm-3 col-form-label">Latitude & Longitude Out</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <span class="input-group-text"><i class='bx bx-map'></i></span>
                                    <input type="text" class="form-control" name="latlon_out" value="{{ $attendance->latlon_out }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-sm-3 col-form-label"></label>
                            <div class="col-sm-9">
                                <div class="d-md-flex d-grid align-items-center gap-3">
                                    <button type="submit" class="btn btn-primary px-4">Simpan Perubahan</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection
