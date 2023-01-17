<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from creativelayers.net/themes/superio/register.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 31 Aug 2022 09:27:55 GMT -->
<head>
  <meta charset="utf-8">
  <title>Register</title>

  <!-- Stylesheets -->
  <link href="{{ asset('assets/client-bower/css/bootstrap.css')}}" rel="stylesheet">
  <link href="{{ asset('assets/client-bower/css/style.css')}}" rel="stylesheet">
  <link href="{{ asset('assets/client-bower/css/responsive.css')}}" rel="stylesheet">

  <link rel="shortcut icon" href="{{ asset('assets/client-bower/images/favicon.png')}}" type="image/x-icon">
  <link rel="icon" href="{{ asset('assets/client-bower/images/favicon.png')}}" type="image/x-icon">

  <!-- Responsive -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
  
</head>
<style>
    .employer{
        display: none;

    }
</style>
<body>

  <div class="page-wrapper">

    <!-- Preloader -->


    <!-- Main Header-->
    <header class="main-header">
      <div class="container-fluid">
        <!-- Main box -->
        <div class="main-box">
          <!--Nav Outer -->
          <div class="nav-outer">
            <div class="logo-box">
                <div class="logo"><a href="{{route('company.register')}}"><img src="" alt="" title=""></a></div></div>
          </div>

        </div>
      </div>

      <!-- Mobile Header -->
      <div class="mobile-header">
        <div class="logo"><a href="index.html"><img src="{{ asset('assets/client-bower/images/logo.svg')}}" alt="" title=""></a></div>

        <!--Nav Box-->
        <div class="nav-outer clearfix">
          <div class="outer-box">
            <!-- Login/Register -->
            <div class="login-box">
              <a href="login-popup.html" class="call-modal"><span class="icon-user"></span></a>
            </div>
            <a href="#nav-mobile" class="mobile-nav-toggler navbar-trigger"><span class="flaticon-menu-1"></span></a>
          </div>
        </div>
      </div>

      <!-- Mobile Nav -->
      <div id="nav-mobile"></div>
    </header>
    <!--End Main Header -->

    <!-- Info Section -->
    <div class="login-section">
        <div class="image-layer" style="background-image: url({{ asset('assets/client-bower/images/background/12.jpg')}});"></div>
      <div class="outer-box">
        <!-- Login Form -->
        <div class="login-form default-form">
          <div class="form-inner">
            <h3>Tạo tài khoản công ty</h3>

            <!--Login Form-->
           
              <div class="form-group">
              </div>
              <form method="post" action="{{ route('register.store') }}" class="candidate">
                @csrf
                <div class="form-group">
                  <label>Tên Công Ty</label>
                  <input type="text" name="company_name" placeholder="Tên Công ty..." value="{{old('company_name')}}">
                </div>
                  @error('company_name')
                    <small class="text-danger">{{$message}}</small>
                  @enderror
              <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" placeholder="Email" value="{{old('email')}}">
                @error('email')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
              </div>
              <div class="form-group">
                <label>Số điện thoại</label>
                <input type="number" name="phone" placeholder="Số điện thoại" value="{{old('phone')}}">
                @error('phone')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
              </div>
              <div class="form-group">
                <label>Mật khẩu</label>
                <input id="password-field" type="password" name="password" value="" placeholder="Mật khẩu">
                @error('password')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
              </div>
              <div class="form-group">
                <label>Website</label>
                <input type="text" name="link_web" placeholder="Link website" value="{{old('link_web')}}">
              </div>
              <div class="form-group">
                <button class="theme-btn btn-style-one " type="submit" name="Register">Đăng ký</button>
              </div>
            </form>
        <div class="bottom-box">
          <div class="text">Bạn đã có tài khoản? <a href="{{route('company.login')}}">Đăng nhập</a></div>
          <div class="divider"><span>hoặc</span></div>
            <div class="btn-box row">
              <div class="col-lg-12 col-md-12">
                <a href="{{route('getGoogleLoginClient')}}" class="theme-btn social-btn-two google-btn"><i class="fab fa-google"></i> Google</a>
              </div>
            </div>
        </div>
    
          </div>
        </div>
        <!--End Login Form -->
      </div>
    </div>
    <!-- End Info Section -->

  </div><!-- End Page Wrapper -->

</body>


</html>