<div class="page-header">
    <div class="header-wrapper row m-0">
        <div class="header-logo-wrapper col-auto p-0">
            <div class="logo-wrapper">
                <a href="{{ route('manage.dashboard')}}">
                    <img class="img-fluid" src="{{ asset('assets/images/logo/logo.png') }}" alt="{{ env('APP_NAME') }}" width="220">
                </a>
            </div>
            <div class="toggle-sidebar" style="display:block!important;">
                <i class="status_toggle middle sidebar-toggle" data-feather="align-center"></i>
            </div>
        </div>
        <div class="nav-right col-xxl-7 col-xl-6 col-md-7 col-8 pull-right right-header p-0 ms-auto">
            <ul class="nav-menus">
                <!-- <li>
                    <div class="mode">
                        <svg>
                            <use href="{{ asset('assets/svg/icon-sprite.svg#moon') }}"></use>
                        </svg>
                    </div>
                </li> -->
                <li class="profile-nav onhover-dropdown pe-0 py-0">
                    <div class="media profile-media">
                        <img class="b-r-10 for-light" src="{{ asset('assets/images/logo/favicon.png') }}" alt="" style="width: 30px; height: auto;">
                        <img class="b-r-10 for-dark" src="{{ asset('assets/images/logo/favicon.png') }}" alt="" style="width: 30px; height: auto;">
                        @php
                            $roles = [
                                0 => 'Admin',
                                1 => 'Office Staff',
                                2 => 'IVR Support Staff',
                                3 => 'IT Staff'
                            ];
                        @endphp
                        <div class="media-body"><span>{{ Auth::user()->fullname ?? Auth::user()->name }}</span>
                            <p class="mb-0 font-roboto">{{ $roles[Auth::user()->role] ?? 'Unknown' }}<i class="middle fa fa-angle-down"></i></p>
                        </div>
                    </div>
                    <ul class="profile-dropdown onhover-show-div">
                        <!-- <li><a href="javascript:;"><i data-feather="user"></i><span>Account </span></a></li> -->
                        <li><a href="{{ route('manage.changePassword') }}"><i data-feather="lock"></i><span>Change Password</span></a></li>
                        <li><a href="{{ route('manage.logout') }}"><i data-feather="log-out"> </i><span>Log out</span></a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
