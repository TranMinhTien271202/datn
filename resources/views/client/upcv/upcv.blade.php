@extends('client.layout.app')
@section('title')
{{ __('UB Work') }} | {{'Quản lý CV'}}
@endsection
@section('content')
    <section class="ls-section mt-5">
        <div class="container-fluid" style="max-width: 720px">
            <div class="row">

                <div class="col-lg-12">
                    <!-- CV Manager Widget -->
                    <div class="cv-manager-widget ls-widget">
                        <div class="widget-title">
                            <h4>Quản lý CV</h4>
                        </div>
                        <center>
                            
                            @if ($errors->any())
                                <div class="h4 text-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </center>
                        <div class="widget-content">
                            <form action="{{ route('store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
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
                                </div>
                            </form>
                            <div class="files-outer mt-3 radio-outer ">
                          <div class="radio-box d-flex">
                                @foreach ($data as $item)
                                    <div class="file-edit-box div_cv{{$item->id}}"  style="background: {{$item->is_active == 1 ? 'antiquewhite' : ''}}">
                                        <div class="edit-btns mb-3">
                                            @if(!empty($item->path_cv))
                                            <a style="margin-right: 5px" target="_blank"
                                                href="upload/cv/{{ $item->path_cv }}"><button><span class="la la-eye"></span></button></a>
                                            @endif
                                            <a href="{{ route('CreateCV', ['idsee' => $item->id]) }}"><button><span class="la la-pencil"></span></button></a>

                                            <form class="removeCVF" action="{{route('delete_seeker', ['id' => $item->id])}}">
                                                <button data-id-cv="{{$item->id}}" class="removeCV btn-delete-seeker" type="submit"><span
                                                        class="la la-trash"></span>
                                                </button>
                                            </form>
                                        </div>
                                        <small style="-webkit-line-clamp: 1; -webkit-box-orient: vertical; display: -webkit-box; overflow: hidden; text-align: center;">CV-{{$item->name}}</small>
                                        <div class="form-check form-check-inline mt-3" data-toggle="tooltip" data-placement="bottom" title="Chọn cv">
                                            <input data-id-path="{{$item->path_cv}}" @php echo $item->is_active == 1 ? 'checked' : '' @endphp class="form-check-input" onclick="i_active({{$item->id}})" type="radio" name="is_active" id="inlineRadio{{$item->id}}" value="1">
                                            <label class="form-check-label" for="inlineRadio{{$item->id}}"></label>
                                        </div>
                                    </div>
                                @endforeach
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
    <script>
        function i_active(id) {
            var url = window.location.href;
            var path_cv = $('#inlineRadio'+id).data('id-path');
            if(path_cv == ""){
                toastr.error("CV chưa hoàn thiện, vui lòng nhấn sửa CV và nhấn tạo file CV!");
            }else {
                var data = {
                    "_token": $('meta[name="csrf-token"]').attr('content'),
                    "id": id,
                }
                $.ajax({
                    type: "GET",
                    url: url,
                    data: data,
                    success: function(response) {
                        $('.file-edit-box').css('background','')
                        $('#inlineRadio'+id).parent().parent().css('background','antiquewhite')
                        toastr.success(response.success)
                    },
                    error: function(response) {
                        toastr.error("Cập nhật thất bại")
                    }
                });
            }
        }

        $('.removeCV').click(function (e) {
        e.preventDefault();
        var url = $('.removeCVF').attr('action');
        var idcv = $(this).data('id-cv');
        var data = {
            id: idcv,
            "_token": $('meta[name="csrf-token"]').attr('content'),
        }
        Swal.fire({
            icon: 'warning',
            title: 'Bạn có chắc chắn muốn xóa ?',
            text: 'Bấm không nếu bạn đổi ý!',
            showCancelButton: true,
            showConfirmButton: true,
            confirmButtonText: 'Xóa',
            confirmButtonColor: '#C46F01',
            cancelButtonText: 'Không'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: "get",
                    data: data,
                    success: function(results) {
                        if (results.is_check === true) {
                            Swal.fire({
                                title: results.success,
                                icon: 'success',
                                type: 'success',
                                showConfirmButton: false,
                                timer: 1500
                            }, setTimeout(function() {
                            
                            }, 500)).then(function() {
                                $('.div_cv'+idcv).remove();
                            });
                        } else {
                            Swal.fire({
                                title: results.error,
                                type: 'error',
                                icon: 'error',
                                timer: 1500
                            });
                        }
                    }
                });
            }
        });
    });
    </script>
@endsection
