@extends('layouts.app')

@section('title', 'Tambah Unit')

@section('main')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="card">
                <div class="card-body p-3">
                    <h5 class="mb-3">Tambah Unit Baru</h5>

                    {{-- Menampilkan pesan sukses atau error jika ada --}}
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    {{-- Form untuk menambah unit baru --}}
                    <form action="{{ route('units.store') }}" method="POST">
                        @csrf

                        {{-- Nama Unit --}}
                        <div class="form-group mb-3">
                            <label for="name">Nama Unit</label>
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                                required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Slug Unit --}}
                        <div class="form-group mb-3">
                            <label for="slug_name">Slug</label>
                            <input type="text" name="slug_name" id="slug_name"
                                class="form-control @error('slug_name') is-invalid @enderror" value="{{ old('slug_name') }}"
                                required>
                            @error('slug_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Detail Unit --}}
                        <div class="form-group mb-3">
                            <label for="details">Detail</label>
                            <textarea name="details" id="details" class="form-control @error('details') is-invalid @enderror" rows="4">{{ old('details') }}</textarea>
                            @error('details')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Status Unit --}}
                        <div class="form-group mb-3">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control @error('status') is-invalid @enderror"
                                required>
                                <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Tidak Aktif
                                </option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Tombol Submit --}}
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('units.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
