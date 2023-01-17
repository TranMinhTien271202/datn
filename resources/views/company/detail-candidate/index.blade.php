@extends('company.layout.app')
@section('title')
{{__('UB Work')}} | {{$title}}
@endsection
@section('content')

<section class="candidate-detail-section style-three" style=" background-color: white;">
    <div class="upper-box mb-0">
      <div class="auto-container">
        <div class="candidate-block-six" >
          <div class="inner-box">
            {{-- @dd($data['candidate']) --}}
            @if(empty($data->image))
            <figure class="image"><img src="{{!empty($data['candidate']->avatar) ? asset('storage/'. $data['candidate']->avatar) : 'https://quarantine.doh.gov.ph/wp-content/uploads/2016/12/no-image-icon-md.png' }}" alt=""></figure>
            @else
            <figure class="image"><img src="{{!empty($data->image) ? asset('storage/'. $data->image) : 'https://quarantine.doh.gov.ph/wp-content/uploads/2016/12/no-image-icon-md.png' }}" alt=""></figure>
            @endif
            <h4 id="nameSeeker" class="name" style="bottom: 15px">
              @if(!empty($data->name))
              {{$data->name}}
              @else
              {{$data['candidate']->name}}
              @endif
            </h4>
            <span class="designation">{!!$data['major']->name ?? ''!!}</span>
            <div class="content">
              <ul class="candidate-info justify-content-center">
                @if ($data->address ?? '')
                <li><span class="icon flaticon-map-locator"> </span>{{$data->address ?? ''}}</li>
                @endif
              </ul>
              <div class="btn-box">
              @if(!empty($data->path_cv))
                <a href="{{route('company.feedback',['id' => $data->candidate_id])}}" style="width: 49%;cursor: pointer; margin-right:30px" class="btn_unlock theme-btn btn-style-one">Đánh giá</a>

                <a href="{{asset('upload/cv/'.$data->path_cv)}}" target="_blank" style="width: 49%;cursor: pointer;" class="btn_unlock theme-btn btn-style-one">Tải CV</a>
              @endif
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="candidate-detail-outer">
      <div class="auto-container">
        <div class="row">
          <div class="content-column col-lg-8 col-md-12 col-sm-12 order-2">
            <div class="job-detail">
              <h4>Giới Thiệu</h4>
              <p>{{$data->description ?? 'Chưa cập nhật'}}</p>
              <div class="resume-outer">
                <div class="upper-title">
                  <h4>Học vấn</h4>
                </div>
                <!-- Resume BLock -->
                @if(count($education) > 0)
                @foreach ($education as $item)
                <div class="resume-block">
                  <div class="inner">
                    <span class="name">M</span>
                    <div class="title-box">
                      <div class="info-box">
                        
                        <h3>{{$item['name_education'] ?? ''}}</h3>
                        <span>{{$item['type_degree']}}</span>
                        
                        
                      </div>
                      
                      <div class="edit-box">
                        <span class="year">{{\Carbon\Carbon::parse($item['start_date'])->format('d/m/Y')}} @if(!empty($item['end_date'])) - {{\Carbon\Carbon::parse($item['end_date'])->format('d/m/Y')}} @else - Hiện tại @endif</span>
                        <div class="edit-btns">
                        </div>
                      </div>
                    </div>
                    <div class="text">{{$item['description']}}</div>
                  </div>
                </div>
                @endforeach
                @else
                Chưa cập nhật
                @endif
              </div>

              <!-- Resume / Work & Experience -->
              <div class="resume-outer theme-blue">
                <div class="upper-title">
                  <h4>Kinh nghiệm làm việc</h4>
                </div>
                <!-- Resume BLock -->
                @if(count($exp) > 0)
                @foreach ($exp as $item)
                <div class="resume-block">
                  <div class="inner">
                    <span class="name">S</span>
                    <div class="title-box">
                      <div class="info-box">
                        <h3>{{$item['company_name']}}</h3>
                        <span>{{$item['position']}}</span>
                      </div>
                      <div class="edit-box">
                        <span class="year">{{\Carbon\Carbon::parse($item['start_date'])->format('d/m/Y')}} @if(!empty($item['end_date'])) - {{\Carbon\Carbon::parse($item['end_date'])->format('d/m/Y')}} @else - Hiện tại @endif </span>
                      </div>
                    </div>
                    <div class="text">{{$item['description']}}</div>
                  </div>
                </div>
                @endforeach
                @else
                Chưa cập nhật
                @endif

                <!-- Resume BLock -->
              </div>
              <!-- Resume / Awards -->
              <div class="resume-outer theme-yellow">
                <div class="upper-title">
                  <h4>Chứng chỉ</h4>
                </div>
                @if(count($exp) > 0)
                @foreach($certificate as $cer)
                <!-- Resume BLock -->
                <div class="resume-block">
                  <div class="inner">
                    <span class="name"></span>
                    <div class="title-box">
                      <div class="info-box">
                        <h3>{{$cer->name}}</h3>
                        <span></span>
                      </div>
                      <div class="edit-box">
                        <span class="year">{{$cer->time}}</span>
                      </div>
                    </div>
                  </div>
                </div>
                @endforeach
                @else
                Chưa cập nhật
                @endif
              </div>
              <!-- Video Box -->
            </div>
          </div>

          <div class="sidebar-column col-lg-3 col-md-12 col-sm-12">
            <aside class="sidebar">

              <div class="sidebar-widget" style="word-break:break-word;">
                <div class="widget-content">
                  <ul class="job-overview">
                    @if(!empty($data->total_exp))
                    <li>
                      <i class="icon icon-calendar"></i>
                      <h5>Kinh nghiệm:</h5>
                      <span>{{floor($data->total_exp) == 0 ? 'chưa có kinh nghiệm' : floor($data->total_exp) }} Năm</span>
                    </li>
                    @endif
                    @if(!empty($data['candidate']->birthday))
                    <li>
                      <i style="color: #1967d2;font-size: 20px;" class="icon icon-expiry"></i>
                      <h5>Tuổi:</h5>
                      @php
                      $sn = strtotime($data['candidate']->birthday);
                      $timeNow = strtotime($timeNow);

                      $tong = $timeNow - $sn;
                      $day = floor($tong / 60 / 60 / 24 /30/12);
                      @endphp
                      <span>{{$day}}</span>
                    </li>
                    @endif
                    @isset($data['candidate']->gender)
                    <li>
                      <i style="color: #1967d2;font-size: 20px;"  class="icon fa fa-user"></i>
                      <h5>Giới Tính:</h5>
                      @if ($data['candidate']->gender == 1 )
                      <span>Nam</span>
                      @else 
                      <span>Nữ</span>
                      @endif
                    </li>
                    @endisset
                    
                    @if(!empty($data->email))
                    <li>
                      <i style="color: #1967d2;font-size: 20px;" class="icon fa fa-mail-bulk"></i>
                      <h5>Email:</h5>
                      {{$data->email}}
                    </li>
                    @endif

                    @isset($data->phone)
                    <li>
                      <i style="color: #1967d2;font-size: 20px;" class="icon fa fa-phone"></i>
                      <h5>Số điện thoại:</h5>
                      +{{$data->phone}}
                    </li>
                    @endisset

                  </ul>
                </div>
              </div>
              <div class="sidebar-widget">
                  <!-- Job Skills -->
                  <h4 class="widget-title">Kỹ năng</h4>
                  <div class="widget-content">
                    <ul class="job-skills">
                      @forelse ($seekerSkill as $item)
                      <li><a href="javascript:void(0)">{!!$item->getNameSkill->name!!}</a></li>
                      @empty
                      <li><a href="javascript:void(0)">Chưa cập nhật</a></li>
                      @endforelse
                    </ul>
                  </div>
                </div>
            </aside>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection