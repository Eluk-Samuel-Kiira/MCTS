@extends('dashboard.layout')
@section('title','Location | History')
@section('content')

<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="page-wrapper">
            <!-- Page body start -->
            <div class="page-body">
                <div class="row">
                    <div class="col-lg-12 col-xl-4">
                        <!-- Basic map start -->
                        <div class="card" style="height: 520px">
                            <div class="card-header">
                                <h5>Trip History</h5>
                                <span>for {{ $deviceHistory->name }} as of {{ $deviceHistory->updated_at }}</span>
                            </div>
                            <div class="card-block">
                                <div id="map" class="set-map"></div>
                            </div>
                        </div>
                        <!-- Basic map end -->
                    </div>
                    <div class="col-lg-12 col-xl-4">
                        <!-- Basic map start -->
                        <div class="card" style="height: 520px">
                            <div class="card-header">
                                <h5>Trip History</h5>
                                <span>for {{ $deviceHistory->name }} as of {{ $deviceHistory->updated_at }}</span>
                            </div>
                            <div class="card-block">
                                <div id="map" class="set-map"></div>
                            </div>
                        </div>
                        <!-- Basic map end -->
                    </div>
                    <div class="col-lg-12 col-xl-4">
                        <!-- Basic map start -->
                        <div class="card" style="height: 520px">
                            <div class="card-header">
                                <h5>Trp History</h5>
                                <span>for {{ $deviceHistory->name }} as of {{ $deviceHistory->updated_at }}</span>
                            </div>
                            <div class="card-block">
                                <div id="map" class="set-map"></div>
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

<script>
    'use strict';
    $(document).ready(function() {

        
        //Map view
        var map;
        map = L.map('map');
        map.setView([0.339730, 32.562191], 13);

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

    
    });
    
</script>

@endpush