@extends('admin.layout.app')
@section('title')
    {{ __('Major - edit') }}
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
                  <form action="{{ route('admin.major.update', ['id' => $obj->id])}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $obj->id }}">
                    <div class="row">
                    <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label for="inputName">{{__('Tên chuyên ngành')}} <span class="text-danger">*</span></label>
                            <input type="text" id="inputName" name="name" class="form-control" value="{{$obj->name}}">
                            @error('name')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>{{__('Mô tả')}}</label>
                        <input type="text" class="form-control" name="description" value="{{$obj->description}}">
                      </div>
                  </div>
                    </div>
                    <div class="mt-3">
                        <input type="submit" value="Lưu" class="btn btn-primary float-left mr-3">
                        <a href="{{route('admin.major.index')}}" class="btn btn-secondary">Hủy</a>
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
