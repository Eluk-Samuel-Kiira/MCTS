@extends('dashboard.layout')
@section('title','Dashboard | Devices')
@section('content')
@if(auth()->user()->status==1 && auth()->user()->role==2)
<!-- Hover table card start -->
<div class="col-sm-12">
    <div class="card">
        <div class="card-header">
            <h5>Devices Table</h5>
            <a class="btn waves-effect waves-light btn-success" href="{{route('devices.create')}}">
                <i class="fas fa-pencil-alt"></i>
                Add Device
            </a>    
            <span>These are Devices Registered in the System</span>
            @if(session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <div class="card-header-right">
                <ul class="list-unstyled card-option">
                    <li><i class="fa fa fa-wrench open-card-option"></i></li>
                    <li><i class="fa fa-window-maximize full-card"></i></li>
                    <li><i class="fa fa-minus minimize-card"></i></li>
                    <li><i class="fa fa-refresh reload-card"></i></li>
                    <li><i class="fa fa-trash close-card"></i></li>
                </ul>
            </div>
        </div>
        <div class="card-block table-border-style">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Full Names</th>
                            <th>Email</th>
                            <th>Location</th>
                            <th>Role</th>
                            <th>Date Created</th>
                            <th>Status</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>    
<!-- Hover table card end -->
@elseif(auth()->user()->status==1 && auth()->user()->role==1)
// Your devices here
@else
    <div class="pcoded-inner-content">
        <!-- Primary-color Breadcrumb card start -->
        <div class="card borderless-card">
            <div class="card-block primary-breadcrumb">
                <div class="breadcrumb-header">
                    <h5>Hello! {{auth()->user()->name}}, Your Account has been Temporarily suspended</h5>
                    <span>Either your account is not activated or you have not been assigned a role</span>
                    <span>Try contacting your system administrators for reinstatement to access our services</span>
                </div>
            </div>
        </div>
        <!-- Primary-color Breadcrumb card end -->
    </div>
@endif
@endsection