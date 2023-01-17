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
                            <th>{{ __('Tên vai trò') }}</th>
                            {{-- <th>{{ __('TOTAL USER') }}</th> --}}
                            <th>{{ __('Ngày tạo') }}</th>
                            <th>
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                    data-target="#formAdd">
                                    <i class="fa fa-plus"></i>
                                </button>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $role)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $role->name }}</td>
                                {{-- <td></td> --}}
                                <td>{{ $role->created_at }}</td>
                                <td>
                                    <button class="btn btn-primary btn-sm btn-modal-edit" data-toggle="modal"
                                        data-target="#modal-edit" data-name="{{ $role->name }}"
                                        data-id="{{ $role->id }}"><i class="fa fa-edit"></i></button>
                                    <button class="btn btn-danger btn-sm delete-confirm" type="submit"
                                        value="{{ $role->id }}"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <tfoot>
                    <tr>
                        <td>{{ $roles->links() }}</td>
                    </tr>
                </tfoot>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
    <!-- Modal -->
    @include('admin.role.add')
    @include('admin.role.edit')
@endsection
@section('script')
    @parent
    <script>
        $(document).ready(function() {
        $('#check-all-permission').click(function() {
            var checked = this.checked;
                $('.permission').each(function() {
                this.checked = checked;})
            })
        });    
        $('.btn-create').click(function(e) {
            e.preventDefault();
            var arrayUrl = $(location).attr('pathname').split('/');
            var model = arrayUrl[arrayUrl.length - 1];
            var url = `${model}`;
            var nameInput = $('#nameInput').val();
            var permissions = [];
            $(':checkbox:checked').each(function(i){
                permissions[i] = $(this).val();
            });
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    "_token": CSRF_TOKEN,
                    "name": nameInput,
                    "permissions" : permissions
                },
                success: function success(results) {
                    if (results.status == false) {
                        $('#nameInput').addClass('is-invalid'),
                        $('#name-error').text(results.message.name),
                        $('#permission-error').text(results.message.permissions)
                    
                    } else {
                        console.log(results);
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
        $('#modal-edit').on('hidden.bs.modal', function () {
            $('#nameEdit').val();
            $('.checkbox-edit').removeAttr('checked')
        })
        $('.btn-modal-edit').click(function() {
            var namePresent = $(this).attr('data-name');
            var idRole = $(this).attr('data-id');
            $('#nameEdit').val(namePresent) ;
            $('#idRole').val(idRole);
            var arrayUrl = $(location).attr('pathname').split('/');
            var model = arrayUrl[arrayUrl.length - 1];
            var url = `${model}/${idRole}/edit`;
            $.ajax({
                type: 'GET',
                url: url,
                success: function success(results) {
                    if (results.status) {
                        results.data.forEach(element => {
                            $('#permissionChecked'+element).attr('checked', 'checked');
                        });
                    }
                }
            });
        })
        $('.btn-edit').click(function(e) {
            e.preventDefault();
            var arrayUrl = $(location).attr('pathname').split('/');
            var model = arrayUrl[arrayUrl.length - 1];
            var idRole = $('#idRole').val();
            var url = `${model}/${idRole}`;
            var nameEdit = $('#nameEdit').val();
            var permissions = [];
            $(':checkbox:checked').each(function(i){
                permissions[i] = $(this).val();
            });
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: 'PUT',
                url: url,
                data: {
                    "_method": 'PUT',
                    "_token": CSRF_TOKEN,
                    "name": nameEdit,
                    "permissions" : permissions
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
