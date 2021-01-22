@extends('layouts.default')
@section('content')
<div class="container-fluid">
  <div class="card shadow border-left-primary mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <ol class="breadcrumb py-0 my-0" style="background-color: transparent">
        <li class="breadcrumb-item"><a href="/home">Home</a></li>
        <li class="breadcrumb-item"><a href="/categories">Categories List</a></li>
        <li class="breadcrumb-item active" aria-current="page">Categories Edit</li>
        </ol>
    </div>
    <div class="card-body">
      <form action="/categories/update/{{$cat->id}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
          <label for="name">Name</label>
          <input type="text" name="name" class="form-control" value="{{$cat->name}}" required id="name">
        </div>

        <hr>
        <button type="submit" class="btn btn-info"><i class="fa fa-save"></i> Update</button>
        <a href="/categories" class="btn btn-danger"><i class="fa fa-reply"></i> Back</a>
      </form>
    </div>
  </div>
</div>
@stop