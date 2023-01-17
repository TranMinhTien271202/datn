@extends('admin.layout.app')
@section('title')
    {{ __('Candidate - edit') }}
@endsection
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="">
            <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">{{$title}}</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <form action="{{ route('admin.candidate.update', ['id' => $obj->id])}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $obj->id }}">
                    <div class="row">
                    <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label for="inputName">Tên <span class="text-danger">*</span></label>
                            <input type="text" id="inputName" name="name" class="form-control" value="{{$obj->name}}">
                            @error('name')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Địa chỉ</label>
                        <input type="text" class="form-control" name="address" value="{{$obj->address}}">
                      </div>
                  </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label>Email <span class="text-danger">*</span></label>
                          <input type="text" class="form-control" name="email" value="{{$obj->email}}">
                          @error('email')
                          <small class="text-danger">{{$message}}</small>
                          @enderror
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                            <label>Số điện thoại <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="phone" value="{{$obj->phone}}">
                            @error('phone')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                              <label class="form-label w-100">Ảnh</label>
                              <img id="image" src="{{ $obj->avatar?''.Storage::url($obj->avatar):'http://placehold.it/100x100' }}" alt="your image"
                                  style="max-width: 200px; height:100px; margin-bottom: 10px;" class="img-fluid"/>
                              <input name="image" type="file" id="img">
                              <small class="form-text text-muted">Chọn ảnh kích thước nhỏ hơn 5mb</small>
                              @error('image')
                              <small class="text-danger">{{$message}}</small>
                              @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-6">
                        <label class="form-label w-100">Giới tính</label>
                        <div class="d-flex">
                          <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" id="radio1" name="gender" value="1" @if($obj->gender == 1) checked @endif>Nam
                            <label class="form-check-label" for="radio1"></label>
                          </div>
                          <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" id="radio2" name="gender" value="2" @if($obj->gender == 2) checked @endif>Nữ
                            <label class="form-check-label" for="radio2"></label>
                          </div>
                          <div class="form-check">
                            <input type="radio" class="form-check-input" id="radio3" name="gender" value="3" @if($obj->gender == 3) checked @endif>Khác
                            <label class="form-check-label" for="radio3"></label>
                          </div>
                        </div>
                      </div>

                      
                      <div class="col-sm-6">
                        <label class="form-label w-100">Trạng thái</label>
                        <div class="d-flex">
                          <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" id="status" name="status" value="0" @if($obj->status == 0) checked @endif>Chưa kích hoạt
                            <label class="form-check-label" for="status"></label>
                          </div>
                          <div class="form-check mr-3">
                            <input type="radio" class="form-check-input" id="status" name="status" value="1" @if($obj->status == 1) checked @endif>Đã kích hoạt
                            <label class="form-check-label" for="status"></label>
                          </div>
                          <div class="form-check">
                            <input type="radio" class="form-check-input" id="status2" name="status" value="2" @if($obj->status == 2) checked @endif>Chặn
                            <label class="form-check-label" for="status2"></label>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="mt-3">
                        <input type="submit" value="Lưu" class="btn btn-primary float-left mr-3">
                        <a href="{{route('admin.candidate.index')}}" class="btn btn-secondary">Hủy</a>
                    </div>
                  </form>
                </div>
                <!-- /.card-body -->
              </div>
        </div>
    </div>
</section>
@endsection
@section('script')
@parent
<script src="{{asset('js/admin/candidate.js')}}"></script>
@endsection