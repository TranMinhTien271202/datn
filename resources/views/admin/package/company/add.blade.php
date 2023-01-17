@extends('admin.layout.app')
@section('title')
    {{ __('Company - add') }}
@endsection
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="">
            <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">{{__($title)}}</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <form action="{{ route('admin.package.company.storec')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6">
                            <!-- text input -->
                            <div class="form-group">
                                <label for="inputName">{{__('Tên gói nạp')}} <span class="text-danger">*</span></label>
                                <input type="text" id="inputName" name="title" class="form-control" value="{{old('title')}}">
                                @error('title')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>{{__('Số coin')}} <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="coin" value="{{old('coin')}}">
                                @error('coin')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    {{--  --}}
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>{{__('Giá')}} <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="amount" value="{{old('amount')}}">
                                @error('amount')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>{{__('Giá giảm (không được nhỏ hơn giá)')}}</label>
                                <input type="number" class="form-control" name="discount" value="{{old('discount')}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>{{__('Hạn sử dụng (trong bao nhiêu tháng)')}} <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="expired" value="{{old('expired')}}">
                                @error('expired')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label w-100">{{__('STATUS')}}</label>
                            <div class="d-flex">
                              <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" id="status" name="status" value="0" checked>{{__('Chưa kích hoạt')}}
                                <label class="form-check-label" for="status"></label>
                              </div>
                              <div class="form-check mr-3">
                                <input type="radio" class="form-check-input" id="status" name="status" value="1" checked>{{__('kích hoạt')}}
                                <label class="form-check-label" for="status"></label>
                              </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary float-left mr-3">{{__('Lưu')}}</button>
                        <a href="{{route('admin.package.company.indexc')}}" class="btn btn-secondary">{{__('Hủy')}}</a>
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