@extends('layouts.app')

@section('title', 'Perusahaan')


@section('main')

  

    <div class="page-wrapper">
        <div class="page-content">
            <div class="card">
                <form action="{{ route('companies.update', $company->id) }}" enctype="multipart/form-data" method="POST"
                    class="dropzone needsclick" id="dropzone-basic">
                    @csrf
                    @method('PUT')
                    <div class="card-body p-4">
                        
                       
                        <div class="row mb-3">
                        <h5 class="mb-3">Perusahaan</h5>
                        <div class="row mb-3">
                            <label for="input49" class="col-sm-3 col-form-label">Name</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <span class="input-group-text"><i class='bx bx-user'></i></span>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" value="{{ $company->name }}">
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
                                        name="email" value="{{ $company->email }}">
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
                                        name="address" value="{{ $company->address }}">
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
                                        name="latitude" value="{{ $company->latitude }}">
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
                                        name="longitude" value="{{ $company->longitude }}">
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
                                        name="radius_km" value="{{ $company->radius_km }}">
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
                                        name="time_in" value="{{ $company->time_in }}">
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
                                        name="time_out" value="{{ $company->time_out }}">
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
    
  <div class="card">
            <div class="card-body p-4">
                <!-- Peta -->
                <div class="row mb-3">
                    <label for="map" class="col-sm-3 col-form-label">Map Location</label>
                    <div class="col-sm-9">
                        <div id="map" style="height: 400px;"></div>
                        <!-- Input pencarian lokasi -->
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Leaflet CSS & JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <!-- Leaflet Control Geocoder -->
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css"/>

    <script>
    // Inisialisasi peta dengan koordinat dari company, atau koordinat default jika tidak ada
    var latitude = {{ $company->latitude ?? -6.200000 }};
    var longitude = {{ $company->longitude ?? 106.816666 }};
    var map = L.map('map').setView([latitude, longitude], 13);

    // Tambahkan tile layer dari OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: ''
    }).addTo(map);

    // Tambahkan marker pada lokasi perusahaan
    var marker = L.marker([latitude, longitude]).addTo(map);

    // Fungsi untuk memperbarui marker dan input latitude/longitude ketika peta diklik
    map.on('click', function (e) {
        var lat = e.latlng.lat;
        var lon = e.latlng.lng;

        marker.setLatLng([lat, lon]);

        // Perbarui input latitude dan longitude
        document.querySelector('input[name="latitude"]').value = lat;
        document.querySelector('input[name="longitude"]').value = lon;
    });

    // Inisialisasi geocoder
    var geocoder = L.Control.geocoder({
        defaultMarkGeocode: false
    }).addTo(map);

    // Fungsi untuk menangani hasil pencarian
    geocoder.on('markgeocode', function(e) {
        var latlng = e.geocode.center;
        map.setView(latlng, 13);
        marker.setLatLng(latlng);

        // Perbarui input latitude dan longitude
        document.querySelector('input[name="latitude"]').value = latlng.lat;
        document.querySelector('input[name="longitude"]').value = latlng.lng;
    });

    // Event listener untuk input pencarian
    document.getElementById('searchBox').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            var query = this.value;
            geocoder.geocode(query);
        }
    });
</script>
@endsection
