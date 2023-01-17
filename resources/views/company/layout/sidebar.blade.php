<div class="user-sidebar">
    <div class="sidebar-inner">
      <ul class="navigation">
        @foreach (config('route.company.sidebar') as $key => $value )
            <li class="{{$key==$activeRoute ? 'active' : ''}}"><a href="{{route($value['route'])}}"> <i class="{{$value['icon']}}"></i>{{$value['title']}}</a></li>
        @endforeach
        <li>
          <form action="{{ route('company.logOut') }}" method="post">
            @csrf
            <a><button type="submit">
                    <i class="la la-sign-out"></i>Đăng xuất
            </button></a>
        </form>
        </li>
      </ul>
    </div>
  </div>
  