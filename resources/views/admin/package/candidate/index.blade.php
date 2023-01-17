@extends('admin.layout.app')
@section('title')
    {{ __('Package') }}
@endsection
@section('content')
<section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">{{$title}}</h3>
              <form action="" class="form-inline float-right mr-3">
                <div class="form-group">
                    <input class="form-control" name="key" id="key" placeholder="Nhập tên gói nạp....">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example2" class="table table-bordered table-striped dataTable dtr-inline">
                <thead>
                <tr>
                  <th>STT</th>
                  <th>{{__('Tên gói nạp')}}</th>
                  <th>{{__('Số coin')}}</th>
                  <th>{{__('Giá')}}</th>
                  <th>{{__('Giá giảm')}}</th>
                  <th>{{__('Ngày tạo')}}</th>
                  <th>{{__('Hạn sử dụng')}}</th>
                  <th>{{__('Trạng thái')}}</th>
                  <th>
                    @can('package-create')
                    <a href="{{route('admin.package.candidate.create')}}"><i class="fa fa-plus"></i></a>
                    @endcan
                  </th>
                </tr>
                </thead>
                <tbody>
                    @foreach($list as $item)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$item->title}}</td>
                        <td>{{$item->coin}}</td>
                        <td><?php echo number_format($item->amount, 0, '.', '.')?>đ</td>
                        <td><?php echo number_format($item->discount, 0, '.', '.')?>đ</td>
                        <td><?php echo date_format($item->created_at,"Y/m/d H:i:s") ?></td>
                        <td>{{$item->expired}} tháng</td>
                        <td>
                            <form action="{{route('admin.package.candidate.status', ['id' => $item->id])}}" method="post">
                                @csrf
                                @method('post')
                                <select class="stu form-select" name="status" data-id="{{$item->id}}">
                                <option @if($item->status == 0) selected @endif value="0">Chưa kích hoạt</option>
                                <option @if($item->status == 1) selected @endif value="1">Đã kích hoạt</option>
                                </select>
                            </form>
                        </td>
                        <td class="project-actions xoa text-right d-flex align-items-center">
                            @can('package-update')
                              <a class="btn btn-info mr-3" href="{{route('admin.package.candidate.edit', ['id' => $item->id])}}">
                                <i class="fa fa-edit"></i>
                              </a>
                            @endcan

                            @can('package-delete')
                            <button data-id="{{$item->id}}" class="btn btn-danger btn-delete"><i class="fa fa-trash"></i></button>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
              </table>
              <div class="text-center mt-3">
            </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </section>
@endsection
@section('script')
@parent
<script src="{{asset('js/admin/candidate.js')}}"></script>
@endsection