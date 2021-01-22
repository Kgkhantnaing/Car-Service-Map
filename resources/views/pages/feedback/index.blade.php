@extends('layouts.default')
@section('content')
<div class="container-fluid">
  <div class="card shadow border-left-primary mb-4">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <ol class="breadcrumb py-0 my-0" style="background-color: transparent">
          <li class="breadcrumb-item"><a href="/home">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">All Feedbacks</li>
        </ol>
      </div>
      <div class="card-body">
          <div class="table-responsive">
              <table class="table table-border datatable" id="feedback_table" width="100%">
                  <thead>
                  <tr>
                    <th scope="col">NO</th>
                    <th scope="col">Name</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Feedback</th>
                    <th scope="col">Feedback_Date</th>
                    <th scope="col"></th> 
                    <th scope="col"></th>                
                  </tr>
                  </thead>                 
                  <tbody>
                  @if(count($feedbackList) > 0)
                    @foreach($feedbackList as $key=>$item)
                      <tr>
                        <td>
                            {{$key+1}}
                        </td>
                        <td>
                            {{$item->name}}
                        </td>
                        <td>
                            {{$item->customer_phone_number}}
                        </td>
                        <td>
                            {{$item->feedback_body}}
                        </td>
                        <td>
                            {{$item->created_at}}
                        </td>
                        <td>
                          <a href="/feedbacks/show/{{$item->id}}" class="btn btn-warning"><i class="fa fa-eye"></i></a>
                        </td>
                        <td>
                          <form action="/feedbacks/delete/{{$item->id}}" method="POST">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>
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
  $(document).ready(function(){
    $('#feedback_table').DataTable( {
        dom: 'lBfrtip',
        "autoWidth": false,
        buttons: [
          'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
  })
</script>
@endsection