<div class="ls-outer" aria-live="polite">
    <div class="row searchpate" id="paginated-list" >
        @foreach ($data as $item)
            @php
                $end_time = strtotime($item->end_date);
                $total = $end_time - $today;
                $day = floor($total / 60 / 60 / 24);
                $start_time = strtotime($item->start_date);
                $days = floor(($today - $start_time) / 60 / 60 / 24);
            @endphp
                <div class="job-block col-lg-6 col-md-12 col-sm-12 pagi">
                    <div class="inner-box" style="height:200px">
                        <div class="content">
                            <span class="company-logo"><img
                                    src="{{ asset('storage/images/company/' . $item->company->logo) }}"
                                    alt=""></span>
                            <h4><a
                                    href="{{ route('job-detail', ['id' => $item->id]) }}">{{ $item->title }}</a>
                            </h4>
                            <ul class="job-info">
                                <li><span
                                        class="icon flaticon-briefcase"></span>{{ $item->major->name }}
                                </li>
                                <li><span
                                        class="icon flaticon-map-locator"></span>{{ $item->company->address }}
                                </li>
                                <li><span
                                        class="icon flaticon-clock-3"></span>{{ $item->company->working_time }}
                                </li>
                                @if($item->min_salary > 0 && $item->max_salary > 0)
                                <li><span class="icon flaticon-money"></span>
                                    {{number_format($item->min_salary, 0, ',', '.')}} - {{number_format($item->max_salary, 0, ',', '.')}}</li>
                                @else
                                <li><span class="icon flaticon-money"></span>Thỏa thuận</li>
                                @endif
                                <li><i class="icon flaticon-clock-3"></i><span>
                                        @if ($day < 0)
                                            <b>Hết hạn.</b>
                                        @else
                                            <b>Còn lại {{ $day }} ngày.</b>
                                        @endif
                                    </span>

                                </li>
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
    <nav class="ls-pagination">
        @if (!empty($urlWith))
            {{$data->appends($urlWith)->links('company.layout.paginate')}}
        @else
            {{$data->links('company.layout.paginate')}}
        @endif
       </nav>
</div>