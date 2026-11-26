<nav class="pc-sidebar">
  <div class="navbar-wrapper">
    <div class="m-header flex items-center py-4 px-6 h-header-height">
      <a href="{{ route('dashboard') }}" class="b-brand flex items-center gap-3">
        <img src="{{ asset('assets/images/logo-dark.svg') }}" class="img-fluid logo-lg" alt="logo" />
        <span class="badge bg-success-500/10 text-success-500 rounded-full theme-version">v1.0</span>
      </a>
    </div>
    <div class="navbar-content h-[calc(100vh_-_74px)] py-2.5">
      <div class="card pc-user-card mx-[15px] mb-[15px] bg-theme-sidebaruserbg dark:bg-themedark-sidebaruserbg">
        <div class="card-body !p-5">
          <div class="flex items-center">
            <img class="shrink-0 w-[45px] h-[45px] rounded-full" src="{{ asset('assets/images/user/avatar-1.jpg') }}" alt="user-image" />
            <div class="ml-4 mr-2 grow">
              <h6 class="mb-0">{{ auth()->user()->name ?? 'Admin' }}</h6>
              <small>Administrator</small>
            </div>
            <a class="shrink-0 btn btn-icon inline-flex btn-link-secondary" data-pc-toggle="collapse" href="#pc_sidebar_userlink">
              <svg class="pc-icon w-[22px] h-[22px]">
                <use xlink:href="#custom-sort-outline"></use>
              </svg>
            </a>
          </div>
          <div class="hidden pc-user-links" id="pc_sidebar_userlink">
            <div class="pt-3 *:flex *:items-center *:py-2 *:gap-2.5 hover:*:text-primary-500">
              <a href="#!">
                <i class="text-lg leading-none ti ti-user"></i>
                <span>My Account</span>
              </a>
              <a href="#!">
                <i class="text-lg leading-none ti ti-settings"></i>
                <span>Settings</span>
              </a>
              <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="text-lg leading-none ti ti-power"></i>
                <span>Logout</span>
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
              </form>
            </div>
          </div>
        </div>
      </div>
      <ul class="pc-navbar">
        <li class="pc-item pc-caption">
          <label>Navigation</label>
        </li>
        <li class="pc-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
          <a href="{{ route('dashboard') }}" class="pc-link">
            <span class="pc-micon">
              <svg class="pc-icon">
                <use xlink:href="#custom-status-up"></use>
              </svg>
            </span>
            <span class="pc-mtext">Dashboard</span>
          </a>
        </li>
        <li class="pc-item pc-hasmenu {{ request()->is('dokter*') || request()->is('perawat*') || request()->is('pasien*') || request()->is('jadwal-dokter*') ? 'active pc-trigger' : '' }}">
          <a href="#!" class="pc-link">
            <span class="pc-micon">
              <svg class="pc-icon">
                <use xlink:href="#custom-document"></use>
              </svg>
            </span>
            <span class="pc-mtext">Master Data</span>
            <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
          </a>
          <ul class="pc-submenu">
            <li class="pc-item {{ request()->is('dokter*') ? 'active' : '' }}"><a class="pc-link" href="{{ route('dokter.index') }}">Dokter</a></li>
            <li class="pc-item {{ request()->is('perawat*') ? 'active' : '' }}"><a class="pc-link" href="{{ route('perawat.index') }}">Perawat</a></li>
            <li class="pc-item {{ request()->is('pasien*') ? 'active' : '' }}"><a class="pc-link" href="{{ route('pasien.index') }}">Pasien</a></li>
            <li class="pc-item {{ request()->is('jadwal-dokter*') ? 'active' : '' }}"><a class="pc-link" href="{{ route('jadwal-dokter.index') }}">Jadwal Dokter</a></li>
          </ul>
        </li>
        <li class="pc-item pc-hasmenu {{ request()->is('registrasi*') || request()->is('antrean*') ? 'active pc-trigger' : '' }}">
          <a href="#!" class="pc-link">
            <span class="pc-micon">
              <svg class="pc-icon">
                <use xlink:href="#custom-note-1"></use>
              </svg>
            </span>
            <span class="pc-mtext">Registrasi</span>
            <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
          </a>
          <ul class="pc-submenu">
            <li class="pc-item {{ request()->is('registrasi*') ? 'active' : '' }}"><a class="pc-link" href="{{ route('registrasi.index') }}">Registrasi Pasien</a></li>
            <li class="pc-item {{ request()->is('antrean') && !request()->is('antrean-v2') ? 'active' : '' }}"><a class="pc-link" href="{{ route('antrean.index') }}">Antrean</a></li>
            <li class="pc-item {{ request()->is('antrean-v2') ? 'active' : '' }}"><a class="pc-link" href="{{ route('antrean-v2.index') }}">Antrean V2</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
