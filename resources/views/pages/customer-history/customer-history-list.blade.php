@extends('layouts.default')
@section('content')
<div class="container-fluid">
  <div class="card shadow border-left-primary mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <ol class="breadcrumb py-0 my-0" style="background-color: transparent">
            <li class="breadcrumb-item"><a href="/home">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Customer History</li>
        </ol>
    </div>
    <div class="card-body">
        <!-- <form action="/customer/history/search" action="post">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="customer" class="form-label">Customer</label>
                    <input class="typeahead form-control" type="text" name="customer" autocomplete="off"/>
                </div>
                <div class="form-group col-md-4">
                    <label for="customer" class="form-label">Transaction Date</label>
                    <input class="form-control" type="text" name="transaction" />
                </div>
                <div class="form-group col-md-4">
                    <label for="customer" class="form-label">Pin Code</label>
                    <input class="form-control" type="numberf" name="pincode" />
                </div>
            </div>
            <div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Search</button>
                    <a href="/customer/history" class="btn btn-danger" id="reload"><i class="fa fa-redo" aria-hidden="true"></i> Cancel</a>
                </div>
            </div>
            <br>
        </form> -->
        <div id="loading">
            <img id="loading-image" src="general_imgs/loading.gif" alt="Loading..." />
        </div>
        <div class="table-responsive">
            <table class="table table-border datatable" id="cus_history_table" width="100%">
                <thead>
                    <tr>
                        <th scope="col">NO</th>
                        <th scope="col">Name</th>
                        <th scope="col">Phone Number</th>
                        <th scope="col">Pin</th>
                        <th scope="col">Lucky Draw Amount</th>
                        <th scope="col">Product Code</th>
                        <th scope="col">Transaction Date</th>
                        <th scope="col">State</th>
                        <th scope="col">Claim</th>
                       
                    </tr>
                </thead>
                <tbody>                   
                    @foreach($cusHistoryList as $key => $cusHistory)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $cusHistory->customer_name }}</td>
                        <td>{{  $cusHistory->customer_phone_number }}</td>
                        <td>{{ $cusHistory->pin_id }}</td>
                        <td>{{ $cusHistory->lucky_draw_amt }}</td>
                        <td>{{ $cusHistory->product_code }}</td>
                        <td>{{date('d/m/Y H:i:s', strtotime($cusHistory->created_at))}}</td>
                        <td>
                            @if($cusHistory->pin_flag == 1)
                                <span class="label label-success label-many">Register</span>
                            @elseif($cusHistory->pin_flag == 2)
                                <span class="label label-info label-many">Next Purchase</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <form action="/customer/claim" method="post">
                                @csrf
                                <input type="hidden" name="customerHistory" value="{{ $cusHistory }}">
                                <input type="checkbox" name="claim" onchange="this.form.submit()" {{ $cusHistory->is_claim == 0 ? '': 'checked'}}>
                            </form>
                        </td>
                        
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
  </div>
</div>
@stop
@section('script')
<script>
    $('#cus_history_table').DataTable();
    var path = "{{ route('typeahead.customer.name') }}";
    // console.log(path);
    $('input.typeahead').typeahead({
        source: function(query, process) {
            return $.get(path, {
                query: query
            }, function(data) {
                return process(data);
            });
        }
    });
    $(function () {
        $('#loading').hide();
    });
    $(function() {
        $('input[name="transaction"]').daterangepicker({
            opens: 'left',
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear'
            }
        }, function(start, end, label) {
            console.log("A new date selection was made: " + start.format('YYYY-MM-DD hh:mm:ss') + ' to ' + end.format('YYYY-MM-DD hh:mm:ss'));
        });

        $('input[name="transaction"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
        });

        $('input[name="transaction"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val(null);
        });
    });

    // const observer = lozad();
    // observer.observe();
</script>
@endsection