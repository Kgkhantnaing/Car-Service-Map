@extends('layouts.default')
@section('content')
<div class="container" style="margin-top: 2%">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="background-color: transparent">
            <li class="breadcrumb-item"><a href="/home">Home</a></li>
            <li class="breadcrumb-item"><a href="/shops">Shops List</a></li>
            <li class="breadcrumb-item active" aria-current="page">Shop Edit</li>
        </ol>
    </nav>
    <form action="/shops/update/{{$shop->id}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('POST')
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" required id="name" value="{{$shop->name}}">
        </div>
        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" name="address" class="form-control" required id="address" value="{{$shop->address}}">
        </div>
        <div class="form-group">
            <label for="latitude">Latitude</label>
            <input type="text" name="latitude" class="form-control" required id="latitude" value="{{$shop->latitude}}">
        </div>
        <div class="form-group">
            <label for="longitude">Longitude</label>
            <input type="text" name="longitude" class="form-control" required id="longitude" value="{{$shop->longitude}}">
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" class="form-control" required id="description">{{$shop->description}}</textarea>
        </div>
        <div class="form-group">
            <label for="phone">Phone No</label>
            <input type="text" name="phone" class="form-control" required id="phone" value="{{$shop->phone_no}}">
        </div>
        <div class="form-group">
            <label for="city">City</label>
            <input type="text" name="city" class="form-control" required id="city" value="{{$shop->city}}">
        </div>
        <div class="form-group">
            <label for="remark">Remark</label>
            <input type="text" name="remark" class="form-control" id="remark" value="{{$shop->remark}}">
        </div>
        <div class="form-group">
            <select name="category" class="custom-select" required>
                <option selected value="{{$selectedCategory->id}}">{{$selectedCategory->name}}</option>
                @foreach($categories as $category)
                <option value="{{$category->id}}">{{$category->name}}</option>
                @endforeach
            </select>
            <div class="invalid-feedback">Example invalid custom select feedback</div>
        </div>
        <div class="form-group">
            <img src="{{$shop->image_url}}" alt="{{$shop->name}}" class="rounded" width="200" height="200"><br>
            <input type="hidden" name="shop_img_hidden" value="{{$shop->image_url}}">
            <label for="exampleFormControlFile1">Shop Image</label>
            <input type="file" name="shop_img" class="form-control-file" id="exampleFormControlFile1">
            <div class="invalid-feedback">Please select file</div>
        </div>
        <hr>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@stop