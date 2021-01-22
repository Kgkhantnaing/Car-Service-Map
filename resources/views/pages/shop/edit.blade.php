@extends('layouts.default')
@section('content')
<div class="container-fluid">
  <div class="card shadow border-left-primary mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <ol class="breadcrumb py-0 my-0" style="background-color: transparent">
            <li class="breadcrumb-item"><a href="/home">Home</a></li>
            <li class="breadcrumb-item"><a href="/shops">Shops List</a></li>
            <li class="breadcrumb-item active" aria-current="page">Shop Edit</li>
        </ol>
    </div>
    <div class="card-body">
    <form action="/shops/update/{{$shop->id}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('POST')
        <div class="form-row">
          <div class="form-group col-md-6">
          <label for="name">Shop Name</label>
            <input type="text" name="name" class="form-control" required id="name" value="{{$shop->name}}">
          </div>
          <div class="form-group col-md-6">
            <label for="name">Type Of Service</label>
            <select name="category" class="custom-select" required>
                <option selected value="{{$selectedCategory->id}}">{{$selectedCategory->name}}</option>
                @foreach($categories as $category)
                <option value="{{$category->id}}">{{$category->name}}</option>
                @endforeach
            </select>
          </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="latitude">Latitude</label>
                <input type="text" name="latitude" class="form-control" required id="latitude" value="{{$shop->latitude}}">
            </div>
            <div class="form-group col-md-6">
                <label for="longitude">Longitude</label>
                <input type="text" name="longitude" class="form-control" required id="longitude" value="{{$shop->longitude}}">     
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="phone">Phone No</label>
                <input type="text" name="phone" class="form-control" required id="phone" value="{{$shop->phone_no}}">
            </div>
            <div class="form-group col-md-6">
                <label for="city">City </label>
                <select name="city" class="custom-select" required>
                    <!-- <option selected value="{{$shop->city}}">{{$shop->city}}</option>                     -->
                    @foreach($cityList as $item)
                    <option value="{{$item->city_name}}" {{ $shop->city == $item->city_name ? 'selected' : '' }}>{{$item->city_name}}</option>
                    @endforeach
                </select> 
            </div>
        </div>
        <div class="form-group">
            <label for="address">Address</label>
            <textarea name="address" class="form-control" required id="address">{{$shop->address}}</textarea>
        </div>
        <div class="form-group">
            <label for="description">Car Service Center</label>
            <textarea name="description" class="form-control" id="description">{{$shop->description}}</textarea>
        </div>
        <div class="form-group">
            <input type="hidden" name="remark" class="form-control" id="remark" value="{{$shop->remark}}">
        </div>
        <div class="form-group">
            <img src="{{$shop->image_url}}" alt="{{$shop->name}}" class="rounded" width="200" height="200"><br>
            <input type="hidden" name="shop_img_hidden" value="{{$shop->image_url}}">
            <label for="exampleFormControlFile1">Shop Image</label>
            <input type="file" name="shop_img" class="form-control-file" id="exampleFormControlFile1">
            <div class="invalid-feedback">Please select file</div>
        </div>
        <hr>
        <button type="submit" class="btn btn-info"><i class="fa fa-save"></i> Update</button>
        <a href="/shops" class="btn btn-danger"><i class="fa fa-reply"></i> Back</a>
    </form>
    </div>
  </div>
</div>

@stop