@extends('client.layout.app')
@section('title')
    {{ __('UB Work') }}
@endsection
@section('content')
    <section class="page-title style-three" style="margin-top:100px ">
        <h1>Tìm Kiếm Nhanh</h1>
        <form action="send" method="GET">
            <div class="auto-container" style="width:800px">
                Mỗi lần sử dụng bạn sẽ mất 30 coin. Tối đa bạn chỉ được sử dụng 1 lần / 1 ngày. Sử dụng chức năng sẽ giúp
                bạn apply vào bài tuyển dụng phù hợp một cách nhanh chống mà bạn không phải tìm xem từng bài tuyển dụng nào
                phù hợp với bạn.
                <br>
                @if (auth('candidate')->check())
                    @if ($major == null && $skill_seeker == null)
                        <span>Do bạn chưa tạo cv trên hệ thống. nên bạn hãy tìm kiếm bằng cách chọn chuyên ngành hoặc chọn
                            kỹ năng bên dưới để sử dụng chức năng hoặc bạn có thể tạo cv <a
                                href="{{ route('createNew') }}">tại đây!</a></span>
                        <div class="top-filters" style="margin-top: 100px ">
                            <div class="form-group" style="width:220px">
                                <select class="chosen-select" name="major">
                                    <option value="">Chuyên Ngành</option>
                                    @foreach ($maJor as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group" style="width:220px">
                                <select class="chosen-select" name="type">
                                    <option value="">Loại Hình</option>
                                    @foreach (config('custom.type_work') as $value)
                                        <option value="{{ $value['id'] }}">{{ $value['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group" style="width:220px">
                                <select data-placeholder="Chọn kỹ năng... " class="chosen-select" name="skill[]" multiple>
                                    @foreach ($skill as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif
                @endif
                <button class="theme-btn btn-style-one" style="margin-top: 50px " type="submit">Tìm Kiếm</button>
            </div>
        </form>
    </section>
@endsection
