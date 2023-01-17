@extends('admin.layout.app')
@section('title')
    {{ __($title) }}
@endsection
@section('style')
    @parent
    <link rel="stylesheet" href="{{ asset('assets/admin-bower/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/admin-bower/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin-bower/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection
@section('content')
    <div class="row">
        <div class="card col-12">
            <div class="card-header">
                <h3 class="card-title">{{ __($title) }}</h3>
                <p class="">
                </p>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="table" class="table table-bordered table-striped dataTable dtr-inline">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>{{ __('Tên quyền') }}</th>
                            <th>{{ __('Phần quyền') }}</th>
                            <th>{{ __('Ngày tạo') }}</th>
                            <th>
                                {{-- <a href="{{route('admin.permission.create')}}"><i class="fa fa-plus"></i></a> --}}
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                    data-target="#formAdd">
                                    <i class="fa fa-plus"></i>
                                </button>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($permissions as $permission)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $permission->name }}</td>
                                <td>{{ $permission->display_name }}</td>
                                <td>{{ $permission->created_at }}</td>
                                <td>
                                    <button class="btn btn-primary btn-sm btn-modal-edit" data-toggle="modal"
                                        data-target="#modal-edit" data-name="{{ $permission->name }}"
                                        data-id="{{ $permission->id }}"><i class="fa fa-edit"></i></button>
                                    <button class="btn btn-danger btn-sm delete-confirm" type="submit"
                                        value="{{ $permission->id }}"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <tfoot>
                    <tr>
                        <td>{{ $permissions->links() }}</td>
                    </tr>
                </tfoot>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
    <!-- Modal -->
    @include('admin.permission.add')
    @include('admin.permission.edit')
@endsection
@section('script')
    @parent
    <script>
        $('.btn-create').click(function(e) {
            e.preventDefault();
            var arrayUrl = $(location).attr('pathname').split('/');
            var model = arrayUrl[arrayUrl.length - 1];
            var url = `${model}`;
            var nameInput = $('#nameInput').val();
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    "_token": CSRF_TOKEN,
                    "name": nameInput
                },
                success: function success(results) {
                    if (results.status == false) {
                        $('#nameInput').addClass('is-invalid'),
                        $('#name-error').text(results.message.name)
                    } else {
                        Swal.fire({
                            title: 'Success',
                            icon: 'success',
                            type: 'success',
                            text: results.message,
                            showConfirmButton: false,
                            timer: 1000
                        }, setTimeout(function() {
                            window.location.reload();
                        }, 100));
                    }
                }
            });
        });
        $('.btn-modal-edit').click(function() {
            var namePresent = $(this).attr('data-name');
            var idPermission = $(this).attr('data-id');
            $('#nameEdit').val(namePresent) ;
            $('#idPermission').val(idPermission);
        })
        $('.btn-edit').click(function(e) {
            e.preventDefault();
            var arrayUrl = $(location).attr('pathname').split('/');
            var model = arrayUrl[arrayUrl.length - 1];
            var idPermission = $('#idPermission').val();
            var url = `${model}/${idPermission}`;
            var nameEdit = $('#nameEdit').val();
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: 'PUT',
                url: url,
                data: {
                    "_method": 'PUT',
                    "_token": CSRF_TOKEN,
                    "name": nameEdit,
                },
                success: function success(results) {
                    if (results.status == false) {
                        $('#nameEdit').addClass('is-invalid '),
                            $('#messageEdit').addClass('show'),
                            $('#messageEdit').children('span').text(results.message.name)
                    } else {
                        Swal.fire({
                            title: 'Success',
                            icon: 'success',
                            type: 'success',
                            text: results.message,
                            showConfirmButton: false,
                            timer: 1000
                        }, setTimeout(function() {
                            window.location.reload();
                        }, 100));
                    }
                }
            });
        })
    </script>
    <script src="{{ asset('js/remove-ajax.js') }}"></script>
@endsection
