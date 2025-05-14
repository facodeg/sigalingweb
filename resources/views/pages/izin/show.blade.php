@extends('layouts.app')

@section('title', 'Users')


@section('main')

    <div class="page-wrapper">
        <div class="page-content">
            <div class="card">

                <div class="card-body p-4">
                    <h5 class="mb-3">Users</h5>
                    <div class="row mb-3">
                        <label for="input49" class="col-sm-3 col-form-label">User ID</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <span class="input-group-text"><i class='bx bx-user'></i></span>
                                <input type="text" class="form-control" name="user_id" value="{{ $izin->user->name }}"
                                    disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="input51" class="col-sm-3 col-form-label">Date Izin</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <span class="input-group-text"><i class='bx bx-calendar'></i></span>
                                <input type="text" class="form-control" name="date_izin" value="{{ $izin->date_izin }}"
                                    disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="input51" class="col-sm-3 col-form-label">Reason</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <span class="input-group-text"><i class='bx bx-message'></i></span>
                                <input type="text" class="form-control" name="reason" value="{{ $izin->reason }}"
                                    disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="input51" class="col-sm-3 col-form-label">Image</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <span class="input-group-text"><i class='bx bx-image'></i></span>
                                <input type="text" class="form-control" name="image" value="{{ $izin->image }}"
                                    disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="input51" class="col-sm-3 col-form-label">Is Approved</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <span class="input-group-text"><i class='bx bx-check-circle'></i></span>
                                <input type="text" class="form-control" name="is_approved"
                                    value="{{ $izin->is_approved ? 'Approved' : 'Not Approved' }}" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <label class="col-sm-3 col-form-label"></label>
                        <div class="col-sm-9">
                            <div class="d-md-flex d-grid align-items-center gap-3">
                                <button class="btn btn-primary px-4"
                                    onclick="window.location.href='{{ route('izins.edit', $izin->id) }}'">Edit</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
