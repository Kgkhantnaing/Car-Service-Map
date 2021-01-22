@extends('layouts.default')
@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb" style="background-color: transparent">
      <li class="breadcrumb-item"><a href="/home">Home</a></li>
      <li class="breadcrumb-item"><a href="/feedbacks">Feedbacks</a></li>
      <li class="breadcrumb-item active" aria-current="page">Feedback Detail</li>
    </ol>
  </nav>
</div>
<div class="card mb-3" style="max-width: 80%; margin-left: 3%">
  <div class="row no-gutters">
    <div class="col-md-8">
      <div class="card-body">
        <h5 class="card-title text-primary">Name</h5>
        <p class="card-text">{{$feedbackDetail->name}}</p>
        <h5 class="card-title text-primary">Phone Number</h5>
        <p class="card-text">{{$feedbackDetail->customer_phone_number}}</p>
        <h5 class="card-title text-primary">Feedback</h5>
        <p class="card-text">{{$feedbackDetail->feedback_body}}</p>
        <h5 class="card-title text-primary">Feedback Date</h5>
        <p class="card-text">{{$feedbackDetail->created_at}}</p>
      </div>
    </div>
  </div>
</div>
@stop