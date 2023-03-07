@extends('dashboard.layout')
@section('title','Dashboard | Devices')
@section('content')
@if(auth()->user()->status==1)
<div class="pcoded-inner-content">

    //Your devices here<br>
    if admin display all the available devices for an admin
    else display only devices for a specific user
</div>
@else
<div class="pcoded-inner-content">
    <!-- Primary-color Breadcrumb card start -->
    <div class="card borderless-card">
        <div class="card-block primary-breadcrumb">
            <div class="breadcrumb-header">
                <h5>Hello! {{auth()->user()->name}}, Your Account has been Temporarily suspended</h5>
                <span>Try contacting your system administrators for reinstatement to access our services</span>
            </div>
        </div>
    </div>
    <!-- Primary-color Breadcrumb card end -->
</div>
@endif
@endsection