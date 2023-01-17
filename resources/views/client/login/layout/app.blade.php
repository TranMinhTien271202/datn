<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>UBWORK | Login</title>
  @section('style')
    @include('client.login.layout.style')
  @show
  <link rel="shortcut icon" href="{{asset('/assets/client-bower/images/favicon.png')}}" type="image/x-icon">
  <link rel="icon" href="{{asset('/assets/client-bower/images/favicon.png')}}" type="image/x-icon">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
</head>
<body>

  <div class="page-wrapper">

    <!-- Preloader -->
    <div class="preloader"></div>

    <!-- Main Header-->
      @include('client.login.layout.header')
    <!--End Main Header -->

    <!-- Info Content -->
    @yield('content')
    <!-- End Content -->
  
  </div><!-- End Page Wrapper -->

  {{-- script --}}
  @section('script')
  
    @include('client.login.layout.script')
  @show
  @include('admin.layout.toastr')
  {{-- script --}}
  
</body>
</html>