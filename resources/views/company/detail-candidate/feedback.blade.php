@extends('company.layout.app')
@section('title')
{{__('UB Work')}} | {{$title}}
@endsection
@section('style')
@parent
<link href="{{ asset('css/client_style.css') }}" rel="stylesheet">
@endsection
@section('content')
    <section class="job-detail-Section ls-widget">
        <!-- Upper Box -->
        <div class="upper-box">
            <div class="auto-container">
                <!-- Job Block -->
                <div class="job-block-seven">
                    <div style="text-align:center; display:block;" class="inner-box">
                        <div style="padding-top:50px" class="">
                            {{-- <span class="company-logo"><img src="{{asset('storage/'.$data->image)}}" alt=""></span> --}}
                            <h4><a href="#">Đánh giá</a></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div style="padding: 30px 30px;" class="job-detail-outer">
            <div class="auto-container">
                <div class="row justify-content-center">
                    <div class="content-column col-lg-8 col-md-12 col-sm-12">
                        <form class="default-form" action="{{ route('company.saveFeedback', ['id'=> $data->id]) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <!-- Input -->
                        <div class="form-group col-lg-12 col-md-3">
                            <label>Tiêu đề</label>
                            <input type="text" name="title" placeholder="Tóm tắt đánh giá của bạn ví dụ: 'cv ảo' hoặc 'ứng viên điền sai thông tin'" value="">
                            @error('title')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        <!-- Input -->
                        <div class="form-group col-lg-6 col-md-12 rating-css">
                            <label>Đánh giá</label>
                            <div class="star-icon">
                                <input type="radio" value="1" name="rate" checked id="rating1">
                                <label for="rating1" class="fa fa-star"></label>
                                <input type="radio" value="2" name="rate" id="rating2">
                                <label for="rating2" class="fa fa-star"></label>
                                <input type="radio" value="3" name="rate" id="rating3">
                                <label for="rating3" class="fa fa-star"></label>
                                <input type="radio" value="4" name="rate" id="rating4">
                                <label for="rating4" class="fa fa-star"></label>
                                <input type="radio" value="5" name="rate" id="rating5">
                                <label for="rating5" class="fa fa-star"></label>
                            </div>
                        </div>
                        {{-- select --}}
                        <div class="form-group col-lg-6 col-md-12">
                            <label>CV ứng viên có sát thực tế ?</label>
                            <select class="chosen-select" name="reality">
                                <option value="0">Sát thực tế</option>
                                <option value="1">Không sát thực tế</option>
                            </select>
                        </div>
                        <div class="form-group col-lg-6 col-md-12">
                            <label>Hài Lòng</label>
                            <input type="text" name="satisfied" placeholder="ví dụ: ' ứng viên có trình độ '" value="">
                            @error('satisfied')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>

                        <!-- Input -->
                        <div class="form-group col-lg-6 col-md-12">
                            <label>Chưa hài lòng</label>
                            <input type="text" name="unsatisfied" placeholder="ví dụ:' kỹ năng hạn chế ' " value="">
                            @error('unsatisfied')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>

                        <!-- Input -->
                        <div class="form-group col-lg-12 col-md-12">
                            <label>Điều bạn thích ở ứng viên này </label>
                            <textarea type="text" name="like_text" placeholder="Ví dụ: 'còn trẻ có thể thay đổi trong tương lai' hay 'nhân tố tốt, phù hợp với môi trường văn phòng '" value=""></textarea>
                            @error('like_text')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>

                        <!-- Input -->
                        <div class="form-group col-lg-12 col-md-12">
                            <label>Điều ứng viên cần cải thiện</label>
                            <textarea type="text" name="improve" placeholder="Ví dụ:'cần cải thiện khả năng giao tiếp' hay 'nêm tham gia nhiều hoạt động ngoại khóa hơn để tăng tính đồng đội ' " value=""></textarea>
                            @error('improve')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>

                        <div class="form-group col-lg-6 col-md-12">
                            <button type="submit" class="theme-btn btn-style-one">Gửi</button>
                            <a style="margin-left:30px" href="{{route('company.detail-candidate.index', ['id' => $data->id ])}}" class="btn btn-theme-btn btn-style-one">Quay lại</a>
                        </div>
                    </div>
                </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection