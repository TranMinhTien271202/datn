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
                            <div class="widget-title">
                                <div class="upper-title-box">
                                    <h3>Tài khoản công ty!</h3>
                                </div>
                            </div>
                            <div class="widget-content">
                                <form class="default-form" action="{{ route('company.profile.update') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="uploading-outer">
                                        <div class="uploadButton">
                                            <input class="uploadButton-input" type="file" name="logo"
                                                accept="image/*, application/pdf" id="upload" multiple />
                                            <label class="uploadButton-button ripple-effect fileupload-preview thumbnail"
                                                for="upload"><img id="image"
                                                    src="{{ asset('storage/images/company/' . $data->logo) }}"
                                                    alt="Ảnh của bạn"
                                                    style="width: 201px;max-height: 111px; margin-bottom: 28px;object-fit: cover;"
                                                    class="img-fluid" /></label>
                                            <span class="uploadButton-file-name"></span>
                                        </div>
                                        <div class="text">Kích thước tệp tối đa là 1MB, Kích thước tối thiểu: 330x300 Và
                                            các tệp phù hợp là .jpg & .png</div>
                                    </div>

                                    {{-- @dd($data);  --}}
                                    <input type="hidden" name="logo_old" value="{{ $data->logo }}">

                                    <td class="text-center"></td>
                                    <div class="row">
                                        <!-- Input -->
                                        <div class="form-group col-lg-6 col-md-12">
                                            <label>Tên người đại diện</label>

                                            <input type="text" name="name" value="{!! $data->name !!}">
                                            @error('name')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group col-lg-6 col-md-12">
                                            <label>Tên Công ty</label>

                                            <input type="text" name="company_name" value="{!! $data->company_name !!}">
                                            @error('company_name')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="form-group col-lg-6 col-md-12">
                                            <label>Email *</label>
                                            <input type="text" readonly name="email" value="{!! $data->email !!}">
                                            @error('email')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <!-- Input -->
                                        <div class="form-group col-lg-6 col-md-12">
                                            <label>Số điện thoại *</label>
                                            @if ($data->phone)
                                            <input type="text" readonly name="phone" value="{!! $data->phone !!}">
                                            @else
                                            <input type="text" name="phone" value="{!! $data->phone !!}">
                                            @endif

                                        </div>

                                        <!-- Input -->
                                        <div class="form-group col-lg-6 col-md-12">
                                            <label>Website</label>
                                            <input type="text" name="website" value="{!! $data->link_web !!}">
                                        </div>
                                        <div class="form-group col-lg-6 col-md-12">
                                            <label>Mã số thuế</label>
                                            @if ($data->tax_code)
                                            <input type="number" disabled name="tax_code" value="{!! $data->tax_code !!}">
                                            @else
                                            <input type="number" name="tax_code" value="{!! $data->tax_code !!}">
                                            @endif
                                        </div>
                                        <div class="form-group col-lg-6 col-md-12">
                                            <label>Lĩnh vực hoạt động</label>
                                            <input type="text" name="career" value="{!! $data->career !!}">
                                        </div>

                                        <!-- Input -->
                                        <div class="form-group col-lg-6 col-md-12">
                                            <label>Năm thành lập</label>
                                            <input type="date" name="founded_in" value="{!! $data->founded_in !!}"
                                                placeholder="06.04.2020">
                                        </div>
                                        <div class="form-group col-lg-6 col-md-12">
                                            <label>Thời gian làm việc</label>
                                            <select name="working_time" class="chosen-select">
                                                @foreach ($workingTime as $k => $v)
                                                    <option value="{{ $k }}"
                                                        @if (isset($data->working_time) && $data->working_time == $k) selected @endif>
                                                        {{ $v }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        {{-- @dd($data); --}}
                                        <div class="form-group col-lg-6 col-md-12">
                                            <label>Địa chỉ</label>
                                            <input type="text" name="address" value="{!! $data->address !!}">
                                        </div>
                                        <div class="form-group col-lg-6 col-md-12">
                                            <label>Loại hình doanh nghiệp</label>
                                            <input type="text" name="company_model" value="{!! $data->company_model !!}">
                                        </div>
                                        <!-- Input -->
                                        <div class="form-group col-lg-6 col-md-12">
                                            <label>Số lượng nhân viên</label>
                                            <select name="team" class="chosen-select">
                                                @foreach ($team as $k => $v)
                                                    <option value="{{ $k }}"
                                                        @if (isset($data->team) && $data->team == $k) selected @endif>
                                                        {{ $v }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-lg-12 col-md-12">
                                            <label>Nhúng bản đồ</label>
                                            <textarea name="map" id="" cols="30" rows="10">{!! $data->map !!}</textarea>
                                        </div>
                                        <div class="form-group col-lg-12 col-md-12">
                                            <label>Nhúng video công ty</label>
                                            <textarea name="iframe_ytb" id="" cols="30" rows="10">{!! $data->iframe_ytb !!}</textarea>
                                        </div>
                                        <div class="form-group col-lg-12 col-md-12">
                                            <label>Chi tiết về công ty</label>
                                                <textarea type="text" name="about" id="editor">{!! $data->about !!}</textarea>
                                        </div>

                                        <!-- Input -->
                                        <div class="form-group col-lg-6 col-md-12">
                                            <button class="theme-btn btn-style-one">Lưu</button>
                                        </div>
                                    </div>
                                </form>
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
        ClassicEditor
            .create(document.querySelector('#editor'))
            .then(editor => {
                console.log(editor);
            })
            .catch(error => {
                console.error(error);
            });
    </script>
@endsection
