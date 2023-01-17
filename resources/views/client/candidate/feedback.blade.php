@extends('client.layout.app')
@section('title')
    {{__('UB work')}} | {{$company_detail->company_name}}
@endsection
@section('content')
    <section class="job-detail-section">
        <!-- Upper Box -->
        <div class="upper-box">
            <div class="auto-container">
                <!-- Job Block -->
                <div class="job-block-seven">
                    <div class="inner-box">
                        <div class="content">
                            <span class="company-logo"><img src="{{asset('storage/'.$company_detail->logo)}}" alt=""></span>
                            <h4><a href="#">{{$company_detail->company_name}}</a></h4>
                            <ul class="job-info">
                                <li><span class="icon flaticon-map-locator"></span> {{$company_detail->address}}</li>
                                <li><span class="icon flaticon-briefcase"></span> Accounting / Finance</li>
                                <li><span class="icon flaticon-telephone-1"></span>{{$company_detail->phone}}</li>
                                <li><span class="icon flaticon-mail"></span>{{$company_detail->email}}</li>
                            </ul>
                            <ul class="job-other-info">
                                <li class="time">Open Jobs – </li>
                            </ul>
                        </div>

                        <div class="btn-box">
                            @if (auth('candidate')->check()) 
                                <a href="{{route('feedback', ['id' => $company_detail->id])}}" class="theme-btn btn-style-one">Feedback</a>
                            @else
                                <button class="theme-btn btn-style-one">Feedback</button>
                            @endif

                            @if (auth('candidate')->check()) 
                                <button class="bookmark-btn"><i class="flaticon-bookmark"></i></button>
                            @else
                                <button class="bookmark-btn"><i class="flaticon-bookmark"></i></button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="job-detail-outer">
            <div class="auto-container">
                <div class="row">
                    <div class="content-column col-lg-8 col-md-12 col-sm-12">
                        <form class="default-form" action="{{ route('saveFeedback', ['id'=> $company_detail->id]) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <!-- Input -->
                        <div class="form-group col-lg-12 col-md-3">
                            <label>Tiêu đề</label>
                            <input type="text" name="title" placeholder="Tóm tắt đánh giá của bạn ví dụ: 'công ty ảo' hoặc 'bạn hr quá xinh đẹp'" value="">
                            @error('title')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                          </div>
                        <!-- Input -->
                        <div class="form-group col-lg-12 col-md-12 rating-css">
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
                      <div class="form-group col-lg-6 col-md-12">
                        <label>Hài Lòng</label>
                        <input type="text" name="satisfied" placeholder="Điều bạn hài lòng" value="">
                        @error('satisfied')
                            <small class="text-danger">{{$message}}</small>
                        @enderror
                      </div>

                      <!-- Input -->
                      <div class="form-group col-lg-6 col-md-12">
                        <label>Chưa hài lòng</label>
                        <input type="text" name="unsatisfied" placeholder="Điều bạn chưa hài lòng" value="">
                        @error('unsatisfied')
                            <small class="text-danger">{{$message}}</small>
                        @enderror
                      </div>

                      <!-- Input -->
                      <div class="form-group col-lg-12 col-md-12">
                        <label>Điều bạn thích ở ứng viên này </label>
                        <textarea type="text" name="like_text" placeholder="Điều bạn thích ở ứng viên này" value=""></textarea>
                        @error('like_text')
                            <small class="text-danger">{{$message}}</small>
                        @enderror
                      </div>

                      <!-- Input -->
                      <div class="form-group col-lg-12 col-md-12">
                        <label>Điều ứng viên cần cải thiện</label>
                        <textarea type="text" name="improve" placeholder="Điều ứng viên cần cải thiện" value=""></textarea>
                        @error('improve')
                            <small class="text-danger">{{$message}}</small>
                        @enderror
                      </div>

                      <div class="form-group col-lg-6 col-md-12">
                        <button type="submit" class="theme-btn btn-style-one">Save</button>
                      </div>
                    </div>
                  </form>
                    </div>
                    <div class="sidebar-column col-lg-4 col-md-12 col-sm-12">
                        <aside class="sidebar">
                            <div class="sidebar-widget company-widget">
                                <div class="widget-content">
                                    <div class="upper-title-box" style="text-align: center; font-weight:bold">
                                        <h3> Hướng Dẫn & Điều Kiện Về Đánh Giá</h3>
                                    </div>
                                    <div class="widget-content">
                                        <div style="font-size: 20px; ">Mọi đánh giá phải tuân thủ Hướng Dẫn & Điều Kiện về đánh giá để được hiển thị trên website.</div>
                                        <div style="font-size: 16px; ">>Xin vui lòng:</div>
                                    <ul class="notification-list">
                                    <li style="padding-left: 0px; font-size: 15px;line-height: 25px; color: #696969; font-weight: 400;min-height: 35px;margin-bottom: 0px;"></span><strong>Không sử dụng từ ngữ mang ý </strong><span class="colored">xúc phạm, miệt thị</span></li>
                                    <li style="padding-left: 0px; font-size: 15px;line-height: 25px; color: #696969; font-weight: 400;min-height: 35px;margin-bottom: 0px;"></span><strong>Không cung cấp</strong><span class="colored">thông tin cá nhân</span></li>
                                    <li class="success" style="padding-left: 0px; font-size: 15px;line-height: 25px; color: #696969; font-weight: 400;min-height: 35px;margin-bottom: 0px;">Không cung cấp<strong>thông tin bảo mật,</strong><span class="colored">bí mật kinh doanh của công ty</span></li>
                                    <li style="padding-left: 0px; font-size: 15px;line-height: 25px; color: #696969; font-weight: 400;min-height: 35px;margin-bottom: 0px;"><strong>Cảm ơn bạn đã đưa ra những đánh giá chân thực nhất. </strong> applied for a job <span class="colored">Xem thêm thông tin chi tiết về Hướng Dẫn & Điều Kiện về đánh giá</span></li>
                                    </ul>
                                </div>
                                </div>
                            </div>
                        </aside>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
