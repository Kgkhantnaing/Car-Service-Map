@extends('layouts.default')
@section('content')
<div class="container-fluid">
  <div class="card shadow border-left-primary mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <ol class="breadcrumb py-0 my-0" style="background-color: transparent">
          <li class="breadcrumb-item"><a href="/home">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">Create Category</li>
        </ol>
    </div>
    <div class="card-body">
      <form action="/categories/store" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
          <label for="name">Name</label>
          <input type="text" name="name" class="form-control" required id="name">
        </div>
        <button type="submit" class="btn btn-success"><i class="fa fa-save" aria-hidden="true"></i> Create</button>
        <a href="/categories" class="btn btn-danger"><i class="fa fa-reply" aria-hidden="true"></i> Back</a>
      </form>
    </div>
  </div>
</div>
@stop
