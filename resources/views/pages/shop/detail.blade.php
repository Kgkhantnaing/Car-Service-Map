@extends('layouts.default')
@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb py-0 my-0" style="background-color: transparent">
        <li class="breadcrumb-item"><a href="/home">Home</a></li>
        <li class="breadcrumb-item"><a href="/shops">Shop</a></li>
        <li class="breadcrumb-item active" aria-current="page">Shop Detail</li>
      </ol>   
  </nav>

  <div class="row mt-3">
    <div class="col-md-3 text-center">
        <div class="card shadow mb-4">
            <div class="card-body">
              <img src="{{$shopDetail->image_url}}" alt="" width="100%" class="user-profile rounded">
              <h3 class="text-dark pt-2">Name - {{$shopDetail->name}}</h3>
              <p>Category - {{App\Category::find($shopDetail->category_id)->name}}</p>
              <p>Description - {{$shopDetail->description}}</p>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="card shadow mb-4">
          <div class="card-body">
            <div class="row mb-2">
              <div class="col-md-6">
                  Shop Location
              </div>
              <div class="col-md-6">
                  {{$shopDetail->latitude}},&nbsp;{{$shopDetail->longitude}}
              </div>
            </div>
            
            <div class="row my-2">
              <div class="col-md-6">
                  Shop Address
              </div>
              <div class="col-md-6">
                  {{$shopDetail->address}}
              </div>
            </div>

            <div class="row my-2">
              <div class="col-md-6">
                  City
              </div>
              <div class="col-md-6">
                  {{$shopDetail->city}}
              </div>
            </div>

            <div class="row my-2">
              <div class="col-md-6">
                  Phone Number
              </div>
              <div class="col-md-6">
                  {{$shopDetail->phone_no ?? ''}}
              </div>
            </div>            

            <div class="row my-2">
              <div class="col-md-6">
                  Remark
              </div>
              <div class="col-md-6">
                  {{$shopDetail->remark ?? 'Non'}}
              </div>
            </div>

            <div class="row">
              <div class="col-12">
                <a href="{{ url()->previous() }}" class="btn btn-danger btn-sm"><i class="fa fa-reply-all"></i> Back</a>
              </div>
            </div>

          </div>
        </div>
    </div>
  </div>
</div>
@stop