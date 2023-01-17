@extends('admin.layout.app')
@section('title')
    {{ __('Major') }}
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
                    <input class="form-control" name="key" id="key" placeholder="Nhập tên chuyên ngành ....">
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
                  <th>{{__('Tên chuyên ngành')}}</th>
                  <th>{{__('Mô tả')}}</th>
                  <th>
                    @can('major-create')
                    <a href="{{route('admin.major.create')}}"><i class="fa fa-plus"></i></a>
                    @endcan
                  </th>
                </tr>
                </thead>
                <tbody>
                    @foreach($list as $item)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$item->name}}</td>
                        <td>{{$item->description}}</td>
                        <td class="project-actions xoa text-right d-flex align-items-center">
                            @can('major-update')
                            <a class="btn btn-info mr-3" href="{{route('admin.major.edit', ['id' => $item->id])}}">
                              <i class="fa fa-edit"></i>
                            </a>
                            @endcan

                            @can('major-delete')
                            <button data-id="{{$item->id}}" class="btn btn-danger btn-delete"><i class="fa fa-trash"></i></button>
                            @endcan
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
