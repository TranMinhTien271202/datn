@extends('company.layout.app')
@section('title')
    {{ __('Sửa Công ty') }}
@endsection
@section('content')
<section class="user-dashboard">
    <div class="dashboard-outer">
      
      <div class="row">
        <div class="col-lg-12">
          <!-- Ls widget -->
          <div class="ls-widget">
            <div class="tabs-box">
              <div class="upper-title-box">
                <h3 style="text-align: center; top: 20px">Giấy phép kinh doanh</h3>
              </div>
              <div class="widget-title">
                <h4>Thông tin giấy phép kinh doanh</h4>
              </div>
              <div class="widget-content">
                {{-- @dd($data); --}}
                <form class="default-form" action="{{route('company.image-paper.update')}}" method="post" enctype="multipart/form-data">
                  @csrf
                <div class="form-group col-lg-6 col-md-12">
                  @if ($data->image_paper)
                    <label>Trạng thái :</label> 
                      @if ($data->status == 0)
                      <span class="text-warning" style="font-weight: 900">Chờ duyệt</span>
                      @elseif ( $data->status == 1)
                      <span class="text-success" style="font-weight: 900">Xác thực thành công</span>
                      @else
                      <span class="text-danger" style="font-weight: 900">Xác thực thất bại</span>
                      @endif
                  @endif
                </div>
                <div class="form-group col-lg-6 col-md-12">
                    <label>Giấy phép kinh doanh / Giấy ủy quyền</label>    
                </div>
                  
                  <div class="uploading-outer">
                    <div class="uploadButton">
                      <input class="uploadButton-input" type="file" name="image_paper" accept="image/*, application/pdf" id="upload" multiple />
                      <label class="uploadButton-button ripple-effect fileupload-preview thumbnail" for="upload"><img id="image" src="{{asset('storage/images/image_paper/'. $data->image_paper)}}" alt="Ảnh của bạn"
                        style="width: 201px;max-height: 111px; margin-bottom: 28px;object-fit: cover;" class="img-fluid"/></label>
                      <span class="uploadButton-file-name"></span>
                    </div>
                    <div class="text">Dung lượng file không vượt quá 5MB</div>
                  </div>

                <input type="hidden" name="image_paper_old" value="{{$data->image_paper}}">
                @if($data->status == 1)
                    
                @else
                <div class="form-group col-lg-6 col-md-12">
                  <button class="theme-btn btn-style-one">Lưu</button>
                </div>
                @endif
                    {{-- <div class="form-group col-lg-6 col-md-12">
                      <label>Tài liệu hướng dẫn</label>    
                  </div> --}}
                  </div>
                </form>
              </div>
            </div>
          </div>
      </div>
    </div>
  </section>
@endsection