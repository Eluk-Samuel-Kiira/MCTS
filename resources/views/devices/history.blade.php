@extends('dashboard.layout')
@section('title','Location | History')
@section('content')

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"
integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM="
crossorigin=""></script>
<!-- Snake animation plugin -->
<script src="{{asset('assets/js/L.Polyline.SnakeAnim.js')}}"></script>
@endpush

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI="
crossorigin=""/>
@endsection

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
                            foreach ($files as $file) {
                                $fileName = basename($file);
                                $fileNameWithoutExt = pathinfo($fileName, PATHINFO_FILENAME);
                        @endphp    
                                <div class="col-lg-12 col-xl-4">
                                    <!-- Basic map start -->
                                    <div class="card">
                                        <div class="card-block">
                                            <div id="map-{{ $device->id }}-{{ $fileNameWithoutExt }}" class="set-map"></div>
                                        </div>
                                        <div class="card-header">
                                            <h5>Trip History
                                                <!-- <a href="{{ route('download', ['filename' => $filePath]) }}">Download File</a> -->
                                            </h5>
                                            <span>for {{ $device->name }} as of {{ $device->fileNameWithoutExt }} on
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
                                    var map = L.map(mapId).setView([0.37734, 32.6258], 10);
                                    // Add a tile layer to the map
                                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
                                        maxZoom: 18,
                                    }).addTo(map);

                                    fileContents = @json(file_get_contents($file));
                                    lines = fileContents.split('\n');

                                    var latlngs = [];
                                    for (var i = 0; i < lines.length; i++) {
                                        var line = lines[i].trim();
                                        if (line !== '') { //skip empty lines
                                            var data = JSON.parse(line);
                                            if (data) {
                                                for (var j = 0; j < data.length; j++) {
                                                    var item = data[j];
                                                    var latitude = item.latitude;
                                                    var longitude = item.longitude;
                                                    var device_id = item.device_id;
                                                    // Check if the current array exists in latlngs
                                                    if (!latlngs.some(function(arr) { return arr[0] === latitude && arr[1] === longitude; })) {
                                                        var marker = L.marker([latitude, longitude]).addTo(map);
                                                        latlngs.push([latitude, longitude]);
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    //set view to the latest coordinates on the file
                                    map.setView([latitude, longitude], 8);
                                    var roadLine = L.polyline(latlngs, { color: 'green', snakingSpeed: 200 }).addTo(map);
                                    roadLine.snakeIn();
                            
                                </script>
                        @endpush
                        @php
                            }
                        @endphp    
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
@endsection
