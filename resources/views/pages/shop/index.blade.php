@extends('layouts.default')
@section('content')
<div id="applicantDeleteModal" class="modal modal-danger fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog" style="width:55%;">
    <div class="modal-content">
      <form id="shopDeleteForm" action="" method="POST" class="remove-record-model">
        {{ csrf_field() }}
        {{ method_field('DELETE') }}

        <div class="modal-header">
          <h3>Delete</h3>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div>
        <div class="modal-body">
          <h6>You Want You Sure Delete This Record?</h6>
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
  <div class="card shadow mb-4">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <ol class="breadcrumb py-0 my-0" style="background-color: transparent">
          <li class="breadcrumb-item"><a href="/home">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">Shop List</li>
        </ol>
        <div class="pull-right">
            <a href="/shops/create" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Add New Shop</a>          
            <a href="shops/export" class="btn btn-sm btn-primary"><i class="fa fa-download"></i> Download Shops</a> 
        </div>
      </div>
      <div class="card-body">
        <div id="loading">
          <img id="loading-image" src="general_imgs/loading.gif" alt="Loading..." />
        </div>
          <div class="table-responsive">
              <table class="table table-sm table-border datatable" id="shop_table" width="100%">
                  <thead>
                    <tr>
                      <th>NO</th>
                      <th>Name</th>
                      <th>Image</th>
                      <th>Address</th>
                      <!-- <th>Latitude : Longitude</th>
                      <th>Description</th> -->
                      <th>Phone No</th>
                      <th>City</th>
                      <!-- <th>Remark</th>
                      <th>Category</th> -->
                      <th>Created At</th>
                      <th>Updated At</th>
                      <th width="15%">Action</th>                      
                    </tr>
                  </thead>                 
                  <tbody>            
                      @if(count($shopList) > 0)
                      @foreach($shopList as $key => $shop)
                      <tr>
                        <td>{{$key+1}}</td>
                        <td>
                          <p class="max-lines-p-tag">{{$shop->name}}</p>
                        </td>
                        <td>
                          <img src="{{$shop->image_url}}" style="height:70px!important; width:125px!important;" alt="{{$shop->name}}" class="img-thumbnail" loading="lazy">
                          <!-- <img class="img-thumbnail lazy" width="125" height="125" src="{{ URL::to('/') }}/img/shop-hover.png" data-src="{{$shop->image_url}}" alt="{{$shop->image_url}}" /> -->
                        </td>
                        <td>
                          <p class="max-lines-p-tag">{{$shop->address}}</p>
                        </td>
                        <!-- <td>
                          <p class="max-lines-p-tag">{{$shop->latitude}},&nbsp;{{$shop->longitude}}</p>
                        </td>
                        <td>
                          <p class="max-lines-p-tag">{{$shop->description}}</p>
                        </td> -->
                        <td>
                          <p class="max-lines-p-tag">{{$shop->phone_no}}</p>
                        </td>
                        <td>
                          <p class="max-lines-p-tag">{{$shop->city}}</p>
                        </td>
                        <!-- <td>
                          <p class="max-lines-p-tag">{{$shop->remark}}</p>
                        </td>
                        <td>
                          <p class="max-lines-p-tag">{{App\Category::find($shop->category_id)->name}}</p>
                        </td> -->
                        <td>
                          <p class="max-lines-p-tag">{{$shop->created_at}}</p>
                        </td>
                        <td>
                          <p class="max-lines-p-tag">{{$shop->updated_at}}</p>
                        </td>
                        <td>
                          <a href="/shops/show/{{$shop->id}}" class="btn btn-sm btn-warning"><i class="fa fa-eye"></i></a>
                          <a href="/shops/edit/{{$shop->id}}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                          <a id="shopDel" href="javascript:void(0)" class="btn btn-danger btn-sm shopDel" data-shopid="{{$shop->id}}"><i class="fa fa-trash"></i></a>
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
@stop

@section('script')
<script>
  $(document).ready(function() {
    $('#shop_table').DataTable();
    // $('#shop_table').DataTable({
    //   // dom: 'lBfrtip',
    //   //   "autoWidth": false,
    //   //   buttons: [
    //   //     'copy', 'csv', 'excel', 'pdf', 'print'
    //   //   ]
    // });
    $(function () {
      $('#loading').hide();
    });
    $(document).on('click', '#shopDel', function() {
      var userID = $(this).attr('data-shopid');
      $('#shopDeleteForm').attr('action', '/shops/delete/'+userID);
      $('#applicantDeleteModal').modal('show');
    });
  });
</script>
@endsection