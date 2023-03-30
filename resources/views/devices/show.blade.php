@extends('dashboard.layout')
@section('title','Device | Location')
@section('content')

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
                <!-- Page body start --> 
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12 col-xl-12">
                            <!-- Basic map start -->
                            <div class="card" style="height: 520px">
                                <div class="card-header">
                                    <h5>Current Location (Map View)</h5>
                                    <button class="btn waves-effect waves-light btn-primary" onclick="myGeoFence()">View GeoFence</button>
                                    <a class="btn waves-effect waves-light btn-success" href="{{route('trip.history',$device->id)}}">
                                        {{ $device->name}} Trip Histroy
                                    </a>
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
<!-- Turf.js Libraries -->
<script src='https://unpkg.com/@turf/turf@6/turf.min.js'></script>

<script>

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

        //Marker for the user's current location - map view && street view
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
                polyline: false,
                rectangle: {
                    shapeOptions: {
                        color: 'green'
                    },
                },
                circle: false,
                marker: false,
            }
        });
        map.addControl(drawControl);

        map.on("draw:created",function(e){
            var type = e.layerType;
            var layer = e.layer;
            //console.log(layer.toGeoJSON);
            layer.bindPopup(JSON.stringify(layer.toGeoJSON()))
            var  feature = layer.toGeoJSON();
            // console.log(JSON.stringify(feature))

            //sets the default headers for all subsequent AJAX requests, including the CSRF token
            $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ route('geojson.store') }}",
                type: "POST",
                data: {
                    geojson: JSON.stringify(feature),
                    device_id: currentCoordinate[0].coordinates.id
                },
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });

            drawnItems.addLayer(layer);
            document.location.reload();
        });

        map.on("draw:edited",function(e){
            var type = e.layerType;
            var layers = e.layers;
            layers.eachLayer(function(layer){
                console.log(layer.toGeoJSON())
                var updatedGeoFence = layer.toGeoJSON();
                //Lets edit the geofence
                $.ajaxSetup({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{ route('geojson.store') }}",
                    type: "POST",
                    data: {
                        geojson: JSON.stringify(updatedGeoFence),
                        device_id: currentCoordinate[0].coordinates.id
                    },
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                });
            });
            
        });

    function myGeoFence() 
    {
        //displaying the geofences within the map
        if({!! json_encode($geofence) !!} !== null){
            var myData = {!! $geofence !!}
            L.geoJSON(myData).addTo(map);
        }else{
            alert("No geofence set")
        }    
    }    

    //setInterval(() => {
        var presentData = {!! json_encode($geofence) !!}
        if(presentData !== null) {
            var myType = {!! $geofence !!}
            type = myType.geometry.type
            // check if the point is within the polygon
            coordinates = turf.point([longitude, latitude])
            jsonData = {!!$geofence!!}
            poly = jsonData.geometry.coordinates[0]
            //console.log(poly)
            polygon = turf.polygon([poly])
            isInside = turf.booleanPointInPolygon(coordinates, polygon);
            console.log(isInside)
            if(!isInside)
            {
                console.log("Device Out of Designated Area")
                $.ajaxSetup({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                //Email notifications
                $.ajax({
                    url: "{{ route('geofence.alert') }}",
                    type: "POST",
                    data: {
                        user_id: {{auth()->user()->id}},
                        device_id: currentCoordinate[0].coordinates.id
                    },
                    success: function(response) {
                        console.log(response);
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                });

                // var url = "/send-sms?user=" + {{auth()->user()->id}} + "&device=" + currentCoordinate[0].coordinates.id;
                // var request = new XMLHttpRequest();
                // request.open('GET', url);
                // request.onload = function() {
                // if (request.status === 200) {
                //     console.log("sent")
                // } else {
                //     console.log("failed")
                // }
                // };
                // request.send();

                $.ajaxSetup({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                //Email notifications
                $.ajax({
                    url: "{{ route('send.sms') }}",
                    type: "POST",
                    data: {
                        user_id: {{auth()->user()->id}},
                        device_id: currentCoordinate[0].coordinates.id
                    },
                    success: function(response) {
                        console.log(response);
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                });
            }else{
                console.log("Device Still in Position")
            }
        }else{
            console.log("No geofence set")
        }
    //}, 5000);

</script>

@endpush