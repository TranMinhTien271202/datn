@extends('client.layout.app')
@section('title')
    {{__('UB Work')}} | {{$job_cat->name}}
@endsection
@section('content')
@section('style')
@parent
<style>
    .page-link{
        border-radius:50%;
        padding: 0px;
    }
    .page-item:last-child .page-link{
        border-top-right-radius: 50%;
        border-bottom-right-radius: 50%;
    }
    .page-item:first-child .page-link{
        border-top-left-radius: 50%;
        border-bottom-left-radius: 50%;
    }
    .form-control:focus{
        box-shadow: none;
    }
    .tt-menu{
        left: -25px !important;
        top: 80px !important;
        width: 435px;
        border-radius: 5px;
    }
    .tt-dataset{
        border-radius: 5px; 
    }
    .tt-dataset a{
        font-family: 'Roboto', sans-serif;
    }
    .tt-dataset a:hover{
            color:#f7941d;
    }
</style>
@endsection
    <section class="page-title">
        <div class="auto-container">
            <div class="title-outer">
                <h1>{{$job_cat->name}}</h1>
                <ul class="page-breadcrumb">
                    <li><a href="/">Trang chủ</a></li>
                    <li>Công việc</li>
                </ul>
            </div>
        </div>
    </section>
    <section class="ls-section">
        <div class="auto-container">
            <div class="filters-backdrop"></div>
            <div class="row">
                <div class="job-search-form">
                    <form method="get" action="job-search">
                        <div class="row">
                            <!-- Form Group -->
                            <div class="form-group col-lg-4 col-md-12 col-sm-12">
                                <span class="icon flaticon-search-1"></span>
                                <input type="text" class="form-control search-input" name="search" placeholder="Mời Nhập Từ Khóa">
                            </div>
                            <div class="form-group col-lg-3 col-md-12 col-sm-12">
                                <span class="icon fa fa-history"></span>
                                <select name="type" id="" class="chosen-select">
                                    <option value="">Mời Chọn</option>
                                    <option value="1">Intern</option>
                                    <option value="2">Part Time</option>
                                    <option value="3">Full Time</option>
                                </select>
                            </div>
                            <div class="form-group col-lg-3 col-md-12 col-sm-12">
                                <span class="icon flaticon-briefcase"></span>
                                <select name="major" class="chosen-select">
                                    <option value="">Chuyên Ngành</option>
                                    @foreach ($maJor as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- Form Group -->
                            <div class="form-group col-lg-2 col-md-12 col-sm-12 text-right">
                                <button type="submit" class="theme-btn btn-style-one">Tìm Kiếm</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="content-column col-lg-12">
                    <div class="ls-outer">
                        <!-- ls Switcher -->
                        {{-- <div class="ls-switcher">
                            <div class="showing-result show-filters">
                                <button type="button" class="theme-btn toggle-filters"><span
                                        class="icon icon-filter"></span> Filter</button>
                                <div class="text">Showing <strong>41-60</strong> of <strong>944</strong> jobs</div>
                            </div>
                            <div class="sort-by">
                                <select class="chosen-select">
                                    <option>New Jobs</option>
                                    <option>Freelance</option>
                                    <option>Full Time</option>
                                    <option>Internship</option>
                                    <option>Part Time</option>
                                    <option>Temporary</option>
                                </select>

                                <select class="chosen-select">
                                    <option>Show 10</option>
                                    <option>Show 20</option>
                                    <option>Show 30</option>
                                    <option>Show 40</option>
                                    <option>Show 50</option>
                                    <option>Show 60</option>
                                </select>
                            </div>
                        </div> --}}

                        <div class="row">
                            <!-- Job Block -->
                            @foreach ($data as $item)
                            <div class="job-block col-lg-6 col-md-12 col-sm-12">
                                <div class="inner-box">
                                    <div class="content">
                                        <span class="company-logo"><img src="{{asset('storage/'.$item->company->logo)}}"
                                                alt=""></span>
                                        <h4><a href="{{route('job-detail', ['id' => $item->id])}}">{{$item->title}}</a></h4>
                                        <ul class="job-info">
                                            <li><span class="icon flaticon-briefcase"></span>{{$item->major->name}}</li>
                                            <li><span class="icon flaticon-map-locator"></span>{{$item->company->address}}</li>
                                            <li><span class="icon flaticon-clock-3"></span>{{$item->company->working_time}}</li>
                                            <li><span class="icon flaticon-money"></span>{{number_format($item->min_salary, 0, ',', '.')}} - {{number_format($item->max_salary, 0, ',', '.')}} đ</li>
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
                                            @if (!empty($job_short[$item->id]) )
                                                @if($job_short[$item->id]->job_post_id == $item->id)
                                                <a href="{{route('delete_shortlisted', ['id' => $job_short[$item->id]->id])}}" class="bookmark-btn" style="background-color: #f7941d;"><span class="flaticon-bookmark"style="color: white" ></span></a>
                                                @endif
                                            @else
                                                <a href="{{route('shortlisted', ['id' => $item->id])}}" class="bookmark-btn"><span class="flaticon-bookmark" ></span></a>
                                            @endif
                                        @else
                                            <button class="bookmark-btn"><span class="flaticon-bookmark"></span></button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <nav class="ls-pagination mb-5">
                            {{-- <ul>
                                <li class="prev"><a href="#"><i class="fa fa-arrow-left"></i></a></li>
                                <li><a href="#">1</a></li>
                                <li><a href="#" class="current-page">2</a></li>
                                <li><a href="#">3</a></li>
                                <li class="next"><a href="#"><i class="fa fa-arrow-right"></i></a></li>
                            </ul> --}}
                            {{$data->links()}}
                        </nav>

                        <!-- Call To Action -->
                        <!-- End Call To Action -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <input type="hidden" id="value_id" value="{{$job_cat->id}}">
@endsection
@section('script')
@parent
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
<script>

$(document).ready(function($) {
    var id = document.getElementById('value_id').value
    console.log(id);

    var engine1 = new Bloodhound({
        remote: {
            url:`/search/title-cat/${id}?value=%QUERY%`,
            wildcard: '%QUERY%'
        },
        datumTokenizer: Bloodhound.tokenizers.whitespace('value'),
        queryTokenizer: Bloodhound.tokenizers.whitespace
    });

    $(".search-input").typeahead({
        hint: true,
        highlight: true,
        minLength: 1
    }, [
        {
            source: engine1.ttAdapter(),
            name: 'students-name',
            display: function(data) {
                return data.title;
            },
            templates: {
                suggestion: function (data) {
                    return '<a href="/job-detail/' + data.id + '" class="list-group-item">' + data.title + '</a>';
                }
            }
        }, 
    ]);
});

</script>
@endsection
