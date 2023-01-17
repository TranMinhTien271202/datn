@extends('company.layout.app')
@section('title')
@endsection
@section('content')

@if ($company->status == 1)
{{-- <section class="page-title style-two"> --}}
    <div class="auto-container mb-0" >
    </div>
  {{-- </section> --}}
  <!--End Page Title-->

  <!-- Listing Section -->
  <section class="ls-section pt-0" >
    <div class="auto-container">
      <div class="filters-backdrop"></div>

      <div class="row">
        <!-- Content Column -->
        <div class="content-column col-lg-12">
          <div class="ls-outer">
            <!-- ls Switcher -->
            <div class="ls-switcher">
              <div class="showing-result">
                <div class="top-filters justify-content-center">

                  <div class="form-group mt-3">
                    <input style="padding: 13px; border: 2px solid #e6e8ed;border-radius: 10px;"
                    type="text" class="search_address form-control" id="search-text" name="search_address" placeholder="Tìm theo địa chỉ">
                  </div>

                  <div class="form-group mt-3">
                    <select name="major" class="selectMajor select2">
                      <option value="">Chọn chuyên ngành</option>
                      @foreach ($major as $item)
                      <option value="{{$item->id}}">{{$item->name}}</option>
                      @endforeach
                    </select>
                </div>


                  <div class="form-group mt-3">
                    <select name="gender" class="selectGender select2">
                        <option value="">Giới Tính</option>
                        <option value="1"> Nam </option>
                        <option value="2"> Nữ </option>
                      </select>
                  </div>

                  <div class="form-group mt-3">
                    <select name="skill" class="selectSkill select2">
                        <option value="">Kỹ năng</option>
                        @foreach ($skill as $item)
                        <option value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach
                    </select>
                  </div>
                  <div class="form-group mt-3">
                    <select name="experience" class="selectYearKn select2">
                        <option value="">Năm kinh nghiệm</option>
                        @foreach (config('custom.experience') as $value)
                            <option value="{{ $value['id']}}">{{ $value['name']}}</option>
                        @endforeach
                    </select>
                  </div>

                  <div class="form-group mt-3">
                    <select name="type_degree" class="select_type_degree select2">
                        <option value="">Trình độ học vấn</option>
                        @foreach (config('custom.type_degree') as $value)
                            <option value="{{ $value['id']}}">{{ $value['name']}}</option>
                        @endforeach
                    </select>
                  </div>

                  <div class="form-group mt-3">
                    <select name="name_cty" class="select_name_cty select2">
                        <option value="">Từng làm tại công ty</option>
                        @foreach ($getNameCty as $item)
                            <option value="{{$item->company_name}}">{{ $item->company_name }}</option>
                        @endforeach
                    </select>
                  </div>

                  <div class="form-group mt-3">
                    <select name="name_edu" class="select_name_edu select2">
                        <option value="">Từng học tại trường</option>
                        @foreach ($nameEdu as $item)
                            <option value="{{$item->name_education}}">{{ $item->name_education }}</option>
                        @endforeach
                    </select>
                  </div>
                  
                  <form class="mt-3" onsubmit="return false">
                    <div class="form-group " >
                        <span class="input-group-append">
                            <button
                                class="theme-btn btn-style-one  "
                                type="button"
                                href="{{url("company/filter")}}"
                                id="search_filter">
                                Tìm kiếm
                            </button>
                        </span>
                    </div>
                </form>

                </div>
              </div>
            </form>
            </div>
            <div class="viewList">
              @include('company.filter-cv.list-view')
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  @elseif ($company->status == 2)
  <span class="text-warning" style="font-weight: 900">Bạn chưa đủ điều kiện xét duyệt, Vui lòng liên hệ admin</span>
  @else
  <span class="text-warning" style="font-weight: 900">Bạn cần chờ xét duyệt</span>

  @endif
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
                $(".viewList").html(data);
            });
            return false;
        })})

      $( document ).ready(function() {

          $('#search_filter').click(function (e){
            e.preventDefault();
            var id_gender = $('.selectGender').find(":selected").val();
            var id_major = $('.selectMajor').find(":selected").val();
            var id_skill = $('.selectSkill').find(":selected").val();
            var type_degree = $('.select_type_degree').find(":selected").val();
            var name_edu = $('.select_name_edu').find(":selected").val();
            var name_cty = $('.select_name_cty').find(":selected").val();
            var search_address = $('.search_address').val();
            var selectYearKn = $('.selectYearKn').find(":selected").val();
            var data = {
                    "id_major": id_major,
                    "id_gender": id_gender,
                    "id_skill": id_skill,
                    "type_degree": type_degree,
                    "name_edu": name_edu,
                    "name_cty": name_cty,
                    "search_address" : search_address,
                    "selectYearKn" : selectYearKn,
                }
            $.ajax({
              url: "filter",
              type: "get",
              data: data,
              success: function(data)
              {
                $(".viewList").html(data);
              },
              error: function(){
                Swal.fire({
                        icon: 'error',
                        title: 'Cảnh báo',
                        text: 'Dữ liệu bị lỗi',
                        showCancelButton: false,
                        showConfirmButton: false,
                        confirmButtonText: 'Đồng ý',
                        confirmButtonColor: '#C46F01',
                        cancelButtonText: 'Không'
                    })
              }
            });

          });

      });
  </script>
@endsection