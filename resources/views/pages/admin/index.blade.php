@extends('layouts.default')
@section('content')
<div class="container-fluid">
  <div class="card shadow border-left-primary mb-4">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <ol class="breadcrumb py-0 my-0" style="background-color: transparent">
          <li class="breadcrumb-item"><a href="/home">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">Admin List</li>
        </ol>
        <div class="pull-right">
            <a href="/admins/create" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Add New Admin</a>
        </div>
      </div>
      <div class="card-body">
          <div class="table-responsive">
              <table class="table table-border datatable" id="Admin_table" width="100%">
                  <thead>
                  <tr>
                    <th scope="col">NO</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Created Date</th>
                    <th scope="col">Action</th>               
                  </tr>
                  </thead>                 
                  <tbody>
                  @if(count($adminList) > 0)
                  @foreach($adminList as $key=>$admin)
                    <tr>
                      <td>{{ $key + 1 }}</td>
                      <td>{{$admin->name}}</td>
                      <td>{{$admin->email}}</td>
                      <td>{{$admin->created_at}}</td>
                      <td>
                        <form style="display: inline;" action="/admins/edit/{{$admin->id}}" method="POST">
                          {{ csrf_field() }}
                          <button type="submit" class="btn btn-info"><i class="fa fa-edit"></i> Edit</button>
                        </form>
                        <form style="display: inline;" action="/admins/delete/{{$admin->id}}" method="POST">
                          {{ csrf_field() }}
                          {{ method_field('DELETE') }}
                          <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i>  Delete</button>
                        </form>
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
    $('#Admin_table').DataTable( {
        dom: 'lBfrtip',
        "autoWidth": false,
        buttons: [
          'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );
</script>
@endsection