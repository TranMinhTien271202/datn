@extends('company.layout.app')
@section('title')
    {{-- {{ __('Sửa Công ty') }} --}}
@endsection
@section('content')

<section class="user-dashboard">
  <div class="">

    <div class="row">
      <div class="col-lg-12">
        <!-- Ls widget -->
        <div class="ls-widget">
          <div class="tabs-box">
            <div class="widget-title">
              <h4>Hồ sơ ứng viên</h4>
  
              <div class="chosen-outer">
                <!--Tabs Box-->
                <select id="selectView" class="chosen-select">
                  <option value="-1">Tất cả trạng thái</option>
                  <option value="3">Chưa xem</option>
                  <option value="1">Đã xem</option>
                </select>

                <select id="selectFunction" class="chosen-select">
                  <option value="-1">Tất cả hồ sơ</option>
                  <option value="5">CV từ bài đăng</option>
                  <option value="1">CV từ tìm việc nhanh</option>
                  <option value="2">CV mở khóa</option>
                </select>
  
                
              </div>
            </div>
            <div class="rowView">
                @include('company.manage-cv.selectView')
            </div>

          </div>
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
                $(".rowView").html(data);
            });
            return false;
        })})
      $( document ).ready(function() {
        $('#selectView').change(function() {
          var idsee = $(this).val();
          var idfun = $('#selectFunction').find(":selected").val();
          call_ajax(idsee, idfun);
        });
        $('#selectFunction').change(function() {
          var idfun = $(this).val();
          var idsee = $('#selectView').find(":selected").val();
          call_ajax(idsee, idfun);
        });
          function call_ajax(idsee, idfun) {
            var data = {
                    "is_see": idsee,
                    "is_function": idfun,
                }
            $.ajax({
              url: "manage-cv",
              type: "get",
              data: data,
              success: function(data)
              {
                $(".rowView").html(data);
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
          }

      });
  </script>
@endsection