
<div class="model">
    <div id="login-modal" style="max-width: 700px">
      <div class="login-form default-form">
        <div class="form-inner">
          <h3>Chọn hồ sơ ứng tuyển</h3>
          <form action="{{ route('store') }}" method="POST" >
          {{-- <form action="{{ route('store') }}" method="POST" enctype="multipart/form-data"> --}}
            {{-- @csrf
            <div class="uploading-resume">
                <div class="uploadButton">
                    <input class="uploadButton-input" type="file" name="path_cv" id="upload"
                        multiple />
                    <label class="cv-uploadButton" for="upload">
                        <span class="title">Click vào đây để upload</span>
                        <span class="text">Kích thước tệp tải lên là (Tối đa 2Mb) và các loại tệp được phép là .pdf</span>
                        <span class="theme-btn btn-style-one">Upload CV</span>
                    </label>
                    <span class="uploadButton-file-name"></span>
                    <center><button type="submit" class="btn btn-danger">Gửi</button></center>
                </div>
            </div> --}}
     {{--   </form> --}}
            
            <div class="form-group">
                <div class="row">
                <a href="{{route('createNew')}}">Tạo cv</a>
                </div>
                <label for="">Chọn CV</label>
               <div class="files-outer mt-3 radio-outer ">
                    <div class="radio-box d-flex">
                      {{--  <input type="radio" name="radio" id="radio-1" checked="">
                        <label for="radio-1"><input class="uploadButton-input" type="file" name="path_cv" id="upload" multiple /></label>
                      </div>
                      <div class="radio-box">
                        <input type="radio" name="radio" id="radio-2" >
                        <label for="radio-2">
                            <select name="" id="">
                                @foreach ($data as $item)
                                <option value="">CV-{{$item->name}}#{{$item->id}} 
                                    <div class="edit-btns ml-0">
                                        @if(!empty($item->path_cv))
                                        <a style="margin-right: 5px" target="_blank"
                                            href="upload/cv/{{ $item->path_cv }}"><button><span class="la la-eye"></span></button></a>
                                        @endif
                                        <a href="{{ route('CreateCV', ['idsee' => $item->id]) }}" target="_blank"><button><span class="la la-pencil"></span></button></a>
                                    </div>
                                </option> --}}
                            @foreach ($data as $item)
                            <div class="file-edit-box div_cv{{$item->id}}" style=" height: 130px ;background: {{$item->is_active == 1 ? 'antiquewhite' : ''}}" >
                                <div class="edit-btns ml-0">
                                    @if(!empty($item->path_cv))
                                    <a style="margin-right: 5px" target="_blank" href="{{url('').'/upload/cv/'. $item->path_cv}}"
                                        ><button type="button"><span class="la la-eye"></span></button></a>
                                    @endif
                                    <a  target="_blank" href="{{ route('CreateCV', ['idsee' => $item->id]) }}"><button type="button"><span class="la la-pencil"></span></button></a>
                                </div>
                                <small style="-webkit-line-clamp: 1; -webkit-box-orient: vertical; display: -webkit-box; overflow: hidden; text-align: center;">CV-{{$item->name}}</small>
                                <div class="form-check form-check-inline mt-3" data-toggle="tooltip" data-placement="bottom" title="Chọn cv">
                                    <input data-id-path="{{$item->path_cv}}" @php echo $item->is_active == 1 ? 'checked' : '' @endphp class="form-check-input inlineRadio{{$item->id}}" onclick="i_active({{$item->id}})" type="radio" name="is_active" id="inlineRadio{{$item->id}}" value="1">
                                    <label class="form-check-label" for="inlineRadio{{$item->id}}"></label>
                                </div>
                            </div>
                        @endforeach 
                    {{-- </select>
                    </label> 
                    --}}
                </div>
              </div>
            </div>
              <div class="form-group">
                <label for="">Mô tả ngắn</label>
                <textarea class="introduct" name="introduct" id="" cols="30" rows="10" class="form-control" placeholder="Ví dụ giới thiệu về bản thân, chuyên môn, mục tiêu dự định"></textarea>
              </div>
              <button class="theme-btn btn-style-one submit" >Gửi</button>
            </form>
        </div>
      </div>
    </div>
    <script type="text/javascript">
      function i_active(id) {
            var url = window.location.origin;
            var path_cv = $('.inlineRadio'+id).last().data('id-path');
            if(path_cv == ""){
                toastr.error("CV chưa hoàn thiện, vui lòng nhấn sửa CV và nhấn tạo file CV!");
            }else {
                var data = {
                    "_token": $('meta[name="csrf-token"]').attr('content'),
                    "id": id,
                }
                $.ajax({
                    type: "GET",
                    url: url+'/seeker',
                    data: data,
                    success: function(response) {
                        $('.file-edit-box').css('background','')
                        console.log();
                        $('.inlineRadio'+id).last().parent().parent().css('background','antiquewhite')
                        toastr.success(response.success)
                    },
                    error: function(response) {
                        toastr.error("Cập nhật thất bại")
                    }
                });
            }
        }
        $('.submit').on('click',function (e) {
            e.preventDefault();
            var job_id = window.location.pathname.split("/").pop();
            var introduct = $(".introduct").last().val();
            var url = window.location.origin + '/appliedAJAX'
            var data = {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "job_id": job_id,
                "introduct" : introduct
            }
            $.ajax({
                type: "POST",
                url: url,
                data: data,
                success: function(response) {
                    $('.close-modal').click();
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Ứng tuyển thành công!',
                            text: response.message,
                            showCancelButton: false,
                            showConfirmButton: true,
                            confirmButtonColor: '#C46F01',
                            timer: 2000
                        })
                    };
                    $('.call-modal').parent().prepend("<button class='theme-btn btn-style-one'>Đã ứng tuyển</button>")
                    $('.call-modal').css('display','none');
                },
                error: function(rep){
                    $('close-modal').click();
                    if (rep.status == 401) {
                        Swal.fire({
                        icon: 'error',
                        title: 'Cảnh báo!',
                        text: 'Hãy đăng nhập để tiếp tục thực hiện',
                        showCancelButton: false,
                        showConfirmButton: false,
                        confirmButtonText: 'Đồng ý',
                        confirmButtonColor: '#C46F01',
                        cancelButtonText: 'Không'
                    })
                    }
                }
            });
            
        })
    </script>
  </div>