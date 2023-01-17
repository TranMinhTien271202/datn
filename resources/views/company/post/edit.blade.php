@extends('company.layout.app')
@section('style')
    @parent
    <link rel="stylesheet" href="{{ asset('assets/admin-bower/plugins/summernote/summernote-bs5.min.css') }}">
    <style>
        .card {
            height: auto;
        }

        textarea .description ul {
            list-style: disc !important;
            list-style-position: inside !important;
        }

        textarea .description ol {
            list-style: decimal !important;
            list-style-position: inside !important;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <!-- Ls widget -->
            <div class="ls-widget">
                <div class="tabs-box">
                    <div class="widget-title">
                        <h4>{{ $title }}</h4>
                    </div>
                    <div class="widget-content">
                        <form class="default-form" action="{{ route('company.post.update',$jobPost->id) }}" method="POST" id="formPost">
                            @csrf
                            <div class="row">
                                <div class="column col-12">
                                    <!--Accordian Box-->
                                    <ul class="accordion-box" style="border-radius: 0px">
                                        <!--Block-->
                                        <li class="accordion block active-block">
                                            <div class="acc-btn active">Thông tin chung <span
                                                    class="icon flaticon-add"></span></div>
                                            <div class="acc-content current">
                                                <div class="content row">
                                                    <div class="form-group col-lg-12 col-md-12">
                                                        <label>Tiêu đề tin tuyển dụng</label>
                                                        <input type="text" name="title" value="{{ $jobPost->title }}"
                                                            placeholder="Tiêu đề">
                                                        @error('title')
                                                            <div class="text-danger pl-4">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col-lg-6 col-md-12">
                                                        <label>Chuyên nghành</label>
                                                        <select data-placeholder="Chọn ... " class="chosen-select"
                                                            name="major_id">
                                                            @foreach ($majors as $value)
                                                                <option
                                                                    {{ $jobPost->major_id == $value['id'] ? 'selected' : '' }}
                                                                    value="{{ $value->id }}">{{ $value->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-lg-6 col-md-12">
                                                        <label>Kinh nghiệm</label>
                                                        <select class="chosen-select" name="experience">
                                                            @foreach (config('custom.experience') as $value)
                                                                <option
                                                                    {{ $jobPost->experience == $value['id'] ? 'selected' : '' }}
                                                                    value="{{ $value['id'] }}">{{ $value['name'] }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-lg-3 col-md-12">
                                                        <label>Số lượng</label>
                                                        <input type="number" name="amount"
                                                            value="{{ $jobPost->amount }}">
                                                        @error('amount')
                                                            <div class="text-danger pl-4">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col-lg-3 col-md-12">
                                                        <label>Loại công việc</label>
                                                        <select class="chosen-select" name="type_work">
                                                            @foreach (config('custom.type_work') as $value)
                                                                <option
                                                                    {{ $jobPost->type_work == $value['id'] ? 'selected' : '' }}
                                                                    value="{{ $value['id'] }}">{{ $value['name'] }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-lg-3 col-md-12">
                                                        <label>Giới tính</label>
                                                        <select class="chosen-select" name="gender">
                                                            @foreach (config('custom.gender') as $value)
                                                                <option
                                                                    {{ $jobPost->gender == $value['id'] ? 'selected' : '' }}
                                                                    value="{{ $value['id'] }}">{{ $value['name'] }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-lg-3 col-md-12">
                                                        <label>Cấp bậc</label>
                                                        <select class="chosen-select" name="level">
                                                            @foreach (config('custom.level') as $value)
                                                                <option  {{ $jobPost->level == $value['id'] ? 'selected' : '' }} value="{{ $value['id'] }}">{{ $value['name'] }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-lg-4 col-md-12">
                                                        <label>Kiểu lương</label>
                                                        <select class="chosen-select" name="type_salary">
                                                            @foreach (config('custom.type_salary') as $value)
                                                                <option value="{{ $value['id'] }}">{{ $value['name'] }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-lg-4 col-md-12">
                                                        <label>Từ</label>
                                                        <input type="number" name="min_salary"
                                                            value="{{ $jobPost->min_salary }}">
                                                    </div>
                                                    <div class="form-group col-lg-4 col-md-12">
                                                        <label>Đến</label>
                                                        <input type="number" name="max_salary"
                                                            value="{{ $jobPost->max_salary }}">
                                                    </div>
                                                    <div class="form-group col-lg-3 col-md-12">
                                                        <label>Khu vực</label>
                                                        <select class="chosen-select" name="area">
                                                            @foreach (config('custom.area') as $value)
                                                                <option
                                                                    {{ $jobPost->area == $value['id'] ? 'selected' : '' }}
                                                                    value="{{ $value['id'] }}">{{ $value['name'] }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-lg-9 col-md-12">
                                                        <label>Địa chỉ</label>
                                                        <input type="text" name="address" placeholder=""
                                                            value="{{ $jobPost->address }}">
                                                        @error('address')
                                                            <div class="text-danger pl-4">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>

                                                </div>
                                            </div>
                                        </li>
                                        <li class="accordion block">
                                            <div class="acc-btn"> Nội dung tuyển dụng chi tiết <span
                                                    class="icon flaticon-add"></span></div>
                                            <div class="acc-content">
                                                <div class="content row">
                                                    <div class="form-group col-lg-12 col-md-12">
                                                        <label>Mô tả công việc</label>
                                                        <textarea class="description" name="description" placeholder="">{{ $jobPost->description }}</textarea>
                                                        @error('description')
                                                            <div class="text-danger pl-4">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>

                                                    <div class="form-group col-lg-12 col-md-12">
                                                        <label>Yêu cầu công việc</label>
                                                        <textarea class="description" name="requirement" placeholder="">{{ $jobPost->requirement }}</textarea>
                                                        @error('requirement')
                                                            <div class="text-danger pl-4">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col-lg-12 col-md-12">
                                                        <label>Kĩ năng liên quan</label>
                                                        <select data-placeholder="Chọn ... " class="chosen-select"
                                                            name="skill[]" multiple>
                                                            @foreach ($skills as $value)
                                                                <option {{in_array($value['id'],$skillActive) ? 'selected' : ''}}  value="{{ $value['id'] }}">{{ $value['name'] }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('skill')
                                                            <div class="text-danger pl-4">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col-lg-12 col-md-12">
                                                        <label>Quyền lợi</label>
                                                        <textarea class="description" name="benefits" placeholder="">{{ $jobPost->benefits }}</textarea>
                                                        @error('benefits')
                                                            <div class="text-danger pl-4">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </li>

                                    </ul>
                                </div>
                                <div class="form-group col-lg-12 col-md-12 text-right clearfix">
                                    <button type="submit" class="theme-btn btn-style-one float-end"
                                        id="buttonSubmit">Sửa</button>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    @parent
    <script src="{{ asset('assets/admin-bower/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.description').summernote({
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['fontsize', [13]],
                    ['para', ['ul', 'ol']],
                ],
                height: 150,
            });

        });
    </script>
@endsection
