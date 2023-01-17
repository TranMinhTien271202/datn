@extends('admin.layout.app')
@section('title')
    {{ __('Feedback - Candidate') }}
@endsection

@section('style')
@parent
<link href="{{ asset('css/client_style.css') }}" rel="stylesheet">
@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">{{$title}}</h3>
              <h3 class="card-title float-right mr-3"><a href="{{route('admin.candidate.index')}}">{{__('Danh sách ứng viên')}} ➝</a></h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example2" class="table table-bordered table-striped dataTable dtr-inline">
                <thead>
                <tr>
                  <th>STT</th>
                  <th>{{__('Tên công ty')}}</th>
                  <th>{{__('Tiêu đề / Số sao đánh giá / Sát thực tế ?')}}</th>
                  <th>{{__('Điều hài lòng / chưa hài lòng')}}</th>
                  <th>{{__('Điều thích / cần cải thiện')}}</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($can as $kcan)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            @foreach ( $kcan as $item )
                                <td>{{$item->company_name}}</td>
                                @foreach ( $list as $data )
                                    @if ($data->company_id == $item->id)
                                        <td>
                                            <label class="">Tiêu đề: </label>
                                            <textarea class="form-control" rows="3" cols="30" disabled>{{$data->title}}</textarea>
                                            <div class="rating-css">
                                                <label class="">Số sao: </label>
                                                <?php echo $data->rate?>
                                                <div class="star-icon">
                                                    <input @if($data->rate == 1) checked  @endif type="radio" value="1" id="rating1" disabled>
                                                    <label for="rating1" class="fa fa-star"></label>
                                                    <input @if($data->rate == 2) checked @endif type="radio" value="2" id="rating2" disabled>
                                                    <label for="rating2" class="fa fa-star"></label>
                                                    <input @if($data->rate == 3) checked @endif type="radio" value="3" id="rating3" disabled>
                                                    <label for="rating3" class="fa fa-star"></label>
                                                    <input @if($data->rate == 4) checked @endif type="radio" value="4" id="rating4" disabled>
                                                    <label for="rating4" class="fa fa-star"></label>
                                                    <input @if($data->rate == 5) checked @endif type="radio" value="5" id="rating5" disabled>
                                                    <label for="rating5" class="fa fa-star"></label>
                                                </div>
                                            </div>
                                            <label class=""> CV có sát với thực tế : </label>
                                            <input class="form-control" rows="3" cols="30" 
                                              value="<?php if($data->is_reality == 0){
                                                echo 'Sát thực tế';
                                              }else{
                                                echo 'Không sát thực tế';
                                              }?>" disabled>
                                        </td>
                                        <td>
                                            <label class="">Điều hài lòng: </label>
                                            <textarea class="form-control" rows="3" cols="30" disabled>{{$data->satisfied}}</textarea>
                                            <label class="">Điều chưa hài lòng: </label>
                                            <textarea class="form-control" rows="3" cols="30" disabled>{{$data->unsatisfied}}</textarea>
                                        </td>
                                        <td>
                                            <label class="">Điều thích: </label>
                                            <textarea class="form-control" rows="3" cols="30" disabled>{{$data->like_text}}</textarea>
                                            <label class="">Điều cần cải thiện: </label>
                                            <textarea class="form-control" rows="3" cols="30" disabled>{{$data->improve}}</textarea>
                                        </td>
                                        <td class="project-actions xoa text-right d-flex align-items-center">
                                            <button data-id="{{$data->id}}" class="btn btn-danger btn-delete"><i class="fa fa-trash"></i></button>
                                        </td>
                                    @endif
                                @endforeach
                            @endforeach
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