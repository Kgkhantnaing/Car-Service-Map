@extends('layouts.default')
@section('content')
<div class="container-fluid">
    <div class="card shadow border-left-primary mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <ol class="breadcrumb py-0 my-0" style="background-color: transparent">
                <li class="breadcrumb-item"><a href="/home">Home</a></li>
                <li class="breadcrumb-item"><a href="/emergency_contact">Emergency Contact List</a></li>
                <li class="breadcrumb-item active" aria-current="page">Emergency Contact Detail</li>
            </ol>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <img src="{{$EC->image}}" alt="" width="100%" height="300px" class="rounded-image">

                    <div class="row no-gutters align-items-center text-center py-4">
                        <div class="col mr-2">
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><a href="/emergency_contact" class="btn btn-danger"><i class="fa fa-reply" aria-hidden="true"></i> Go Back</a></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card border-left-primary shadow py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Name</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{$EC->name}}</div>
                                </div>
                            </div>
                            <div class="row no-gutters align-items-center py-4">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Phone Number</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><a href="tel:{{$EC->phone}}" style="color:#5a5c69;">{{$EC->phone}}</a></div>
                                </div>
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Address</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{$EC->address}}</div>
                                </div>
                            </div>
                            <div class="row no-gutters align-items-center py-4">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Location</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{$EC->latitude}}, {{$EC->longitude}}</div>
                                </div>
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Category</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{$EC->category_name}}</div>
                                </div>
                            </div>
                            <div class="row no-gutters align-items-center pt-4">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        City</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{$EC->city}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
