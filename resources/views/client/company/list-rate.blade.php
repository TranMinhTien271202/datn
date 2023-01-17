@extends('client.layout.app')
@section('title')
    {{__('UB work')}} | Danh sách đánh giá
@endsection
@section('content')
<style>
    iframe {
        width: 100% !important;
    }
    .bty .rating-css input + label {
        font-size:12px !important;
    }
</style>
<section class="job-detail-section" style="margin-top: 90px">
    <!-- Upper Box -->
    <div class="upper-box">
        <div class="auto-container">
            <!-- Job Block -->
            <div class="job-block-seven">
                <div class="inner-box">
                    <div class="content">
                        <span class="company-logo"><img src="{{asset('storage/images/company/' . $company_detail->logo)}}" alt=""></span>
                        <h4><a href="#">{{$company_detail->company_name}}</a></h4>
                        <ul class="job-info">
                            <li><span class="icon flaticon-map-locator"></span> {{$company_detail->address}}</li>
                            <li><span class="icon flaticon-briefcase"></span> {{$company_detail->company_model}}</li>
                        </ul>
                        <ul class="job-other-info">
                            <li class="time">Công việc – {{count($company_job)}}</li>
                        </ul>
                    </div>

                    <div class="btn-box">
                        @if (auth('candidate')->check())
                        <a style="margin-right:10px;" href="{{route('company-detail', ['id' => $company_detail->id])}}" class="theme-btn btn-style-one">Quay lại</a>
                            <a  href="{{route('feedback', ['id' => $company_detail->id])}}" class="theme-btn btn-style-one">Đánh giá</a>
                        @else
                            <a href="{{route('candidate.login')}}" title="Đăng nhập để gửi đánh giá" class="theme-btn btn-style-one">Đánh giá</a>
                        @endif
                        @if (auth('candidate')->check())
                            @if (!empty($idCompanyShort[$company_detail->id]) )
                                @if($idCompanyShort[$company_detail->id]->company_id == $company_detail->id)
                                <a href="{{route('delete_shortlisted_company', ['id' => $idCompanyShort[$company_detail->id]->id])}}"><button class="bookmark-btn" style="background-color: #f7941d;"><span class="flaticon-bookmark" style="color: white" ></span></button></a>
                                @endif
                            @else
                                <a href="{{route('shortlisted_company', ['id' => $company_detail->id])}}"><button class="bookmark-btn"  ><span class="flaticon-bookmark" ></span></button></a>
                            @endif
                        @else
                            <button class="bookmark-btn"><span class="flaticon-bookmark"></span></button>
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
                    <div class="job-detail" style="padding-bottom: 80px;margin: auto; background: #f5f7fc; padding-left: 30px; padding-top: 30px;">
                        <h4>Các đánh giá về {!! $company_detail->company_name !!}</h4>
                        
                        @if($sum >= 5)
                        <div style="max-width: 27%;" class="company-widget">
                            <div class="widget-content">
                                <ul class="company-info mt-0">
                                    <li class="rating-css">
                                        
                                        <div class="star-icon">
                                            <input @if($average > 0 && $average <= 1.5) checked @endif type="radio" value="1" name="rate"id="rating1" disabled>
                                            <label for="rating1" class="fa fa-star"></label>
                                            <input @if($average > 1.5 && $average <= 2.5) checked @endif type="radio" value="2" name="rate" id="rating2" disabled>
                                            <label for="rating2" class="fa fa-star"></label>
                                            <input @if($average > 2.5 && $average <= 3.5) checked @endif type="radio" value="3" name="rate" id="rating3" disabled>
                                            <label for="rating3" class="fa fa-star"></label>
                                            <input @if($average > 3.5 && $average <= 4.5) checked @endif type="radio" value="4" name="rate" id="rating4" disabled>
                                            <label for="rating4" class="fa fa-star"></label>
                                            <input @if($average > 4.5 && $average <= 5) checked @endif type="radio" value="5" name="rate" id="rating5" disabled>
                                            <label for="rating5" class="fa fa-star"></label>
                                        </div>
                                        <span>(<?php echo $average?>)</span>
                                    </li>
                                   
                            </div>
                        </div>
                        @endif

                        <div class="mt-3">
                            <h5>Tổng {{$tong}} lượt đánh giá</h5>
                        </div>
                         
                        <div class="mt-5 bty">
                           @include('client.company.rate_paginate')
                        </div>
                    </div>

                    
                </div>

                <div class="sidebar-column col-lg-4 col-md-12 col-sm-12">
                    <aside class="sidebar">
                        <div class="sidebar-widget company-widget">
                            <div class="widget-content">
                                <ul class="company-info mt-0">
                                  
                                    <li>Loại hình doanh nghiệp: <span>{{$company_detail->company_model}}</span></li>
                                    <li>Thành lập: <span>{{date('d-m-Y', strtotime($company_detail->founded_in))}}</span></li>
                                    @if(isset($company_detail->career))
                                    <li>Lĩnh vực hoạt động: <span>{{$company_detail->career}}</span></li>
                                    @endif
                                    @foreach($workingTime as $wor => $w)
                                        @if(isset($company_detail->working_time) && $company_detail->working_time == $wor)
                                        <li>Thời gian làm việc: <span>{{$w}}</span></li>
                                        @endif
                                    @endforeach
                                    @foreach($team as $tea => $t)
                                        @if(isset($company_detail->team) && $company_detail->team == $tea)
                                        <li>Quy mô: <span>{{$t}}</span></li>
                                        @endif
                                    @endforeach
                                    
                                </ul>
                                @if (empty($company_detail->link_web))

                                @else
                                <div class="btn-box"><a href="{{$company_detail->link_web}}"
                                    class="theme-btn btn-style-three">Website công ty</a></div>
                                @endif

                            </div>
                        </div>

                        @if(!empty($company_detail->map))
                            <div class="sidebar-widget">
                            <!-- Map Widget -->
                            <h4 class="widget-title">Địa điểm</h4>
                            <div class="widget-content">
                                <div class="map-outer mb-0">
                                    @php echo $company_detail->map @endphp
                                </div>
                            </div>
                        </div>
                        @endif
                    </aside>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
@section('script')
  @parent
  <script src="{{asset('js/paginate.js')}}"></script>
  <script>
    $(function() {
        $(document).on("click",".pagination li a,#button_search", function(e) {
            e.preventDefault();
            var url=$(this).attr("href");
            var append = url.indexOf("?") == -1 ? "?" : "&";
            var finalURL = url + append + $("#search").serialize();
            window.history.pushState({}, null, finalURL);
            $.get(finalURL, function(data) {
                $(".bty").html(data);
            });
            return false;
    })})
  </script>
@endsection