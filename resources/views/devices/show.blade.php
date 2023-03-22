@extends('dashboard.layout')
@section('title','Device | Location')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

@if(auth()->user()->role == 1 && $device->status == 0)
    <div class="pcoded-inner-content">
        <!-- Primary-color Breadcrumb card start -->
        <div class="card borderless-card">
            <div class="card-block primary-breadcrumb">
                <div class="breadcrumb-header">
                    <h5>Hello! {{auth()->user()->name}}, Your Device, registered as <u><b>{{$device->name}}</b></u> has been Temporarily suspended</h5>
                    <span>Try contacting your system administrators for reinstatement to access our services</span>
                </div>
            </div>
        </div>
        <!-- Primary-color Breadcrumb card end -->
    </div>
@else
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <a class="btn waves-effect waves-light btn-success" href="{{route('trip.history',$device->id)}}">
                    Device {{ $device->name}} Trip Histroy
                </a> 
                <a class="btn waves-effect waves-light btn-success" href="{{route('locations.store')}}">
                    Device {{ $device->name}} Trip Histroy
                </a> 
                <!-- Page body start --> 
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12 col-xl-12">
                            <!-- Basic map start -->
                            <div class="card" style="height: 520px">
                                <div class="card-header">
                                    <h5>Current Location (Map View)</h5>
                                    <span>for {{ $device->name}} as of {{ $timeNow }}</span>
                                </div>
                                <div class="card-block">
                                    <div id="map" class="set-map"></div>
                                </div>
                            </div>
                            <!-- Basic map end -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-xl-12">
                            <!-- Basic map start -->
                            <div class="card" style="height: 520px">
                                <div class="card-header">
                                    <h5>Current Location (Street View)</h5>
                                    <span>for {{ $device->name}} as of {{ $timeNow }}</span>
                                </div>
                                <div class="card-block">
                                    <div id="map2" class="set-map"></div>
                                </div>
                            </div>
                            <!-- Basic map end -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- Page body end -->
        </div>
    </div>
@endif

@endsection
@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI="
crossorigin=""/>
@endsection
@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"
integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM="
crossorigin=""></script>
<!-- leaflet draw Plugin -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/0.4.2/leaflet.draw.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/0.4.2/leaflet.draw.js"></script>

<script>
    'use strict';
    $(document).ready(function() {

        var currentCoordinate = @json($currentCoordinate);
        var latitude = currentCoordinate[0].latitude;
        var longitude = currentCoordinate[0].longitude;
        //console.log(longitude);

        //Map view
        var map;
        map = L.map('map');
        map.setView([latitude, longitude], 13);

        //For street view
        var map2;
        map2 = L.map('map2');
        map2.setView([latitude, longitude], 13);

        //Map view continues
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        //for street view
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map2);

        //Marker for the user's current location - map view
        var marker = L.marker([latitude, longitude]).addTo(map);
        var mark = L.marker([latitude, longitude]).addTo(map2);

        //Map view
        marker.on('click', mapClick);
        var pop = L.popup();

        function mapClick(e) {
            pop
                .setLatLng(e.latlng)
                .setContent("The current location of " +currentCoordinate[0].coordinates.name+ " is " + e.latlng.toString())
                .openOn(map);
        }

        //Street view
        mark.on('click', streetClick);
        var popup = L.popup();
        function streetClick(e) {
            popup
                .setLatLng(e.latlng)
                .setContent("The current location of " +currentCoordinate[0].coordinates.name+ " is " + e.latlng.toString())
                .openOn(map2);
        }

        //google street view
        var googleStreets = L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}',{
            maxZoom: 20,
            subdomains:['mt0','mt1','mt2','mt3']
        });
        googleStreets.addTo(map2);

        //google satellite
        var googleSat = L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}',{
            maxZoom: 20,
            subdomains:['mt0','mt1','mt2','mt3']
        });
        googleSat.addTo(map2);
        

        //leaflet.draw to help in Geo-fencing techniques
        var drawnItems = new L.FeatureGroup();
        map.addLayer(drawnItems);
        
        var drawControl = new L.Control.Draw({
            position: "topright",
            edit: {
                featureGroup: drawnItems
            },
            draw: {
                polygon: {

                    shapeOptions: {
                        color: 'purple'
                    },
                },
                polyline: {
                    shapeOptions: {
                        color: 'red'
                    },
                },
                rectangle: {
                    shapeOptions: {
                        color: 'green'
                    },
                },
                circle: {
                    shapeOptions: {
                        color: 'steelblue'
                    },
                },
            }
        });
        map.addControl(drawControl);

        map.on("draw:created",function(e){
            var type = e.layerType;
            var layer = e.layer;
            //console.log(layer.toGeoJSON);
            layer.bindPopup(JSON.stringify(layer.toGeoJSON()))
            var  feature = layer.toGeoJSON();
            fetch('{{route('locations.store')}}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                body: JSON.stringify(feature)
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                // Handle success response
                console.log('Success:', response);
            })
            .catch(error => {
                // Handle error response
                console.error('Error:', error);
            });
            //console.log(JSON.stringify(feature))
            drawnItems.addLayer(layer);
        });

        map.on("draw:edited",function(e){
            var type = e.layerType;
            var layers = e.layers;
            layers.eachLayer(function(layer){
                //console.log(layer);
            });
            
        });
        
    });

    
</script>

@endpush