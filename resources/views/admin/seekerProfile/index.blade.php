@extends('admin.layout.app')
@section('title')
    {{ __('SeekerProfile') }}
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
                    <input class="form-control" name="key" id="key" placeholder="Nhập tên ứng viên ....">
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
                  <th>{{__('Tên Ứng viên')}}</th>
                  <th>{{__('Email')}}</th>
                  <th>{{__('SĐT')}}</th>
                  <th>{{__('Cv ứng viên')}}</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($can as $kcan)
                      <tr>
                        <td>{{$loop->iteration}}</td>
                        @foreach ($kcan as $item )
                            <td>{{$item->name}}</td>
                            <td>{{$item->email}}</td>
                            <td>{{$item->phone}}</td>
                            <td>
                                @foreach ( $data as $u )
                                    @if ($item->id == $u->candidate_id)
                                      @if(!empty($u->path_cv))
                                        <button type="button" class="btn btn-primary btn-sm mb-2" data-toggle="modal" data-target="#myModal<?php echo $u->id?>">
                                          Thông tin cv
                                        </button>
                                        <br>
                                        {{-- popup --}}
                                          <div id="myModal<?php echo $u->id?>"  class="modal fade" tabindex="-1" role="dialog">
                                            <div class="modal-dialog" role="document">
                                              <div class="modal-content">
                                                <div class="modal-header">
                                                  <h5 class="modal-title float-left"> Thông tin CV </h5>
                                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                </div>
                                                <div class="modal-body">
                                                  <div class="form-group">
                                                    <a target="_blank" href="../upload/cv/{{ $u->path_cv }}">Xem CV ứng viên</a>
                                                  </div>
                                                  <form action="{{ route('admin.seekerProfile.update', ['id' => $u->id])}}" method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $u->id }}">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <!-- text input -->
                                                            <div class="form-group">
                                                                <label for="inputName">Cập nhật giá trị CV<span class="text-danger">*</span></label>
                                                                <input type="number" id="inputCoin" name="coin" class="form-control" value="{{$u->coin}}">
                                                                @error('coin')
                                                                <small class="text-danger">{{$message}}</small>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mt-3">
                                                        <input type="submit" value="Lưu" class="btn btn-primary float-left mr-3">
                                                        <a data-dismiss="modal" aria-label="Close" class="btn btn-secondary">Hủy</a>
                                                    </div>
                                                  </form>
                                                </div>
                                              </div><!-- /.modal-content -->
                                            </div><!-- /.modal-dialog -->
                                          </div><!-- /.modal -->
                                        {{-- end-popup --}}
                                      @endif
                                    @endif
                                @endforeach
                            </td>
                            <td class="project-actions xoa text-right">
                                @foreach ( $data as $u )
                                    @if ($item->id == $u->candidate_id)
                                        <button data-id="{{$u->id}}" class="btn btn-sm btn-danger btn-delete mb-2"><i class="fa fa-trash"></i></button>
                                        <br>
                                    @endif
                                @endforeach
                            </td>
                        @endforeach
                      </tr>
                    @endforeach
                </tbody>
              </table>
              <div class="text-center mt-3">
                {{$data->links()}} 
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