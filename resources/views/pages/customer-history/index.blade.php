@extends('layouts.default')
@section('content')
<div class="container-fluid">
  <div class="card shadow border-left-primary mb-4">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <ol class="breadcrumb py-0 my-0" style="background-color: transparent">
          <li class="breadcrumb-item"><a href="/home">Home</a></li>
          <li class="breadcrumb-item"><a href="/customers">Customer List</a></li>
          <li class="breadcrumb-item active" aria-current="page">Customer History</li>
        </ol>
        <div class="pull-right">
            <p style="color:blue;"> Customer - <b>{{$cus->name}} ( {{$cus->phone_number}} )</b> </p>
        </div>
      </div>
      <div class="card-body">
          <div class="table-responsive">
              <table class="table table-border datatable" id="history_table" width="100%">
                  <thead>
                  <tr>
                    <th scope="col">NO</th>
                    <th scope="col">Pin</th>
                    <th scope="col">Lucky Draw Amount</th>
                    <th scope="col">Product Code</th>
                    <th scope="col">Status</th>
                    <th scope="col">Claim</th>
                    <th scope="col">Transaction Date</th>                                
                  </tr>
                  </thead>                 
                  <tbody>
                  @if(count($cusHistoryList) > 0)
                    @foreach($cusHistoryList as $key=>$cusHistory)
                      <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $cusHistory->pin_id }}</td>
                        <td>{{ $cusHistory->lucky_draw_amt }}</td>
                        <td>{{ $cusHistory->product_code }}</td>
                        <td>
                            @if($cusHistory->pin_flag == 1)
                                <span class="label label-success label-many">Register</span>
                            @elseif($cusHistory->pin_flag == 2)
                                <span class="label label-info label-many">Next Purchase</span>
                            @endif
                        </td>
                        <td>
                            @if($cusHistory->is_claim == 0)
                                <span class="label label-success label-many">Not Yet</span>
                            @elseif($cusHistory->is_claim == 1)
                                <span class="label label-info label-many">Done</span>
                            @endif
                        </td>
                        <td>{{ $cusHistory->created_at}}</td>
                      </tr>
                    @endforeach
                  @endif                                    
                  </tbody>
              </table>
          </div>
      </div>
  </div>
</div>
@stop
@section('script')
<script>
  $(document).ready(function(){
    $('#history_table').DataTable();
  })
</script>
@endsection