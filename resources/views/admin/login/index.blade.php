<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Login</title>

  <!-- Stylesheets -->
  <link href="{{ asset('assets/client-bower/css/bootstrap.css')}}" rel="stylesheet">
  <link href="{{ asset('assets/client-bower/css/style.css')}}" rel="stylesheet">
  <link href="{{ asset('assets/client-bower/css/responsive.css')}}" rel="stylesheet">

  <link rel="shortcut icon" href="{{ asset('assets/client-bower/images/favicon.png')}}" type="image/x-icon">
  <link rel="icon" href="{{ asset('assets/client-bower/images/favicon.png')}}" type="image/x-icon">

  <!-- Responsive -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <!--[if lt IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script><![endif]-->
  <!--[if lt IE 9]><script src="js/respond.js"></script><![endif]-->
</head>

<body>

  <div class="page-wrapper">

    <!-- Preloader -->

    <!-- Main Header-->
    <header class="main-header">
      <div class="container-fluid">
        <!-- Main box -->

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
            <h3>Đăng nhập admin </h3>
            <!--Login Form-->
            
            <form method="post" action="{{ url('admin/login') }}">
              <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" placeholder="Email" value="{{ old('email') }}">
                @error('email')
                <small class="text-danger">{{$message}}</small>
                @enderror
              </div>

              <div class="form-group">
                <label>Mật khẩu</label>
                <input id="password-field" type="password" name="password" value="" placeholder="Password">
                @error('password')
                  <small class="text-danger">{{$message}}</small>
                @enderror
              </div>

              <div class="form-group">
                <div class="field-outer">
                  <div class="input-group checkboxes square">
                    {{-- <input type="checkbox" name="remember-me" value="" id="remember">
                    <label for="remember" class="remember"><span class="custom-checkbox"></span> Remember me</label> --}}
                  </div>
                  {{-- <a href="#" class="pwd">Forgot password?</a> --}}
                </div>
              </div>

              <div class="form-group">
                <button class="theme-btn btn-style-one" type="submit">Đăng nhập</button>
                
              </div>
              <input type="hidden" name="_token" value="{!! csrf_token() !!}">
            </form>
          </div>
        </div>
        <!--End Login Form -->
      </div>
    </div>
    <!-- End Info Section -->


  </div><!-- End Page Wrapper -->


  <script src="{{ asset('assets/client-bower/js/jquery.js')}}"></script>
  <script src="{{ asset('assets/client-bower/js/popper.min.js')}}"></script>
  <script src="{{ asset('assets/client-bower/js/chosen.min.js')}}"></script>
  <script src="{{ asset('assets/client-bower/js/bootstrap.min.js')}}"></script>
  <script src="{{ asset('assets/client-bower/js/jquery-ui.min.js')}}"></script>
  <script src="{{ asset('assets/client-bower/js/jquery.fancybox.js')}}"></script>
  <script src="{{ asset('assets/client-bower/js/jquery.modal.min.js')}}"></script>
  <script src="{{ asset('assets/client-bower/js/mmenu.polyfills.js')}}"></script>
  <script src="{{ asset('assets/client-bower/js/mmenu.js')}}"></script>
  <script src="{{ asset('assets/client-bower/js/appear.js')}}"></script>
  <script src="{{ asset('assets/client-bower/js/ScrollMagic.min.js')}}"></script>
  <script src="{{ asset('assets/client-bower/js/rellax.min.js')}}"></script>
  <script src="{{ asset('assets/client-bower/js/owl.js')}}"></script>
  <script src="{{ asset('assets/client-bower/js/wow.js')}}"></script>
  <script src="{{ asset('assets/client-bower/js/script.js')}}"></script>
</body>


<!-- Mirrored from creativelayers.net/themes/superio/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 31 Aug 2022 09:27:55 GMT -->
</html>