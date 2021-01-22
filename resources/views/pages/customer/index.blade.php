@extends('layouts.default')
@section('content')


<div id="applicantDeleteModal" class="modal modal-danger fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog" style="width:55%;">
    <div class="modal-content">
      <form id="cusDeleteForm" action="" method="POST" class="remove-record-model">
        {{ csrf_field() }}
        {{ method_field('DELETE') }}

        <div class="modal-header">
          <h3>Delete</h3>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div>
        <div class="modal-body">
          <h6>Are you sure you want to Delete This Record?</h6>
          <input type="hidden" , name="applicant_id" id="app_id">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-danger waves-effect remove-data-from-delete-form">Delete</button>
        </div>

      </form>
    </div>
  </div>
</div>
<div class="container-fluid">
  <div class="card shadow border-left-primary mb-4">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <ol class="breadcrumb py-0 my-0" style="background-color: transparent">
          <li class="breadcrumb-item"><a href="/home">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">Customer List</li>
        </ol>
        <div class="pull-right">
            <a href="/customers/create" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Add New Customer</a>
            <a href="customers/export" class="btn btn-sm btn-primary"><i class="fa fa-download"></i> Download Customers</a>
        </div>
      </div>
      <div class="card-body">
          <div class="table-responsive">
              <table class="table table-border datatable" id="customer_table" width="100%">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Phone Number</th>
                    <th>Pin Code</th>
                    <th>Product Code</th>
                    <th>LuckyDraw Amount</th>
                    <th>Type</th>
                    <th>Photo</th>
                    <th>Join Date</th>  
                    <th>History</th>
                    <th>Action</th>
                  </tr>
                  </thead>                 
                  <tbody>
                  @if(count($cusList) > 0)
                    @foreach($cusList as $key => $item)
                      <tr>
                        <td>
                            {{$key+1}}
                        </td>
                        <td>
                            {{$item->name}}
                        </td>
                        <td>
                            {{$item->phone_number}}
                        </td>
                        <td>
                            {{$item->pin_code}}
                        </td>
                        <td>
                            {{$item->p_code ?? ''}}
                        </td>
                        <td>
                            {{$item->lucky_amount ?? ''}}
                        </td>                
                        <td>
                            @if($item->type == 0)
                                User
                            @else
                                Sale Person
                            @endif
                        </td>
                        <td>
                          @if($item->user_photo != "null")
                          <img src="{{$item->user_photo}}" width="50" height="50" alt="{{$item->name}}" class="img-thumbnail" loading="lazy">
                          @else
                          <img src="/img/shop-hover.png" width="50" height="50" alt="Not Found" class="img-thumbnail" loading="lazy">
                          @endif
                         
                        </td>
                        <td>
                            {{$item->created_at}}
                        </td>
                        <td>
                          <a href="/customers/{{$item->id}}/history" class="btn btn-warning btn-sm btn-flat"><i class="fa fa-eye"></i> purch({{ App\CustomerHistory::where('customer_id', '=', $item->id)->get()->count() }})</a> 
                        </td>
                        <td style="width:70%;">
                          <a href="/customers/edit/{{$item->id}}" class="btn btn-info btn-sm btn-flat"><i class="fa fa-edit"></i> Edit</a>
                          <button id="cusDel" type="button" class="btn btn-danger btn-sm btn-flat cusDel" data-cusid="{{$item->id}}"><i class="fa fa-trash"></i> Delete</button>
                        </td>                 
                      </tr>
                    @endforeach
                  @endif                                    
                  </tbody>
              </table>
          </div>
      </div>
  </div>
</div>

<!-- 
<script>
  const observer = lozad();
  observer.observe();
</script> -->
@stop

@section('script')
<script>
  $(document).on('click', '#cusDel', function() {
    var userID = $(this).attr('data-cusid');
    $('#cusDeleteForm').attr('action', '/customers/delete/' + userID);
    $('#applicantDeleteModal').modal('show');    
  });

  $(document).ready(function() {
    $('#customer_table').DataTable( {
        dom: 'lBfrtip',
        "autoWidth": false,
        buttons: [
          'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );
</script>
@endsection