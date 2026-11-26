<!doctype html>
<html lang="en" class="preset-1" data-pc-sidebar-caption="true" data-pc-layout="vertical" data-pc-direction="ltr" dir="ltr" data-pc-theme_contrast="" data-pc-theme="light">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Dashboard') - Rekam Medis</title>
  <link rel="icon" href="{{ asset('assets/images/favicon.svg') }}" type="image/x-icon" />
  <link rel="stylesheet" href="{{ asset('assets/fonts/inter/inter.css') }}" id="main-font-link" />
  <link rel="stylesheet" href="{{ asset('assets/fonts/phosphor/duotone/style.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/fonts/material.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link" />
</head>
<body>
  <div class="loader-bg fixed inset-0 bg-white dark:bg-themedark-cardbg z-[1034]">
    <div class="loader-track h-[5px] w-full inline-block absolute overflow-hidden top-0">
      <div class="loader-fill w-[300px] h-[5px] bg-primary-500 absolute top-0 left-0 transition-[transform_0.2s_linear] origin-left animate-[2.1s_cubic-bezier(0.65,0.815,0.735,0.395)_0s_infinite_normal_none_running_loader-animate]"></div>
    </div>
  </div>
  
  @include('components.sidebar')
  @include('components.topbar')
  
  <div class="pc-container">
    <div class="pc-content">
      @yield('content')
    </div>
  </div>
  
  <footer class="pc-footer">
    <div class="footer-wrapper container-fluid mx-10">
      <div class="grid grid-cols-12 gap-1.5">
        <div class="col-span-12 sm:col-span-6 my-1">
          <p class="m-0">Rekam Medis &#9829; Sistem Informasi Kesehatan</p>
        </div>
        <div class="col-span-12 sm:col-span-6 my-1">
          <ul class="mb-0 ltr:sm:text-right rtl:sm:text-left">
            <li class="inline-block max-sm:mr-2 sm:ml-2"><a href="{{ route('dashboard') }}">Home</a></li>
          </ul>
        </div>
      </div>
    </div>
  </footer>
  
  @stack('scripts')
  
  <script src="{{ asset('assets/js/plugins/simplebar.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
  <script src="{{ asset('assets/js/icon/custom-icon.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>
  <script src="{{ asset('assets/js/component.js') }}"></script>
  <script src="{{ asset('assets/js/theme.js') }}"></script>
  <script src="{{ asset('assets/js/script.js') }}"></script>
</body>
</html>
