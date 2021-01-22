@extends('layouts.default')
@section('content')
<div class="container" style="margin-top: 2%">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb" style="background-color: transparent">
      <li class="breadcrumb-item"><a href="/home">Home</a></li>
      <li class="breadcrumb-item active" aria-current="page">Shop Create</li>
    </ol>
  </nav>
  <h3>Create New Shop</h3>
  <br>
  <form action="/shops/store" method="post" enctype="multipart/form-data">
    @csrf
    @if ($errors->any())
    @foreach ($errors->all() as $error)
    <div class="alert alert-danger" role="alert">
      {{$error}}
    </div>
    @endforeach
    @endif
    <div class="form-group">
      <label for="name">Name</label>
      <input type="text" name="name" class="form-control" value="{{old('name')}}" required id="name">
    </div>
    <div class="form-group">
      <label for="address">Address</label>
      <input type="text" name="address" class="form-control" required id="address" value="{{old('address')}}">
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
    <!-- <div class="form-group">
      <label for="latitude">Latitude</label>
      <input type="text" name="latitude" class="form-control" required id="latitude">
    </div>
    <div class="form-group">
      <label for="longitude">Longitude</label>
      <input type="text" name="longitude" class="form-control" required id="longitude">
    </div> -->
    <div class="form-group">
      <label for="description">Car Service Center</label>
      <textarea name="description" class="form-control" id="description">{{ old('description') }}</textarea>
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
          <option value="">Select Category</option>
          <?php
          $cityList = [
            'Yangon', 'Mandalay', 'Naypyidaw', 'Taunggyi', 'Mawlamyine', 'Mawlamyine', 'Bago',
            'Myitkyina', 'Monywa', 'Pathein', 'Pyay', 'Myeik', 'Meiktila', 'Pakokku', 'Taungoo', 'Sittwe', 'Magway', 'Myingyan',
            'Thanlyin', 'Hinthada', 'Sagaing', 'Dawei', 'Mogok', 'Shwebo', 'Nyaunglebin', 'Bhamo', 'Aunglan', 'Yenangyaung', 'Bogale',
            'Hlegu', 'Minbu', 'Tharrawaddy', 'Hakha', 'Thayet', 'Nyaung Oo', 'Tarchileik', 'Aung Pan', 'Shwe Nyaung', 'Nyaung Shwe', 'Yatsawk', 'Pinlon',
            'Pinlaung', 'Kalaw', 'Hopong',
            'Pyinmana','TatKone','Lewe','Pyi Oo Lwin','HeHo','Kholen','Naung Cho','Lashio','Myaung Mya','Yae Kyi','Kyeik hto','Phayargyi','Hmawbi'
          ];
          $cityList = collect($cityList);
          $sortedCityList = $cityList->sort();
          ?>
          @foreach($sortedCityList as $city)
          <option value="{{$city}}" {{ (old("category") == $city ? "selected":"") }}>{{$city}}</option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="form-group">
      <label for="remark">Remark</label>
      <input type="text" name="remark" value="{{ old('remark') }}" class="form-control" id="remark">
    </div>
    <div class="form-group">
      <select name="category" class="custom-select" required>
        <option value="">Select Category</option>
        @foreach($categoryList as $category)
        <option value="{{$category->id}}" {{ (old("category") == $category->id ? "selected":"") }}>{{$category->name}}</option>
        @endforeach
      </select>
      <div class="invalid-feedback">Example invalid custom select feedback</div>
    </div>
    <div class="form-group">
      <label for="exampleFormControlFile1">Shop Image</label>
      <input type="file" name="shop_img" class="form-control-file" id="exampleFormControlFile1">
      <div class="invalid-feedback">Please select file</div>
    </div>
    <hr>
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
</div>



@stop