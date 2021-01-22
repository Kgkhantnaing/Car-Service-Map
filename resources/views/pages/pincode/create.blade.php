@extends('layouts.default')
@section('content')
<div class="container-fluid">
  <div class="card shadow border-left-primary mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <ol class="breadcrumb py-0 my-0" style="background-color: transparent">
          <li class="breadcrumb-item"><a href="/home">Home</a></li>
          <li class="breadcrumb-item"><a href="/pincodes">Pins List</a></li>
          <li class="breadcrumb-item active" aria-current="page">Pin Create</li>
        </ol>
    </div>
    <div class="card-body">
      <form action="/pincodes" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-row">
          <div class="form-group col-md-4">
            <label for="name">Number of Pincode</label>
            <input type="number" name="pin" class="form-control" required id="name">
          </div>
          <div class="form-group col-md-4">
            <label for="lucky_draw_amount">Lucky Draw Amout</label>
            <input type="number" name="lucky_draw_amount" class="form-control" required id="lucky_draw_amount">
          </div>
          <div class="form-group col-md-4">
            <label for="product_code">Product Code</label>
            <input type="text" name="product_code" class="form-control" required id="product_code">
          </div>
        </div>
        <hr>
        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Create</button>
        <a href="/pincodes" class="btn btn-danger"><i class="fa fa-reply"></i> Back</a>
    </form>
    </div>
  </div>
</div>
@stop