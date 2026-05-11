<div class="sidebar-wrapper" sidebar-layout="stroke-svg">
    <div>
        <div class="logo-wrapper">
            <a href="{{ route('manage.dashboard') }}">
                <img class="img-fluid for-light" src="{{ asset('assets/images/logo/fittoss-logo.png') }}" alt="{{ env('APP_NAME') }}" width="110" style="max-width: 68%;">
                <img class="img-fluid for-dark" src="{{ asset('assets/images/logo/fittoss-logo-white.png') }}" alt="{{ env('APP_NAME') }}" width="110" style="max-width: 68%;">
            </a>
            <div class="back-btn"><i class="fa fa-angle-left"></i></div>
            <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid"> </i></div>
        </div>
        <div class="logo-icon-wrapper">
            <a href="{{ route('manage.dashboard') }}">
                <img class="img-fluid for-light" src="{{ asset('assets/images/logo/favicon.png') }}" alt="{{ env('APP_NAME') }}" style="width: 40px; height: auto;">
                <img class="img-fluid for-dark" src="{{ asset('assets/images/logo/favicon.png') }}" alt="{{ env('APP_NAME') }}" style="width: 40px; height: auto;">
            </a>
        </div>
        <nav class="sidebar-main">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="sidebar-menu">
                <ul class="sidebar-links" id="simple-bar">
                    <li class="back-btn">
                        <a href="{{ route('manage.dashboard') }}">
                            <img class="img-fluid for-light" src="{{ asset('assets/images/logo/apple-touch-icon-16x16.png') }}" alt="{{ env('APP_NAME') }}">
                            <img class="img-fluid for-dark" src="{{ asset('assets/images/logo/apple-touch-icon-32x32.png') }}" alt="{{ env('APP_NAME') }}">
                        </a>
                        <div class="mobile-back text-end">
                            <span>Back</span><i class="fa fa-angle-right ps-2" aria-hidden="true"></i>
                        </div>
                    </li>
                    <li class="sidebar-main-title">
                        <div>
                            <h6 class="heading-color">Dashboard</h6>
                        </div>
                    </li>
                    <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title link-nav" href="{{ route('manage.dashboard') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-airplay">
                                <path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1">
                                </path>
                                <polygon points="12 15 17 21 7 21 12 15"></polygon>
                            </svg>
                            <span class="">Dashboard</span>
                            <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                        </a>
                    </li>
                    <li class="sidebar-main-title">
                        <div>
                            <h6 class="heading-color">Customers</h6>
                        </div>
                    </li>
                    <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title link-nav" href="{{ route('manage.customers.create') }}">
                            <i data-feather="user-plus"></i>
                            <span class="">Create An Account</span>
                        </a>
                    </li>
                    <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title link-nav" href="{{ route('manage.searchdata') }}">
                            <i data-feather="search"></i>
                            <span class="">Search Data</span>
                        </a>
                    </li>

                    {{-- <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title link-nav" href="{{ route('manage.partner.create') }}" data-bs-original-title="" title="">
                    <i data-feather="user-plus"></i>
                    <span class="">Create An Account</span>
                    <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                    </a>
                    </li> --}}

                    <li class="sidebar-main-title">
                        <div>
                            <h6 class="heading-color">Weight Loss Program</h6>
                        </div>
                    </li>
                    <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title link-nav" href="{{ route('manage.weight-loss-program.statistics') }}" data-bs-original-title="" title="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bar-chart-2">
                                <line x1="18" y1="20" x2="18" y2="10"></line>
                                <line x1="12" y1="20" x2="12" y2="4"></line>
                                <line x1="6" y1="20" x2="6" y2="14"></line>
                            </svg>
                            <span class="">Statistics</span>
                        </a>
                    </li>
                    <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title link-nav" href="{{ route('manage.weight-loss-program.leads') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bar-chart-2">
                                <line x1="18" y1="20" x2="18" y2="10"></line>
                                <line x1="12" y1="20" x2="12" y2="4"></line>
                                <line x1="6" y1="20" x2="6" y2="14"></line>
                            </svg>
                            <span class="">Leads</span>
                        </a>
                    </li>
                    <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title link-nav" href="{{ route('manage.weight-loss-program.customers') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                            <span class="">Customers</span>
                        </a>
                    </li>

                    <li class="sidebar-main-title">
                        <div>
                            <h6 class="heading-color">Weight Loss Webinar</h6>
                        </div>
                    </li>
                    <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title link-nav" href="{{ route('manage.weight-loss-webinar.statistics') }}" data-bs-original-title="" title="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bar-chart-2">
                                <line x1="18" y1="20" x2="18" y2="10"></line>
                                <line x1="12" y1="20" x2="12" y2="4"></line>
                                <line x1="6" y1="20" x2="6" y2="14"></line>
                            </svg>
                            <span class="">Statistics</span>
                        </a>
                    </li>
                    <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title link-nav" href="{{ route('manage.weight-loss-webinar.leads') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bar-chart-2">
                                <line x1="18" y1="20" x2="18" y2="10"></line>
                                <line x1="12" y1="20" x2="12" y2="4"></line>
                                <line x1="6" y1="20" x2="6" y2="14"></line>
                            </svg>
                            <span class="">Leads</span>
                        </a>
                    </li>
                    <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title link-nav" href="{{ route('manage.weight-loss-webinar.customers') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                            <span class="">Customers</span>
                        </a>
                    </li>

                    <li class="sidebar-main-title">
                        <div>
                            <h6 class="heading-color">Bodyfat Analysis Workshop</h6>
                        </div>
                    </li>
                    <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title link-nav" href="{{ route('manage.bodyfat-analysis-workshop.statistics') }}" data-bs-original-title="" title="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bar-chart-2">
                                <line x1="18" y1="20" x2="18" y2="10"></line>
                                <line x1="12" y1="20" x2="12" y2="4"></line>
                                <line x1="6" y1="20" x2="6" y2="14"></line>
                            </svg>
                            <span class="">Statistics</span>
                        </a>
                    </li>
                    <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title link-nav" href="{{ route('manage.bodyfat-analysis-workshop.leads') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bar-chart-2">
                                <line x1="18" y1="20" x2="18" y2="10"></line>
                                <line x1="12" y1="20" x2="12" y2="4"></line>
                                <line x1="6" y1="20" x2="6" y2="14"></line>
                            </svg>
                            <span class="">Leads</span>
                        </a>
                    </li>
                    <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title link-nav" href="{{ route('manage.bodyfat-analysis-workshop.customers') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                            <span class="">Customers</span>
                        </a>
                    </li>

                    <li class="sidebar-main-title">
                        <div>
                            <h6 class="heading-color">Bussiness Programs</h6>
                        </div>
                    </li>
                    <li class="sidebar-list  {{ request()->routeIs('manage.health-coach-webinar.*') ? 'active' : 'close' }}">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title {{ request()->routeIs('manage.health-coach-webinar.*') ? 'active' : '' }}" href="#" data-bs-original-title="" title="">
                            <i data-feather="tag"></i>
                            <span class="">Health Coach Webinar</span>
                            <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                        </a>
                        <ul class="sidebar-submenu" style="display: {{ request()->routeIs('manage.health-coach-webinar.*') ? 'block' : 'none' }};">
                            <li class="{{ request()->routeIs('manage.health-coach-webinar.leads') || request()->routeIs('manage.health-coach-webinar.customer.details') ? 'active' : '' }}">
                                <a href="{{ route('manage.health-coach-webinar.leads') }}" class="{{ request()->routeIs('manage.health-coach-webinar.leads') || request()->routeIs('manage.health-coach-webinar.customer.details') ? 'active' : '' }}">
                                    Leads
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('manage.health-coach-webinar.customers') || request()->routeIs('manage.health-coach-webinar.customer.details') ? 'active' : '' }}">
                                <a href="{{ route('manage.health-coach-webinar.customers') }}" class="{{ request()->routeIs('manage.health-coach-webinar.customers') || request()->routeIs('manage.health-coach-webinar.customer.details') ? 'active' : '' }}">
                                    Customers
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="sidebar-main-title">
                        <div>
                            <h6 class="heading-color">Offers</h6>
                        </div>
                    </li>
                    <li class="sidebar-list  {{ request()->routeIs('manage.weight-loss-offer.*') ? 'active' : 'close' }}">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title {{ request()->routeIs('manage.weight-loss-offer.*') ? 'active' : '' }}" href="#" data-bs-original-title="" title="">
                            <i data-feather="tag"></i>
                            <span class="">Weight Loss Crash Offer</span>
                            <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                        </a>
                        <ul class="sidebar-submenu" style="display: {{ request()->routeIs('manage.weight-loss-offer.*') ? 'block' : 'none' }};">
                            <li class="{{ request()->routeIs('manage.weight-loss-offer.leads') || request()->routeIs('manage.weight-loss-offer.customer.details') ? 'active' : '' }}">
                                <a href="{{ route('manage.weight-loss-offer.leads') }}" class="{{ request()->routeIs('manage.weight-loss-offer.leads') || request()->routeIs('manage.weight-loss-offer.customer.details') ? 'active' : '' }}">
                                    Leads
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('manage.weight-loss-offer.customers') || request()->routeIs('manage.weight-loss-offer.customer.details') ? 'active' : '' }}">
                                <a href="{{ route('manage.weight-loss-offer.customers') }}" class="{{ request()->routeIs('manage.weight-loss-offer.customers') || request()->routeIs('manage.weight-loss-offer.customer.details') ? 'active' : '' }}">
                                    Customers
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-list  {{ request()->routeIs('manage.ultimate-program.*') ? 'active' : 'close' }}">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title {{ request()->routeIs('manage.ultimate-program.*') ? 'active' : '' }}" href="#" data-bs-original-title="" title="">
                            <i data-feather="tag"></i>
                            <span class="">Ultimate Program</span>
                            <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                        </a>
                        <ul class="sidebar-submenu" style="display: {{ request()->routeIs('manage.ultimate-program.*') ? 'block' : 'none' }};">
                            <li class="{{ request()->routeIs('manage.ultimate-program.leads') || request()->routeIs('manage.ultimate-program.customer.details') ? 'active' : '' }}">
                                <a href="{{ route('manage.ultimate-program.leads') }}" class="{{ request()->routeIs('manage.ultimate-program.leads') || request()->routeIs('manage.ultimate-program.customer.details') ? 'active' : '' }}">
                                    Leads
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('manage.ultimate-program.customers') || request()->routeIs('manage.ultimate-program.customer.details') ? 'active' : '' }}">
                                <a href="{{ route('manage.ultimate-program.customers') }}" class="{{ request()->routeIs('manage.ultimate-program.customers') || request()->routeIs('manage.ultimate-program.customer.details') ? 'active' : '' }}">
                                    Customers
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-list  {{ request()->routeIs('manage.customize-program.*') ? 'active' : 'close' }}">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title {{ request()->routeIs('manage.customize-program.*') ? 'active' : '' }}" href="#" data-bs-original-title="" title="">
                            <i data-feather="tag"></i>
                            <span class="">Customize Program</span>
                            <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                        </a>
                        <ul class="sidebar-submenu" style="display: {{ request()->routeIs('manage.customize-program.*') ? 'block' : 'none' }};">
                            <li class="{{ request()->routeIs('manage.customize-program.leads') || request()->routeIs('manage.customize-program.customer.details') ? 'active' : '' }}">
                                <a href="{{ route('manage.customize-program.leads') }}" class="{{ request()->routeIs('manage.customize-program.leads') || request()->routeIs('manage.customize-program.customer.details') ? 'active' : '' }}">
                                    Leads
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('manage.customize-program.customers') || request()->routeIs('manage.customize-program.customer.details') ? 'active' : '' }}">
                                <a href="{{ route('manage.customize-program.customers') }}" class="{{ request()->routeIs('manage.customize-program.customers') || request()->routeIs('manage.customize-program.customer.details') ? 'active' : '' }}">
                                    Customers
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-list  {{ request()->routeIs('manage.weight-loss-webinar-offer.*') ? 'active' : 'close' }}">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title {{ request()->routeIs('manage.weight-loss-webinar-offer.*') ? 'active' : '' }}" href="#" data-bs-original-title="" title="">
                            <i data-feather="tag"></i>
                            <span class="">Weight Loss Webinar Offer</span>
                            <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                        </a>
                        <ul class="sidebar-submenu" style="display: {{ request()->routeIs('manage.weight-loss-webinar-offer.*') ? 'block' : 'none' }};">
                            <li class="{{ request()->routeIs('manage.weight-loss-webinar-offer.leads') || request()->routeIs('manage.weight-loss-webinar-offer.customer.details') ? 'active' : '' }}">
                                <a href="{{ route('manage.weight-loss-webinar-offer.leads') }}" class="{{ request()->routeIs('manage.weight-loss-webinar-offer.leads') || request()->routeIs('manage.weight-loss-webinar-offer.customer.details') ? 'active' : '' }}">
                                    Leads
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('manage.weight-loss-webinar-offer.customers') || request()->routeIs('manage.weight-loss-webinar-offer.customer.details') ? 'active' : '' }}">
                                <a href="{{ route('manage.weight-loss-webinar-offer.customers') }}" class="{{ request()->routeIs('manage.weight-loss-webinar-offer.customers') || request()->routeIs('manage.weight-loss-webinar-offer.customer.details') ? 'active' : '' }}">
                                    Customers
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-list  {{ request()->routeIs('manage.fitone.*') ? 'active' : 'close' }}">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title {{ request()->routeIs('manage.fitone.*') ? 'active' : '' }}" href="#" data-bs-original-title="" title="">
                            <i data-feather="tag"></i>
                            <span class="">Fitone</span>
                            <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                        </a>
                        <ul class="sidebar-submenu" style="display: {{ request()->routeIs('manage.fitone.*') ? 'block' : 'none' }};">
                            <li class="{{ request()->routeIs('manage.fitone.leads') || request()->routeIs('manage.fitone.customer.details') ? 'active' : '' }}">
                                <a href="{{ route('manage.fitone.leads') }}" class="{{ request()->routeIs('manage.fitone.leads') || request()->routeIs('manage.fitone.customer.details') ? 'active' : '' }}">
                                    Leads
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('manage.fitone.customers') || request()->routeIs('manage.fitone.customer.details') ? 'active' : '' }}">
                                <a href="{{ route('manage.fitone.customers') }}" class="{{ request()->routeIs('manage.fitone.customers') || request()->routeIs('manage.fitone.customer.details') ? 'active' : '' }}">
                                    Customers
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-list  {{ request()->routeIs('manage.expert.consultation.*') ? 'active' : 'close' }}">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title {{ request()->routeIs('manage.expert.consultation.*') ? 'active' : '' }}" href="#" data-bs-original-title="" title="">
                            <i data-feather="tag"></i>
                            <span class="">Expert Consultation</span>
                            <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                        </a>
                        <ul class="sidebar-submenu" style="display: {{ request()->routeIs('manage.expert.consultation.*') ? 'block' : 'none' }};">
                            <li class="{{ request()->routeIs('manage.expert.consultation.leads') || request()->routeIs('manage.expert.consultation.customer.details') ? 'active' : '' }}">
                                <a href="{{ route('manage.expert.consultation.leads') }}" class="{{ request()->routeIs('manage.expert.consultation.leads') || request()->routeIs('manage.expert.consultation.customer.details') ? 'active' : '' }}">
                                    Leads
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('manage.expert.consultation.customers') || request()->routeIs('manage.expert.consultation.customer.details') ? 'active' : '' }}">
                                <a href="{{ route('manage.expert.consultation.customers') }}" class="{{ request()->routeIs('manage.expert.consultation.customers') || request()->routeIs('manage.expert.consultation.customer.details') ? 'active' : '' }}">
                                    Customers
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-list  {{ request()->routeIs('manage.membership-plan.*') ? 'active' : 'close' }}">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title {{ request()->routeIs('manage.membership-plan.*') ? 'active' : '' }}" href="#" data-bs-original-title="" title="">
                            <i data-feather="tag"></i>
                            <span class="">Membership Plan</span>
                            <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                        </a>
                        <ul class="sidebar-submenu" style="display: {{ request()->routeIs('manage.membership-plan.*') ? 'block' : 'none' }};">
                            <li class="{{ request()->routeIs('manage.membership-plan.leads') || request()->routeIs('manage.membership-plan.customer.details') ? 'active' : '' }}">
                                <a href="{{ route('manage.membership-plan.leads') }}" class="{{ request()->routeIs('manage.membership-plan.leads') || request()->routeIs('manage.membership-plan.customer.details') ? 'active' : '' }}">
                                    Leads
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('manage.membership-plan.customers') || request()->routeIs('manage.membership-plan.customer.details') ? 'active' : '' }}">
                                <a href="{{ route('manage.membership-plan.customers') }}" class="{{ request()->routeIs('manage.membership-plan.customers') || request()->routeIs('manage.membership-plan.customer.details') ? 'active' : '' }}">
                                    Customers
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-list  {{ request()->routeIs('manage.associate-partner-program.*') ? 'active' : 'close' }}">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title {{ request()->routeIs('manage.associate-partner-program.*') ? 'active' : '' }}" href="#" data-bs-original-title="" title="">
                            <i data-feather="tag"></i>
                            <span class="">Associate Partner Program</span>
                            <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                        </a>
                        <ul class="sidebar-submenu" style="display: {{ request()->routeIs('manage.associate-partner-program.*') ? 'block' : 'none' }};">
                            <li class="{{ request()->routeIs('manage.associate-partner-program.leads') || request()->routeIs('manage.associate-partner-program.customer.details') ? 'active' : '' }}">
                                <a href="{{ route('manage.associate-partner-program.leads') }}" class="{{ request()->routeIs('manage.associate-partner-program.leads') || request()->routeIs('manage.associate-partner-program.customer.details') ? 'active' : '' }}">
                                    Leads
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('manage.associate-partner-program.customers') || request()->routeIs('manage.associate-partner-program.customer.details') ? 'active' : '' }}">
                                <a href="{{ route('manage.associate-partner-program.customers') }}" class="{{ request()->routeIs('manage.associate-partner-program.customers') || request()->routeIs('manage.associate-partner-program.customer.details') ? 'active' : '' }}">
                                    Customers
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-list  {{ request()->routeIs('manage.advance-plan.*') ? 'active' : 'close' }}">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title {{ request()->routeIs('manage.advance-plan.*') ? 'active' : '' }}" href="#" data-bs-original-title="" title="">
                            <i data-feather="tag"></i>
                            <span class="">Fitpro</span>
                            <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                        </a>
                        <ul class="sidebar-submenu" style="display: {{ request()->routeIs('manage.advance-plan.*') ? 'block' : 'none' }};">
                            <li class="{{ request()->routeIs('manage.advance-plan.leads') || request()->routeIs('manage.advance-plan.customer.details') ? 'active' : '' }}">
                                <a href="{{ route('manage.advance-plan.leads') }}" class="{{ request()->routeIs('manage.advance-plan.leads') || request()->routeIs('manage.advance-plan.customer.details') ? 'active' : '' }}">
                                    Leads
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('manage.advance-plan.customers') || request()->routeIs('manage.advance-plan.customer.details') ? 'active' : '' }}">
                                <a href="{{ route('manage.advance-plan.customers') }}" class="{{ request()->routeIs('manage.advance-plan.customers') || request()->routeIs('manage.advance-plan.customer.details') ? 'active' : '' }}">
                                    Customers
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-list  {{ request()->routeIs('manage.onboard-upi-payment.*') ? 'active' : 'close' }}">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title {{ request()->routeIs('manage.onboard-upi-payment.*') ? 'active' : '' }}" href="#" data-bs-original-title="" title="">
                            <i data-feather="tag"></i>
                            <span class="">Onboard UPI Payment</span>
                            <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                        </a>
                        <ul class="sidebar-submenu" style="display: {{ request()->routeIs('manage.onboard-upi-payment.*') ? 'block' : 'none' }};">
                            <li class="{{ request()->routeIs('manage.onboard-upi-payment.customers') || request()->routeIs('manage.onboard-upi-payment.customer.details') ? 'active' : '' }}">
                                <a href="{{ route('manage.onboard-upi-payment.customers') }}" class="{{ request()->routeIs('manage.onboard-upi-payment.customers') || request()->routeIs('manage.onboard-upi-payment.customer.details') ? 'active' : '' }}">
                                    Customers
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-main-title">
                        <div>
                            <h6 class="heading-color">Payment Logs</h6>
                        </div>
                    </li>
                    <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title link-nav" href="{{ route('manage.payu-log') }}" data-bs-original-title="" title="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-credit-card">
                                <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                <line x1="1" y1="10" x2="23" y2="10"></line>
                            </svg>
                            <span class="">Payu Logs</span>
                            <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                        </a>
                    </li>
                    <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title link-nav" href="{{ route('manage.sabpaisa-log') }}" data-bs-original-title="" title="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-credit-card">
                                <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                <line x1="1" y1="10" x2="23" y2="10"></line>
                            </svg>
                            <span class="">SabPaisa Logs</span>
                            <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                        </a>
                    </li>
                    <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title link-nav" href="{{ route('manage.paytm-log') }}" data-bs-original-title="" title="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-credit-card">
                                <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                <line x1="1" y1="10" x2="23" y2="10"></line>
                            </svg>
                            <span class="">PayTm Logs</span>
                            <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                        </a>
                    </li>
                    <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title link-nav" href="{{ route('manage.phonepay-log') }}" data-bs-original-title="" title="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-credit-card">
                                <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                <line x1="1" y1="10" x2="23" y2="10"></line>
                            </svg>
                            <span class="">PhonePe Logs</span>
                            <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                        </a>
                    </li>
                    <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title link-nav" href="{{ route('manage.vegaah-log') }}" data-bs-original-title="" title="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-credit-card">
                                <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                <line x1="1" y1="10" x2="23" y2="10"></line>
                            </svg>
                            <span class="">Vegaah Logs</span>
                            <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                        </a>
                    </li>
                    <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title link-nav" href="{{ route('manage.paygic-log') }}" data-bs-original-title="" title="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-credit-card">
                                <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                <line x1="1" y1="10" x2="23" y2="10"></line>
                            </svg>
                            <span class="">Paygic Logs</span>
                            <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                        </a>
                    </li>

                    <li class="sidebar-main-title">
                        <div>
                            <h6 class="heading-color">Accounting</h6>
                        </div>
                    </li>
                    <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title link-nav" href="{{ route('manage.invoice') }}" data-bs-original-title="" title="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                <polyline points="10 9 9 9 8 9"></polyline>
                            </svg>
                            <span class="">Invoices</span>
                            <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                        </a>
                    </li>
                    <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title link-nav" href="{{ route('manage.gst') }}">
                            <i data-feather="percent"></i>
                            <span class="">GST</span>
                        </a>
                    </li>
                    <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title link-nav" href="{{ route('manage.refunds') }}">
                            <i data-feather="repeat"></i>
                            <span class="">Refunds</span>
                        </a>
                    </li>

                    <li class="sidebar-main-title">
                        <div>
                            <h6 class="heading-color">Schedule Slots</h6>
                        </div>
                    </li>
                    <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title link-nav" href="{{ route('manage.schedule-slot') }}" data-bs-original-title="" title="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="4" width="18" height="18" rx="2"></rect>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                                <circle cx="12" cy="16" r="2"></circle>
                            </svg>
                            <span class="">Schedule Slots</span>
                            <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                        </a>
                    </li>

                    <li class="sidebar-main-title">
                        <div>
                            <h6 class="heading-color">Products</h6>
                        </div>
                    </li>
                    <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title link-nav " href="{{ route('manage.products.index') }}" data-bs-original-title="" title="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-package">
                                <path d="M21 8l-9-5-9 5 9 5 9-5z"></path>
                                <path d="M3 8v8l9 5 9-5V8"></path>
                                <path d="M12 13v8"></path>
                            </svg>
                            <span class="">Products</span>
                            <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                        </a>
                    </li>
                    <li class="sidebar-main-title">
                        <div>
                            <h6 class="heading-color">Partners</h6>
                        </div>
                    </li>
                    <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title link-nav" href="{{ route('manage.partner.index') }}" data-bs-original-title="" title="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                            <span class="">Partners</span>
                            <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                        </a>
                    </li>
                    <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title link-nav" href="{{ route('manage.partner.create') }}" data-bs-original-title="" title="">
                            <i data-feather="user-plus"></i>
                            <span class="">Add Partner</span>
                            <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                        </a>
                    </li>

                    <li class="sidebar-main-title">
                        <div>
                            <h6 class="heading-color">Main IVR</h6>
                        </div>
                    </li>
                    <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title link-nav" href="{{ route('manage.supportrequest.index') }}" data-bs-original-title="" title="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-life-buoy">
                                <circle cx="12" cy="12" r="10"></circle>
                                <circle cx="12" cy="12" r="4"></circle>
                                <line x1="4.93" y1="4.93" x2="9.17" y2="9.17"></line>
                                <line x1="14.83" y1="14.83" x2="19.07" y2="19.07"></line>
                                <line x1="14.83" y1="9.17" x2="19.07" y2="4.93"></line>
                                <line x1="14.83" y1="9.17" x2="18.36" y2="5.64"></line>
                                <line x1="4.93" y1="19.07" x2="9.17" y2="14.83"></line>
                            </svg>
                            <span class="">Support Request</span>
                            <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                        </a>
                    </li>
                    <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title link-nav" href="{{ route('manage.contact.index') }}" data-bs-original-title="" title="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-globe">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="2" y1="12" x2="22" y2="12"></line>
                                <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z">
                                </path>
                            </svg>
                            <span class="">Contact Enquiry</span>
                            <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                        </a>
                    </li>

                    <li class="sidebar-main-title">
                        <div>
                            <h6 class="heading-color">In-house HR Mgmt.</h6>
                        </div>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav active" href="{{ route('manage.birthday-list.index') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clipboard">
                                <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                                <rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect>
                            </svg>
                            <span class="">Birthday List</span>
                            <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                        </a>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav active" href="{{ route('manage.joining-list.index') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clipboard">
                                <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                                <rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect>
                            </svg>
                            <span class="">Joining List</span>
                            <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                        </a>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav active" href="{{ route('manage.resigning-list.index') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clipboard">
                                <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                                <rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect>
                            </svg>
                            <span class="">Resigning List</span>
                            <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                        </a>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav" href="{{ route('manage.holiday-list.index') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                            <span>Yearly Holiday List</span>
                        </a>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav" href="{{ route('manage.apply-leave.index') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file">
                                <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                                <polyline points="13 2 13 9 20 9"></polyline>
                            </svg>
                            <span>Leave Application</span>
                        </a>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav active" href="{{ route('manage.important.updates') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-circle">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" y1="8" x2="12" y2="12"></line>
                                <line x1="12" y1="16" x2="12" y2="16"></line>
                            </svg>
                            <span class="">Important Updates</span>
                            <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                        </a>
                    </li>

                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav active" href="{{ route('manage.employee.index') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                            <span class="">Employee Account</span>
                            <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                        </a>
                    </li>

                    <li class="sidebar-main-title">
                        <div>
                            <h6 class="heading-color">Data List</h6>
                        </div>
                    </li>
                    @can('faqs-list')
                    <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title link-nav" href="{{ route('manage.faq.index') }}">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-home') }}"></use>
                            </svg>
                            <span class="">Faqs</span>
                        </a>
                    </li>
                    @endcan
                    @can('role-list')
                    <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title link-nav" href="{{ route('manage.role.index') }}">
                            <svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-home') }}"></use>
                            </svg>
                            <span class="">Role</span>
                        </a>
                    </li>
                    @endcan
                    <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title" href="javascript:;" data-bs-original-title="" title="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layers">
                                <polygon points="12 2 2 7 12 12 22 7 12 2"></polygon>
                                <polyline points="2 17 12 22 22 17"></polyline>
                                <polyline points="2 12 12 17 22 12"></polyline>
                            </svg>
                            <span class="">Testimonials</span>
                            <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                        </a>
                        <ul class="sidebar-submenu" style="display: none;">
                            <li><a href="{{ route('manage.testimonial.index') }}" data-bs-original-title="" title="">Testimonials</a></li>
                            <li><a href="{{ route('manage.before-after-testimonial.index') }}" data-bs-original-title="" title="">Before-After Testimonials</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title link-nav" href="{{ route('manage.disease.index') }}" data-bs-original-title="" title="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clipboard">
                                <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2">
                                </path>
                                <rect x="8" y="2" width="8" height="4" rx="1" ry="1">
                                </rect>
                            </svg>
                            <span class="">Disease</span>
                            <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                        </a>
                    </li>
                    <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title" href="javascript:;" data-bs-original-title="" title="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-briefcase">
                                <rect x="2" y="7" width="20" height="14" rx="2" ry="2">
                                </rect>
                                <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                            </svg>
                            <span class="">Career</span>
                            <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                        </a>
                        <ul class="sidebar-submenu" style="display: none;">
                            <li><a href="{{ route('manage.career.index') }}" data-bs-original-title="" title="">Career Openings</a></li>
                            <li><a href="{{ route('manage.careerenquiry.index') }}" data-bs-original-title="" title="">Career Enquiry</a></li>
                        </ul>
                    </li>

                    <li class="sidebar-main-title">
                        <div>
                            <h6 class="heading-color">SMS DATA</h6>
                        </div>
                    </li>

                    <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title link-nav " href="{{ route('manage.sms.smsmessage') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-square">
                                <path d="M21 15a4 4 0 0 1-4 4H7l-4 4V5a4 4 0 0 1 4-4h10a4 4 0 0 1 4 4z"></path>
                            </svg>
                            <span class="">SMS Message</span>
                            <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                        </a>
                    </li>
                    <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title link-nav" href="{{ route('manage.dnd.list', ['type' => 'fittoss']) }}" data-bs-original-title="" title="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus-circle">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="8" y1="12" x2="16" y2="12"></line>
                            </svg>
                            <span class="">DND</span>
                            <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                        </a>
                    </li>
                    <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title link-nav" href="{{ route('manage.remarketing.log') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                            <span class="">Remarketing Log</span>
                        </a>
                    </li>
                    <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title link-nav" href="{{ route('manage.bulk.sms') }}" data-bs-original-title="" title="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                            <span class="">Leads Remarketing</span>
                        </a>
                    </li>
                    <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title link-nav" href="{{ route('manage.sendotps') }}" data-bs-original-title="" title="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="5" y="11" width="14" height="10" rx="2"></rect>
                                <path d="M8 11V8a4 4 0 0 1 8 0v3"></path>
                                <circle cx="10" cy="16" r="1"></circle>
                                <circle cx="12" cy="16" r="1"></circle>
                                <circle cx="14" cy="16" r="1"></circle>
                            </svg>
                            <span class="">Send OTPs</span>
                            <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                        </a>
                    </li>
                    <li class="sidebar-main-title">
                        <div>
                            <h6 class="heading-color">Data Management</h6>
                        </div>
                    </li>
                    <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title link-nav" href="{{ route('manage.drive.links.index') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M15 7h3a5 5 0 0 1 0 10h-3"></path>
                                <path d="M9 17H6a5 5 0 0 1 0-10h3"></path>
                                <line x1="8" y1="12" x2="16" y2="12"></line>
                            </svg>
                            <span class="">Drive Links</span>
                        </a>
                    </li>
                    <li class="sidebar-main-title">
                        <div>
                            <h6 class="heading-color">Site Options</h6>
                        </div>
                    </li>
                    @can('staff-list')
                    <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title link-nav" href="{{ route('manage.staff.index') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                            <span class="">Staff Management</span>
                        </a>
                    </li>
                    @endcan
                    <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title link-nav" href="{{ route('manage.website.links.index') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M15 7h3a5 5 0 0 1 0 10h-3"></path>
                                <path d="M9 17H6a5 5 0 0 1 0-10h3"></path>
                                <line x1="8" y1="12" x2="16" y2="12"></line>
                            </svg>
                            <span class="">Website Links</span>
                        </a>
                    </li>

                    <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title" href="javascript:;" data-bs-original-title="" title="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings">
                                <circle cx="12" cy="12" r="3"></circle>
                                <path d="M19.4 15a1.7 1.7 0 0 0 .3 1.8l.1.1a2 2 0 1 1-2.8 2.8l-.1-.1a1.7 1.7 0 0 0-1.8-.3 1.7 1.7 0 0 0-1 1.5V21a2 2 0 1 1-4 0v-.1a1.7 1.7 0 0 0-1-1.5 1.7 1.7 0 0 0-1.8.3l-.1.1a2 2 0 1 1-2.8-2.8l.1-.1a1.7 1.7 0 0 0 .3-1.8 1.7 1.7 0 0 0-1.5-1H3a2 2 0 1 1 0-4h.1a1.7 1.7 0 0 0 1.5-1 1.7 1.7 0 0 0-.3-1.8l-.1-.1a2 2 0 1 1 2.8-2.8l.1.1a1.7 1.7 0 0 0 1.8.3h.1A1.7 1.7 0 0 0 10 3.1V3a2 2 0 1 1 4 0v.1a1.7 1.7 0 0 0 1 1.5h.1a1.7 1.7 0 0 0 1.8-.3l.1-.1a2 2 0 1 1 2.8 2.8l-.1.1a1.7 1.7 0 0 0-.3 1.8v.1a1.7 1.7 0 0 0 1.5 1H21a2 2 0 1 1 0 4h-.1a1.7 1.7 0 0 0-1.5 1z"></path>
                            </svg>
                            <span class="">Site Options</span>
                            <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                        </a>
                        <ul class="sidebar-submenu" style="display: none;">
                            <li><a href="{{ route('manage.facebook-setting.index') }}" data-bs-original-title="" title="">Facebook Settings</a></li>
                            <li><a href="{{ route('manage.whatsapp-setting.index') }}" data-bs-original-title="" title="">Whatsapp Settings</a></li>
                            <li><a href="{{ route('manage.sms-setting.index') }}" data-bs-original-title="" title="">SMS Settings</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title" href="javascript:;" data-bs-original-title="" title="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-circle">
                                <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z">
                                </path>
                            </svg>
                            <span class="">Messages</span>
                            <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                        </a>
                        <ul class="sidebar-submenu" style="display: none;">
                            <li><a href="{{ route('manage.account-message') }}" data-bs-original-title="" title="">Partner A/c Message</a></li>
                            <li><a href="{{ route('manage.welcome-message') }}" data-bs-original-title="" title="">Welcome Page Message</a></li>
                            <li><a href="{{ route('manage.welcome_image_flyer.index') }}" data-bs-original-title="" title="">Welcome Image Flyer</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title" href="javascript:;" data-bs-original-title="" title="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file">
                                <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                                <polyline points="13 2 13 9 20 9"></polyline>
                            </svg>
                            <span class="">Pages</span>
                            <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                        </a>
                        <ul class="sidebar-submenu" style="display: none;">
                            <li><a href="{{ route('manage.privacy-policy') }}" data-bs-original-title="" title="">Privacy Policy</a></li>
                            <li><a href="{{ route('manage.refund-policy') }}" data-bs-original-title="" title="">Refund Policy</a></li>
                            <li><a href="{{ route('manage.disclaimer') }}" data-bs-original-title="" title="">Disclaimer</a></li>
                            <li><a href="{{ route('manage.terms-conditions') }}" data-bs-original-title="" title="">Terms &amp; Conditions</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list">
                        <a class="sidebar-link sidebar-title link-nav " href="{{ route('manage.staff.account') }}" data-bs-original-title="" title="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                            <span class="">Staff Account</span>
                            <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>
