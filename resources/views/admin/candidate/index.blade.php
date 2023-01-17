@extends('admin.layout.app')
@section('title')
    {{ __('Candidate') }}
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
                    <input class="form-control" name="key" id="key" placeholder="Nhập tên ứng viên....">
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
                  <th>{{__('Họ tên')}}</th>
                  <th>{{__('Ảnh')}}</th>
                  <th>Email</th>
                  <th>{{__('Số điện thoại')}}</th>
                  <th>Đánh giá</th>
                  <th>{{__('Trạng thái')}}</th>
                  <th><a href="{{route('admin.candidate.create')}}"><i class="fa fa-plus"></i></a></th>
                </tr>
                </thead>
                <tbody>
                    @foreach($list as $item)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$item->name}}</td>
                        <td class="text-center"><img width="100px" src="{{asset('storage/'. $item->avatar)}}" alt=""></td>
                        <td>{{$item->email}}</td>
                        <td>{{$item->phone}}</td>
                        <td>
                          {{-- hàm sử lý mảng --}}
                          <?php $k=[]?>
                          @foreach ($feed as $u )
                            @if ($u->candidate_id == $item->id)
                              <?php $k[]=$u->id;?>                
                            @endif 
                          @endforeach
                          {{-- hàm hiển thị count --}}
                          @foreach ($feed as $u )
                            @if ($u->candidate_id == $item->id)
                            <a href="{{route('admin.feedback.candidate.index',['id' => $item->id])}}"><?php echo count($k).' bài';break;?></a>              
                            @endif
                          @endforeach
                        </td>
                        <td>
                          <form action="{{route('admin.candidate.status', ['id' => $item->id])}}" method="post">
                            @csrf
                            @method('post')
                            <select class="stu form-select" name="status" data-id="{{$item->id}}">
                              <option @if($item->status == 0) selected @endif value="0">Chưa kích hoạt</option>
                              <option @if($item->status == 1) selected @endif value="1">Đã kích hoạt</option>
                              <option @if($item->status == 2) selected @endif value="2">Chặn</option>
                            </select>
                          </form>
                      </td>
                        
                        <td class="project-actions xoa text-right d-flex align-items-center">
                            <a class="btn btn-info mr-3" href="{{route('admin.candidate.edit', ['id' => $item->id])}}">
                              <i class="fa fa-edit"></i>
                            </a>

                            <button data-id="{{$item->id}}" class="btn btn-danger btn-delete"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
              </table>
              <div class="text-center mt-3">
                {{$list->links()}} 
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