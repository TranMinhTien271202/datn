<div class="widget-content">
  <div class="tabs-box">
    <div class="aplicants-upper-bar">
      <h6>Danh sách ứng viên</h6>
      <ul class="aplicantion-status tab-buttons clearfix">
        <li class="tab-btn totals active-btn" data-tab="#totals">Tổng: {{count($listCV)}}</li>
        
      </ul>
    </div>

    <div class="tabs-content">
      <!--Tab-->
      <div class="tab active-tab animated fadeIn" id="totals" style="display: block;">
        <div class="row">
          @foreach($listCV as $item)
          <div class="candidate-block-three col-lg-6 col-md-12 col-sm-12">
            <div class="inner-box p-4">
              <div class="content">
                <figure class="image"><img src="{{!empty($item->seeker_profile->image) ? asset('storage/'.  $item->seeker_profile->image) : asset('assets/admin-bower/dist/img/avatar.png') }}" alt=""></figure>
                <h4 class="name"><a href="#">
                  @if(!empty($item->seeker_profile->name))
                  {{$item->seeker_profile->name}}
                  @else
                  {{$infoCandidate[$item->seeker_profile->candidate_id]->name}}
                  @endif
                </a></h4>
                <ul class="candidate-info">
                  <li class="designation">
                    @foreach($major as $mj)
                    {{  $item->seeker_profile->major_id == $mj->id ? $mj->name : ''}}
                    @endforeach
                  </li>
                  @if(!empty($item->seeker_profile->address))
                  <li><span class="icon flaticon-map-locator"></span> 
                    {{$item->seeker_profile->address}}
                  </li>
                  @elseif($infoCandidate[$item->seeker_profile->candidate_id]->address)
                  <li><span class="icon flaticon-map-locator"></span> 
                    {{$infoCandidate[$item->seeker_profile->candidate_id]->address}}
                  </li>
                  @endif
                </ul>
                <ul class="post-tags" style="">
                  @foreach($list_skill[$item->seeker_id] as $sk)
                  <li style="margin-bottom: 10px;"><a href="javascript:void(0)">{{$sk->getNameSkill->name}}</a></li>
                  @endforeach
                </ul>
              </div>
              <div class="option-box">
                <ul class="option-list">
                  <li><a target="_blank" href="{{route('company.detail-candidate.index', ['id' => $item->seeker_profile->candidate_id ])}}" data-text="Chi tiết"><span class="la la-eye"></span></a></li>
                  {{-- <li><a data-text="Phê duyệt"><span class="la la-check"></span></a></li>
                  <li><a data-text="Từ chối"><span class="la la-times-circle"></span></a></li> --}}
                  <li><span>{{$get_data[$item->seeker_id]['is_see'] == 0 ? 'Chưa xem' : 'Đã xem'}}</span></li>
                </ul>
              </div>
            </div>
          </div>
          @endforeach
        </div>
        <div class="ls-pagination">{{ $listCV->links('company.layout.paginate'); }}</div>
      </div>
    </div>
  </div>
</div>