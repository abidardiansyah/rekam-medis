<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>Login - Rekam Medis</title>
  <link rel="icon" href="{{ asset('assets/images/favicon.svg') }}" type="image/x-icon" />
  <link rel="stylesheet" href="{{ asset('assets/fonts/inter/inter.css') }}" id="main-font-link" />
  <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/fonts/material.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link" />
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
  <div class="loader-bg">
    <div class="loader-track">
      <div class="loader-fill"></div>
    </div>
  </div>
  <div class="auth-main relative">
    <div class="auth-wrapper v2 flex items-center w-full h-full min-h-screen">
      <div class="auth-sidecontent">
        <img src="{{ asset('assets/images/authentication/img-auth-sideimg.jpg') }}" alt="images" class="img-fluid h-screen hidden lg:block" />
      </div>
      <div class="auth-form flex items-center justify-center grow flex-col min-h-screen bg-cover relative p-6 bg-theme-cardbg dark:bg-themedark-cardbg">
        <div class="card sm:my-12 w-full max-w-[480px] border-none shadow-none">
          <div class="card-body sm:!p-10">
            <div class="text-center">
              <a href="#"><img src="{{ asset('assets/images/logo-dark.svg') }}" alt="img" class="mx-auto"/></a>
            </div>
            <h4 class="text-center font-medium mb-4 mt-6">Login Rekam Medis</h4>
            
            @if ($errors->any())
              <div class="alert alert-danger mb-4">
                <ul class="mb-0">
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif
            
            <form method="POST" action="{{ route('login.post') }}">
              @csrf
              <div class="mb-3">
                <input type="email" name="email" class="form-control" placeholder="Email Address" value="{{ old('email') }}" required autofocus />
              </div>
              <div class="mb-4">
                <input type="password" name="password" class="form-control" placeholder="Password" required />
              </div>
              <div class="flex mt-1 justify-between items-center flex-wrap">
                <div class="form-check">
                  <input class="form-check-input input-primary" type="checkbox" name="remember" id="customCheckc1" />
                  <label class="form-check-label text-muted" for="customCheckc1">Remember me?</label>
                </div>
              </div>
              <div class="mt-4">
                <button type="submit" class="btn btn-primary w-full">Login</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="{{ asset('assets/js/plugins/simplebar.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
  <script src="{{ asset('assets/js/icon/custom-icon.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>
  <script src="{{ asset('assets/js/component.js') }}"></script>
  <script src="{{ asset('assets/js/theme.js') }}"></script>
  <script src="{{ asset('assets/js/script.js') }}"></script>
</body>
</html>
