@extends('layouts.default')
@section('content')
<div class="container" style="margin-top: 2%; margin-bottom:2%">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="background-color: transparent">
            <li class="breadcrumb-item"><a href="/home">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Customer Create</li>
        </ol>
    </nav>
    <h3>Create New Customer</h3>
    <br>
    <form action="/customers/store" method="post" enctype="multipart/form-data">

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" value="{{old('name')}}" required id="name">
        </div>
        <div class="form-group">
            <label for="address">Phone Number</label>
            <input type="number" name="phone_number" value="{{old('phone_number')}}" class="form-control" required id="address">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="text" name="password" class="form-control" required id="password">
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">Type</label>
            </div>
            <select name="type" class="custom-select" id="inputGroupSelect01" required>
                <option selected>Choose...</option>
                <option value="0">Customer (End User)</option>
                <option value="1">Sale Person</option>
            </select>
        </div>
        <div class="form-group" id="pin-group">
            <label for="pincode">Pincode</label>
            <input type="text" name="pin_code" value="{{old('pin_code')}}" class="form-control" required id="pincode">
        </div>
        <div class="form-group">
            <label for="exampleFormControlFile1">Customer Image</label>
            <input type="file" name="customer_photo" class="form-control-file" id="exampleFormControlFile1">
            <div class="invalid-feedback">Please select file</div>
        </div>
        <hr>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<script>
    var customerType = document.getElementById('inputGroupSelect01');
    var pinGroup = document.getElementById('pin-group');
    var pinCode = document.getElementById('pincode');

    window.addEventListener("load", function() {
        pinGroup.style.display = "none";
        pinCode.value = null;
        customerType.selectedIndex = 0;
    });

    customerType.addEventListener("change", function() {
        console.log(customerType.options[customerType.selectedIndex].value);
        if (customerType.options[customerType.selectedIndex].value == 1) {
            pinGroup.style.display = "none";
            pinCode.value = "0";
        } else {
            pinGroup.style.display = "";
            pinCode.value = "";
        }
    });
</script>

<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
@stop