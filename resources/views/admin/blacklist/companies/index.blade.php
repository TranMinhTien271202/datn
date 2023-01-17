@extends('admin.layout.app')
@section('title')
@endsection
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ $title }}</h3>
                            <a href="/" class="btn btn-primary float-right">Tạo mới</a>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example2" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Tên Công ty</th>
                                        <th>Email</th>
                                        <th>Trạng thái</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($list as $item)
                                        @if ($item->company_id != 0 || $item->company_id != null)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                @foreach ($list_comp as $u)
                                                    @if ($u->id == $item->company_id)
                                                        <td>{{ $u->company_name }}</td>
                                                        <td>{{ $u->email }}</td>
                                                    @endif
                                                @endforeach
                                                <td>
                                                    @if ($item->status == 0)
                                                    <span class="badge badge- warning">Chưa xác định</span>
                                                    @elseif($item->status == 1)
                                                       <span class="badge badge-success">Hoạt động</span>
                                                    @elseif($item->status == 2)
                                                    <span class="badge badge-danger">Chặn</span>
                                                    @endif
                                                </td>
                                                <td class="project-actions xoa text-right d-flex align-items-center">
                                                    <a class="btn btn-danger btn-sm" href="#">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
    @parent
    <script>
        function Del() {
            return confirm('Bạn có chắc chắn muốn xóa');
        }
    </script>
    <script src="{{ asset('js/remove-ajax.js') }}"></script>
    <script src="{{ asset('js/admin/Candidate.js') }}"></script>
@endsection
