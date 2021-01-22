@extends('layouts.default')
@section('content')
<div class="container-fluid">
  <div class="card shadow border-left-primary mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <ol class="breadcrumb py-0 my-0" style="background-color: transparent">
        <li class="breadcrumb-item"><a href="/home">Home</a></li>
        <li class="breadcrumb-item"><a href="/city-categories">City List</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit Form</li>
        </ol>
    </div>
    <div class="card-body">
      <form action="/city-categories/update/{{$city->id}}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="city_name" value="{{old('city_name',$city->city_name)}}" class="form-control" required id="name">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="des">Description</label>
                    <input type="text" name="description" value="{{old('description',$city->description)}}" class="form-control" id="des">
                </div>
            </div>
        </div>

        <hr>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
  </div>
</div>
@stop