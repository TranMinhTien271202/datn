@extends('client.layout.app')
@section('title')
    {{ __('UB Work') }} | {{ __('Danh sách công việc') }}
@endsection
@section('content')
    <style>
        .page-link {
            border-radius: 50%;
            padding: 0px;
        }

        .page-item:last-child .page-link {
            border-top-right-radius: 50%;
            border-bottom-right-radius: 50%;
        }

        .page-item:first-child .page-link {
            border-top-left-radius: 50%;
            border-bottom-left-radius: 50%;
        }
        @import url('https://fonts.googleapis.com/css2?family=Inter&display=swap');

body {
  font-family: 'Inter', sans-serif;
  line-height: 1.7;
  font-size: 1.1rem;
  margin: 0;
  color: #27253d;
  background: #e6f3f8;
}

main {
  position: relative;
  padding: 1rem 1rem 3rem;
  min-height: calc(100vh - 4rem);
}

h1 {
  margin-top: 0;
}

.hidden {
  display: none;
}

.pagination-container {
    text-align: center
}

.pagination-number,
.pagination-button{
  font-size: 1.1rem;
  background-color: transparent;
  border: none;
  margin: 0.25rem 0.25rem;
  cursor: pointer;
  height: 2.5rem;
  width: 2.5rem;
  border-radius: .2rem;
}
.pagination-number:hover,
.pagination-button:not(.disabled):hover {
  background: #fff;
}

.pagination-number.active {
  color: #fff;
  background: #0085b6;
}

footer {
  padding: 1em;
  text-align: center;
  background-color: #FFDFB9;
}

footer a {
  color: inherit;
  text-decoration: none;
}

footer .heart {
  color: #DC143C;
}
    </style>
    <section class="page-title" style="margin-top: 100px">
        <div class="auto-container">
            <div class="title-outer">
                <h1>Danh sách công việc </h1>
                <ul class="page-breadcrumb">
                    <li><a href="{{route('index')}}">Trang chủ</a></li>
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
                    <div class="row">
                        <div class="form-group col-lg-4 col-md-12 col-sm-12" style="width:370px">
                            <span class="icon flaticon-search-1"></span>
                            <input type="text" class="form-control search-input" id="search-text" name="search"
                                placeholder="Mời Nhập Từ Khóa">
                        </div>
                        <div class="form-group col-lg-3 col-md-12 col-sm-12" style="width:230px">
                            <span class="icon fa fa-history"></span>
                            <select name="type" id="search-type" class="chosen-select">
                                <option value="">Mời Chọn</option>
                                <option value="1">Intern</option>
                                <option value="2">Part Time</option>
                                <option value="3">Full Time</option>
                            </select>
                        </div>
                        <div class="form-group col-lg-3 col-md-12 col-sm-12" style="width:230px">
                            <span class="icon flaticon-briefcase"></span>
                            <select name="major" id="search-major" class="chosen-select">
                                <option value="">Chuyên Ngành</option>
                                @foreach ($maJor as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-lg-3 col-md-12 col-sm-12" style="width:230px">
                            <span class="icon flaticon-briefcase"></span>
                            <select name="skill" id="search-skill" class="chosen-select">
                                <option value="">Kỹ Năng</option>
                                @foreach ($Skill as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-lg-2 col-md-12 col-sm-12 text-right">
                            <button type="submit" class="theme-btn btn-style-one btn-search">Tìm Kiếm</button>
                        </div>
                    </div>
                </div>
                <div class="content-column col-lg-12">
                    <div class="ls-outer" data-current-page="1" aria-live="polite">
                        <div class="row searchpate" id="paginated-list" >

                            @if (!empty($data))
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
                                                    <li><span class="icon flaticon-money"></span>
                                                        {{number_format($item->min_salary, 0, ',', '.')}} - {{number_format($item->max_salary, 0, ',', '.')}}</li>

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
                                                    <a href="{{ route('shortlisted', ['id' => $item->id]) }}"><button
                                                            class="bookmark-btn"><span
                                                                class="flaticon-bookmark"></span></button></a>
                                                @else
                                                    <button class="bookmark-btn"><span
                                                            class="flaticon-bookmark"></span></button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                            @endforeach
                            @endif

                        </div>
                    </div>
                </div>
            </div>
            <nav class="pagination-container">
                <button class="pagination-button" id="prev-button" aria-label="Previous page" title="Previous page">

                </button>
                <div id="pagination-numbers">

                </div>
                <button class="pagination-button" id="next-button" aria-label="Next page" title="Next page">
                </button>
              </nav>
            </main>
        </div>
    </section>
@endsection
@section('script')
    @parent
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('.btn-search').on('click',function(){
            var searchText = $('#search-text').val();
            var searchType = $('#search-type').val();
            var searchMajor = $('#search-major').val();
            var searchSkill = $('#search-skill').val();
            var url=$(this).attr("href");
                $.ajax({
                    method: "post",
                    url:'job-searchs',
                    data: JSON.stringify({
                        searchText:searchText,
                        searchMajor:searchMajor,
                        searchType:searchType,
                        searchSkill:searchSkill
                    }),
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    dataType: "json",
                    success: function(data) {
                        var searchpateAjax = '';
                        $('.searchpate').show();
                        for (job of data) {
                            searchpateAjax += `<div class="job-block col-lg-6 col-md-12 col-sm-12 pagi" style="height:200px">
                                        <div class="inner-box">
                                            <div class="content">
                                                <span class="company-logo"><img
                                                        src="storage/images/company/`+job.company.logo+`"
                                                        alt=""></span>
                                                <h4><a
                                                        href="{{url('/job-detail/`+job.id+`')}}">`+job.title+`</a>
                                                </h4>
                                                <ul class="job-info">
                                                    <li><span
                                                            class="icon flaticon-briefcase"></span>`+job.major.name+`
                                                    </li>
                                                    <li><span
                                                            class="icon flaticon-map-locator"></span>`+job.company.address+`
                                                    </li>
                                                    <li><span
                                                            class="icon flaticon-clock-3"></span>`+job.company.working_time+`
                                                    </li>
                                                    <li><span class="icon flaticon-money"></span>
                                                        `+job.min_salary+` -
                                                        `+job.max_salary+`
                                                        </li>
                                                </ul>
                                                <ul class="job-other-info">
                                                    <li class="time">
                                                        @if ($item->full_time == 1)
                                                            Full Time
                                                        @endif
                                                    </li>
                                                    <li class="privacy">
                                                        @if ($item->part_time == 1)
                                                            Part Time
                                                        @endif
                                                    </li>
                                                    {{-- <li class="required">Urgent</li> --}}
                                                </ul>
                                                @if (auth('candidate')->check())
                                                    <a href="{{url('/shortlisted/`+job.id+`')}}"><button
                                                            class="bookmark-btn"><span
                                                                class="flaticon-bookmark"></span></button></a>
                                                @else
                                                    <button class="bookmark-btn"><span
                                                            class="flaticon-bookmark"></span></button>
                                                @endif
                                                </li>
                                                {{-- <li class="required">Urgent</li> --}}
                                                </ul
                                                @if (auth('candidate')->check())
                                                    <a href="{{url('/shortlisted/`+job.id+`')}}"><button
                                                            class="bookmark-btn"><span
                                                                class="flaticon-bookmark"></span></button></a>
                                                @else
                                                    <button class="bookmark-btn"><span
                                                            class="flaticon-bookmark"></span></button>
                                                @endif
                                            </div>
                                        </div>
                                        </div>
                                    `
                        }
                        $('.searchpate').html(searchpateAjax);

                    }
                })
        })
        const paginationNumbers = document.getElementById("pagination-numbers");
        const paginatedList = document.getElementById("paginated-list");
        const listItems = paginatedList.querySelectorAll(".pagi");
        const nextButton = document.getElementById("next-button");
        const prevButton = document.getElementById("prev-button");

        const paginationLimit = 6;
        const pageCount = Math.ceil(listItems.length / paginationLimit);
        let currentPage = 1;

        const disableButton = (button) => {
        button.classList.add("disabled");
        button.setAttribute("disabled", true);
        };

        const enableButton = (button) => {
        button.classList.remove("disabled");
        button.removeAttribute("disabled");
        };

        const handlePageButtonsStatus = () => {
        if (currentPage === 1) {
            disableButton(prevButton);
        } else {
            enableButton(prevButton);
        }

        if (pageCount === currentPage) {
            disableButton(nextButton);
        } else {
            enableButton(nextButton);
        }
        };

        const handleActivePageNumber = () => {
        document.querySelectorAll(".pagination-number").forEach((button) => {
            button.classList.remove("active");
            const pageIndex = Number(button.getAttribute("page-index"));
            if (pageIndex == currentPage) {
            button.classList.add("active");
            }
        });
        };

        const appendPageNumber = (index) => {
        const pageNumber = document.createElement("button");
        pageNumber.className = "pagination-number";
        pageNumber.innerHTML = index;
        pageNumber.setAttribute("page-index", index);
        pageNumber.setAttribute("aria-label", "Page " + index);

        paginationNumbers.appendChild(pageNumber);
        };

        const getPaginationNumbers = () => {
        for (let i = 1; i <= pageCount; i++) {
            appendPageNumber(i);
        }
        };

        const setCurrentPage = (pageNum) => {
        currentPage = pageNum;

        handleActivePageNumber();
        handlePageButtonsStatus();

        const prevRange = (pageNum - 1) * paginationLimit;
        const currRange = pageNum * paginationLimit;

        listItems.forEach((item, index) => {
            item.classList.add("hidden");
            if (index >= prevRange && index < currRange) {
            item.classList.remove("hidden");
            }
        });
        };

        window.addEventListener("load", () => {
        getPaginationNumbers();
        setCurrentPage(1);

        prevButton.addEventListener("click", () => {
            setCurrentPage(currentPage - 1);
        });

        nextButton.addEventListener("click", () => {
            setCurrentPage(currentPage + 1);
        });

        document.querySelectorAll(".pagination-number").forEach((button) => {
            const pageIndex = Number(button.getAttribute("page-index"));

            if (pageIndex) {
            button.addEventListener("click", () => {
                setCurrentPage(pageIndex);
            });
            }
        });
        });
    </script>
@endsection
