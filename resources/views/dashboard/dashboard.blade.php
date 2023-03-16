@if(auth()->user()->role==2 && auth()->user()->status==1)
    @extends('dashboard.layout')
    @section('title','Dashboard | MCTS')
    @section('content')

        <div class="pcoded-inner-content">
            <!-- Main-body start -->
            <div class="main-body">
                <div class="page-wrapper">
                    <!-- Page-body start -->
                    <div class="page-body">
                        <div class="row">
                            <!-- Material statustic card start -->
                            <div class="col-xl-4 col-md-12">
                                <div class="card mat-stat-card">
                                    <div class="card-block">
                                        <div class="row align-items-center b-b-default">
                                            <div class="col-sm-6 b-r-default p-b-20 p-t-20">
                                                <div class="row align-items-center text-center">
                                                    <div class="col-4 p-r-0">
                                                        <i class="far fa-user text-c-purple f-24"></i>
                                                    </div>
                                                    <div class="col-8 p-l-0">
                                                        <h5>{{$unique_vistors}}</h5>
                                                        <p class="text-muted m-b-0">New Visitors</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 p-b-20 p-t-20">
                                                <div class="row align-items-center text-center">
                                                    <div class="col-4 p-r-0">
                                                        <i class="far fa-user text-c-purple f-24"></i>
                                                    </div>
                                                    <div class="col-8 p-l-0">
                                                        <h5>{{$user_count}}</h5>
                                                        <p class="text-muted m-b-0">Users</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row align-items-center">
                                            <div class="col-sm-6 p-b-20 p-t-20 b-r-default">
                                                <div class="row align-items-center text-center">
                                                    <div class="col-4 p-r-0">
                                                        <i class="far fa-file-alt text-c-red f-24"></i>
                                                    </div>
                                                    <div class="col-8 p-l-0">
                                                        <h5>{{$user_orders}}</h5>
                                                        <p class="text-muted m-b-0">New Orders</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 p-b-20 p-t-20">
                                                <div class="row align-items-center text-center">
                                                    <div class="col-4 p-r-0">
                                                        <i class="far fa-user text-c-purple f-24"></i>
                                                    </div>
                                                    <div class="col-8 p-l-0">
                                                        <h5>{{$session_count}}</h5>
                                                        <p class="text-muted m-b-0">Sessions</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-12">
                                <div class="card mat-stat-card">
                                    <div class="card-block">
                                        <div class="row align-items-center b-b-default">
                                            <div class="col-sm-6 b-r-default p-b-20 p-t-20">
                                                <div class="row align-items-center text-center">
                                                    <div class="col-4 p-r-0">
                                                        <i class="fas fa-share-alt text-c-purple f-24"></i>
                                                    </div>
                                                    <div class="col-8 p-l-0">
                                                        <h5>1000</h5>
                                                        <p class="text-muted m-b-0">Share</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 p-b-20 p-t-20">
                                                <div class="row align-items-center text-center">
                                                    <div class="col-4 p-r-0">
                                                        <i class="fas fa-sitemap text-c-green f-24"></i>
                                                    </div>
                                                    <div class="col-8 p-l-0">
                                                        <h5>600</h5>
                                                        <p class="text-muted m-b-0">Network</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row align-items-center">
                                            <div class="col-sm-6 p-b-20 p-t-20 b-r-default">
                                                <div class="row align-items-center text-center">
                                                    <div class="col-4 p-r-0">
                                                        <i class="fas fa-signal text-c-red f-24"></i>
                                                    </div>
                                                    <div class="col-8 p-l-0">
                                                        <h5>350</h5>
                                                        <p class="text-muted m-b-0">Returns</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 p-b-20 p-t-20">
                                                <div class="row align-items-center text-center">
                                                    <div class="col-4 p-r-0">
                                                        <i class="fas fa-wifi text-c-blue f-24"></i>
                                                    </div>
                                                    <div class="col-8 p-l-0">
                                                        <h5>100%</h5>
                                                        <p class="text-muted m-b-0">Connections</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-12">
                                <div class="card mat-clr-stat-card text-white green ">
                                    <div class="card-block">
                                        <div class="row">
                                            <div class="col-3 text-center bg-c-green">
                                                <i class="fas fa-star mat-icon f-24"></i>
                                            </div>
                                            <div class="col-9 cst-cont">
                                                <h5>4000+</h5>
                                                <p class="m-b-0">Ratings Received</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card mat-clr-stat-card text-white blue">
                                    <div class="card-block">
                                        <div class="row">
                                            <div class="col-3 text-center bg-c-blue">
                                                <i class="fas fa-trophy mat-icon f-24"></i>
                                            </div>
                                            <div class="col-9 cst-cont">
                                                <h5>17</h5>
                                                <p class="m-b-0">Achievements</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Material statustic card end -->
                            <!--  sale analytics start -->
                            <div class="col-xl-6 col-md-12">
                                <div class="card table-card">
                                    <div class="card-header">
                                        <h5>Active Users</h5>
                                    </div>
                                    <div class="card-block">
                                        <div class="table-responsive">
                                            <table class="table table-hover m-b-0 without-header">
                                                <tbody>
                                                @forelse($registered_users as $user)
                                                    <tr>
                                                        <td>
                                                            <div class="d-inline-block align-middle">
                                                                <img src="assets/images/avatar-4.jpg" alt="user image" class="img-radius img-40 align-top m-r-15">
                                                                <div class="d-inline-block">
                                                                    <h6>{{ $user->name }}</h6>
                                                                    <p class="text-muted m-b-0">{{ $user->location }}</p>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-right">
                                                            <h6 class="f-w-700">@if($user->role == 1){{__('Normal User')}} @elseif($user->role == 2) {{__('Administrator')}} @else{{('No Role')}} @endif<i class="fas fa-level-up-alt text-c-green m-l-10"></i></h6>
                                                        </td>
                                                    </tr>
                                                @empty  
                                                    <div class="d-inline-block align-middle">
                                                        <img src="assets/images/avatar-4.jpg" alt="user image" class="img-radius img-40 align-top m-r-15">
                                                        <div class="d-inline-block">
                                                            <h6>{{ ('None is active') }}</h6>
                                                        </div>
                                                    </div>
                                                @endforelse  
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-12">
                                <div class="row">
                                    <!-- sale card start -->

                                    <div class="col-md-6">
                                        <div class="card text-center order-visitor-card">
                                            <div class="card-block">
                                                <h6 class="m-b-0">Total Subscription</h6>
                                                <h4 class="m-t-15 m-b-15"><i class="fa fa-arrow-down m-r-15 text-c-red"></i>7652</h4>
                                                <p class="m-b-0">48% From Last 24 Hours</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card text-center order-visitor-card">
                                            <div class="card-block">
                                                <h6 class="m-b-0">Order Status</h6>
                                                <h4 class="m-t-15 m-b-15"><i class="fa fa-arrow-up m-r-15 text-c-green"></i>6325</h4>
                                                <p class="m-b-0">36% From Last 6 Months</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card bg-c-red total-card">
                                            <div class="card-block">
                                                <div class="text-left">
                                                    <h4>489</h4>
                                                    <p class="m-0">Total Comment</p>
                                                </div>
                                                <span class="label bg-c-red value-badges">15%</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card bg-c-green total-card">
                                            <div class="card-block">
                                                <div class="text-left">
                                                    <h4>$5782</h4>
                                                    <p class="m-0">Income Status</p>
                                                </div>
                                                <span class="label bg-c-green value-badges">20%</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card text-center order-visitor-card">
                                            <div class="card-block">
                                                <h6 class="m-b-0">Unique Visitors</h6>
                                                <h4 class="m-t-15 m-b-15"><i class="fa fa-arrow-down m-r-15 text-c-red"></i>652</h4>
                                                <p class="m-b-0">36% From Last 6 Months</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card text-center order-visitor-card">
                                            <div class="card-block">
                                                <h6 class="m-b-0">Monthly Earnings</h6>
                                                <h4 class="m-t-15 m-b-15"><i class="fa fa-arrow-up m-r-15 text-c-green"></i>5963</h4>
                                                <p class="m-b-0">36% From Last 6 Months</p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- sale card end -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Page-body end -->
                </div>
                <div id="styleSelector"> </div>
            </div>
        </div>

    @endsection
@else
    <script>
        window.location.href = "{{route('devices.index')}}";
    </script>
@endif
