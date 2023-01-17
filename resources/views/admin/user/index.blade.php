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
                            <th>{{ __('Họ tên') }}</th>
                            <th>{{ __('Email') }}</th>
                            <th>{{ __('Số điện thoại') }}</th>
                            <th>{{ __('Vai trò') }}</th>
                            {{-- <th>{{ __('IMAGE') }}</th> --}}
                            {{-- <th>{{ __('ROLE') }}</th> --}}
                            {{-- <th>{{ __('Trạng thái') }}</th> --}}
                            <th>
                                @can('user-create')
                                    <a href="{{ route('admin.user.create') }}"><i class="fa fa-plus"></i></a>
                                @endcan
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone }}</td>
                                <td>
                                    @if (!empty($user->getRoleNames()))
                                        @foreach ($user->getRoleNames() as $v)
                                            <label class="badge badge-success">{{ $v }}</label>
                                        @endforeach
                                    @endif
                                {{-- </td>
                                <td> --}}
                                </td>
                                {{-- <td>{{ $user->role->name }}</td> --}}
                                {{-- <td>
                                    <button
                                        class="btn  {{ $user->status == config('custom.user_status_text.active') ? 'btn-success' : 'btn-danger' }} btn-sm btn-update"
                                        data-id="{{ $user->id }}">{{ __($user->status) }}</button>
                                </td> --}}
                                <td>
                                    @can('user-update')
                                    <a class="btn btn-primary btn-sm" href="{{ route('admin.user.edit', $user->id) }}"><i
                                        class="fa fa-edit"></i></a>
                                    @endcan
                                    @can('user-delete')
                                    @if(Auth::user()->id != $user->id)
                                        <button class="btn btn-danger btn-sm delete-confirm" type="submit"
                                            value="{{ $user->id }}"><i class="fa fa-trash"></i></button>
                                    @endif
                                    @endcan

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
@endsection
@section('script')
    @parent
    <script src="{{ asset('js/remove-ajax.js') }}"></script>
@endsection
