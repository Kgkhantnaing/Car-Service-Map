@extends('layouts.default')
@section('content')
<div class="container" style="margin-top: 2%">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="background-color: transparent">
            <li class="breadcrumb-item"><a href="/home">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Customer Update</li>
        </ol>
    </nav>
    <h3>Update Customer</h3>
    <br>
    <form action="/customers/update/{{$cus->id}}" method="post" enctype="multipart/form-data">
        @csrf
        @method('POST')
        @if ($errors->any())
        @foreach ($errors->all() as $error)
        <div class="alert alert-danger" role="alert">
            {{$error}}
        </div>
        @endforeach
        @endif
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" value="{{old('name', $cus->name)}}" required id="name">
        </div>
        <div class="form-group">
            <label for="phone_number">Phone Number</label>
            <input type="number" name="phone_number" value="{{old('phone_number', $cus->phone_number)}}" class="form-control" required id="phone_number">
        </div>
        <div class="form-group">
            <label for="latitude">Password</label>
            <input type="text" name="password" class="form-control" id="latitude">
        </div>
        <!-- <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">Type</label>
            </div>
            <select name="type" class="custom-select" id="inputGroupSelect01" required>
                <option value="0" {{ old('type', $cus->type) === 0? 'selected' : '' }}>Customer (End User)</option>
                <option value="1" {{ old('type', $cus->type) === 1? 'selected' : '' }}>Sale Person</option>
            </select>
        </div>
        <div class="form-group" id="pin-group">
            <label for="pincode">Pincode</label>
            <input type="text" name="pin_code" value="{{old('pin_code', $cus->pin_code)}}" class="form-control" required id="pincode" disabled>
        </div> -->
        <div class="form-group">
            <label for="exampleFormControlFile1">Customer Image</label>
            <input type="file" name="customer_photo" class="form-control-file" id="exampleFormControlFile1">
            <img src="$cus->user_photo" class="thumbnail" width="50px" height="50px" alt="">
            <div class="invalid-feedback">Please select file</div>
        </div>
        <hr>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<!-- <script>
    var customerType = document.getElementById('inputGroupSelect01');
    var pinCode = document.getElementById('pincode');
    var pinCodeGP = document.getElementById('pin-group');

    document.addEventListener('load', pincodeShowHide());
    customerType.addEventListener("change", function(){
        pincodeShowHide();
    });
    
    function pincodeShowHide() {
        console.log(customerType.options[customerType.selectedIndex].value);
        if (customerType.options[customerType.selectedIndex].value == 1) {
            pinCodeGP.style.display = "none";
            pinCode.value = "0";
        } else {
            pinCodeGP.style.display = "";
            pinCode.value = '{{$cus->pin_code}}';
        }
    }
</script> -->

<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
@stop