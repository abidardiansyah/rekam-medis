<header class="pc-header">
  <div class="header-wrapper flex max-sm:px-[15px] px-[25px] grow">
    <div class="me-auto pc-mob-drp">
      <ul class="inline-flex *:min-h-header-height *:inline-flex *:items-center">
        <li class="pc-h-item pc-sidebar-collapse max-lg:hidden lg:inline-flex">
          <a href="#" class="pc-head-link ltr:!ml-0 rtl:!mr-0" id="sidebar-hide">
            <i class="ti ti-menu-2"></i>
          </a>
        </li>
        <li class="pc-h-item pc-sidebar-popup lg:hidden">
          <a href="#" class="pc-head-link ltr:!ml-0 rtl:!mr-0" id="mobile-collapse">
            <i class="ti ti-menu-2 text-2xl leading-none"></i>
          </a>
        </li>
      </ul>
    </div>
    <div class="ms-auto">
      <ul class="inline-flex *:min-h-header-height *:inline-flex *:items-center">
        <li class="dropdown pc-h-item">
          <a class="pc-head-link dropdown-toggle me-0" data-pc-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
            <svg class="pc-icon">
              <use xlink:href="#custom-sun-1"></use>
            </svg>
          </a>
          <div class="dropdown-menu dropdown-menu-end pc-h-dropdown">
            <a href="#!" class="dropdown-item" onclick="layout_change('dark')">
              <svg class="pc-icon w-[18px] h-[18px]">
                <use xlink:href="#custom-moon"></use>
              </svg>
              <span>Dark</span>
            </a>
            <a href="#!" class="dropdown-item" onclick="layout_change('light')">
              <svg class="pc-icon w-[18px] h-[18px]">
                <use xlink:href="#custom-sun-1"></use>
              </svg>
              <span>Light</span>
            </a>
            <a href="#!" class="dropdown-item" onclick="layout_change_default()">
              <svg class="pc-icon w-[18px] h-[18px]">
                <use xlink:href="#custom-setting-2"></use>
              </svg>
              <span>Default</span>
            </a>
          </div>
        </li>
        <li class="dropdown pc-h-item">
          <a class="pc-head-link dropdown-toggle me-0" data-pc-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
            <svg class="pc-icon">
              <use xlink:href="#custom-setting-2"></use>
            </svg>
          </a>
          <div class="dropdown-menu dropdown-menu-end pc-h-dropdown">
            <a href="#!" class="dropdown-item">
              <i class="ti ti-user"></i>
              <span>My Account</span>
            </a>
            <a href="#!" class="dropdown-item">
              <i class="ti ti-settings"></i>
              <span>Settings</span>
            </a>
            <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form-top').submit();">
              <i class="ti ti-power"></i>
              <span>Logout</span>
            </a>
            <form id="logout-form-top" action="{{ route('logout') }}" method="POST" class="hidden">
              @csrf
            </form>
          </div>
        </li>
        <li class="dropdown pc-h-item">
          <a class="pc-head-link dropdown-toggle me-0" data-pc-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
            <svg class="pc-icon">
              <use xlink:href="#custom-notification"></use>
            </svg>
            <span class="badge bg-success-500 text-white rounded-full z-10 absolute right-0 top-0">3</span>
          </a>
          <div class="dropdown-menu dropdown-notification dropdown-menu-end pc-h-dropdown p-2">
            <div class="dropdown-header flex items-center justify-between py-4 px-5">
              <h5 class="m-0">Notifications</h5>
              <a href="#!" class="btn btn-link btn-sm">Mark all read</a>
            </div>
            <div class="dropdown-body header-notification-scroll relative py-4 px-5" style="max-height: calc(100vh - 215px)">
              <p class="text-span mb-3">Today</p>
              <div class="card mb-2">
                <div class="card-body">
                  <div class="flex gap-4">
                    <div class="shrink-0">
                      <svg class="pc-icon text-primary w-[22px] h-[22px]">
                        <use xlink:href="#custom-layer"></use>
                      </svg>
                    </div>
                    <div class="grow">
                      <span class="float-end text-sm text-muted">2 min ago</span>
                      <h5 class="text-body mb-2">New notification</h5>
                      <p class="mb-0">Sample notification message</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="text-center py-2">
              <a href="#!" class="link-primary">View all Notifications</a>
            </div>
          </div>
        </li>
        <li class="dropdown pc-h-item header-user-profile">
          <a class="pc-head-link dropdown-toggle me-0" data-pc-toggle="dropdown" href="#" role="button" aria-haspopup="false" data-bs-auto-close="outside" aria-expanded="false">
            <img src="{{ asset('assets/images/user/avatar-1.jpg') }}" alt="user-image" class="user-avtar" />
          </a>
          <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
            <div class="dropdown-header flex items-center justify-between">
              <h5 class="m-0">Profile</h5>
            </div>
            <div class="dropdown-body">
              <div class="profile-notification-scroll relative" style="max-height: calc(100vh - 225px)">
                <div class="flex mb-1">
                  <div class="shrink-0">
                    <img src="{{ asset('assets/images/user/avatar-1.jpg') }}" alt="user-image" class="wid-35 rounded-circle" />
                  </div>
                  <div class="grow ms-3">
                    <h6 class="mb-1">{{ auth()->user()->name ?? 'Admin' }}</h6>
                    <span>{{ auth()->user()->email ?? 'admin@example.com' }}</span>
                  </div>
                </div>
                <hr class="border-secondary-500/10 my-4" />
                <p class="text-span">Settings</p>
                <a href="#!" class="dropdown-item">
                  <span>
                    <svg class="pc-icon text-muted me-2">
                      <use xlink:href="#custom-setting-outline"></use>
                    </svg>
                    <span>Account Settings</span>
                  </span>
                </a>
                <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form-profile').submit();">
                  <span>
                    <svg class="pc-icon text-muted me-2">
                      <use xlink:href="#custom-logout-1-outline"></use>
                    </svg>
                    <span>Logout</span>
                  </span>
                </a>
                <form id="logout-form-profile" action="{{ route('logout') }}" method="POST" class="hidden">
                  @csrf
                </form>
              </div>
            </div>
          </div>
        </li>
      </ul>
    </div>
  </div>
</header>
