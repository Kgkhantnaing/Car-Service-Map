@extends('layouts.default')
@section('content')
    <div class="container-fluid">
        <div class="card shadow border-left-primary mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <ol class="breadcrumb py-0 my-0" style="background-color: transparent">
                    <li class="breadcrumb-item"><a href="/home">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Emergency Contact List</li>
                </ol>
                <div class="pull-right">
                    <a href="/emergency_contact/create" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Add New</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-border datatable" id="category_table" width="100%">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Category</th>
                                <th scope="col">City</th>
                                <th scope="col">Created Date</th>
                                <th scope="col">Modified Date</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($ECList) > 0)
                                @foreach ($ECList as $key => $item)
                                    <tr>
                                        <td>
                                            {{ $key + 1 }}
                                        </td>
                                        <td>
                                            {{ $item->name }}
                                        </td>
                                        <td>
                                            {{ $item->phone }}
                                        </td>
                                        <td>
                                            {{ $item->category_name }}
                                        </td>
                                        <td>
                                            {{ $item->city }}
                                        </td>
                                        <td>
                                            {{ $item->created_at }}
                                        </td>
                                        <td>
                                            {{ $item->updated_at }}
                                        </td>
                                        <td>
                                            <a href="/emergency_contact/detail/{{ $item->id }}" class="btn btn-primary btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> Detail</a>
                                            <form style="display: inline;" action="/emergency_contact/edit/{{ $item->id }}"
                                                method="POST">
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-info btn-sm"><i class="fa fa-edit"></i>
                                                    Edit</button>
                                            </form>
                                            <button button id="Del" type="button" class="btn btn-danger btn-sm btn-flat Del"
                                                data-id="{{ $item->id }}"><i class="fa fa-trash"></i> Delete</button>
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

    <div id="applicantDeleteModal" class="modal modal-danger fade" tabindex="-1" role="dialog"
        aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog" style="width:55%;">
            <div class="modal-content">
                <form id="DeleteForm" action="" method="POST" class="remove-record-model">
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
                        <button type="submit"
                            class="btn btn-danger waves-effect remove-data-from-delete-form">Delete</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@stop
@section('script')
    <script>
        $(document).ready(function() {
            $('#category_table').DataTable({
                dom: 'lBfrtip',
                "autoWidth": false,
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });

            $(document).on('click', '#Del', function() {
                var ID = $(this).attr('data-id');
                $('#DeleteForm').attr('action', '/emergency_contact/delete/' + ID);
                $('#applicantDeleteModal').modal('show');
            });
        })

    </script>
@endsection
