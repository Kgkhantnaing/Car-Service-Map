@extends('layouts.default')
@section('content')
<div class="container-fluid">
  <div class="card shadow border-left-primary mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <ol class="breadcrumb py-0 my-0" style="background-color: transparent">
            <li class="breadcrumb-item"><a href="/home">Home</a></li>
            <li class="breadcrumb-item"><a href="/admins">Admins</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create New Admin</li>
        </ol>
    </div>
    <div class="card-body">
        <form action="/admins/store" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="form-control" required id="name">
                </div>
                <div class="form-group col-md-4">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" required id="email">
                </div>
                <div class="form-group col-md-4">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control" required id="password">
                </div>
            </div>
            <hr>
            <button type="submit" class="btn btn-success"><i class="fa fa-save" aria-hidden="true"></i> Create</button>
            <a href="/admins" class="btn btn-danger"><i class="fa fa-reply" aria-hidden="true"></i> Back</a>
        </form>
    </div>
  </div>
</div>
@stop