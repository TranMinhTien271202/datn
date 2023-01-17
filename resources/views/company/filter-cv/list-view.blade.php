<div class="row">
    @foreach ($seekerProfile as $item)
    
    <div class="candidate-block-four col-lg-4 col-md-6 col-sm-12">
        <div class="inner-box">
          @if(!empty($item->image))
          <span class="thumb"><img src="{{ !empty($item->image) ? asset('storage/'. $item->image) : 'https://quarantine.doh.gov.ph/wp-content/uploads/2016/12/no-image-icon-md.png'}}" alt=""></span>
          @else
          <span class="thumb"><img src="{{ !empty($item->candidate->avatar) ? asset('storage/'. $item->candidate->avatar) : 'https://quarantine.doh.gov.ph/wp-content/uploads/2016/12/no-image-icon-md.png'}}" alt=""></span>
          @endif
          <h3 class="name"><a href="#">
            @php
            if(!empty($item->name)){
              $nameAt = $item->name;
              $count = mb_substr($nameAt, 0, 4,'UTF-8');
              echo $count."...";
            }else {
              $nameAt = $item->candidate->name;
              $count = mb_substr($nameAt, 0, 4,'UTF-8');
              echo $count."...";
            }
            @endphp
          </a></h3>
          <span class="cat" style="min-height: 22px">{{ !empty($item->major_id) ? $getMajor[$item->major_id]->name : "Chưa cập nhật"}}</span>
          <ul class="job-info">
            <li style="min-height: 22px;-webkit-line-clamp: 1; -webkit-box-orient: vertical; display: -webkit-box; overflow: hidden;">
            @if (!empty($item->address))
            <span class="icon flaticon-map-locator"></span>{{$item->address}}
            @elseif(!empty($item->candidate->address))
            <span class="icon flaticon-map-locator"></span>{{$item->candidate->address}}
            @endif
          </li>
            
          </ul>
          <ul class="post-tags">
            @if(count($list_skill[$item->id]) > 0)
            @foreach ($list_skill[$item->id] as $sk)
            <li><a href="javascript:void(0)">{{$sk->getNameSkill->name}}</a></li>
            @endforeach
            <li><a href="javascript:void(0)">Xem thêm</a></li>
            @else
            <li><a href="javascript:void(0)">Chưa cập nhật</a></li>
            @endif

          </ul>
          
          
          <div class="d-flex justify-content-between">
            @if (!empty($item->candidate_id))
            <a href="{{route('company.detail-profile.hidden', $item->candidate_id)}}" class="theme-btn btn-style-three">Xem Chi Tiết</a>
            @endif

          </div>
        </div>
      </div>
    @endforeach
  <!-- Candidate block Four -->
</div>

<!-- Pagination -->
<nav class="ls-pagination">
  {{ $seekerProfile->links('company.layout.paginate'); }}
</nav>