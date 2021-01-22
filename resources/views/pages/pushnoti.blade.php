@extends('layouts.default')
@section('content')
<div class="container-fluid">
  <div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <ol class="breadcrumb py-0 my-0" style="background-color: transparent">
            <li class="breadcrumb-item"><a href="/home">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Notification</li>
        </ol>
    </div>
    <div class="card-body">
        <form action="/customers/noti/send" method="post">
            @csrf
            @if ($errors->any())
            @foreach ($errors->all() as $error)
            <div class="alert alert-danger" role="alert">
                {{$error}}
            </div>
            @endforeach
            @endif
            <div class="form-group">
                <label for="title">Message Title</label>
                <input name="title" type="title" class="form-control" id="title" aria-describedby="titleHelp" required>
            </div>
            <div class="form-group">
                <label for="description">Message Description</label>
                <textarea name="description" class="form-control" id="description" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-success"><i class="fa fa-paper-plane" aria-hidden="true"></i> Send</button>
        </form>
    </div>
  </div>
</div>
@stop