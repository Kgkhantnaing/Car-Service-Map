@extends('layouts.default')
@section('content')
<div class="container-fluid">
  <div class="card shadow border-left-primary mb-4">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <ol class="breadcrumb py-0 my-0" style="background-color: transparent">
            <li class="breadcrumb-item"><a href="/home">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Pin List</li>
        </ol>
        <div class="pull-right">
            <a href="pincodes/create" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Add New Pincodes</a>
            <form action="/pincodes-filter" method="post" style="display:inline-block;">
                {{ csrf_field() }}
                <select id="filter" name="isUsed" class="form-control form-control-sm">
                    <option value="2" {{ ($currentFilter == 2 ? "selected":"") }}>Filter Here</option>
                    <option value="0" {{ ($currentFilter == 0 ? "selected":"") }}>New</option>
                    <option value="1" {{ ($currentFilter == 1 ? "selected":"") }}>Used</option>
                </select>
            </form>
        </div>
      </div>
      <div class="card-body">
        <div id="loading">
            <img id="loading-image" src="general_imgs/loading.gif" alt="Loading..." />
        </div>
        <?php if ($currentFilter != null ? $currentFilter : $currentFilter = 2) ?>
          <div class="table-responsive">
              <table class="table table-border datatable" id="pincode_table" width="100%">
                    <thead>
                    <tr>
                        <th scope="col">NO</th>
                        <th scope="col">PinCode Number</th>
                        <th scope="col">Is Used</th>
                        <th scope="col">Lucky Amount</th>
                        <th scope="col">Product Code</th>  
                        <th scope="col">Created Date</th>            
                    </tr>
                    </thead>                 
                    <tbody>
                        @if(count($pins) > 0)
                            @foreach($pins as $key=>$item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{$item->pin}}</td>
                                <td>{{$item->is_used === 1? 'Used': 'New'}}</td>
                                <td>{{$item->lucky_draw_amount}}</td>
                                <td>{{$item->product_code}}</td>
                                <td>{{$item->created_at}}</td>
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
    var select = document.getElementById('filter');
    select.addEventListener('change', function() {
        this.form.submit();
    }, false);
    $(document).ready(function(){
        $(function () {
            $('#loading').hide();
        });
        $('#pincode_table').DataTable( {
            dom: 'lBfrtip',
            "autoWidth": false,
            buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        } );
    })
</script>
@endsection