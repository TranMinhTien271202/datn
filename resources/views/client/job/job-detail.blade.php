@extends('client.layout.app')
@section('title')
    {{__('UB Work')}} | {{$data_job->title}}
@endsection
@section('content')
<style>
  iframe {
      width: 100% !important;
  }
</style>
    <section class="job-detail-section mt-5">
      <!-- Upper Box -->
      <div class="upper-box" style="background-image: url({{asset('storage/images/bg-4.png')}}) ">
        <div class="auto-container">
          <!-- Job Block -->
          <div class="job-block-seven">
            <div class="inner-box">
              <div class="content">
                <span class="company-logo"><img src="{{asset('storage/images/company/'.$data_job->company->logo)}}"></span>
                <h4><a href="{{route('job-detail', ['id' => $data_job->id])}}">{{$data_job->title}}</a></h4>
                <ul class="job-info">
                  {{-- <li><span class="icon flaticon-briefcase"></span> {{$data_job->major->name}}</li> --}}
                  <li><span class="icon flaticon-map-locator"></span>{{$data_job->company->address}}</li>
                  <li><span class="icon flaticon-clock-3"></span>{{$data_job->company->working_time}}h/ngày</li>
                  @if($data_job->min_salary > 0 && $data_job->max_salary > 0)
                  <li><span class="icon flaticon-money"></span> {{number_format($data_job->min_salary)}} - {{number_format($data_job->max_salary)}}</li>
                  @else
                  <li><span class="icon flaticon-money"></span>Thỏa thuận</li>
                  @endif
                </ul>
                <ul class="job-other-info">
                  @foreach (config('custom.type_work') as $value)
                      @if($value['id'] == $data_job->type_work)
                          <li class="time">
                              {{$value['name']}}
                          </li>
                      @endif
                  @endforeach
                </ul>
              </div>

              <div class="btn-box">
                @if (auth('candidate')->check())
                    @if (!empty($idJobApplied[$data_job->id]) )
                      @if($idJobApplied[$data_job->id]->job_post_id == $data_job->id )
                      <button class="theme-btn btn-style-one" >Đã ứng tuyển</button>
                      @endif
                    @else
                      @if(!empty($seeker->id))
                      <a href="{{route('modal_selectCV')}}" data-id-job="{{$data_job->id}}" class="theme-btn btn-style-one call-modal">Ứng tuyển ngay</a>
                      @else 
                      <a href="{{route('createNew')}}" class="theme-btn btn-style-one">Ứng tuyển ngay</a>
                      @endif
                    @endif
                @else
                  <a class="theme-btn btn-style-one" href="{{route('candidate.login',['job_id'=>$data_job->id])}}">Ứng tuyển ngay</a>
                @endif
                @if (auth('candidate')->check())
                    @if (!empty($idJobShort[$data_job->id]))
                        @if ($idJobShort[$data_job->id]->job_post_id == $data_job->id)
                            <a data-shortlistId="{{$idJobShort[$data_job->id]->id}}" data-id="{{$data_job->id}}"
                                class="bookmark-btn btn-shortlisted"><span class="flaticon-bookmark"
                                    style="color: #f7941d"></span></a>
                        @endif
                    @else
                        <a  data-id="{{$data_job->id}}" data-shortlistId=""
                            class="bookmark-btn btn-shortlisted"><span class="flaticon-bookmark"
                                style="color: black"></span></a>
                    @endif
                @else
                
                    <a href="{{route('candidate.login')}}" class="bookmark-btn"><span class="flaticon-bookmark"  style="color: black"></span></a>
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
              <div class="job-detail">
                <h4>Mô tả công việc</h4>
                <p>{!! $data_job->description !!}</p>
                <h4>Yêu cầu công việc</h4>
                <ul class="list-style-three">
                  {!! $data_job->requirement !!}
                </ul>
                @if(!empty($data_job->benefits))
                <h4>Quyền lợi</h4>
                <ul class="list-style-three">
                  {!! $data_job->benefits !!}
                </ul>
                @endif
                <h4>Kinh nghiệm</h4>
                <ul class="list-style-three">
                  @foreach (config('custom.experience') as $value)
                  @if($data_job->experience == $value['id'])
                  <li>{{$value['name']}}</li>
                  @endif
                  @endforeach
                </ul>
              </div>


              <!-- Related Jobs -->
              <div class="related-jobs">
                <div class="title-box">
                  <h3>Công việc liên quan</h3>
                  <div class="text">{{count($data_job_relate)}} việc làm.</div>
                </div>

                <!-- Job Block -->
                @foreach ($data_job_relate as $item)
                    <div class="job-block">
                        <div class="inner-box">
                            <div class="content">
                            <span class="company-logo"><img src="{{asset('storage/images/company/'.$item->company->logo)}}" alt=""></span>
                            <h4><a href="{{route('job-detail', ['id' => $item->id])}}">{{$item->title}}</a></h4>
                            <ul class="job-info">
                                {{-- <li><span class="icon flaticon-briefcase"></span>{{$item->major->name}}</li> --}}
                                <li><span class="icon flaticon-map-locator"></span>{{$item->company->address}}</li>
                                <li><span class="icon flaticon-clock-3"></span>{{$item->company->working_time}} giờ/ngày</li>
                                @if($item->min_salary > 0 && $item->max_salary > 0)
                                <li><span class="icon flaticon-money"></span>{{number_format($item->min_salary)}} - {{number_format($item->max_salary)}}</li>
                                @else
                                <li><span class="icon flaticon-money"></span>Thỏa thuận</li>
                                @endif
                              </ul>
                            <ul class="job-other-info">
                                 @foreach (config('custom.type_work') as $value)
                                      @if($value['id'] == $item->type_work)
                                          <li class="time">
                                              {{$value['name']}}
                                          </li>
                                      @endif
                                  @endforeach
                            </ul>
                            @if (auth('candidate')->check())
                                @if (!empty($job_short[$item->id]))
                                    @if ($job_short[$item->id]->job_post_id == $item->id)
                                        <a data-shortlistId="{{$job_short[$item->id]->id}}" data-id="{{$item->id}}"
                                            class="bookmark-btn btn-shortlisted"><span class="flaticon-bookmark"
                                                style="color: #f7941d"></span></a>
                                    @endif
                                @else
                                    <a  data-id="{{$item->id}}" data-shortlistId=""
                                        class="bookmark-btn btn-shortlisted"><span class="flaticon-bookmark"
                                            style="color: black"></span></a>
                                @endif
                            @else
                                <button class="bookmark-btn"><span class="flaticon-bookmark"
                                        style="color: black"></span></button>
                                <a href="{{route('candidate.login')}}" class="bookmark-btn"><span class="flaticon-bookmark"  style="color: black"></span></a>
                            @endif
                            </div>
                        </div>
                    </div>
                @endforeach
              </div>
              <div class="related-jobs">
                <div class="title-box">
                  <h3>Giới thiệu về công ty</h3>
                </div>

                <!-- Job Block -->
                @if(!empty($data_job->company->about))
                    <div class="job-block">
                        <div class="inner-box">
                            <div class="content">
                              {!! $data_job->company->about !!}
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="job-block">
                      <div class="inner-box">
                          <div class="content">
                            Chưa có thông tin
                          </div>
                      </div>
                  </div>
                  @endif
              </div>
            </div>

            <div class="sidebar-column col-lg-4 col-md-12 col-sm-12">
              <aside class="sidebar">
                <div class="sidebar-widget">
                  <!-- Job Overview -->
                  <h4 class="widget-title">Tổng quan về công việc</h4>
                  <div class="widget-content">
                    <ul class="job-overview">
                      <li>
                        <i class="icon icon-calendar"></i>
                        <h5>Ngày đăng:</h5>
                        <span>{{date("d-m-Y", strtotime($data_job->created_at))}}</span>
                      </li>
                      <li>
                        <i class="icon icon-expiry"></i>
                        <h5>Ngày hết hạn:</h5>
                        <span>{{date("d-m-Y", strtotime($data_job->end_date))}}</span>
                      </li>
                      <li>
                        <i class="icon icon-location"></i>
                        <h5>Địa điểm:</h5>
                        <span>{{$data_job->company->address}}</span>
                      </li>
                      <li>
                        <i class="icon icon-clock"></i>
                        <h5>Giờ làm việc:</h5>
                        <span>{{$data_job->company->working_time}} giờ/ngày</span>
                      </li>
                      <li>
                        <i class="icon icon-salary"></i>
                        <h5>Lương:</h5>
                        @if($data_job->min_salary > 0 && $data_job->max_salary > 0)
                         <span>{{number_format($data_job->min_salary, 0, ',', '.')}} - {{number_format($data_job->max_salary, 0, ',', '.')}} đ</span>
                         @else
                         <li>Thỏa thuận</li>
                         @endif
                        </li>
                    </ul>
                  </div>

                  <!-- Map Widget -->
                  {{-- <h4 class="widget-title">Đia điểm</h4>
                  <div class="widget-content">
                    <div class="map-outer">
                      <div class="map-canvas">
                        <iframe class="map-canvas" width="100%" src="{{$data_job->company->map}}" frameborder="0"></iframe>
                      </div>
                    </div>
                  </div> --}}

                  <!-- Job Skills -->
                  <h4 class="widget-title">Kỹ năng</h4>
                  
                  <div class="widget-content">
                    <ul class="job-skills">
                      @foreach($skills as $item)
                      @if(in_array($item['id'],$skillActive))
                      <li><a href="javascript:void(0)">{{$item->name}}</a></li>
                      @endif
                      @endforeach
                    </ul>
                  </div>

                </div>

                <div class="sidebar-widget company-widget">
                  <div class="widget-content">
                    <div class="company-title">
                      <div class="company-logo"><img src="{{asset('storage/images/company/'.$data_job->company->logo)}}" alt=""></div>
                      <h5 class="company-name">{{$data_job->company->company_name}}</h5>
                      <a target="_blank" href="{{route('company-detail', ['id' => $data_job->company->id])}}" class="profile-link">Thông tin công ty</a>
                    </div>

                    <ul class="company-info">
                      <li>Loại hình doanh nghiệp: <span>{{$data_job->company->company_model}}</span></li>
                      {{-- <li>Quy mô: <span>{{$data_job->company->company_size}}</span></li> --}}
                      <li>Thành lập: <span>{{date('d-m-Y', strtotime($data_job->company->founded_in))}}</span></li>
                      <li>Địa điểm: <span>{{$data_job->company->address}}</span></li>
                      {{-- <li>Truyền thông xã hội:
                        <div class="social-links">
                          <a href="#"><i class="fab fa-facebook-f"></i></a>
                          <a href="#"><i class="fab fa-twitter"></i></a>
                          <a href="#"><i class="fab fa-instagram"></i></a>
                          <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                      </li> --}}
                    </ul>
                    @if(!empty($data_job->company->link_web))
                    <div class="btn-box"><a target="_blank" href="{{$data_job->company->link_web}}" class="theme-btn btn-style-three">Website công ty</a></div>
                  @endif
                  </div>
                </div>

                @if(!empty($data_job->company->map))
                    <div class="sidebar-widget">
                    <!-- Map Widget -->
                    <h4 class="widget-title">Địa điểm của {{$data_job->company->company_name}}</h4>
                    <div class="widget-content">
                        <div class="map-outer mb-0">
                            @php echo $data_job->company->map @endphp
                        </div>
                    </div>
                </div>
                @endif

                @if(!empty($data_job->company->iframe_ytb))
                    <div class="sidebar-widget">
                    <!-- Map Widget -->
                    <h4 class="widget-title">Video của {{$data_job->company->company_name}}</h4>
                    <div class="widget-content">
                        <div class="map-outer mb-0">
                            @php echo $data_job->company->iframe_ytb @endphp
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
  <script src="{{asset('assets/client-bower/js/jquery.modal.min.js')}}"></script>
  <script src="{{asset('js/client/shortlist.js')}}"></script>
  <script>
    updateShortList();
    // Open modal in AJAX callback
	$('.call-modal').on('click', function(event) {
	  event.preventDefault();
	  this.blur();
	  $.get(this.href, function(html) {
	    $(html).appendTo('body').modal({
	    	closeExisting: true,
			fadeDuration: 300,
			fadeDelay: 0.15
	    });
	  });
	});
    $('.call-modal2').on('click', function(event) {
	  event.preventDefault();
	  this.blur();
    var id = $(this).data('id-job');
    console.log(id);
	  $.get(this.href, function(html) {
          $(html).appendTo('body').modal({
            closeExisting: true,
          fadeDuration: 300,
          fadeDelay: 0.15
          });
        });
      });
  </script>
  <script>
    
  </script>
@endsection