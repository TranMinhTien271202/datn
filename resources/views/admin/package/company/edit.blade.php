@extends('admin.layout.app')
@section('title')
    {{ __('Company - edit') }}
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
                  <form action="{{ route('admin.package.company.updatec', ['id' => $obj->id])}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $obj->id }}">
                    <div class="row">
                        <div class="col-sm-6">
                            <!-- text input -->
                            <div class="form-group">
                                <label for="inputName">{{__('Title')}} <span class="text-danger">*</span></label>
                                <input type="text" id="inputName" name="title" class="form-control" value="{{$obj->title}}">
                                @error('title')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>{{__('Số Coin')}} <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="coin" value="{{$obj->coin}}">
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
                                <input type="number" class="form-control" name="amount" value="{{$obj->amount}}">
                                @error('amount')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>{{__('Giá giảm (không được nhỏ hơn giá)')}}</label>
                                <input type="number" class="form-control" name="discount" value="{{$obj->discount}}">
                            </div>
                        </div>
                    </div>
                    {{--  --}}
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>{{__('Hạn sử dụng (trong bao nhiêu tháng)')}} <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="expired" value="{{$obj->expired}}">
                                @error('expired')
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
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <input type="submit" value="Lưu" class="btn btn-primary float-left mr-3">

                        <a href="{{route('admin.package.company.indexc')}}" class="btn btn-secondary">Hủy</a>
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