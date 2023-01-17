@extends('admin.layout.app')
@section('title')
    {{ __('Sửa Công ty') }}
@endsection
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="">
            <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">{{$title}}</h3>
                </div>
            <div class="card-body">
                <form action="{{ route('admin.company.update', ['id' => $obj->id])}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Tên *</label>
                                <input type="text" name="name" class="form-control" placeholder=""  value="{{$obj->name}}">
                                @error('name')
                                    <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Tên công ty *</label>
                                <input type="text" name="company_name" class="form-control" placeholder=""  value="{{$obj->company_name}}">
                            @error('company_name')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Địa chỉ</label>
                                <input type="text" name="address" class="form-control" placeholder=""  value="{{$obj->address}}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Mã số thuế *</label>
                                <input type="text" name="tax_code" class="form-control" placeholder=""  value="{{$obj->tax_code}}">
                                @error('tax_code')
                                    <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Mô hình công ty</label>
                                <input type="text" name="company_model" class="form-control" placeholder=""  value="{{$obj->company_model}}">
                                @error('conpany_model')
                                    <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Thời gian làm việc</label>
                                <input type="text" name="working_time" class="form-control" placeholder=""  value="{{$obj->working_time}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Số điện thoại *</label>
                                <input type="number" name="phone" class="form-control" placeholder=""  value="{{$obj->phone}}">
                                @error('phone')
                                    <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Email *</label>
                                <input type="email" name="email" class="form-control" placeholder=""  value="{{$obj->email}}">
                                @error('email')
                                    <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="">Link Website</label>
                                <input type="text" name="link_web" class="form-control" placeholder=""  value="{{$obj->link_web}}">
                            </div>
                        </div>
                    </div>      
                        <div class="row">
                          <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label w-100">Logo</label>
                                <img id="image" src="{{ $obj->logo?''.Storage::url('images/company/'.$obj->logo):'http://placehold.it/100x100' }}" alt="your image"
                                    style="max-width: 200px; height:100px; margin-bottom: 10px;" class="img-fluid"/>
                                <input name="image" type="file" id="img">
                                <small class="form-text text-muted">Chọn ảnh kích thước nhỏ hơn 5mb</small>
                                @error('image')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
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
                        <br>
                        <div class="mt-3">
                            <input type="submit" value="Lưu" class="btn btn-primary float-left mr-3">
                            <a href="{{route('admin.company.index')}}" class="btn btn-secondary">Hủy</a>
                        </div>
                    </form>
                </div>
                </div>
                <!-- /.card-body -->
              </div>
        </div>
    </div>
</section>
@endsection