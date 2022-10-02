<!-- Menu -->

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="index.html" class="app-brand-link">
            <span class="app-brand-logo demo">
              <a href="{{ route('home') }}">
                <img src="{{ asset('user/images/logo.png') }}" alt="" class="logo-sec">
            </a>
            </span>
            <span class="app-brand-text demo menu-text fw-bolder ms-2">NineGolf</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item active">
            <a href="index.html" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>

        <!-- Layouts -->
        <!--<li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons bx bx-layout"></i>
          <div data-i18n="Layouts">Business Listing</div>
        </a>

        <ul class="menu-sub">
          <li class="menu-item">
            <a href="layouts-without-menu.html" class="menu-link">
              <div data-i18n="Without menu">Item One List</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="layouts-without-navbar.html" class="menu-link">
              <div data-i18n="Without navbar">Item Two List</div>
            </a>
          </li>
          {{-- <li class="menu-item">
            <a href="layouts-container.html" class="menu-link">
              <div data-i18n="Container">Container</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="layouts-fluid.html" class="menu-link">
              <div data-i18n="Fluid">Fluid</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="layouts-blank.html" class="menu-link">
              <div data-i18n="Blank">Blank</div>
            </a>
          </li> --}}
        </ul>
      </li>-->

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">User</span>
        </li>
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div data-i18n="Account Settings">Accounts</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{ route('administrator.user') }}" class="menu-link">
                        <div data-i18n="Account">All</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="javascript:void(0)" class="menu-link">
                        <div data-i18n="Account">Active</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="javascript:void(0)" class="menu-link">
                        <div data-i18n="Notifications">Suspended</div>
                    </a>
                </li>
                {{-- <li class="menu-item">
            <a href="pages-account-settings-connections.html" class="menu-link">
              <div data-i18n="Connections">Connections</div>
            </a>
          </li> --}}
            </ul>
        </li>
        {{-- <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons bx bx-lock-open-alt"></i>
          <div data-i18n="Authentications">Sellers</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item">
            <a href="auth-login-basic.html" class="menu-link" target="_blank">
              <div data-i18n="Basic">Accounts</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="auth-register-basic.html" class="menu-link" target="_blank">
              <div data-i18n="Basic">Suspended</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="auth-forgot-password-basic.html" class="menu-link" target="_blank">
              <div data-i18n="Basic">Notifictions</div>
            </a>
          </li>
        </ul>
      </li>
      <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons bx bx-cube-alt"></i>
          <div data-i18n="Misc">Misc</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item">
            <a href="pages-misc-error.html" class="menu-link">
              <div data-i18n="Error">Error</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="pages-misc-under-maintenance.html" class="menu-link">
              <div data-i18n="Under Maintenance">Under Maintenance</div>
            </a>
          </li>
        </ul>
      </li> --}}
        <!-- Components -->
        <li class="menu-header small text-uppercase"><span class="menu-header-text">Clubs</span></li>

        <!-- User interface -->
        <li class="menu-item">
            <a href="javascript:void(0)" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-box"></i>
                <div data-i18n="User interface">List</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{ route('administrator.club') }}" class="menu-link">
                        <div data-i18n="Accordion">All</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="javascript:void(0)" class="menu-link">
                        <div data-i18n="Accordion">Active</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="javascript:void(0)" class="menu-link">
                        <div data-i18n="Accordion">Suspended</div>
                    </a>
                </li>

            </ul>
        </li>


        <!-- Forms & Tables -->
    </ul>
</aside>
<!-- / Menu -->
