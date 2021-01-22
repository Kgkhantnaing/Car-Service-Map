@extends('layouts.default')
@section('content')
<div class="container-fluid">
  <div class="card shadow border-left-primary mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <ol class="breadcrumb py-0 my-0" style="background-color: transparent">
          <li class="breadcrumb-item"><a href="/home">Home</a></li>
          <li class="breadcrumb-item"><a href="/shops">Shop List</a></li>
          <li class="breadcrumb-item active" aria-current="page">Create New Shop</li>
        </ol>
    </div>
    <div class="card-body">
    <form action="/shops/store" method="post" enctype="multipart/form-data">
        @csrf
        @if ($errors->any())
        @foreach ($errors->all() as $error)
        <div class="alert alert-danger" role="alert">
          {{$error}}
        </div>
        @endforeach
        @endif
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" value="{{old('name')}}" required id="name">
          </div>
          <div class="form-group col-md-6">
            <label for="name">Type Of Service</label>
            <select name="category" class="custom-select" required>
              <option value="">Select Category</option>
              @foreach($categoryList as $category)
              <option value="{{$category->id}}" {{ (old("category") == $category->id ? "selected":"") }}>{{$category->name}}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="latitude">Latitude</label>
            <input type="text" name="latitude" value="{{old('latitude')}}" class="form-control" required id="latitude">
          </div>
          <div class="form-group col-md-6">
            <label for="longitude">Longitude</label>
            <input type="text" name="longitude" value="{{old('longitude')}}" class="form-control" required id="longitude">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="phone">Phone No</label>
            <input type="number" name="phone" value="{{ old('phone') }}" class="form-control" required id="phone">
          </div>
          <div class="form-group col-md-6">
            <label for="selectCity">City</label>
            <!-- <input type="text" name="city" value="{{ old('city') }}" class="form-control" required id="city"> -->
            <select name="city" class="custom-select" required>
              <option value="">Select City</option>             
              @foreach($cityList as $city)
              <option value="{{$city->city_name}}" {{ (old("city") == $city->city_name ? "selected":"") }}>{{$city->city_name}}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="form-group">
          <label for="address">Address</label>
          <textarea name="address" class="form-control" required id="address">{{old('address')}}</textarea>
        </div>
        <div class="form-group">
          <label for="description">Car Service Center</label>
          <textarea name="description" class="form-control" id="description">{{ old('description') }}</textarea>
        </div>
        <div class="form-group">
          <input type="hidden" name="remark" value="{{ old('remark') }}" class="form-control" id="remark">
        </div>
        <div class="form-group">
          <label for="exampleFormControlFile1">Shop Image</label>
          <input type="file" name="shop_img" class="form-control-file" id="exampleFormControlFile1">
          <div class="invalid-feedback">Please select file</div>
        </div>
        <hr>
        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Create</button>
        <a href="/shops" class="btn btn-danger"><i class="fa fa-reply"></i> Back</a>
      </form>
    </div>
  </div>
</div>
@stop