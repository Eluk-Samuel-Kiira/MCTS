@extends('dashboard.layout')
@section('title', 'Location | History')
@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
          integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI="
          crossorigin=""/>
@endsection
@section('content')

<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="page-wrapper">
            <!-- Page body start -->
            <div class="page-body">
                <div class="row">
                    @forelse($devices as $device)
                        @php
                            $filePath = storage_path('app/public/TripHistories/'.$device->user.'/'.$device->id.'/');
                            $files = glob($filePath . '*.txt');
                        @endphp    
                        @foreach($files as $file)
                            @php
                                $fileName = basename($file);
                                $fileNameWithoutExt = pathinfo($fileName, PATHINFO_FILENAME);
                            @endphp
                            <div class="col-lg-12 col-xl-4">
                                <!-- Basic map start -->
                                <div class="card">
                                    <div class="card-block">
                                        <!-- Add a div with a unique ID for each map -->
                                        <div id="map-{{ $device->id }}-{{ $fileNameWithoutExt }}" class="set-map"
                                             style="height: 400px;"></div>
                                    </div>
                                    <div class="card-header">
                                        <h5>Trip History
                                            <!-- <a href="{{ route('download', ['filename' => $filePath]) }}">Download File</a> -->
                                        </h5>
                                        <span>for {{ $device->name }} as of {{ $fileNameWithoutExt }} on
                                            @php
                                                $day = \Carbon\Carbon::parse($fileNameWithoutExt)->format('l');
                                            @endphp
                                            {{ $day }}
                                        </span>
                                    </div>
                                </div>
                                <!-- Basic map end -->
                            </div>
                            @push('scripts')
                                <script>
                                    // Use a unique map ID based on device ID and file name
                                    var mapId = "map-{{ $device->id }}-{{ $fileNameWithoutExt }}";

                                    // Initialize a new map
                                    var map = L.map(mapId).setView([0, 0], 13);

                                    // Add a tile layer to the map
                                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
                                        maxZoom: 18,
                                    }).addTo(map);

                                    // Add markers or other map layers based on the JSON data
                                    // Replace the code below with your own logic to add markers or layers
                                    // based on the JSON data for each map

                                    // Example code to add a marker
                                    L.marker([51.5, -0.09]).addTo(map);
                                </script>
                            @endpush
                        @endforeach
                    @empty
                        <div class="alert alert-Danger">
                            {{ __('No Device History Available') }}
                        </div>
                    @endforelse 
                </div>
            </div>
        </div>
        <!-- Page body end -->
    </div>
</div>

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"
            integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM="
            crossorigin=""></script>
    <!-- Snake animation plugin -->
    <script src="{{asset('assets/js/L.Polyline.SnakeAnim.js')}}"></script>
@endpush

@endsection
