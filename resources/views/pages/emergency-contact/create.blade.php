@extends('layouts.default')
@section('content')
    <div class="container-fluid">
        <div class="card shadow border-left-primary mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <ol class="breadcrumb py-0 my-0" style="background-color: transparent">
                    <li class="breadcrumb-item"><a href="/home">Home</a></li>
                    <li class="breadcrumb-item"><a href="/emergency_contact">Emergency Contact List</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Create Emergency Contact</li>
                </ol>
            </div>
            <div class="card-body">
                <form action="{{url('/emergency_contact/store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @if ($errors->any())
                    @foreach ($errors->all() as $error)
                    <div class="alert alert-danger" role="alert">
                      {{$error}}
                    </div>
                    @endforeach
                    @endif
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" value="{{old('name')}}" class="form-control" required id="name">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="text" name="phone" value="{{old('phone')}}" class="form-control" required id="phone" placeholder="09xxxxxxxxx">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="latitude">Latitude</label>
                                <input type="text" name="latitude" value="{{old('latitude')}}" class="form-control" required id="latitude">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="longitude">Longitude</label>
                                <input type="text" name="longitude" value="{{old('longitude')}}" class="form-control" required id="longitude">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Select City</label>
                                <select name="city" id="city" class="form-control">
                                    @foreach ($city_list as $item)
                                        <option value="{{$item->city_name}}" {{ (old("city") == $item->city_name ? "selected":" ") }}>{{$item->city_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="category_id">Select Category</label>
                                <select name="category_id" id="category_id" class="form-control">
                                    @foreach ($category_list as $item)
                                        <option value="{{$item->id}}" {{ (old("category_id") == $item->id ? "selected":" ") }}>{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea rows="6" name="address" class="form-control" id="address">{{old('address')}}</textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="image">Image</label>
                                <input type="file" name="image" value="{{old('image')}}" class="form-control" required id="image">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success"><i class="fa fa-save" aria-hidden="true"></i>
                        Create</button>
                    <a href="/emergency_contact" class="btn btn-danger"><i class="fa fa-reply" aria-hidden="true"></i> Back</a>
                </form>
            </div>
        </div>
    </div>
@stop
