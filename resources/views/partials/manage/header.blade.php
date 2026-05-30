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
        <div class="nav-right col-xxl-12 col-xl-12 col-md-12 col-12 pull-right right-header p-0 d-flex justify-content-between">
            <div class="media profile-media">
                <h5 class="media-body">Company : <b>{{ auth()->user()->company?->company_name }}</b></h5>
            </div>
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
                        <div class="media-body"><span>{{ Auth::user()->name }}</span>
                            <p class="mb-0 font-roboto">{{ \Modules\Partner\App\Models\CompanyStaff::getRoleName(Auth::user()->role) }}<i class="middle fa fa-angle-down"></i></p>
                        </div>
                    </div>
                    <ul class="profile-dropdown onhover-show-div">
                        <li><a href="{{ route('manage.profile.detail') }}"><i data-feather="user"></i><span>Account </span></a></li>
                        <li><a href="{{ route('manage.changePassword') }}"><i data-feather="lock"></i><span>Change Password</span></a></li>
                        <li><a href="{{ route('manage.logout') }}"><i data-feather="log-out"> </i><span>Log out</span></a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
