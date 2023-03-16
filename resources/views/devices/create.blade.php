@extends('dashboard.permit')
@extends('dashboard.layout')
@section('title','Device | Create')
@section('content')
@if(auth()->user()->status==1 && auth()->user()->role!=0)
<div class="col-sm-12">
    <div class="card">
        <div class="card-header">
            <h5>Material Form Inputs</h5>
            <!--<span>Add class of <code>.form-control</code> with <code>&lt;input&gt;</code> tag</span>-->
        </div>
        <div class="card-block">
            <form class="form-material">
                <div class="form-group form-default">
                    <input type="text" name="name" class="form-control">
                    <span class="form-bar"></span>
                    <label class="float-label">Device Name</label>
                </div>
                <div class="form-group form-default">
                    <select name="role" class="form-control" required>
                        <option value="0"></option>
                        <option value="1">Normal User</option>
                        <option value="2">Administrator</option>
                    </select>
                    <span class="form-bar"></span>
                    <label class="float-label">Parent/Next of Kin</label>
                </div>
                <button type="submit" class="btn waves-effect waves-light btn-success"><i class="icofont icofont-user-alt-3"></i> Register</button>
            </form>
        </div>
    </div>
</div>

@endif
@endsection