<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="/assets/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/assets/dist/css/adminlte.min.css">
  {{-- toast --}}
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
  <style>
    .toastify {
      background-image: unset;
    }
  </style>
</head>
<body class="hold-transition login-page">
<div class="login-box"  style="position: relative;">
  <div class="login-logo">
    <img src="/assets/dist/img/logo/logo.png" alt="" width="120" height="auto" style="z-index: 1; bottom: -60px;position: relative;">
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body mt-4">     
      {{-- @if ($error->)
        
      @endif --}}
      <form method="POST" action="{{ route('admin.login') }}">
        @csrf       
        <div class="input-group @error('email') mb-1 @else mb-3 @enderror">
          <input type="email" name="email" class="form-control" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope @error('email') text-danger @enderror"></span>
            </div>
          </div>
        </div>
        @error('email')
        <div class="mb-1">
          <span class="text-danger font-weight-bold">{{ $message }}</span> 
        </div>                 
        @enderror      
        <div class="input-group @error('password') mb-1 @else mb-3 @enderror">
          <input type="password" name="password" class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock @error('password') text-danger @enderror"></span>
            </div>
          </div>
        </div>
        @error('password')
        <div class="mb-1">
          <span class="text-danger font-weight-bold">{{ $message }}</span>   
        </div>
              
        @enderror
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-warning btn-block text-white">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <div class="social-auth-links text-center mb-3">
        <p>- OR -</p>
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
        </a>
      </div>
      <!-- /.social-auth-links -->

      <p class="mb-1">
        <a href="forgot-password.html">I forgot my password</a>
      </p>
      <p class="mb-0">
        <a href="register.html" class="text-center">Register a new membership</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="/assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="/assets/dist/js/adminlte.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

@if(session()->has('error'))
<script>
  Toastify({
  text: "{{ session('error') }}",
  className: "bg-danger",
  position: "center", 
  }).showToast();
</script>
@endif

</body>
</html>
